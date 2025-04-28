<script setup>
import UpdatePasswordForm from './Partials/UpdatePasswordForm.vue';
import UpdateProfileInformationForm from './Partials/UpdateProfileInformationForm.vue';
import DefaultCard from '@/components/Forms/DefaultCard.vue'
import BreadcrumbDefault from '@/components/Breadcrumbs/BreadcrumbDefault.vue'
import { ref } from 'vue';

defineProps({
    mustVerifyEmail: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});

const pageTitle = ref('Profile');


</script>

<template>

    <!-- <Head title="Profile" />-->
    <BreadcrumbDefault :pageTitle="pageTitle" />


        <div>
            <div class="mb-4">
                <DefaultCard cardTitle="Profile Information">
                    <div class="bg-white p-4 shadow sm:rounded-lg sm:p-8">
                        <UpdateProfileInformationForm
                            :must-verify-email="mustVerifyEmail"
                            :status="status"
                            class="max-w-xl"
                        />
                    </div>
                </DefaultCard>
            </div>

            <div class="mb-4">
                <DefaultCard cardTitle="Update Password">
                    <div
                        class="bg-white p-4 shadow sm:rounded-lg sm:p-8"
                    >
                        <UpdatePasswordForm class="max-w-xl" />
                    </div>
                </DefaultCard>
            </div>
        </div>
</template>
