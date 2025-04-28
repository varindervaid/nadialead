<template>
    <DefaultCard :cardTitle="`User ${formType} Form`">
        <div class="p-8 rounded-lg shadow-md">
            <div class="grid grid-cols-12 gap-6 mb-6">
                <div class="col-span-6">
                    <InputLabel for="name" value="Name" :isRequired="true" class="text-gray-600" />
                    <TextInput id="name" type="text"
                        class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500"
                        v-model="form.name"  placeholder="Enter your name" />
                    <InputError class="mt-2" :message="errors.name ? errors.name[0] : ''" />
                </div>

                <div class="col-span-6">
                    <InputLabel for="email" value="Email" class="text-gray-600" :isRequired="true" />
                    <TextInput id="email" type="email"
                        class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500"
                        v-model="form.email" required placeholder="Enter your email" />
                    <InputError class="mt-2" :message="errors.email ? errors.email[0] : ''" />
                </div>
            </div>
            <div class="grid grid-cols-12 gap-6 mb-6">
                <div class="col-span-6">
                    <InputLabel for="password" value="Password" class="text-gray-600"
                        :isRequired="form.id ? false : true" />
                    <div class="flex relative">

                        <TextInput id="password" :type="passwordType ? 'password' : 'text'"
                            class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500"
                            v-model="form.password" required placeholder="Enter your password" />

                         <svg v-if="passwordType"
                        class="absolute right-2 top-1/2 transform -translate-y-1/2 fill-current" aria-hidden="true"
                        @click="viewPassword('password')" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                        fill="currentColor" viewBox="0 0 24 24">
                        <path fill-rule="evenodd"
                            d="M4.998 7.78C6.729 6.345 9.198 5 12 5c2.802 0 5.27 1.345 7.002 2.78a12.713 12.713 0 0 1 2.096 2.183c.253.344.465.682.618.997.14.286.284.658.284 1.04s-.145.754-.284 1.04a6.6 6.6 0 0 1-.618.997 12.712 12.712 0 0 1-2.096 2.183C17.271 17.655 14.802 19 12 19c-2.802 0-5.27-1.345-7.002-2.78a12.712 12.712 0 0 1-2.096-2.183 6.6 6.6 0 0 1-.618-.997C2.144 12.754 2 12.382 2 12s.145-.754.284-1.04c.153-.315.365-.653.618-.997A12.714 12.714 0 0 1 4.998 7.78ZM12 15a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z"
                            clip-rule="evenodd" />
                    </svg>
<svg v-if="!passwordType" class="absolute right-2 top-1/2 transform -translate-y-1/2 fill-current"
                        aria-hidden="true" @click="viewPassword('password')" xmlns="http://www.w3.org/2000/svg" width="24"
                        height="24" fill="currentColor" viewBox="0 0 24 24">
                        <path
                            d="m4 15.6 3.055-3.056A4.913 4.913 0 0 1 7 12.012a5.006 5.006 0 0 1 5-5c.178.009.356.027.532.054l1.744-1.744A8.973 8.973 0 0 0 12 5.012c-5.388 0-10 5.336-10 7A6.49 6.49 0 0 0 4 15.6Z" />
                        <path
                            d="m14.7 10.726 4.995-5.007A.998.998 0 0 0 18.99 4a1 1 0 0 0-.71.305l-4.995 5.007a2.98 2.98 0 0 0-.588-.21l-.035-.01a2.981 2.981 0 0 0-3.584 3.583c0 .012.008.022.01.033.05.204.12.402.211.59l-4.995 4.983a1 1 0 1 0 1.414 1.414l4.995-4.983c.189.091.386.162.59.211.011 0 .021.007.033.01a2.982 2.982 0 0 0 3.584-3.584c0-.012-.008-.023-.011-.035a3.05 3.05 0 0 0-.21-.588Z" />
                        <path
                            d="m19.821 8.605-2.857 2.857a4.952 4.952 0 0 1-5.514 5.514l-1.785 1.785c.767.166 1.55.25 2.335.251 6.453 0 10-5.258 10-7 0-1.166-1.637-2.874-2.179-3.407Z" />
                    </svg>
                    </div>
                    <InputError class="mt-2" :message="errors.password ? errors.password[0] : ''" />
                </div>
                <div class="col-span-6">
                    <InputLabel for="confirm_password" value="Confirm Password" class="text-gray-600" />
                    <div class="flex relative">
                        <TextInput id="confirm_password" :type="confirmPasswordType ? 'password' : 'text'"
                            class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500"
                            v-model="form.confirmPassword" required placeholder="Confirm your password" />
                        <svg v-if="confirmPasswordType"
                        class="absolute right-2 top-1/2 transform -translate-y-1/2 fill-current" aria-hidden="true"
                        @click="viewPassword('new-password')" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                        fill="currentColor" viewBox="0 0 24 24">
                        <path fill-rule="evenodd"
                            d="M4.998 7.78C6.729 6.345 9.198 5 12 5c2.802 0 5.27 1.345 7.002 2.78a12.713 12.713 0 0 1 2.096 2.183c.253.344.465.682.618.997.14.286.284.658.284 1.04s-.145.754-.284 1.04a6.6 6.6 0 0 1-.618.997 12.712 12.712 0 0 1-2.096 2.183C17.271 17.655 14.802 19 12 19c-2.802 0-5.27-1.345-7.002-2.78a12.712 12.712 0 0 1-2.096-2.183 6.6 6.6 0 0 1-.618-.997C2.144 12.754 2 12.382 2 12s.145-.754.284-1.04c.153-.315.365-.653.618-.997A12.714 12.714 0 0 1 4.998 7.78ZM12 15a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z"
                            clip-rule="evenodd" />
                    </svg>

                    <svg v-if="!confirmPasswordType" class="absolute right-2 top-1/2 transform -translate-y-1/2 fill-current"
                        aria-hidden="true" @click="viewPassword('new-password')" xmlns="http://www.w3.org/2000/svg" width="24"
                        height="24" fill="currentColor" viewBox="0 0 24 24">
                        <path
                            d="m4 15.6 3.055-3.056A4.913 4.913 0 0 1 7 12.012a5.006 5.006 0 0 1 5-5c.178.009.356.027.532.054l1.744-1.744A8.973 8.973 0 0 0 12 5.012c-5.388 0-10 5.336-10 7A6.49 6.49 0 0 0 4 15.6Z" />
                        <path
                            d="m14.7 10.726 4.995-5.007A.998.998 0 0 0 18.99 4a1 1 0 0 0-.71.305l-4.995 5.007a2.98 2.98 0 0 0-.588-.21l-.035-.01a2.981 2.981 0 0 0-3.584 3.583c0 .012.008.022.01.033.05.204.12.402.211.59l-4.995 4.983a1 1 0 1 0 1.414 1.414l4.995-4.983c.189.091.386.162.59.211.011 0 .021.007.033.01a2.982 2.982 0 0 0 3.584-3.584c0-.012-.008-.023-.011-.035a3.05 3.05 0 0 0-.21-.588Z" />
                        <path
                            d="m19.821 8.605-2.857 2.857a4.952 4.952 0 0 1-5.514 5.514l-1.785 1.785c.767.166 1.55.25 2.335.251 6.453 0 10-5.258 10-7 0-1.166-1.637-2.874-2.179-3.407Z" />
                    </svg>
                    </div>

                    <InputError class="mt-2" :message="errors.confirmPassword ? errors.confirmPassword[0] : ''" />
                </div>
            </div>
            <div class="mb-6">
                <InputLabel for="role" value="Role" class="text-gray-600" :isRequired="true" />
                <SelectInput v-model="form.role"
                    class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    <option :value="none" selected>Select User Role</option>
                    <option value="client">Client</option>
                    <option value="team">Team</option>
                </SelectInput>
                <InputError class="mt-2" :message="errors.role ? errors.role[0] : ''" />
            </div>
            <div class="mt-8 flex justify-end">
                <!-- <a class="p-3 me-3 bg-red-500 text-white font-semibold rounded-lg hover:bg-red-400 focus:ring focus:ring-red-300" :href="route('users')">Cancel </a> -->
                <router-link
                    class="p-3 me-3 bg-red-500 text-white font-semibold rounded-lg hover:bg-red-400 focus:ring focus:ring-red-300"
                    :to="{ name: 'users' }">
                    Cancel
                </router-link>
                <button @click="submitForm()"
                    class="flex items-center gap-2 mx-2 rounded bg-primary px-4.5 py-2 font-medium text-white hover:bg-opacity-80 py-3 bg-blue-500 text-white font-semibold rounded-lg hover:bg-blue-600 focus:ring focus:ring-blue-300">
                    {{ formType }} </button>
            </div>
        </div>
    </DefaultCard>
</template>
<script setup>
import { ref, onMounted } from "vue";
import DefaultCard from "@/components/Forms/DefaultCard.vue";
import InputLabel from "@/components/InputLabel.vue";
import TextInput from "@/components/TextInput.vue";
import SelectInput from "@/components/SelectInput.vue";
import { convertJsonToFormData, notificationMessage } from "@/helpers";
import InputError from '@/components/InputError.vue';
import { useRouter, useRoute } from 'vue-router';
import axios from "../../axios.js";
const routes = useRoute();
const router = useRouter();
let userId = ref("");
const baseUrl = import.meta.env.VITE_API_BASE_URL;
const form = ref({});
let formType = ref('Add');
const passwordType = ref(true);
const confirmPasswordType = ref(true);
const props = defineProps({
    id: Number,
});

const errors = ref({});


const show = () => {

    let endpoint = `${baseUrl}users/${userId.value}`
    axios
        .get(endpoint)
        .then((response) => {
            form.value = response.data.data;
        })
        .catch((error) => { })
        .finally(() => { });
};


const submitForm = () => {
    let method = "";
    let actionUrl = "";
    let formData = "";

    const config = {
        headers: {
            "content-type": "multipart/form-data",
        },
    };
    formData = convertJsonToFormData(form.value);

    if (form.value.id) {
        formData.append("_method", "PUT");
        method = "post";
        actionUrl = `${baseUrl}users/${userId.value}`;
    } else {
        method = "post";
        actionUrl = `${baseUrl}users`;
    }
    axios[method](actionUrl, formData, config)
        .then((response) => {
            let messageType = (form.value.id) ? 'updated' : 'created';
            notificationMessage('success', `User ${messageType} successfully`);
            router.push({ name: 'users' });
        })
        .catch((error) => {
            errors.value = error.response.data.errors;
        })
        .finally(() => { });
};

onMounted(() => {

    if (routes.params.id) {
        userId.value = routes.params.id;
        show();
        formType.value = 'Update';
    }
});

const viewPassword = (type) => {
    if (type == 'password') {
        passwordType.value = !passwordType.value;
    }

    if(type == 'new-password'){
        confirmPasswordType.value = !confirmPasswordType.value
    }
}
</script>
