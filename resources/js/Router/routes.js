import { useAuthStore } from '@/stores/auth.js';
import { useLeadsStore } from '@/stores/leadsStore';
import Login from "@/Pages/Auth/Login.vue";
import Register from "@/Pages/Auth/Register.vue";
import GuestLayout from "@/Layouts/GuestLayout.vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import Dashboard from "@/Pages/Dashboard.vue";
import Role from "@/Pages/Role/Index.vue";
import Lead from "@/Pages/Lead/Index.vue";
import LeadColor from "@/Pages/Lead/LeadColor.vue";
import LeadImport from "@/Pages/Lead/Import.vue";
import User from "@/Pages/User/Index.vue";
import AddEditUser from "@/Pages/User/Add-Edit.vue";
import Profile from "@/Pages/Profile/Edit.vue";
import LeadUpdate from "@/Pages/Lead/Update.vue";
import LeadManageFilters from "@/Pages/Lead/ManageFilters/index.vue";

const routes = [
    {
        path: "/",
        component: GuestLayout,
        beforeEnter: (to, from, next) => {
            const isAuthenticated = localStorage.getItem('token');
            if (isAuthenticated) {
                return next({ name: 'dashboard' });
            }
            next();
        },
        children: [
            {
                path: "/",
                name: "login",
                component: Login,
            },
            {
                path: "/register",
                name: "register",
                component: Register,
            }
        ],
    },
    {
        path: "/dashboard",
        component: AuthenticatedLayout,
        beforeEnter: (to, from, next) => {
            const isAuthenticated = localStorage.getItem('token');
            if (!isAuthenticated) {
                return next({ name: 'login' });
            }
            next();
        },
        children: [
            {
                path: "",
                name: "dashboard",
                component: Dashboard,
            },
            {
                path: "/roles",
                name: "roles",
                component: Role,
                beforeEnter: (to, from, next) => {
                    const store = useAuthStore();
                    const userRole = store.getUserRole;
                    if (userRole === 'admin') {
                        next();
                    } else {
                        next({ path: from.path });
                    }
                }
            },
            {
                path: "/leads",
                name: "leads",
                component: Lead
            },
            {
                path: "/lead/colors",
                name: "lead.colors",
                component: LeadColor,
                beforeEnter: (to, from, next) => {
                    const store = useAuthStore();
                    const userRole = store.getUserRole;
                    if (userRole === 'admin') {
                        next();
                    } else {
                        next({ path: from.path });
                    }
                }
            },
            {
                path: "/lead/import",
                name: "lead.import",
                component: LeadImport,
                beforeEnter: (to, from, next) => {
                    const store = useAuthStore();
                    const userRole = store.getUserRole;
                    if (userRole === 'admin' || userRole === 'team') {
                        next();
                    } else {
                        next({ path: from.path });
                    }
                }
            },
            {
                path: "/lead/update/:id",
                name: "lead.update",
                component: LeadUpdate,
                beforeEnter: async (to, from, next) => {
                    const leadStore = useLeadsStore();
                    const leadId = to?.params?.id || null;
                    const isUserCanEditLead = await leadStore.protectEditRoute(leadId);
                    if (isUserCanEditLead) {
                        next();
                    } else {
                        next({ path: 'leads' });
                    }                    
                }
            },
            {
                path: "/users",
                name: "users",
                component: User,
                beforeEnter: (to, from, next) => {
                    const store = useAuthStore();
                    const userRole = store.getUserRole;
                    if (userRole === 'admin') {
                        next();
                    } else {
                        next({ path: from.path });
                    }
                }
            },
            {
                path: "/add/user",
                name: "add.user",
                component: AddEditUser,
                beforeEnter: (to, from, next) => {
                    const store = useAuthStore();
                    const userRole = store.getUserRole;
                    if (userRole === 'admin') {
                        next();
                    } else {
                        next({ path: from.path });
                    }
                }
            },
            {
                path: "/edit/user/:id",
                name: "edit.user",
                component: AddEditUser,
                beforeEnter: (to, from, next) => {
                    const store = useAuthStore();
                    const userRole = store.getUserRole;
                    if (userRole === 'admin') {
                        next();
                    } else {
                        next({ path: from.path });
                    }
                }
            },
            {
                path: "/edit/profile",
                name: "edit.profile",
                component: Profile,
            },
            {
                path: "/manage/filters",
                name: "manage.filters",
                component: LeadManageFilters,
                beforeEnter: (to, from, next) => {
                    const store = useAuthStore();
                    const userRole = store.getUserRole;
                    if (userRole === 'admin') {
                        next();
                    } else {
                        next({ path: from.path });
                    }
                }
            },
        ],
    }
];

export default routes;
