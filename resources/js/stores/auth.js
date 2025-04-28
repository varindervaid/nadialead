import { defineStore } from 'pinia';
import axios from 'axios'; // Assuming you're using Axios for HTTP requests
import { useRouter } from 'vue-router';
const router = useRouter();
import http from "@/axios.js"

export const useAuthStore = defineStore('auth', {
    state: () => ({
        baseURL: import.meta.env.VITE_API_BASE_URL,
        user: null,
        token: null,
        loading: false,
        error: null,
        userRole: '',
        assignedFields: [],
        dashboardData: []
    }),
    getters: {
        isAuthenticated: (state) => !!state.token,
        getUser: (state) => state.user,
        getErrors: (state) => state.error,
        getUserRole: (state) => state.userRole,
        getAssignedFields: (state) => state.assignedFields,
        getDashboardData: (state) => state.dashboardData,
    },
    actions: {
        async login(formData) {
            this.loading = true;
            this.error = null;
            try {
                let endPoint = `${this.baseURL}login`;
                const response = await axios.post(endPoint, formData);
                this.token = response.data.data.token;
                this.user = response.data.data.user_detail;
                this.userRole = this.user?.roles[0]?.name;
                this.assignedFields = response.data.data.fields;
                localStorage.setItem('token', this.token);
                localStorage.setItem('activeMenu', 'dashboard');
                http.defaults.headers.common['Authorization'] = `Bearer ${this.token}`;
                return response.data.status;
            } catch (err) {
                this.error = err.response?.data?.message || 'Login failed';
            } finally {
                this.loading = false;
            }
        },

        logout() {
            this.user = null;
            this.token = null;
            this.userRole = '';
            localStorage.removeItem('token');
            return;
        },

        async forgotPassword(email) {
            this.loading = true;
            this.error = null;
            try {
                await axios.post('/api/auth/forgot-password', { email });
            } catch (err) {
                this.error = err.response?.data?.message || 'Request failed';
            } finally {
                this.loading = false;
            }
        },

        async updateProfileInfo(payload) {
            this.loading = true;
            this.error = null;
            let endPoint = `${this.baseURL}update/profile`;
            try {
                let response = await http.post(endPoint, payload);
                this.user = response.data.data;
                return response
            } catch (err) {
                this.error = err.response?.data?.message || 'Request failed';
            } finally {
                this.loading = false;
            }
        },

        async updateProfilePassword(payload) {
            this.loading = true;
            this.error = null;
            let endPoint = `${this.baseURL}update/profile/password`;
            try {
                let response = await http.post(endPoint, payload);
                this.error = null;
                // this.logout();
                return response
            } catch (err) {
                this.error = err.response?.data?.errors || 'Request failed';
            } finally {
                this.loading = false;
            }
        },

        async updateFieldPermission(roleId){
            let endPoint = `${this.baseURL}get/assign/fields/${roleId}`;
            try {
                let response = await http.get(endPoint);
                if(response.data.status){
                    this.assignedFields = response.data.data;                    
                }
            } catch (err) {
                this.error = err.response?.data?.errors || 'Request failed';
            } finally {
                this.loading = false;
            }
        },

        async fetchDashboardStatistics(){
            let endPoint = `${this.baseURL}dashboard/data`;
            try {
                let response = await http.get(endPoint);
                if(response.data.status && response.data.data.original?.status){
                    this.dashboardData = response.data.data.original.data;               
                    return response.data.data.original.data;
                }
            } catch (err) {
                this.error = err.response?.data?.errors || 'Request failed';
            } finally {
                this.loading = false;
            }
        }
    },
    persist: {
        key: 'auth', // Optional: Key to use in localStorage
        storage: localStorage, // Default is localStorage; you can use sessionStorage too
    },
});
