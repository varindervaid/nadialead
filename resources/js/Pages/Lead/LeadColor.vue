<template>
    <BreadcrumbDefault pageTitle="Lead color" />
    <div class="rounded-lg border border-gray-200 bg-white p-6 shadow-lg dark:border-gray-700 dark:bg-gray-800">
        <!-- Filter and Actions -->
        <div class="space-y-4">
            <!-- First Line: Filter and Alternative Button -->
            <div class="flex flex-wrap items-center justify-between">
                <!-- Role Filter -->
                <div class="flex gap-2">
                    <select id="roles" @change="filter($event)" name="role"
                        class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500">
                        <option value="" selected>Select Role</option>
                        <option v-for="role in roles" :key="role" :value="role.id">{{
                            role.name.charAt(0).toUpperCase() + role.name.slice(1) }}</option>
                    </select>
                </div>
                <div class="gap-5">
                    <PrimaryButton @click="showModal()">
                        <svg class="fill-current" width="16" height="16" viewBox="0 0 16 16" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M15 7H9V1C9 0.4 8.6 0 8 0C7.4 0 7 0.4 7 1V7H1C0.4 7 0 7.4 0 8C0 8.6 0.4 9 1 9H7V15C7 15.6 7.4 16 8 16C8.6 16 9 15.6 9 15V9H15C15.6 9 16 8.6 16 8C16 7.4 15.6 7 15 7Z"
                                fill=""></path>
                        </svg>
                        Add color
                    </PrimaryButton>
                </div>
            </div>
            <!-- Second Line: Show Entries and Search Bar -->
            <div class="flex flex-wrap items-center justify-between">
                <!-- Entries Per Page -->
                <div class="flex items-center space-x-2">
                    <label for="perPage" class="text-sm font-medium text-gray-700 dark:text-gray-300">
                        Show
                    </label>
                    <select id="perPage" v-model="perPage" @change="pageChange"
                        class="text-sm rounded-lg w-16 border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white p-2">
                        <option value="10">10</option>
                        <option value="30">30</option>
                        <option value="50">50</option>
                        <option value="100">100</option>
                    </select>
                    <span class="text-sm text-gray-600 dark:text-gray-400">Entries</span>
                </div>

                <!-- Search Bar -->
                <div class="relative w-full md:w-64">
                    <input type="search" v-model="search" placeholder="Search..."
                        class="block w-full px-4 py-2 rounded-lg border text-sm text-gray-700 dark:text-gray-200 bg-gray-50 dark:bg-gray-700 border-gray-300 dark:border-gray-600 focus:ring-blue-500 focus:border-blue-500" />
                    <svg class="absolute right-3 top-3 h-4 w-4 text-gray-500 dark:text-gray-400"
                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 15l-4.35-4.35M10.5 7.5a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                </div>
            </div>
        </div>

        <!-- Table Section -->
        <div class="mt-3 overflow-x-auto">
            <table
                class="w-full min-w-full border-collapse border border-gray-200 rounded-lg shadow-md dark:border-gray-700">
                <thead class="border-b-2 border-gray-300">
                    <tr class="bg-gray-2 text-left dark:bg-meta-4 whitespace-nowrap">
                        <th width="40" class="py-4 px-4 font-medium text-black dark:text-white xl:pl-11">
                            #
                        </th>
                        <th class="min-w-[220px] py-4 px-4 font-medium text-black dark:text-white xl:pl-11">
                            Column
                        </th>
                        <th class="min-w-[150px] py-4 px-4 font-medium text-black dark:text-white">
                            Colors
                        </th>
                        <th class="min-w-[120px] py-4 px-4 font-medium text-black dark:text-white">
                            Role
                        </th>
                        <th class="py-4 px-4 font-medium text-black dark:text-white">
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="whitespace-nowrap" v-for="(color, index) in colors" :key="color">
                        <td class="py-5 px-4 pl-9 xl:pl-11">
                            {{ (pagination.currentPage - 1) * pagination.perPage + index + 1 }}
                        </td>
                        <td class="py-5 px-4 pl-9 xl:pl-11">
                            <h5 class="font-medium text-black dark:text-white">
                                {{ color.column_key_val }}
                            </h5>
                        </td>
                        <td class="py-5 px-4">
                            <div class="w-8 h-8 rounded-full" :style="{ backgroundColor: color.color }"></div>
                        </td>
                        <td class="py-5 px-4">
                            <p class="text-black dark:text-white">
                                {{ color.role_val }}
                            </p>
                        </td>

                        <td class="py-5 px-4">
                            <div class="flex items-center space-x-3.5">
                                <button @click="showModal(color)" class="hover:text-primary">
                                    <svg class="fill-current" width="18" height="18" viewBox="0 0 18 18" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M8.99981 14.8219C3.43106 14.8219 0.674805 9.50624 0.562305 9.28124C0.47793 9.11249 0.47793 8.88749 0.562305 8.71874C0.674805 8.49374 3.43106 3.20624 8.99981 3.20624C14.5686 3.20624 17.3248 8.49374 17.4373 8.71874C17.5217 8.88749 17.5217 9.11249 17.4373 9.28124C17.3248 9.50624 14.5686 14.8219 8.99981 14.8219ZM1.85605 8.99999C2.4748 10.0406 4.89356 13.5562 8.99981 13.5562C13.1061 13.5562 15.5248 10.0406 16.1436 8.99999C15.5248 7.95936 13.1061 4.44374 8.99981 4.44374C4.89356 4.44374 2.4748 7.95936 1.85605 8.99999Z"
                                            fill="" />
                                        <path
                                            d="M9 11.3906C7.67812 11.3906 6.60938 10.3219 6.60938 9C6.60938 7.67813 7.67812 6.60938 9 6.60938C10.3219 6.60938 11.3906 7.67813 11.3906 9C11.3906 10.3219 10.3219 11.3906 9 11.3906ZM9 7.875C8.38125 7.875 7.875 8.38125 7.875 9C7.875 9.61875 8.38125 10.125 9 10.125C9.61875 10.125 10.125 9.61875 10.125 9C10.125 8.38125 9.61875 7.875 9 7.875Z"
                                            fill="" />
                                    </svg>
                                </button>
                                <!-- <Link :href="route('lead_color.delete', { id: color.id })" class="hover:text-primary">
                                <svg class="fill-current" width="18" height="18" viewBox="0 0 18 18" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M13.7535 2.47502H11.5879V1.9969C11.5879 1.15315 10.9129 0.478149 10.0691 0.478149H7.90352C7.05977 0.478149 6.38477 1.15315 6.38477 1.9969V2.47502H4.21914C3.40352 2.47502 2.72852 3.15002 2.72852 3.96565V4.8094C2.72852 5.42815 3.09414 5.9344 3.62852 6.1594L4.07852 15.4688C4.13477 16.6219 5.09102 17.5219 6.24414 17.5219H11.7004C12.8535 17.5219 13.8098 16.6219 13.866 15.4688L14.3441 6.13127C14.8785 5.90627 15.2441 5.3719 15.2441 4.78127V3.93752C15.2441 3.15002 14.5691 2.47502 13.7535 2.47502ZM7.67852 1.9969C7.67852 1.85627 7.79102 1.74377 7.93164 1.74377H10.0973C10.2379 1.74377 10.3504 1.85627 10.3504 1.9969V2.47502H7.70664V1.9969H7.67852ZM4.02227 3.96565C4.02227 3.85315 4.10664 3.74065 4.24727 3.74065H13.7535C13.866 3.74065 13.9785 3.82502 13.9785 3.96565V4.8094C13.9785 4.9219 13.8941 5.0344 13.7535 5.0344H4.24727C4.13477 5.0344 4.02227 4.95002 4.02227 4.8094V3.96565ZM11.7285 16.2563H6.27227C5.79414 16.2563 5.40039 15.8906 5.37227 15.3844L4.95039 6.2719H13.0785L12.6566 15.3844C12.6004 15.8625 12.2066 16.2563 11.7285 16.2563Z"
                                        fill="" />
                                    <path
                                        d="M9.00039 9.11255C8.66289 9.11255 8.35352 9.3938 8.35352 9.75942V13.3313C8.35352 13.6688 8.63477 13.9782 9.00039 13.9782C9.33789 13.9782 9.64727 13.6969 9.64727 13.3313V9.75942C9.64727 9.3938 9.33789 9.11255 9.00039 9.11255Z"
                                        fill="" />
                                    <path
                                        d="M11.2502 9.67504C10.8846 9.64692 10.6033 9.90004 10.5752 10.2657L10.4064 12.7407C10.3783 13.0782 10.6314 13.3875 10.9971 13.4157C11.0252 13.4157 11.0252 13.4157 11.0533 13.4157C11.3908 13.4157 11.6721 13.1625 11.6721 12.825L11.8408 10.35C11.8408 9.98442 11.5877 9.70317 11.2502 9.67504Z"
                                        fill="" />
                                    <path
                                        d="M6.72245 9.67504C6.38495 9.70317 6.1037 10.0125 6.13182 10.35L6.3287 12.825C6.35683 13.1625 6.63808 13.4157 6.94745 13.4157C6.97558 13.4157 6.97558 13.4157 7.0037 13.4157C7.3412 13.3875 7.62245 13.0782 7.59433 12.7407L7.39745 10.2657C7.39745 9.90004 7.08808 9.64692 6.72245 9.67504Z"
                                        fill="" />
                                </svg>
                                </Link> -->
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div
            class="mt-6 flex flex-col sm:flex-row sm:items-center sm:justify-between space-y-4 sm:space-y-0 text-sm text-gray-700 dark:text-gray-300">
            <div>
                Showing {{ pageData.from }} to {{ pageData.to }} of {{ pageData.total }}
                entries
            </div>
            <Pagination v-if="pagination.lastPage != 1" @refreshTable="createTable"
                :currentPage="pagination.currentPage" :lastPage="pagination.lastPage" :total="pagination.total" />
        </div>
    </div>
    <Modal ref="modal" :show="modalState" @close="closeModal()">
        <button @click="showList" class="absolute right-1 top-1 sm:right-5 sm:top-5">
            <svg class="fill-current" width="20" height="20" viewBox="0 0 20 20" fill="none"
                xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" clip-rule="evenodd"
                    d="M11.8913 9.99599L19.5043 2.38635C20.032 1.85888 20.032 1.02306 19.5043 0.495589C18.9768 -0.0317329 18.141 -0.0317329 17.6135 0.495589L10.0001 8.10559L2.38673 0.495589C1.85917 -0.0317329 1.02343 -0.0317329 0.495873 0.495589C-0.0318274 1.02306 -0.0318274 1.85888 0.495873 2.38635L8.10887 9.99599L0.495873 17.6056C-0.0318274 18.1331 -0.0318274 18.9689 0.495873 19.4964C0.717307 19.7177 1.05898 19.9001 1.4413 19.9001C1.75372 19.9001 2.13282 19.7971 2.40606 19.4771L10.0001 11.8864L17.6135 19.4964C17.8349 19.7177 18.1766 19.9001 18.5589 19.9001C18.8724 19.9001 19.2531 19.7964 19.5265 19.4737C20.0319 18.9452 20.0245 18.1256 19.5043 17.6056L11.8913 9.99599Z"
                    fill=""></path>
            </svg>
        </button>
        <DefaultCard cardTitle="Lead color">
            <div class="p-4 shadow sm:rounded-lg sm:p-8">
                <div class="mb-4">
                    <InputLabel for="column_key" value="Column Name" />

                    <SelectInput id="column_key" class="mt-1 block w-full" v-model="form.column_key" required autofocus
                        :disabled="row ? true : false">
                        <option v-for="(column) in columns" :key="column" :value="column">
                            {{ column }}
                        </option>
                    </SelectInput>
                    <!-- <InputError class="mt-2" :message="form.errors.column_key" /> -->
                </div>
                <div class="mb-4">
                    <InputLabel for="color" value="Color" />

                    <TextInput id="color" type="color" class="mt-1 block w-full p-2" v-model="form.color" required
                        style="height: 60px; width: 60px; padding: 10px" />

                    <!-- <InputError class="mt-2" :message="form.errors.color" /> -->
                </div>
                <div class="mb-4">
                    <InputLabel for="role" value="Role" />
                    <div v-if="form.role_val">
                        <input id="role" type="checkbox" readonly v-model="form.roles" :checked="true"
                            class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                        <label for="role"
                            class="w-full py-4 ms-2 text-sm font-medium text-gray-900 dark:text-gray-300 uppercase">{{
                                form.role_val }}</label>
                    </div>
                    <div v-else>
                        <div v-for="(role) in roles" :key="role.id"
                            class="flex items-center ps-4 border border-gray-200 rounded dark:border-gray-700 mb-2">
                            <input :id="'role_' + role.id" type="checkbox" v-model="form.roles" :value="role.id"
                                class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                            <label :for="'role_' + role.id"
                                class="w-full py-4 ms-2 text-sm font-medium text-gray-900 dark:text-gray-300 uppercase">{{
                                    role.name }}</label>
                        </div>
                    </div>
                    <!-- <InputError class="mt-2" :message="form.errors.role" /> -->
                </div>
                <div class="mt-4 flex items-center justify-end">
                    <PrimaryButton class="" @click="submitForm">
                        Save
                    </PrimaryButton>
                </div>
            </div>
        </DefaultCard>
    </Modal>
</template>

<script setup>
import { ref, watch, onMounted, onUnmounted } from "vue";
import InputError from "@/components/InputError.vue";
import Modal from "@/components/Modal.vue";
import InputLabel from "@/components/InputLabel.vue";
import PrimaryButton from "@/components/PrimaryButton.vue";
import TextInput from "@/components/TextInput.vue";
import SelectInput from "@/components/SelectInput.vue";
import DefaultCard from "@/components/Forms/DefaultCard.vue";
import Pagination from "@/components/Pagination.vue";
import BreadcrumbDefault from "@/components/Breadcrumbs/BreadcrumbDefault.vue";
import axios from "axios";
import { notificationMessage } from "@/helpers";
import HTTP from "../../axios.js";

// const props = defineProps({
//     roles: Array,
// });


const columns = [
  "id",
  "start_time",
  "name",
  "phone",
  "city",
  "state",
  "source",
  "lead_tag",
  "qualification_status",
  "rating",
  "note",
  "note_strike_first",
  "action",
  "status",
  "lead_id",
  "created_at",
  "updated_at"
];
const modalState = ref(false);
const form = ref({ roles: [], color: '#000' });
const searchTimeout = ref(null);
const colors = ref([]);
const search = ref("");
const perPage = ref(10);
const pageData = ref([]);
const queryData = ref({
    page: 1,
    search: "",
    filters: {
        role: ""
    },
});
const roles = ref([]);
const pagination = ref({
    currentPage: 1,
    lastPage: 1,
    total: 0,
    perPage: 10,
});
const baseUrl = import.meta.env.VITE_API_BASE_URL;

const setPagination = (response) => {
    pagination.value.total = response.data.meta.total;
    pagination.value.lastPage = response.data.meta.last_page;
    pagination.value.currentPage = response.data.meta.current_page;
};
const submitForm = () => {
    let method = "post";
    let endPoint = `${baseUrl}leadcolors`;
    if (form.value.id) {
        method = "put";
        endPoint = `${baseUrl}leadcolors/${form.value.id}`;
    }
    const requestData = { ...form.value };
    HTTP[method](endPoint, requestData)
        .then((response) => {
            if (response.status) {
                const messageType = (form.value.id) ? 'updated' : 'addedd';
                notificationMessage('success', `Lead color ${messageType} successfully`);
                modalState.value = false;
                form.value = {
                    roles: [],
                    color: '#000'
                };
                createTable(1);
            }
        })
        .catch((error) => { })
        .finally(() => { });
};

const createTable = (page) => {
    queryData.value.page = page;
    // axios
    //     .get(route("leadcolors.index"), {
    //         params: queryData.value,
    //     })
    //     .then((response) => {
    //         colors.value = response.data.data;
    //         pageData.value = response.data.meta;
    //         setPagination(response);
    //     })
    //     .catch((error) => { })
    //     .finally(() => { });
    let endpoint = `${baseUrl}leadcolors`
    HTTP
        .get(endpoint, {
            params: queryData.value,
        })
        .then((response) => {
            colors.value = response.data.data;
            pageData.value = response.data.meta;
            setPagination(response);
        })
        .catch((error) => { })
        .finally(() => { });
};


const pageChange = (event) => {
    queryData.value.perPage = event.target.value;
    createTable(1);
};

const filter = (event) => {
    queryData.value.filters[event.target.name] = event.target.value;
}

watch(
    [search, () => queryData.value.filters.role],
    (newValues, oldValues) => {
        clearTimeout(searchTimeout.value);
        searchTimeout.value = setTimeout(() => {
            queryData.value.search = search.value;
            createTable(1);
        }, 700);
    },
    { immediate: true }
);


onUnmounted(() => {
    clearTimeout(searchTimeout.value);
});
const showModal = (data = null) => {
    modalState.value = true;
    if (data != null) {
        form.value = data;
    }
}

const closeModal = () => {
    modalState.value = false;
    setTimeout(() => {
        form.value = {
            roles: [],
            color: '#000'
        };
    }, 200);
}

onMounted(() => {
    getRoles();
});

const getRoles = () => {
    let endpoint = `${baseUrl}roles`;
    HTTP
        .get(endpoint)
        .then((response) => {
            roles.value = response.data.data;
            console.log(roles, 'get-roles');
        })
        .catch((error) => console.log(error))
        .finally(() => { });
}

</script>
