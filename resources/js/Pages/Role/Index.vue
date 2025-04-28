<template>
    <div class="rounded-lg border border-gray-200 bg-white p-6 shadow-lg dark:border-gray-700 dark:bg-gray-800">

        <!-- Table Section -->
        <div class="mt-2 overflow-x-auto">
            <table
                class="w-full min-w-full border-collapse border border-gray-200 rounded-lg shadow-md dark:border-gray-700">
                <thead class="border-b-2 border-gray-300">
                    <tr class="bg-gray-2 text-left dark:bg-meta-4 whitespace-nowrap">
                        <th class="py-4 px-4 font-medium text-black dark:text-white">
                            #
                        </th>
                        <th class="py-4 px-4 font-medium text-black dark:text-white">
                            Name
                        </th>
                        <th class="py-4 px-4 font-medium text-black dark:text-white">
                            Action
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(role, index) in roles" :key="role"
                        class="border-t last:border-b hover:bg-gray-50 dark:hover:bg-gray-700">
                        <td class="px-4 py-3 text-sm text-gray-700 dark:text-gray-300">
                            {{ index + 1 }}
                        </td>

                        <td class="px-4 py-3 text-sm text-gray-700 dark:text-gray-300">
                            {{ role.name }}
                        </td>
                        <td class="px-4 py-3 text-right">
                            <div class="flex items-end space-x-3.5">
                                <PrimaryButton @click="openModal(role)" class="ms-4">
                                    Assign Permission
                                </PrimaryButton>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <AssignFieldsModal v-show="showModal" :showModal="showModal" :getFields="fieldsData" @close="closeModal"
            :roleId="roleId" :assignedFileds="assignedFileds" />
    </div>
</template>

<script setup>
import { ref, onMounted} from "vue";
import HTTP from "../../axios.js";
import PrimaryButton from '@/components/PrimaryButton.vue';
import { useAuthStore } from "@/stores/auth.js";
import AssignFieldsModal from "@/components/AssignFieldsModal.vue";
import { set } from "@vueuse/core";

const roles = ref([]);
const fieldsData = ref([]);
const showModal = ref(false);
const store = useAuthStore();
const roleId = ref('');
const assignedFileds = ref([]);



const createTable = (page) => {
    let endPoint = `${import.meta.env.VITE_API_BASE_URL}roles`;
    HTTP
        .get(endPoint)
        .then((response) => {
            roles.value = response.data.data;
        })
        .catch((error) => { })
        .finally(() => { });
};

const getLeadFields = (roleId) => {
    let endPoint = `${import.meta.env.VITE_API_BASE_URL}get/fields/${roleId}`;
    HTTP
        .get(endPoint)
        .then((response) => {
            let status = response.data?.status;
            if (status) {
                fieldsData.value = response.data.data;
            }
        })
        .catch((error) => { })
        .finally(() => { });
}

const getAssignLeadFields = async (roleId) => {
    let endPoint = `${import.meta.env.VITE_API_BASE_URL}get/fields/${roleId}`;
    await HTTP
        .get(endPoint)
        .then((response) => {
            let status = response.data?.status;
            if (status) {
                fieldsData.value = response.data.data;
            }
        })
        .catch((error) => { })
        .finally(() => { });
}

onMounted(() => {
    createTable(1);
});

const openModal = (role) => {
    roleId.value = role.id;
    getLeadFields(role.id);
    getAssignLeadFields(role.id);
    assignedFileds.value = role.assigned_fields
    setTimeout(() => {
        showModal.value = true;
    }, 500);
}

const closeModal = () => {
    showModal.value = false;
    assignedFileds.value = [];
    createTable();
}
</script>
