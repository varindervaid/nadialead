<template>
    <div class="w-full max-w-md p-8 bg-white rounded-xl shadow-lg overflow-hidden space-y-6">
        <h2 class="text-3xl font-bold text-center text-indigo-700 mb-6">Log In to Client Portal</h2>
        <form @submit.prevent="submit" class="space-y-6">
            <div>
                <InputLabel for="email" value="Email" />
                <TextInput id="email" type="email"
                    class="mt-2 block w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-indigo-500 focus:outline-none shadow-sm"
                    v-model="form.email" required autofocus autocomplete="username" placeholder="Enter Your Email" />
                <InputError class="mt-2" :message="form.errors.email" />
            </div>

            <div>
                <InputLabel for="password" value="Password" />
                <div class="relative">
                    <TextInput id="password" :type="passwordType"
                        class="mt-2 block w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-indigo-500 focus:outline-none shadow-sm"
                        placeholder="Enter Your Password"
                        v-model="form.password" required autocomplete="current-password" />
                    <!-- Conditional Password View Icons -->
                    <svg v-if="passwordType === 'password'" class="absolute right-2 top-1/2 transform -translate-y-1/2 fill-current" aria-hidden="true" @click="viewPassword"
                        xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor"
                        viewBox="0 0 24 24">
                        <path fill-rule="evenodd"
                            d="M4.998 7.78C6.729 6.345 9.198 5 12 5c2.802 0 5.27 1.345 7.002 2.78a12.713 12.713 0 0 1 2.096 2.183c.253.344.465.682.618.997.14.286.284.658.284 1.04s-.145.754-.284 1.04a6.6 6.6 0 0 1-.618.997 12.712 12.712 0 0 1-2.096 2.183C17.271 17.655 14.802 19 12 19c-2.802 0-5.27-1.345-7.002-2.78a12.712 12.712 0 0 1-2.096-2.183 6.6 6.6 0 0 1-.618-.997C2.144 12.754 2 12.382 2 12s.145-.754.284-1.04c.153-.315.365-.653.618-.997A12.714 12.714 0 0 1 4.998 7.78ZM12 15a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z"
                            clip-rule="evenodd" />
                    </svg>

                    <svg v-else class="absolute right-2 top-1/2 transform -translate-y-1/2 fill-current" aria-hidden="true" @click="viewPassword"
                        xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor"
                        viewBox="0 0 24 24">
                        <path
                            d="m4 15.6 3.055-3.056A4.913 4.913 0 0 1 7 12.012a5.006 5.006 0 0 1 5-5c.178.009.356.027.532.054l1.744-1.744A8.973 8.973 0 0 0 12 5.012c-5.388 0-10 5.336-10 7A6.49 6.49 0 0 0 4 15.6Z" />
                        <path
                            d="m14.7 10.726 4.995-5.007A.998.998 0 0 0 18.99 4a1 1 0 0 0-.71.305l-4.995 5.007a2.98 2.98 0 0 0-.588-.21l-.035-.01a2.981 2.981 0 0 0-3.584 3.583c0 .012.008.022.01.033.05.204.12.402.211.59l-4.995 4.983a1 1 0 1 0 1.414 1.414l4.995-4.983c.189.091.386.162.59.211.011 0 .021.007.033.01a2.982 2.982 0 0 0 3.584-3.584c0-.012-.008-.023-.011-.035a3.05 3.05 0 0 0-.21-.588Z" />
                        <path
                            d="m19.821 8.605-2.857 2.857a4.952 4.952 0 0 1-5.514 5.514l-1.785 1.785c.767.166 1.55.25 2.335.251 6.453 0 10-5.258 10-7 0-1.166-1.637-2.874-2.179-3.407Z" />
                    </svg>
                </div>
                <InputError class="mt-2" :message="form.errors.password" />
            </div>

            <div class="flex items-center justify-between">
                <label class="flex items-center">
                    <Checkbox name="remember" v-model:checked="form.remember" />
                    <span class="ml-2 text-sm text-gray-600">Remember me</span>
                </label>

                <Link v-if="canResetPassword" :href="route('password.request')"
                    class="text-sm text-indigo-500 hover:text-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                Forgot your password?
                </Link>
            </div>

            <div class="mt-6">
                <PrimaryButton
                    class="w-full py-2 px-4 rounded-lg bg-indigo-600 text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 shadow-md transition duration-300 transform hover:scale-105 flex justify-center items-center"
                    :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    Log in
                </PrimaryButton>
            </div>
        </form>
    </div>
</template>


<script setup>
import Checkbox from '@/components/Checkbox.vue';
import InputError from '@/components/InputError.vue';
import InputLabel from '@/components/InputLabel.vue';
import PrimaryButton from '@/components/PrimaryButton.vue';
import TextInput from '@/components/TextInput.vue';
import { useForm } from '@inertiajs/vue3';
import { useRouter } from 'vue-router';
import { ref } from 'vue';
import { useAuthStore } from '@/stores/auth';
import { notificationMessage } from '@/helpers';

const router = useRouter();
const authStore = useAuthStore();


const passwordType = ref('password');
const form = useForm({
    email: '',
    password: '',
    remember: false,
});

defineProps({
    canResetPassword: Boolean,
    status: String,
});

const submit = async () => {
    let userDetail = await authStore.login({ email: form.email, password: form.password, remember: form.remember });
    let errors = authStore.error;
    if (errors) {
        notificationMessage('error', errors);
    }
    if (userDetail) {
        router.push({ name: 'dashboard' });
    }
};

const viewPassword = () => {
    passwordType.value = passwordType.value === 'password' ? 'text' : 'password';
};
</script>

<style scoped>
/* Glow effect for inputs */
input,
button {
    transition: all 0.3s ease-in-out;
}

input:focus,
button:focus {
    box-shadow: 0 0 8px rgba(99, 102, 241, 0.5);
}

/* Smooth hover effect for the button */
button:hover {
    transform: scale(1.05);
}

/* Animation for the gradient background */
@keyframes gradient-animation {
    0% {
        background-position: 0% 50%;
    }

    50% {
        background-position: 100% 50%;
    }

    100% {
        background-position: 0% 50%;
    }
}

.bg-gradient-animation {
    background: linear-gradient(45deg, #ff5f6d, #ffc3a0);
    background-size: 400% 400%;
    animation: gradient-animation 15s ease infinite;
}
</style>
