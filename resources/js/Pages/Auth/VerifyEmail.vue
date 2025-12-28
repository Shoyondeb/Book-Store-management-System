<script setup>
import { computed } from "vue";
import GuestLayout from "@/Layouts/GuestLayout.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import { Head, Link, useForm } from "@inertiajs/vue3";

const props = defineProps({
    status: {
        type: String,
    },
});

const form = useForm({});

const submit = () => {
    form.post(route("verification.send"), {
        preserveScroll: true,
    });
};

const verificationLinkSent = computed(
    () => props.status === "verification-link-sent"
);
</script>

<template>
    <GuestLayout>
        <Head title="Email Verification" />

        <div class="text-center mb-6">
            <div
                class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4"
            >
                <svg
                    class="w-8 h-8 text-blue-600"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"
                    ></path>
                </svg>
            </div>
            <h2 class="text-2xl font-bold text-gray-800">Verify Your Email</h2>
        </div>

        <div
            class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6 text-sm text-blue-700"
        >
            Thanks for signing up! Before getting started, could you verify your
            email address by clicking on the link we just emailed to you? If you
            didn't receive the email, we will gladly send you another.
        </div>

        <div
            class="bg-green-50 border border-green-200 rounded-lg p-4 mb-6 text-sm font-medium text-green-700"
            v-if="verificationLinkSent"
        >
            A new verification link has been sent to the email address you
            provided during registration.
        </div>

        <form @submit.prevent="submit" class="space-y-4">
            <PrimaryButton
                class="w-full justify-center py-3 text-base font-medium transition-all duration-200"
                :class="{
                    'opacity-50 cursor-not-allowed': form.processing,
                    'hover:shadow-lg transform hover:scale-105':
                        !form.processing,
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
                    Sending...
                </span>
                <span v-else>Resend Verification Email</span>
            </PrimaryButton>

            <div class="text-center pt-4 border-t border-gray-200">
                <Link
                    :href="route('logout')"
                    method="post"
                    as="button"
                    class="text-sm text-gray-600 hover:text-gray-800 font-medium transition-colors duration-200"
                    preserve-scroll
                >
                    Log Out
                </Link>
            </div>
        </form>
    </GuestLayout>
</template>
