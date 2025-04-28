<template>
    <!-- <Head title="Lead Update" />
    <AuthenticatedLayout>
    </AuthenticatedLayout> -->
    <DefaultCard cardTitle="Lead Update">
        <div class="p-8 rounded-lg shadow-md">
            <!-- Lead Name -->
            <div class="grid grid-cols-12 gap-6 mb-6">
                <div class="col-span-6">
                    <InputLabel for="name" value="Name" class="text-gray-600" />
                    <TextInput id="name" type="text" :disabled="isFieldEnable('name')"
                        class="mt-1 block w-full  border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500"
                        :class="isFieldEnable('name') ? 'bg-gray-200' : ''" v-model="form.name" required
                        placeholder="Enter lead name" />
                        <InputError class="mt-2" :message="errors.name ? errors.name[0] : ''" />
                </div>

                <!-- Lead Phone -->
                <div class="col-span-6">
                    <InputLabel for="phone" value="Phone" class="text-gray-600" />
                    <TextInput id="phone" type="text" :disabled="isFieldEnable('phone')"
                        class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500"
                        :class="isFieldEnable('phone') ? 'bg-gray-200' : ''" v-model="form.phone" required
                        placeholder="Enter lead phone" />
                        <InputError class="mt-2" :message="errors.phone ? errors.phone[0] : ''" />
                </div>
            </div>
            <!-- City and State -->
            <div class="grid grid-cols-12 gap-6 mb-6">
                <div class="col-span-6">
                    <InputLabel for="city" value="City" class="text-gray-600" />
                    <TextInput id="city" type="text" :disabled="isFieldEnable('city')"
                        class="mt-1 block w-full  border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500"
                        :class="isFieldEnable('city') ? 'bg-gray-200' : ''" v-model="form.city" required
                        placeholder="Enter lead city" />
                        <InputError class="mt-2" :message="errors.city ? errors.city[0] : ''" />
                </div>

                <div class="col-span-6">
                    <InputLabel for="state" value="State" class="text-gray-600" />
                    <TextInput id="state" type="text" :disabled="isFieldEnable('state')"
                        class="mt-1 block w-full  border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500"
                        :class="isFieldEnable('state') ? 'bg-gray-200' : ''" v-model="form.state" required
                        placeholder="Enter lead state" />
                        <InputError class="mt-2" :message="errors.state ? errors.state[0] : ''" />
                </div>
            </div>

            <!-- Source and Lead Tag -->
            <div class="grid grid-cols-12 gap-6 mb-6">
                <div class="col-span-6">
                    <InputLabel for="source" value="Source" class="text-gray-600" />
                    <TextInput id="source" type="text" :disabled="isFieldEnable('source')"
                        class="mt-1 block w-full  border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500"
                        :class="isFieldEnable('source') ? 'bg-gray-200' : ''" v-model="form.source" required
                        placeholder="Enter lead source" />
                        <InputError class="mt-2" :message="errors.source ? errors.source[0] : ''" />
                </div>
                <div class="col-span-6">
                    <InputLabel for="lead_tag" value="Lead Tag" class="text-gray-600" />
                    <SelectInput v-model="form.lead_tag" :disabled="isFieldEnable('lead_tag')"
                        class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500"
                        :class="isFieldEnable('lead_tag') ? 'bg-gray-200' : ''">
                        <option v-for="tag in leadTags" :key="tag" :value="tag">{{ tag }}</option>
                    </SelectInput>
                    <InputError class="mt-2" :message="errors.lead_tag ? errors.lead_tag[0] : ''" />
                </div>
            </div>
            <!-- Qualification Status and Rating -->
            <div class="grid grid-cols-12 gap-6 mb-6">
                <div class="col-span-6">
                    <InputLabel for="qualification_status" value="Qualification Status" class="text-gray-600" />
                    <SelectInput v-model="form.qualification_status" :disabled="isFieldEnable('qualification_status')"
                        class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500"
                        :class="isFieldEnable('qualification_status') ? 'bg-gray-200' : ''">
                        <option value="" selected>Select qualification status</option>
                        <option value="0">Unqualified</option>
                        <option value="1">Qualified</option>
                    </SelectInput>
                    <InputError class="mt-2" :message="errors.qualification_status ? errors.qualification_status[0] : ''" />
                </div>
                <div class="col-span-6">
                    <InputLabel for="rating" value="Rating" class="text-gray-600" />
                    <SelectInput v-model="form.rating" :disabled="isFieldEnable('rating')"
                        class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500"
                        :class="isFieldEnable('rating') ? 'bg-gray-200' : ''">
                        <option v-for="rating in leadRatings" :key="rating" :value="rating">{{ rating }}</option>
                    </SelectInput>
                    <InputError class="mt-2" :message="errors.rating ? errors.rating[0] : ''" />
                </div>
            </div>

            <!-- Additional Notes and Note Strike First -->
            <div class="grid grid-cols-12 gap-6 mb-6">
                <div class="col-span-6">
                    <InputLabel for="additonal_note" value="Additional Notes" class="text-gray-600" />
                    <TextInput id="additonal_note" type="text" :disabled="isFieldEnable('note')"
                        class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500"
                        :class="isFieldEnable('note') ? 'bg-gray-200' : ''" v-model="form.note" required
                        placeholder="Enter additional Notes" />
                    <InputError class="mt-2" :message="errors.note ? errors.note[0] : ''" />
                </div>

                <div class="col-span-6">
                    <InputLabel for="note_strike_first" value="Note Strike First" class="text-gray-600" />
                    <SelectInput v-model="form.note_strike_first" :disabled="isFieldEnable('note_strike_first')"
                        class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500"
                        :class="isFieldEnable('note_strike_first') ? 'bg-gray-200' : ''">
                        <option v-for="note in noteStrikeFirst" :key="note" :value="note">{{ note }} </option>
                    </SelectInput>
                    <InputError class="mt-2" :message="errors.note_strike_first ? errors.note_strike_first[0] : ''" />
                </div>
            </div>

            <!-- Action and Status -->
            <div class="grid grid-cols-12 gap-6 mb-6">
                <div class="col-span-6">
                    <InputLabel for="action" value="Listen to Recording" class="text-gray-600" />
                    <TextInput id="action" type="text" :disabled="isFieldEnable('action')"
                        class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500"
                        :class="isFieldEnable('action') ? 'bg-gray-200' : ''" v-model="form.action" required
                        placeholder="Enter action" />
                        <InputError class="mt-2" :message="errors.action ? errors.action[0] : ''" />
                </div>
                <div class="col-span-6">
                    <InputLabel for="status" value="Status" class="text-gray-600" />
                    <SelectInput v-model="form.status" :disabled="isFieldEnable('status')"
                        class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500"
                        :class="isFieldEnable('status') ? 'bg-gray-200' : ''">
                        <option v-for="status in statuses" :key="status" :value="status">{{ status }}</option>
                    </SelectInput>
                    <InputError class="mt-2" :message="errors.status ? errors.status[0] : ''" />
                </div>
            </div>
            <div class="grid grid-cols-12 gap-6 mb-6">
                <div :class="`${userRole == 'admin' ?  'col-span-6' : 'col-span-12'}`">
                    <InputLabel for="start_time" value="Start Time" class="text-gray-600" />
                    <TextInput id="start_time" type="datetime-local" :disabled="isFieldEnable('start_time')"
                        class="mt-1 block w-full  border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500"
                        :class="isFieldEnable('start_time') ? 'bg-gray-200' : ''" v-model="form.start_time" required />
                        <InputError class="mt-2" :message="errors.start_time ? errors.start_time[0] : ''" />
                </div>
                <div class="col-span-6" v-if="userRole == 'admin'">
                    <InputLabel for="assigned_client" value="Assigned Client" class="text-gray-600" />
                    <SelectInput v-model="form.client_id" :disabled="isFieldEnable('client_id')"
                        class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500"
                        :class="isFieldEnable('client_id') ? 'bg-gray-200' : ''">
                        <option v-for="client in clients" :key="client" :value="client.id">{{ client.name }}</option>
                    </SelectInput>
                    <InputError class="mt-2" :message="errors.client_id ? errors.client_id[0] : ''" />
                </div>
            </div>
            <div class="mt-8 flex justify-end">
                <router-link :to="{ name: 'leads' }"
                    class="p-3 me-3 bg-red-500 text-white font-semibold rounded-lg hover:bg-red-400 focus:ring focus:ring-red-300">
                    Cancel
                </router-link>
                <PrimaryButton @click="submitForm()"
                    class="py-3 bg-blue-500 text-white font-semibold rounded-lg hover:bg-blue-600 focus:ring focus:ring-blue-300">
                    Update Lead
                </PrimaryButton>
            </div>
        </div>
    </DefaultCard>
</template>
<script setup>
import { ref, onMounted, computed } from "vue";
import DefaultCard from "@/components/Forms/DefaultCard.vue";
import InputLabel from "@/components/InputLabel.vue";
import PrimaryButton from "@/components/PrimaryButton.vue";
import TextInput from "@/components/TextInput.vue";
import SelectInput from "@/components/SelectInput.vue";
import { convertJsonToFormData, notificationMessage, getFieldsBaseOnRole } from "@/helpers";
import axios from "@/axios";
import LeadFilters from "@/LeadFilters/filters.js"
import { useRouter, useRoute } from 'vue-router';
import { useAuthStore } from "@/stores/auth";
import { useLeadsStore } from "@/stores/leadsStore";
import InputError from '@/components/InputError.vue';

const store = useAuthStore();
const leadStore = useLeadsStore();
const routes = useRoute();
const router = useRouter();
const form = ref({});
const baseUrl = import.meta.env.VITE_API_BASE_URL;
const statuses = computed(() => LeadFilters.leadStatus);
const leadTags = computed(() => LeadFilters.leadTags);
const leadRatings = computed(() => LeadFilters.leadRating);
const noteStrikeFirst = computed(() => LeadFilters.leadStrike);
const userRole = computed(() => store.getUserRole);
const leadId = ref();
const clients = ref([]);
const errors = ref([]);
const getAssignedFields = computed(() => store.getAssignedFields)
const queryData = ref({
    sortOrder: "ASC",
    perPage: "all"
});
const roleId = computed(() => store.getUser?.roles[0]?.id);
const currentLead = computed(() => leadStore.getCurrentLead);

const show = () => {
    if(currentLead){
        form.value = currentLead.value
    }
    // console.log(currentLead.value, 'show-method');
    // let endpoint = `${baseUrl}leads/${leadId.value}`
    // axios
    //     .get(endpoint)
    //     .then((response) => {
    //         form.value = response.data.data;
    //     })
    //     .catch((error) => { })
    //     .finally(() => { });
};

const submitForm = () => {
    let formData = "";
    const config = {
        headers: {
            "content-type": "multipart/form-data",
        },
    };
    formData = convertJsonToFormData(form.value);
    formData.append("_method", "PUT");
    let endpoint = `${baseUrl}leads/${leadId.value}`
    axios.post(endpoint, formData, config)
        .then((response) => {
            if (response.status) {
                notificationMessage('success', 'Lead updated successfully');
                router.push({ name: 'leads' });
            }
        })
        .catch((error) => {
            errors.value = error.response.data.errors;
         })
        .finally(() => { });
};

const createTable = () => {
    queryData.value.user_type = 'client';
    let endpoint = `${import.meta.env.VITE_API_BASE_URL}users`;
    axios
        .get(endpoint, {
            params: queryData.value,
        })
        .then((response) => {
            clients.value = response.data.data;
        })
        .catch((error) => { })
        .finally(() => { });
};

onMounted(() => {
    leadId.value = routes.params.id
    if (routes.params.id) {
        show();
        createTable();
    }
    store.updateFieldPermission(roleId.value);
});

const isFieldEnable = (field) => {
    if (userRole.value != 'admin') {
        let getFields = getFieldsBaseOnRole(userRole.value);
        if (getFields) {
            let isFieldEnable = getAssignedFields.value.includes(field);
            return !isFieldEnable;
        }
    }
    return false;
}
</script>
