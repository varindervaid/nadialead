<template>
    <div class="rounded-lg border border-gray-200 bg-white p-6 shadow-lg dark:border-gray-700 dark:bg-gray-800">
        <!-- Filter and Actions -->
        <div class="space-y-4">
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
                <div class="relative">
                    <button @click="showFilterModal = true"
                        class="flex items-center gap-2 rounded bg-primary px-4.5 py-2 font-medium text-white hover:bg-opacity-80 py-3 bg-blue-500 text-white font-semibold rounded-lg hover:bg-blue-600 focus:ring focus:ring-blue-300">
                        Add Filter
                    </button>
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
                                <svg class="w-4 h-4 inline" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                    width="12" height="12" fill="none" viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" d="M8 20V7m0 13-4-4m4 4 4-4m4-12v13m0-13 4 4m-4-4-4 4" />
                                </svg>
                            </span>
                        </th>
                        <th class="py-4 px-4 font-medium text-black dark:text-white">
                            Action
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-if="serverBusy">
                        <td colspan="6">
                            <Loader height="10" width="10" />
                        </td>
                    </tr>
                    <tr v-else-if="isDataExist">
                        <td colspan="6" class="text-center pt-1 pb-1">
                            No records found.
                        </td>
                    </tr>
                    <tr v-else v-for="(rate, index) in leadRatings" :key="rate"
                        class="border-t last:border-b hover:bg-gray-50 dark:hover:bg-gray-700">
                        <td class="px-4 py-3 text-sm text-gray-700 dark:text-gray-300 w-[15%]">
                            {{
                                (pagination.currentPage - 1) *
                                pagination.perPage +
                                index +
                                1
                            }}
                        </td>
                        <td class="px-4 py-3 text-sm text-gray-700 dark:text-gray-300 w-[45%]">
                            <template v-if="!isFieldEditable || rate.id != filterId">{{ rate.name }}</template>                            
                            <form @submit.prevent="updateFilter(index)" v-if="isFieldEditable && rate.id == filterId" class="flex gap-3 items-start">
                                <div class="flex flex-col gap-1">
                                    <input v-model="filterName" @input="checkFilterName" id="name" type="text"
                                        class="p-1 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500"
                                        placeholder="Add filter name" required maxlength="20" />
                                        <span class="text-red" v-show="showError">{{ errorMessage }}</span>
                                </div>
                                <button type="submit"
                                    class="py-2 px-4 flex items-center gap-2 rounded bg-primary font-medium text-white hover:bg-opacity-80  bg-blue-500 text-white font-semibold rounded-lg hover:bg-blue-600 focus:ring focus:ring-blue-300">
                                    Edit Filter
                                </button>
                                <button @click="isFieldEditable = false" type="btn"
                                    class="py-2 px-4 bg-red-500 text-white font-semibold rounded-lg hover:bg-red-400 focus:ring focus:ring-red-300">
                                    Cancel
                                </button>
                            </form>
                        </td>
                        <td class="px-4 py-3 text-right w-[40%]">
                            <div class="flex items-end space-x-3.5">
                                <svg @click="editFilter(rate.id, rate.name)"
                                    class="w-6 h-6 text-gray-800 dark:text-white hover:text-red" aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                                    viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2"
                                        d="m14.304 4.844 2.852 2.852M7 7H4a1 1 0 0 0-1 1v10a1 1 0 0 0 1 1h11a1 1 0 0 0 1-1v-4.5m2.409-9.91a2.017 2.017 0 0 1 0 2.853l-6.844 6.844L8 14l.713-3.565 6.844-6.844a2.015 2.015 0 0 1 2.852 0Z" />
                                </svg>

                                <svg @click="deleteFilter('confirmation', rate.id)" xmlns="http://www.w3.org/2000/svg"
                                    width="18px" height="18px" viewBox="0 0 24 24" class="text-red-500 cursor-pointer"
                                    fill="currentcolor">
                                    <path
                                        d="M18.87 6h1.007l-.988 16.015A1.051 1.051 0 0 1 17.84 23H6.158a1.052 1.052 0 0 1-1.048-.984v-.001L4.123 6h1.003l.982 15.953a.05.05 0 0 0 .05.047h11.683zM9.5 19a.5.5 0 0 0 .5-.5v-10a.5.5 0 0 0-1 0v10a.5.5 0 0 0 .5.5zm5 0a.5.5 0 0 0 .5-.5v-10a.5.5 0 0 0-1 0v10a.5.5 0 0 0 .5.5zM5.064 5H3V4h5v-.75A1.251 1.251 0 0 1 9.25 2h5.5A1.251 1.251 0 0 1 16 3.25V4h5v1H5.064zM9 4h6v-.75a.25.25 0 0 0-.25-.25h-5.5a.25.25 0 0 0-.25.25z" />
                                    <path fill="none" d="M0 0h24v24H0z" />
                                </svg>
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
    <DeleteModal v-if="showModal" :showModal="showModal" :modalContent="modalContent" @deleteFilter="deleteFilter"
        @close="showModal = false">
    </DeleteModal>
    <AddFilterModal v-if="showFilterModal" :filterType="filterType" :showModal="showFilterModal"
        @close="showFilterModal = false" @filterAdded="filterAdded">
    </AddFilterModal>
</template>

<script setup>
import { ref, watch, onMounted, onUnmounted } from "vue";
import Pagination from "@/components/Pagination.vue";
import axios from '../../../axios.js';
import Loader from "@/components/Loader.vue";
import { notificationMessage } from "@/helpers.js";
import DeleteModal from "@/components/Common/DeleteModal.vue";
import AddFilterModal from "@/components/Common/AddFilterModal.vue"
const sortBy = ref(null); // Column currently sorted by
const sortOrder = ref("asc"); // 'asc' or 'desc'
const searchTimeout = ref(null);
const leadRatings = ref([]);
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
const showModal = ref(false);
const pagination = ref({
    currentPage: 1,
    lastPage: 1,
    total: 0,
    perPage: 10,
});
const serverBusy = ref(true);
const isDataExist = ref(false);
const destroyFilterId = ref();
const modalContent = ref('Are you want to sure to delete this filter?');
const showFilterModal = ref(false);
const filterType = ref('leadRating');
const isFieldEditable = ref(false);
const filterName = ref('');
const filterId = ref(0);
const showError = ref(false);
const errorMessage = ref('Required field. Please fill it in.');
const setPagination = (response) => {
    pagination.value.total = response.data.meta.total;
    pagination.value.lastPage = response.data.meta.last_page;
    pagination.value.currentPage = response.data.meta.current_page;
};

const createTable = (page) => {
    queryData.value.page = page;
    let endpoint = `${import.meta.env.VITE_API_BASE_URL}lead/ratings`;
    axios
        .get(endpoint, {
            params: queryData.value,
        })
        .then((response) => {
            if (response.data.data.length > 0) {
                leadRatings.value = response.data.data;
                pageData.value = response.data.meta;
                serverBusy.value = isDataExist.value = false;
                setPagination(response);
            } else {
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
            }, 1000)
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

const deleteFilter = (type = "", filterId = "") => {
    if (type == "confirmation") {
        showModal.value = true;
        destroyFilterId.value = filterId;
        return;
    }
    showModal.value = false;
    let endPoint = `${import.meta.env.VITE_API_BASE_URL}lead/ratings/${destroyFilterId.value}`;
    axios.delete(endPoint)
        .then((response) => {
            if (response.data.status) {
                createTable(1);
                notificationMessage("success", "Filter deleted successfully");
            }
        })
        .catch((error) => { })
        .finally(() => { });
};

const filterAdded = () => {
    showFilterModal.value = false;
    createTable(1);
    notificationMessage("success", "Filter added successfully");
}


const editFilter = (editId, editName) => {
    if(editName.length == 20){
        errorMessage.value = 'Filter name too long. Max 20 chars.';
        showError.value = true;
    }
    filterId.value = editId;
    filterName.value = editName;
    isFieldEditable.value = true;
}


const updateFilter = (index) => {

    if(!filterName.value){
        showError.value = true;
        return;
    }
    
    let endpoint = `${import.meta.env.VITE_API_BASE_URL}lead/ratings/${filterId.value}`;
    axios
        .put(endpoint, {
            name: filterName.value
        })
        .then((response) => {
            if (response.data.status) {
                showError.value = false;
                let leadDetail = response.data.data.name;
                leadRatings.value[index].name = leadDetail;
                isFieldEditable.value = false;
                notificationMessage("success", "Filter updated successfully");
            } else {
                serverBusy.value = false;
                isDataExist.value = true;

            }
        })
        .catch((error) => { })
        .finally(() => { });
}

const checkFilterName = () => {
    if (filterName.value && filterName.value.length == 20) {
        errorMessage.value = 'Filter name too long. Max 20 chars.';
        showError.value = true;
    }
}

onMounted(() => {

});

onUnmounted(() => {
    clearTimeout(searchTimeout.value);
});
</script>