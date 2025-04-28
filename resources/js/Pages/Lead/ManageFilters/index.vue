<template>
    <div>
        <!-- Tabs -->
        <div class="flex border-b">
            <button v-for="(tab, index) in tabs" :key="tab.name" @click="setActiveTab(tab.name)"
                :class="['py-2 px-4', activeTab === tab.name ? 'text-primary border-b-2 border-primary' : 'text-gray-500']">
                {{ tab.label }}
            </button>
        </div>

        <!-- Tab Content -->
        <div class="p-4">
            <component :is="currentTabComponent" />
        </div>
    </div>
</template>

<script setup>
import { ref, computed, defineAsyncComponent } from 'vue';

const tabs = [
    { name: 'Lead Tag', label: 'Lead Tag', component: () => import('./LeadTag.vue') },
    { name: 'Lead Rating', label: 'Lead Rating', component: () => import('./LeadRating.vue') },
    { name: 'Select Note(Strike First)', label: 'Select Note(Strike First)', component: () => import('./NoteFilters.vue') },
    { name: 'Status Filters', label: 'Status Filters', component: () => import('./StatusFilters.vue') },
];

const data = {
    Profile: [
        { name: 'John Doe', email: 'john@example.com' },
        { name: 'Jane Smith', email: 'jane@example.com' }
    ],
    Dashboard: [],
    Settings: [],
    Contacts: []
};

const activeTab = ref(tabs[0].name);

const setActiveTab = (tabName) => {
    activeTab.value = tabName;
};

const currentTabComponent = computed(() => {
    const tab = tabs.find(t => t.name === activeTab.value);
    return tab ? defineAsyncComponent(tab.component) : null;
});


</script>

<style scoped>
button {
    transition: all 0.3s;
}
</style>