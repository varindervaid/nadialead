// stores/leadsStore.js
import { defineStore } from 'pinia';
import { useRouter } from 'vue-router';
import http from "@/axios.js"
export const useLeadsStore = defineStore('leads', {
    state: () => ({
        baseURL: import.meta.env.VITE_API_BASE_URL,
        isUserCanEditLead: true,
        currentLead: null, // Store the lead being edited
    }),
    getters: {
        getCurrentLead: (state) => state.currentLead,
        getIsUserCanEditLead: (state) => state.isUserCanEditLead,
    },
    actions: {
        // Protect the edit route
        async protectEditRoute(leadId) {
            try {
                let endPoint = `${this.baseURL}leads/${leadId}`;
                const response = await http.get(endPoint);
                const status = response.data.status;
                const leadData = response.data.data;
                if (status) this.currentLead = leadData;
                this.isUserCanEditLead = status;
                return status
            } catch (error) {
                this.isUserCanEditLead = false;
                this.currentLead = null;
                console.error('Error fetching leads:', error);
            }
        },
    },
});