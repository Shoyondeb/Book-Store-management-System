<script setup>
import GuestLayout from "@/Layouts/GuestLayout.vue";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import TextInput from "@/Components/TextInput.vue";
import { Head, Link, useForm } from "@inertiajs/vue3";

const form = useForm({
    name: "",
    email: "",
    password: "",
    password_confirmation: "",
});

// Optimized registration with better validation
const submit = () => {
    form.post(route("register"), {
        onFinish: () => form.reset("password", "password_confirmation"),
        preserveScroll: true,
        onSuccess: () => {
            // Clear form on successful registration
            form.reset();
        },
    });
};
</script>

<template>
    <GuestLayout>
        <Head title="Register" />

        <form @submit.prevent="submit" class="space-y-5">
            <div>
                <InputLabel
                    for="name"
                    value="Full Name"
                    class="text-gray-700 font-medium"
                />
                <TextInput
                    id="name"
                    type="text"
                    class="mt-2 block w-full transition-all duration-200 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                    v-model="form.name"
                    required
                    autofocus
                    autocomplete="name"
                    :class="{ 'border-red-500': form.errors.name }"
                />
                <InputError class="mt-1 text-sm" :message="form.errors.name" />
            </div>

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
                    autocomplete="email"
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
                    autocomplete="new-password"
                    :class="{ 'border-red-500': form.errors.password }"
                />
                <InputError
                    class="mt-1 text-sm"
                    :message="form.errors.password"
                />
            </div>

            <div>
                <InputLabel
                    for="password_confirmation"
                    value="Confirm Password"
                    class="text-gray-700 font-medium"
                />
                <TextInput
                    id="password_confirmation"
                    type="password"
                    class="mt-2 block w-full transition-all duration-200 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                    v-model="form.password_confirmation"
                    required
                    autocomplete="new-password"
                    :class="{
                        'border-red-500': form.errors.password_confirmation,
                    }"
                />
                <InputError
                    class="mt-1 text-sm"
                    :message="form.errors.password_confirmation"
                />
            </div>

            <div class="pt-4">
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
                        Creating Account...
                    </span>
                    <span v-else>Create Account</span>
                </PrimaryButton>
            </div>

            <div class="text-center pt-6 border-t border-gray-200">
                <p class="text-sm text-gray-600">
                    Already have an account?
                    <Link
                        :href="route('login')"
                        class="font-medium text-blue-600 hover:text-blue-800 ml-1 transition-colors"
                        preserve-scroll
                    >
                        Sign in
                    </Link>
                </p>
            </div>
        </form>
    </GuestLayout>
</template>
