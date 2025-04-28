<template>
    <DefaultCard cardTitle="Lead Form">
        <div class="p-8 rounded-lg shadow-md">
            <!-- Lead Field -->
            <div class="grid grid-cols-12 gap-6 mb-6">
                <div class="col-span-12">
                    <!-- <InputLabel for="lead" value="Lead" class="text-gray-600" /> -->
                    <TextInput id="lead" type="file" @change="handleFileChange"
                        class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:outline-0"
                        v-model="form.lead" required autofocus placeholder="Enter the lead name" />
                </div>
            </div>

            <!-- Submit Button -->
            <div class="mt-8 flex justify-end">
                <router-link
                    class="p-3 me-3 bg-red-500 text-white font-semibold rounded-lg hover:bg-red-400 focus:ring focus:ring-red-300"
                    :to="{ name: 'leads' }">
                    Cancel
                </router-link>
                <PrimaryButton @click="submitForm()"
                    class="py-3 bg-blue-500 text-white font-semibold rounded-lg hover:bg-blue-600 focus:ring focus:ring-blue-300">
                    Add Lead
                </PrimaryButton>
            </div>
        </div>
    </DefaultCard>
</template>
<script setup>
import { ref } from "vue";
import DefaultCard from "@/components/Forms/DefaultCard.vue";
import InputLabel from "@/components/InputLabel.vue";
import PrimaryButton from "@/components/PrimaryButton.vue";
import TextInput from "@/components/TextInput.vue";
import { useRouter } from 'vue-router';
import { notificationMessage } from "@/helpers";
import HTTP from "../../axios.js";

const form = ref({});
const router = useRouter();

const handleFileChange = (event) => {
    form.value.leadFile = event.target.files[0];
};

const submitForm = () => {
    if(!form.value.leadFile){
        notificationMessage('error', 'Please select the import file');
        return;
    }
    const formData = new FormData();
    formData.append("lead_file", form.value.leadFile);
    let endPoint = `${import.meta.env.VITE_API_BASE_URL}import/lead`;
    HTTP.post(endPoint, formData)
        .then((response) => {
            if (response.status) {
                notificationMessage('success', 'File imported successfully!');
                router.push({ path: '/leads' });
            }
        })
        .catch((error) => {
            console.log(error);
        });
};
</script>
