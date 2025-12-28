<script setup>
import Checkbox from "@/Components/Checkbox.vue";
import GuestLayout from "@/Layouts/GuestLayout.vue";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import TextInput from "@/Components/TextInput.vue";
import { Head, Link, useForm } from "@inertiajs/vue3";

defineProps({
    canResetPassword: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});

const form = useForm({
    email: "",
    password: "",
    remember: false,
});

// Optimized submit with immediate feedback
const submit = () => {
    form.transform((data) => ({
        ...data,
        remember: data.remember ? "on" : "",
    })).post(route("login"), {
        onSuccess: () => {
            // Force hard reload after login to get fresh session
            window.location.reload(true);
        },
        onFinish: () => form.reset("password"),
    });
};
</script>

<template>
    <GuestLayout>
        <Head title="Log in" />

        <div
            v-if="status"
            class="mb-4 p-3 rounded-lg bg-green-50 border border-green-200 text-sm font-medium text-green-700"
        >
            {{ status }}
        </div>

        <form @submit.prevent="submit" class="space-y-5">
            <div>
                <InputLabel
                    for="email"
                    value="Email"
                    class="text-gray-700 font-medium"
                />
                <TextInput
                    id="email"
                    type="email"
                    class="mt-2 block w-full transition-all duration-200 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                    v-model="form.email"
                    required
                    autofocus
                    autocomplete="username"
                    :class="{ 'border-red-500': form.errors.email }"
                />
                <InputError class="mt-1 text-sm" :message="form.errors.email" />
            </div>

            <div>
                <InputLabel
                    for="password"
                    value="Password"
                    class="text-gray-700 font-medium"
                />
                <TextInput
                    id="password"
                    type="password"
                    class="mt-2 block w-full transition-all duration-200 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                    v-model="form.password"
                    required
                    autocomplete="current-password"
                    :class="{ 'border-red-500': form.errors.password }"
                />
                <InputError
                    class="mt-1 text-sm"
                    :message="form.errors.password"
                />
            </div>

            <div class="flex items-center justify-between">
                <label class="flex items-center space-x-2 cursor-pointer">
                    <Checkbox name="remember" v-model:checked="form.remember" />
                    <span
                        class="text-sm text-gray-600 hover:text-gray-800 transition-colors"
                        >Remember me</span
                    >
                </label>

                <Link
                    v-if="canResetPassword"
                    :href="route('password.request')"
                    class="text-sm text-blue-600 hover:text-blue-800 font-medium transition-colors duration-200"
                    preserve-scroll
                >
                    Forgot password?
                </Link>
            </div>

            <PrimaryButton
                class="w-full justify-center py-3 text-base font-medium transition-all duration-200 hover:shadow-lg"
                :class="{
                    'opacity-50 cursor-not-allowed': form.processing,
                    'transform hover:scale-105': !form.processing,
                }"
                :disabled="form.processing"
            >
                <span v-if="form.processing" class="flex items-center">
                    <svg
                        class="animate-spin -ml-1 mr-3 h-4 w-4 text-white"
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                    >
                        <circle
                            class="opacity-25"
                            cx="12"
                            cy="12"
                            r="10"
                            stroke="currentColor"
                            stroke-width="4"
                        ></circle>
                        <path
                            class="opacity-75"
                            fill="currentColor"
                            d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"
                        ></path>
                    </svg>
                    Signing in...
                </span>
                <span v-else>Log in</span>
            </PrimaryButton>

            <div class="text-center mt-6 pt-6 border-t border-gray-200">
                <p class="text-sm text-gray-600">
                    Don't have an account?
                    <Link
                        :href="route('register')"
                        class="font-medium text-blue-600 hover:text-blue-800 ml-1 transition-colors"
                        preserve-scroll
                    >
                        Sign up
                    </Link>
                </p>
            </div>
        </form>
    </GuestLayout>
</template>
