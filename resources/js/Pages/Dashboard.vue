<template>
    <div class="grid grid-cols-12 gap-4 md:mt-6 md:gap-6 2xl:mt-7.5 2xl:gap-7.5">
        <!-- Welcome Message Start -->
        <template v-if="userRole != 'admin'">
            <div class="col-span-12 md:col-span-12 xl:col-span-12 p-4 text-center rounded-md">
                <h2 class="text-2xl font-semibold text-gray-800">Welcome to Your Dashboard!</h2>
                <p class="mt-2 text-gray-600">We are glad to have you here. Explore the various sections to monitor and
                    manage your data effectively.</p>
            </div>
        </template>

        <template v-else>
            <!-- Users Card -->
            <div class="col-span-12 md:col-span-4">
                <div
                    class="rounded-sm border border-stroke bg-white px-7.5 py-6 shadow-default dark:border-strokedark dark:bg-boxdark">
                    <div class="flex h-11.5 w-11.5 items-center justify-center rounded-full bg-meta-2 dark:bg-meta-4">
                        <svg class="fill-primary dark:fill-white" width="22" height="22" viewBox="0 0 22 22" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M11 9.62499C8.42188 9.62499 6.35938 7.59687 6.35938 5.12187C6.35938 2.64687 8.42188 0.618744 11 0.618744C13.5781 0.618744 15.6406 2.64687 15.6406 5.12187C15.6406 7.59687 13.5781 9.62499 11 9.62499ZM11 2.16562C9.79531 2.16562 8.82812 3.13187 8.82812 4.33749C8.82812 5.54312 9.79531 6.50937 11 6.50937C12.2047 6.50937 13.1719 5.54312 13.1719 4.33749C13.1719 3.13187 12.2047 2.16562 11 2.16562Z"
                                fill="" />
                            <path
                                d="M17.7719 21.4156H4.2281C3.5406 21.4156 2.9906 20.8656 2.9906 20.1781V17.0844C2.9906 13.7156 5.7406 10.9656 9.10935 10.9656H12.925C16.2937 10.9656 19.0437 13.7156 19.0437 17.0844V20.1781C19.0094 20.8312 18.4594 21.4156 17.7719 21.4156ZM4.53748 19.6969H17.4969V17.0844C17.4969 14.575 15.4344 12.5125 12.925 12.5125H9.07498C6.5656 12.5125 4.5031 14.575 4.5031 17.0844V19.6969H4.53748Z"
                                fill="" />
                        </svg>
                    </div>
                    <div class="mt-4 flex items-end justify-between">
                        <div>
                            <h4 class="text-title-md font-bold text-black dark:text-white">Total Users</h4>
                            <span class="text-sm font-medium">Total Users</span>
                        </div>
                        <span class="flex items-center gap-1 text-sm font-medium text-meta-3">
                            {{ totalUsers }}
                        </span>
                    </div>
                    <div class="mt-4 flex items-center justify-between">
                        <router-link :to="{ name: 'users' }" class="text-sm font-medium text-primary hover:text-primary-dark">
                            View More
                            <svg class="inline-block ml-1" width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M12.172 7L6.808 1.636L8.222 0.222L16 8L8.222 15.778L6.808 14.364L12.172 9H0V7H12.172Z" fill="currentColor"/>
                            </svg>
                        </router-link>
                    </div>
                </div>
            </div>

            <!-- Roles Card -->
            <div class="col-span-12 md:col-span-4">
                <div
                    class="rounded-sm border border-stroke bg-white px-7.5 py-6 shadow-default dark:border-strokedark dark:bg-boxdark">
                    <div class="flex h-11.5 w-11.5 items-center justify-center rounded-full bg-meta-2 dark:bg-meta-4">
                        <svg class="fill-primary dark:fill-white" width="22" height="22" viewBox="0 0 22 22" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M11 9.62499C8.42188 9.62499 6.35938 7.59687 6.35938 5.12187C6.35938 2.64687 8.42188 0.618744 11 0.618744C13.5781 0.618744 15.6406 2.64687 15.6406 5.12187C15.6406 7.59687 13.5781 9.62499 11 9.62499ZM11 2.16562C9.79531 2.16562 8.82812 3.13187 8.82812 4.33749C8.82812 5.54312 9.79531 6.50937 11 6.50937C12.2047 6.50937 13.1719 5.54312 13.1719 4.33749C13.1719 3.13187 12.2047 2.16562 11 2.16562Z"
                                fill="" />
                            <path
                                d="M17.7719 21.4156H4.2281C3.5406 21.4156 2.9906 20.8656 2.9906 20.1781V17.0844C2.9906 13.7156 5.7406 10.9656 9.10935 10.9656H12.925C16.2937 10.9656 19.0437 13.7156 19.0437 17.0844V20.1781C19.0094 20.8312 18.4594 21.4156 17.7719 21.4156ZM4.53748 19.6969H17.4969V17.0844C17.4969 14.575 15.4344 12.5125 12.925 12.5125H9.07498C6.5656 12.5125 4.5031 14.575 4.5031 17.0844V19.6969H4.53748Z"
                                fill="" />
                        </svg>
                    </div>
                    <div class="mt-4 flex items-end justify-between">
                        <div>
                            <h4 class="text-title-md font-bold text-black dark:text-white">User Roles</h4>
                            <span class="text-sm font-medium">Available Roles</span>
                        </div>
                        <span class="flex items-center gap-1 text-sm font-medium text-meta-3">
                            {{ totalRoles }}
                        </span>
                    </div>
                    <div class="mt-4 flex items-center justify-between">
                        <router-link :to="{ name: 'roles' }" class="text-sm font-medium text-primary hover:text-primary-dark">
                            View More
                            <svg class="inline-block ml-1" width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M12.172 7L6.808 1.636L8.222 0.222L16 8L8.222 15.778L6.808 14.364L12.172 9H0V7H12.172Z" fill="currentColor"/>
                            </svg>
                        </router-link>
                    </div>
                </div>
            </div>

            <!-- Leads Card -->
            <div class="col-span-12 md:col-span-4">
                <div
                    class="rounded-sm border border-stroke bg-white px-7.5 py-6 shadow-default dark:border-strokedark dark:bg-boxdark">
                    <div class="flex h-11.5 w-11.5 items-center justify-center rounded-full bg-meta-2 dark:bg-meta-4">
                        <svg class="fill-primary dark:fill-white" width="22" height="22" viewBox="0 0 22 22" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M11 9.62499C8.42188 9.62499 6.35938 7.59687 6.35938 5.12187C6.35938 2.64687 8.42188 0.618744 11 0.618744C13.5781 0.618744 15.6406 2.64687 15.6406 5.12187C15.6406 7.59687 13.5781 9.62499 11 9.62499ZM11 2.16562C9.79531 2.16562 8.82812 3.13187 8.82812 4.33749C8.82812 5.54312 9.79531 6.50937 11 6.50937C12.2047 6.50937 13.1719 5.54312 13.1719 4.33749C13.1719 3.13187 12.2047 2.16562 11 2.16562Z"
                                fill="" />
                            <path
                                d="M17.7719 21.4156H4.2281C3.5406 21.4156 2.9906 20.8656 2.9906 20.1781V17.0844C2.9906 13.7156 5.7406 10.9656 9.10935 10.9656H12.925C16.2937 10.9656 19.0437 13.7156 19.0437 17.0844V20.1781C19.0094 20.8312 18.4594 21.4156 17.7719 21.4156ZM4.53748 19.6969H17.4969V17.0844C17.4969 14.575 15.4344 12.5125 12.925 12.5125H9.07498C6.5656 12.5125 4.5031 14.575 4.5031 17.0844V19.6969H4.53748Z"
                                fill="" />
                        </svg>
                    </div>
                    <div class="mt-4 flex items-end justify-between">
                        <div>
                            <h4 class="text-title-md font-bold text-black dark:text-white">Total Leads</h4>
                            <span class="text-sm font-medium">Active Leads</span>
                        </div>
                        <span class="flex items-center gap-1 text-sm font-medium text-meta-3">
                            {{ totalLeads }}
                        </span>
                    </div>
                    <div class="mt-4 flex items-center justify-between">
                        <router-link :to="{ name: 'leads' }" class="text-sm font-medium text-primary hover:text-primary-dark">
                            View More
                            <svg class="inline-block ml-1" width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M12.172 7L6.808 1.636L8.222 0.222L16 8L8.222 15.778L6.808 14.364L12.172 9H0V7H12.172Z" fill="currentColor"/>
                            </svg>
                        </router-link>
                    </div>
                </div>
            </div>
        </template>
    </div>
</template>

<script setup>
import { useAuthStore } from '@/stores/auth';
import { onMounted, ref } from 'vue';
const authStore = useAuthStore();
const userRole = ref('');
const dashboardData = ref([]);
const totalUsers = ref(0);
const totalRoles = ref(0);
const totalLeads = ref(0);
onMounted(async () => {
    userRole.value = authStore.getUserRole;
    if(userRole.value == 'admin'){
        await getDashboardData();
    }
});

const getDashboardData = async () => {
    let response = await authStore.fetchDashboardStatistics();
    totalUsers.value = response.total_users;
    totalRoles.value = response.total_roles;
    totalLeads.value = response.total_leads;
}
</script>
