
<template>
    <section>
        <p class="text-sm text-gray-600">
            Update your account's profile information and email address.
        </p>

        <form
            @submit.prevent="submitHandler"
            class="mt-6 space-y-6"
        >
            <div>
                <InputLabel for="name" value="Name" />

                <TextInput
                    id="name"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.name"
                    required
                    autofocus
                    autocomplete="name"
                />

                <InputError class="mt-2" :message="form.errors.name" />
            </div>

            <div>
                <InputLabel for="email" value="Email" />

                <TextInput
                    id="email"
                    type="email"
                    class="mt-1 block w-full"
                    v-model="form.email"
                    required
                    autocomplete="username"
                    readonly="true"
                />

                <InputError class="mt-2" :message="form.errors.email" />
            </div>
            <div class="flex items-center gap-4">
                <PrimaryButton :disabled="form.processing">Save</PrimaryButton>

                <Transition
                    enter-active-class="transition ease-in-out"
                    enter-from-class="opacity-0"
                    leave-active-class="transition ease-in-out"
                    leave-to-class="opacity-0"
                >
                    <p
                        v-if="form.recentlySuccessful"
                        class="text-sm text-gray-600"
                    >
                        Saved.
                    </p>
                </Transition>
            </div>
        </form>
    </section>
</template>

<script setup>
import InputError from '@/components/InputError.vue';
import InputLabel from '@/components/InputLabel.vue';
import PrimaryButton from '@/components/PrimaryButton.vue';
import TextInput from '@/components/TextInput.vue';
import { useForm } from '@inertiajs/vue3';
import { useAuthStore } from '@/stores/auth';
import { notificationMessage } from '@/helpers';
const store = useAuthStore();
defineProps({
    mustVerifyEmail: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});

// const user = usePage().props.auth.user;
const user = store.getUser;

const form = useForm({
    id: user.id ?? '',
    name: user.name ?? '',
    email: user.email ?? '',
});

const submitHandler = async () => {
    const {id, name, email} = form;
    let response = await store.updateProfileInfo({id, name})
    if(response?.status){
        notificationMessage('success', 'User Details updated successfully')
    }
}


</script>
