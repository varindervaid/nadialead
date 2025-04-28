<template>
    <div class="rounded-lg border border-gray-200 bg-white p-6 shadow-lg dark:border-gray-700 dark:bg-gray-800">
        <!-- Filter and Actions -->
        <div class="space-y-4">
            <!-- First Line: Filter and Alternative Button -->
            <div class="flex flex-wrap items-center justify-between">
                <!-- Lead Tag Filter -->
                <div class="flex gap-2">
                    <select id="leadTags" @change="filter($event)" name="leadTag"
                        class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500">
                        <option value="" selected>Select Lead Tag</option>
                        <option v-for="tag in leadTags" :key="tag" :value="tag">
                            {{ tag }}
                        </option>
                    </select>
                    <select id="leadRatings" @change="filter($event)" name="rating"
                        class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500">
                        <option value="" selected>Select Lead Rating</option>
                        <option v-for="rating in leadRatings" :key="rating" :value="rating">
                            {{ rating }}
                        </option>
                    </select>

                    <select id="noteStrikeFirst" @change="filter($event)" name="noteStrikeFirst"
                        class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500">
                        <option value="" selected>
                            Select Note(Strike First)
                        </option>
                        <option v-for="note in noteStrikeFirst" :key="note" :value="note">
                            {{ note }}
                        </option>
                    </select>

                    <select id="statuses" @change="filter($event)" name="status"
                        class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500">
                        <option value="" selected>Select Status</option>
                        <option v-for="status in statuses" :key="status" :value="status">
                            {{ status }}
                        </option>
                    </select>
                </div>
                <div class="gap-5 flex">
                    <PrimaryButton @click="exportLeads()">
                        Export Lead
                    </PrimaryButton>
                    <router-link v-if="roleType != 'client'" :to="{ name: 'lead.import' }"
                        class="py-2.5 px-5 text-sm font-medium text-gray-900 bg-white border border-gray-300 rounded-lg hover:bg-gray-100 hover:text-blue-700 focus:outline-none focus:ring-4 focus:ring-blue-200 dark:bg-gray-800 dark:border-gray-600 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                        Import Lead
                    </router-link>
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
                    <svg class="absolute right-3 top-2 h-6 w-6 text-gray-500 dark:text-gray-400"
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
                        <th v-if="roleType != 'client'" class="py-4 px-4 font-medium text-black dark:text-white">
                            Assigned To
                        </th>
                        <th class="py-4 px-4 font-medium text-black dark:text-white xl:pl-11"
                            @click="sortTable('start_time')">
                            Start Time
                            <span class="text-blue-500">
                                <svg class="w-4 h-4 inline" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                    width="12" height="12" fill="none" viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" d="M8 20V7m0 13-4-4m4 4 4-4m4-12v13m0-13 4 4m-4-4-4 4" />
                                </svg>
                            </span>
                        </th>
                        <th class="py-4 px-4 font-medium text-black dark:text-white" @click="sortTable('name')">
                            Name
                            <span class="text-blue-500">
                                <svg class="w-4 h-4 inline" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                    width="12" height="12" fill="none" viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" d="M8 20V7m0 13-4-4m4 4 4-4m4-12v13m0-13 4 4m-4-4-4 4" />
                                </svg>
                            </span>
                        </th>
                        <th class="py-4 px-4 font-medium text-black dark:text-white" @click="sortTable('phone')">
                            Phone
                            <span class="text-blue-500">
                                <svg class="w-4 h-4 inline" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                    width="12" height="12" fill="none" viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" d="M8 20V7m0 13-4-4m4 4 4-4m4-12v13m0-13 4 4m-4-4-4 4" />
                                </svg>
                            </span>
                        </th>
                        <th class="py-4 px-4 font-medium text-black dark:text-white" @click="sortTable('state')">
                            State
                            <span class="text-blue-500">
                                <svg class="w-4 h-4 inline" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                    width="12" height="12" fill="none" viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" d="M8 20V7m0 13-4-4m4 4 4-4m4-12v13m0-13 4 4m-4-4-4 4" />
                                </svg>
                            </span>
                        </th>
                        <th class="py-4 px-4 font-medium text-black dark:text-white" @click="sortTable('city')">
                            City
                            <span class="text-blue-500">
                                <svg class="w-4 h-4 inline" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                    width="12" height="12" fill="none" viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" d="M8 20V7m0 13-4-4m4 4 4-4m4-12v13m0-13 4 4m-4-4-4 4" />
                                </svg>
                            </span>
                        </th>
                        <th class="py-4 px-4 font-medium text-black dark:text-white" @click="sortTable('source')">
                            Source
                            <span class="text-blue-500">
                                <svg class="w-4 h-4 inline" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                    width="12" height="12" fill="none" viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" d="M8 20V7m0 13-4-4m4 4 4-4m4-12v13m0-13 4 4m-4-4-4 4" />
                                </svg>
                            </span>
                        </th>
                        <th class="py-4 px-4 font-medium text-black dark:text-white" @click="sortTable('lead_tag')">
                            Lead Tag
                            <span class="text-blue-500">
                                <svg class="w-4 h-4 inline" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                    width="12" height="12" fill="none" viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" d="M8 20V7m0 13-4-4m4 4 4-4m4-12v13m0-13 4 4m-4-4-4 4" />
                                </svg>
                            </span>
                        </th>
                        <th class="py-4 px-4 font-medium text-black dark:text-white"
                            @click="sortTable('qualification_status')">
                            Qualification Status
                            <span class="text-blue-500">
                                <svg class="w-4 h-4 inline" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                    width="12" height="12" fill="none" viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" d="M8 20V7m0 13-4-4m4 4 4-4m4-12v13m0-13 4 4m-4-4-4 4" />
                                </svg>
                            </span>
                        </th>
                        <th class="py-4 px-4 font-medium text-black dark:text-white" @click="sortTable('rating')">
                            Rating
                            <span class="text-blue-500">
                                <svg class="w-4 h-4 inline" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                    width="12" height="12" fill="none" viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" d="M8 20V7m0 13-4-4m4 4 4-4m4-12v13m0-13 4 4m-4-4-4 4" />
                                </svg>
                            </span>
                        </th>
                        <th class="py-4 px-4 font-medium text-black dark:text-white"
                            @click="sortTable('note_strike_first')">
                            Notes (Strike First)
                            <span class="text-blue-500">
                                <svg class="w-4 h-4 inline" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                    width="12" height="12" fill="none" viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" d="M8 20V7m0 13-4-4m4 4 4-4m4-12v13m0-13 4 4m-4-4-4 4" />
                                </svg>
                            </span>
                        </th>

                        <th class="py-4 px-4 font-medium text-black dark:text-white" @click="sortTable('status')">
                            Status
                            <span class="text-blue-500">
                                <svg class="w-4 h-4 inline" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                    width="12" height="12" fill="none" viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" d="M8 20V7m0 13-4-4m4 4 4-4m4-12v13m0-13 4 4m-4-4-4 4" />
                                </svg>
                            </span>
                        </th>
                        <th class="py-4 px-4 font-medium text-black dark:text-white">
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-if="serverBusy" class="whitespace-nowrap">
                        <td colspan="13">
                            <Loader />
                        </td>
                    </tr>
                    <tr v-else-if="isDataExist">
                        <td colspan="13" class="text-center pt-1 pb-1">
                            No records found.
                        </td>
                    </tr>
                    <tr v-else class="whitespace-nowrap" v-for="(lead, index) in leads" :key="lead">
                        <td class="py-5 px-4 pl-9 xl:pl-11">
                            {{
                                (pagination.currentPage - 1) *
                                pagination.perPage +
                                index +
                                1
                            }}
                        </td>
                        <td v-if="roleType != 'client'" class="py-5 px-4">
                            <PrimaryButton v-if="lead.client_id" class="ms-4">
                                {{ lead.client_name }}
                            </PrimaryButton>
                            <PrimaryButton v-else class="ms-4 bg-red-400">
                                Not Assigned
                            </PrimaryButton>
                        </td>
                        <td class="py-5 px-4">
                            <p class="text-black dark:text-white">
                                {{ lead.start_time }}
                            </p>
                        </td>
                        <td class="py-5 px-4">
                            <p class="text-black dark:text-white">
                                {{ lead.name }}
                            </p>
                        </td>
                        <td class="py-5 px-4">
                            <p class="text-black dark:text-white">
                                {{ lead.phone }}
                            </p>
                        </td>
                        <td class="py-5 px-4">
                            <p class="text-black dark:text-white">
                                {{ lead.state }}
                            </p>
                        </td>
                        <td class="py-5 px-4">
                            <p class="text-black dark:text-white">
                                {{ lead.city }}
                            </p>
                        </td>
                        <td class="py-5 px-4">
                            <p class="text-black dark:text-white">
                                {{ lead.source }}
                            </p>
                        </td>
                        <td class="py-5 px-4">
                            <p class="text-black dark:text-white">
                                {{ lead.lead_tag }}
                            </p>
                        </td>
                        <td class="py-5 px-4">
                            <p class="text-black dark:text-white">
                                {{
                                    lead.qualification_status
                                        ? "Qualified"
                                        : "Unqualified"
                                }}
                            </p>
                        </td>
                        <td class="py-5 px-4">
                            <p class="text-black dark:text-white">
                                {{ lead.rating }}
                            </p>
                        </td>
                        <td class="py-5 px-4">
                            <p class="text-black dark:text-white">
                                {{ lead.note_strike_first }}
                            </p>
                        </td>

                        <td class="py-5 px-4">
                            <p class="text-black dark:text-white">
                                {{ lead.status }}
                            </p>
                        </td>
                        <td class="py-5 px-4">
                            <div class="flex items-center space-x-2">
                                <!-- :to="{name: 'lead.update', params: lead.id}" -->
                                <router-link :to="{
                                    name: 'lead.update',
                                    params: { id: lead.id },
                                }" class="hover:text-primary">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18px" height="18px"
                                        viewBox="0 0 24 24" fill="none">
                                        <path
                                            d="M21.2799 6.40005L11.7399 15.94C10.7899 16.89 7.96987 17.33 7.33987 16.7C6.70987 16.07 7.13987 13.25 8.08987 12.3L17.6399 2.75002C17.8754 2.49308 18.1605 2.28654 18.4781 2.14284C18.7956 1.99914 19.139 1.92124 19.4875 1.9139C19.8359 1.90657 20.1823 1.96991 20.5056 2.10012C20.8289 2.23033 21.1225 2.42473 21.3686 2.67153C21.6147 2.91833 21.8083 3.21243 21.9376 3.53609C22.0669 3.85976 22.1294 4.20626 22.1211 4.55471C22.1128 4.90316 22.0339 5.24635 21.8894 5.5635C21.7448 5.88065 21.5375 6.16524 21.2799 6.40005V6.40005Z"
                                            stroke="currentColor" class="" stroke-width="1.5" stroke-linecap="round"
                                            stroke-linejoin="round" />
                                        <path
                                            d="M11 4H6C4.93913 4 3.92178 4.42142 3.17163 5.17157C2.42149 5.92172 2 6.93913 2 8V18C2 19.0609 2.42149 20.0783 3.17163 20.8284C3.92178 21.5786 4.93913 22 6 22H17C19.21 22 20 20.2 20 18V13"
                                            stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                            stroke-linejoin="round" />
                                    </svg>
                                    <i class="fa fa-edit"></i>
                                </router-link>
                                <svg v-if="roleType == 'admin'" @click="
                                    destroyLead('confirmation', lead.id)
                                    " xmlns="http://www.w3.org/2000/svg" width="18px" height="18px" viewBox="0 0 24 24"
                                    class="text-red-500 cursor-pointer" fill="currentcolor">
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

        <Modal ref="modal" v-show="showModal" :show="showModal" @click="showModal = false">
            <button @click="showList" class="absolute right-1 top-1 sm:right-5 sm:top-5">
                <svg class="fill-current" width="20" height="20" viewBox="0 0 20 20" fill="none"
                    xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" clip-rule="evenodd"
                        d="M11.8913 9.99599L19.5043 2.38635C20.032 1.85888 20.032 1.02306 19.5043 0.495589C18.9768 -0.0317329 18.141 -0.0317329 17.6135 0.495589L10.0001 8.10559L2.38673 0.495589C1.85917 -0.0317329 1.02343 -0.0317329 0.495873 0.495589C-0.0318274 1.02306 -0.0318274 1.85888 0.495873 2.38635L8.10887 9.99599L0.495873 17.6056C-0.0318274 18.1331 -0.0318274 18.9689 0.495873 19.4964C0.717307 19.7177 1.05898 19.9001 1.4413 19.9001C1.75372 19.9001 2.13282 19.7971 2.40606 19.4771L10.0001 11.8864L17.6135 19.4964C17.8349 19.7177 18.1766 19.9001 18.5589 19.9001C18.8724 19.9001 19.2531 19.7964 19.5265 19.4737C20.0319 18.9452 20.0245 18.1256 19.5043 17.6056L11.8913 9.99599Z"
                        fill=""></path>
                </svg>
            </button>
            <DefaultCard cardTitle="Delete Item Confirmation" @click.stop>
                <div class="p-4 shadow sm:rounded-lg sm:p-8">
                    <form id="permissionsForm">
                        <div class="flex flex-wrap gap-4">
                            <p>Are you want to sure to delete this lead?</p>
                        </div>
                        <div class="mt-4 flex justify-end space-x-1">
                            <button type="button"
                                class="p-3 me-3 bg-red-500 text-white font-semibold rounded-lg hover:bg-red-400 focus:ring focus:ring-red-300"
                                @click="showModal = false">
                                Cancel
                            </button>
                            <button type="submit" @click.prevent="destroyLead"
                                class="lex items-center gap-2 mx-2 rounded bg-primary px-4.5 py-2 font-medium text-white hover:bg-opacity-80 py-3 bg-blue-500 text-white font-semibold rounded-lg hover:bg-blue-600 focus:ring focus:ring-blue-300">
                                Delete Lead
                            </button>
                        </div>
                    </form>
                </div>
            </DefaultCard>
        </Modal>
    </div>
</template>

<script setup>
import { ref, watch, onMounted, onUnmounted, computed } from "vue";

import Pagination from "@/components/Pagination.vue";
import HTTP from "../../axios.js";
import { useAuthStore } from "@/stores/auth.js";
import LeadFilters from "@/LeadFilters/filters.js";
import Loader from "@/components/Loader.vue";
import PrimaryButton from "@/components/PrimaryButton.vue";
import { all } from "axios";
import Modal from "@/components/Modal.vue";
import DefaultCard from "@/components/Forms/DefaultCard.vue";
import { notificationMessage, getFilters } from "@/helpers.js";
const statuses = ref([]);
const leadTags = ref([]);
const leadRatings = ref([]);
const noteStrikeFirst = ref([]);
const store = useAuthStore();
const roleType = computed(() => store.getUserRole);

const sortBy = ref(null); // Column currently sorted by
const sortOrder = ref("asc"); // 'asc' or 'desc'

const users = ref([]);
const searchTimeout = ref(null);
const leads = ref([]);
const search = ref("");
const perPage = ref(10);
const pageData = ref([]);
const destroyLeadId = ref();
const queryData = ref({
    page: 1,
    search: "",
    filters: {
        leadTag: "",
        rating: "",
        noteStrikeFirst: "",
        status: "",
    },
});
const pagination = ref({
    currentPage: 1,
    lastPage: 1,
    total: 0,
    perPage: 10,
});

const serverBusy = ref(true);
const isDataExist = ref(false);
const showModal = ref(false);
const setPagination = (response) => {
    pagination.value.total = response.data.meta.total;
    pagination.value.lastPage = response.data.meta.last_page;
    pagination.value.currentPage = response.data.meta.current_page;
};

const exportLeads = () => {
    let endPoint = `${import.meta.env.VITE_API_BASE_URL}leads/export`;
    HTTP.get(endPoint, {
        responseType: "blob",
    })
        .then((response) => {
            const blob = new Blob([response.data], {
                type: "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet",
            });
            const link = document.createElement("a");
            link.href = URL.createObjectURL(blob);
            link.download = "leads.xlsx";
            link.click();
        })
        .catch((error) => { })
        .finally(() => { });
};

const createTable = (page) => {
    queryData.value.page = page;
    let endPoint = `${import.meta.env.VITE_API_BASE_URL}leads`;
    HTTP.get(endPoint, {
        params: queryData.value,
    })
        .then((response) => {
            if (response.data.data.length > 0) {
                serverBusy.value = isDataExist.value = false;
                leads.value = response.data.data;
                pageData.value = response.data.meta;
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

const filter = (event) => {
    queryData.value.filters[event.target.name] = event.target.value;
};

watch(
    [
        search,
        () => queryData.value.filters.leadTag,
        () => queryData.value.filters.rating,
        () => queryData.value.filters.noteStrikeFirst,
        () => queryData.value.filters.status,
        () => queryData.value.sortBy,
        () => queryData.value.sortOrder,
    ],
    (newValues, oldValues) => {
        serverBusy.value = true;
        clearTimeout(searchTimeout.value);
        searchTimeout.value = setTimeout(() => {
            queryData.value.search = search.value;
            createTable(1);
            setTimeout(() => {
                serverBusy.value = false;
            }, 500);
        }, 700);
    },
    { immediate: true },
);

const destroyLead = (type = "", leadId = "") => {
    if (type == "confirmation") {
        showModal.value = true;
        destroyLeadId.value = leadId;
        return;
    }
    let endPoint = `${import.meta.env.VITE_API_BASE_URL}leads/${destroyLeadId.value}`;
    HTTP.delete(endPoint)
        .then((response) => {
            if (response.data.status) {
                showModal.value = false;
                createTable(1);
                notificationMessage("success", "Lead deleted successfully");
            }
        })
        .catch((error) => { })
        .finally(() => { });
};

onUnmounted(() => {
    clearTimeout(searchTimeout.value);
});

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


onMounted(async () => {
    await getLeadTagFilters();
    await getLeadRatingFilters();
    await getNotesFilters();
    await getStatusFilters();
});

const getLeadTagFilters = async () => {
    const filterData = await getFilters('get/all/leads/tags', 'leadTags');
    leadTags.value = filterData;
}

const getLeadRatingFilters = async () => {
    const filterData = await getFilters('get/all/leads/ratings', 'leadRating');
    leadRatings.value = filterData;
}

const getNotesFilters = async () => {
    const filterData = await getFilters('get/all/leads/note/strike/first', 'leadStrike');
    noteStrikeFirst.value = filterData;
}

const getStatusFilters = async () => {
    const filterData = await getFilters('get/all/leads/status', 'leadStatus');
    statuses.value = filterData;
}

</script>

<style lang="css" scoped></style>
