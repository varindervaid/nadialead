import { defineStore } from 'pinia'

export const useAppStore = defineStore('app', {
    state: () => ({
        user: {},
        configs: false,
        app_url: 'http://127.0.0.1:8000/storage/',
    }),
    actions: {
        setUser(user) {
            this.user = user;
        },
    },
    getters: {
        getUser(state) {
            return state.user;
        },
    },
    share: {
        omit: [],
        enable: true,
        initialize: true,
    },
    strict: process.env.NODE_ENV !== "production",
});
