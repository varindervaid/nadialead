<template>
    <Modal ref="modal" :show="isShowModal">
        <button @click="$emit('close')" class="absolute right-1 top-1 sm:right-5 sm:top-5">
            <svg class="fill-current" width="20" height="20" viewBox="0 0 20 20" fill="none"
                xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" clip-rule="evenodd"
                    d="M11.8913 9.99599L19.5043 2.38635C20.032 1.85888 20.032 1.02306 19.5043 0.495589C18.9768 -0.0317329 18.141 -0.0317329 17.6135 0.495589L10.0001 8.10559L2.38673 0.495589C1.85917 -0.0317329 1.02343 -0.0317329 0.495873 0.495589C-0.0318274 1.02306 -0.0318274 1.85888 0.495873 2.38635L8.10887 9.99599L0.495873 17.6056C-0.0318274 18.1331 -0.0318274 18.9689 0.495873 19.4964C0.717307 19.7177 1.05898 19.9001 1.4413 19.9001C1.75372 19.9001 2.13282 19.7971 2.40606 19.4771L10.0001 11.8864L17.6135 19.4964C17.8349 19.7177 18.1766 19.9001 18.5589 19.9001C18.8724 19.9001 19.2531 19.7964 19.5265 19.4737C20.0319 18.9452 20.0245 18.1256 19.5043 17.6056L11.8913 9.99599Z"
                    fill=""></path>
            </svg>
        </button>
        <DefaultCard cardTitle="Add New Filter">
            <div class="flex items-center justify-center bg-gray-100 px-4 py-8 relative">
                <Loader v-if="isLoading" height="10" width="10" :overlay="true" />
                <form @submit.prevent="createNewFilter" class="w-full max-w-sm">
                    <div class="mb-4">
                        <input v-model="filterName" id="name" required type="text"
                            class="w-full p-2 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500"
                            placeholder="Add filter name" maxlength="20" />
                        <span class="text-red" v-show="showError">{{ errorMessage }}</span>
                    </div>
                    <div class="mt-4 flex justify-start gap-4">
                        <button type="submit"
                            class="flex items-center gap-2 rounded bg-primary px-4.5 py-2 font-medium text-white hover:bg-opacity-80 py-3 bg-blue-500 text-white font-semibold rounded-lg hover:bg-blue-600 focus:ring focus:ring-blue-300">
                            Create New </button>
                        <button @click="$emit('close')"
                            class="p-3 me-3 bg-red-500 text-white font-semibold rounded-lg hover:bg-red-400 focus:ring focus:ring-red-300">
                            Cancel </button>

                    </div>
                </form>
            </div>
        </DefaultCard>
    </Modal>
</template>


<script setup>
import { ref, watch, onMounted, onUnmounted } from "vue";
import Modal from "@/components/Modal.vue";
import DefaultCard from "@/components/Forms/DefaultCard.vue";
import { addLeadTagFilter, addLeadRatingFilter, addNotesFilter, addStatusFilter, notificationMessage } from "@/helpers.js";
import Loader from "@/components/Loader.vue";
const emit = defineEmits(['filterAdded']);
const isShowModal = ref(false);
const type = ref('');
const filterName = ref('');
const showError = ref(false);
const errorMessage = ref('Filter name is required');
const isLoading = ref(false);
const props = defineProps({
    showModal: {
        type: Boolean,
        required: true
    },
    filterType: {
        type: String,
        required: true
    }
});

onMounted(() => {
    isShowModal.value = props.showModal;
    type.value = props.filterType;
})

const createNewFilter = async () => {
    if (!filterName.value) {
        showError.value = true;
        return;
    }
    let status = null;
    isLoading.value = true;
    const filterActions = {
        leadRating: addLeadRatingFilter,
        noteFilter: addNotesFilter,
        statusFilter: addStatusFilter,
        default: addLeadTagFilter
    };

    const action = filterActions[type.value] || filterActions.default;
    status = await action(filterName.value);

    if (status == true) {
        isLoading.value = false;
        emit('filterAdded');
    } else {
        isLoading.value = false;
        showError.value = true;
        errorMessage.value = status;
    }
}
</script>