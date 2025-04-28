<template>
    <div class="rounded-lg border border-gray-200 bg-white p-6 shadow-lg dark:border-gray-700 dark:bg-gray-800">
        <!-- Filter and Actions -->
        <div class="space-y-4">
            <!-- First Line: Filter and Alternative Button -->
            <div class="flex flex-wrap items-center justify-between">
                <!-- Role Filter -->
                <select @change="filter($event)" id="role" name="role"
                    class="block w-full lg:w-64 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                    <option value="" selected>Select Role</option>
                    <option value="client">Client</option>
                    <option value="team">Team</option>
                </select>
                <router-link :to="{ name: 'add.user' }"
                    class="py-2.5 px-5 text-sm font-medium text-gray-900 bg-white border border-gray-300 rounded-lg hover:bg-gray-100 hover:text-blue-700 focus:outline-none focus:ring-4 focus:ring-blue-200 dark:bg-gray-800 dark:border-gray-600 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                    Add User
                </router-link>
            </div>
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
                    <svg class="absolute right-3 top-2 h-6 w-6 text-gray-500 dark:text-gray-400"
                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 15l-4.35-4.35M10.5 7.5a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                </div>
            </div>
        </div>

        <!-- Table Section -->
        <div class="mt-2 overflow-x-auto">
            <table
                class="w-full min-w-full border-collapse border border-gray-200 rounded-lg shadow-md dark:border-gray-700">
                <thead class="border-b-2 border-gray-300">
                    <tr class="bg-gray-2 text-left dark:bg-meta-4 whitespace-nowrap">
                        <th @click="sortTable('id')"
                            class="py-4 px-4 font-medium text-black dark:text-white cursor-pointer">
                            #
                        </th>
                        <th @click="sortTable('name')"
                            class="py-4 px-4 font-medium text-black dark:text-white cursor-pointer">
                            Name
                            <span class="text-blue-500">
                                <svg class="w-4 h-4 inline" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="none" viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 20V7m0 13-4-4m4 4 4-4m4-12v13m0-13 4 4m-4-4-4 4"/>
                                </svg>
                            </span>
                        </th>
                        <th @click="sortTable('email')"
                            class="py-4 px-4 font-medium text-black dark:text-white cursor-pointer">
                            Email
                            <span class="text-blue-500">
                                <svg class="w-4 h-4 inline" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="none" viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 20V7m0 13-4-4m4 4 4-4m4-12v13m0-13 4 4m-4-4-4 4"/>
                                </svg>
                            </span>
                        </th>
                        <th
                            class="py-4 px-4 font-medium text-black dark:text-white cursor-pointer">
                            Role
                        </th>
                        <th class="py-4 px-4 font-medium text-black dark:text-white">
                            Action
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-if="serverBusy">
                        <td colspan="6">
                            <Loader />
                        </td>
                    </tr>
                    <tr v-else-if="isDataExist">
                        <td colspan="6" class="text-center pt-1 pb-1">
                            No records found.
                        </td>
                    </tr>
                    <tr v-else v-for="(user, index) in users" :key="user"
                        class="border-t last:border-b hover:bg-gray-50 dark:hover:bg-gray-700">
                        <td class="px-4 py-3 text-sm text-gray-700 dark:text-gray-300">
                            {{
                                (pagination.currentPage - 1) *
                                pagination.perPage +
                                index +
                                1
                            }}
                        </td>
                        <td class="px-4 py-3 text-sm text-gray-700 dark:text-gray-300">
                            {{ user.name }}
                        </td>
                        <td class="px-4 py-3 text-sm text-gray-700 dark:text-gray-300">
                            {{ user.email }}
                        </td>
                        <td class="px-4 py-3 text-sm text-gray-700 dark:text-gray-300 capitalize">
                            {{ user.role }}
                        </td>
                        <td class="px-4 py-3 text-right">
                            <div class="flex items-end space-x-3.5">
                                <router-link :to="{ name: 'edit.user', params: { id: user.id } }">
                                    <svg class="w-6 h-6 text-gray-800 dark:text-white hover:text-red" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m14.304 4.844 2.852 2.852M7 7H4a1 1 0 0 0-1 1v10a1 1 0 0 0 1 1h11a1 1 0 0 0 1-1v-4.5m2.409-9.91a2.017 2.017 0 0 1 0 2.853l-6.844 6.844L8 14l.713-3.565 6.844-6.844a2.015 2.015 0 0 1 2.852 0Z"/>
                                    </svg>
                                </router-link>
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
                Showing {{ pageData.from }} to {{ pageData.to }} of
                {{ pageData.total }}
                entries
            </div>
            <Pagination v-if="pagination.lastPage != 1" @refreshTable="createTable"
                :currentPage="pagination.currentPage" :lastPage="pagination.lastPage" :total="pagination.total" />
        </div>
    </div>
</template>

<script setup>
import { ref, watch, onMounted, onUnmounted } from "vue";
import Pagination from "@/components/Pagination.vue";
import axios from '../../axios.js';
import Loader from "@/components/Loader.vue";
const sortBy = ref(null); // Column currently sorted by
const sortOrder = ref("asc"); // 'asc' or 'desc'
const searchTimeout = ref(null);
const users = ref([]);
const search = ref("");
const perPage = ref(10);
const pageData = ref([]);
const queryData = ref({
    isRestore: "",
    page: 1,
    search: "",
    filters: {
        role: ''
    },
    sortBy: null,
    sortOrder: "DESC"

});

const pagination = ref({
    currentPage: 1,
    lastPage: 1,
    total: 0,
    perPage: 10,
});
const serverBusy = ref(true);
const isDataExist = ref(false);
const setPagination = (response) => {
    pagination.value.total = response.data.meta.total;
    pagination.value.lastPage = response.data.meta.last_page;
    pagination.value.currentPage = response.data.meta.current_page;
};

const createTable = (page) => {
    queryData.value.page = page;
    let endpoint = `${import.meta.env.VITE_API_BASE_URL}users`;
    axios
        .get(endpoint, {
            params: queryData.value,
        })
        .then((response) => {
            if(response.data.data.length > 0){
                users.value = response.data.data;
                pageData.value = response.data.meta;
                serverBusy.value = isDataExist.value = false;
                setPagination(response);
            }else{
                serverBusy.value = false;
                isDataExist.value = true;
            }
        })
        .catch((error) => { })
        .finally(() => { });
};

const pageChange = (event) => {
    queryData.value.perPage = event.target.value;
    createTable(1);
};

watch(
    [search, () => queryData.value.filters.role, () => queryData.value.sortBy, () => queryData.value.sortOrder],
    (newValues, oldValues) => {
        clearTimeout(searchTimeout.value);
        serverBusy.value = true;
        searchTimeout.value = setTimeout(() => {
            queryData.value.search = search.value;
            createTable(1);
            setTimeout(() => {
                serverBusy.value = false;
            },1000)
        }, 700);
    },
    { immediate: true }
);
const filter = (event) => {
    queryData.value.filters[event.target.name] = event.target.value;
}

const sortTable = (column) => {
    if (sortBy.value === column) {
        sortOrder.value = sortOrder.value === "asc" ? "desc" : "asc";
    } else {
        sortBy.value = column;
        sortOrder.value = "desc";
    }
    queryData.value.sortBy = column;
    queryData.value.sortOrder = sortOrder.value;

};

onMounted(() => {
});

onUnmounted(() => {
    clearTimeout(searchTimeout.value);
});
</script>
