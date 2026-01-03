<template>
    <AppLayout>
        <div class="min-h-screen bg-gray-50">
            <!-- Simple Header -->
            <div class="bg-white py-12 shadow-sm">
                <div class="max-w-4xl mx-auto px-4">
                    <h1 class="text-3xl font-bold text-gray-900 mb-4">
                        Privacy Policy
                    </h1>
                    <p class="text-gray-600">
                        Last updated: {{ new Date().toLocaleDateString() }}
                    </p>
                </div>
            </div>

            <!-- Simple Content -->
            <div class="max-w-4xl mx-auto px-4 py-12">
                <div class="bg-white rounded-lg shadow p-6">
                    <div class="prose max-w-none">
                        <p class="text-gray-700 mb-6">
                            At PUSTOK, we take your privacy seriously. This
                            policy explains how we handle your information.
                        </p>

                        <h2 class="text-xl font-semibold text-gray-900 mb-4">
                            Information We Collect
                        </h2>
                        <p class="text-gray-700 mb-6">
                            We collect information you provide when creating an
                            account, placing orders, or contacting us.
                        </p>

                        <h2 class="text-xl font-semibold text-gray-900 mb-4">
                            How We Use Your Information
                        </h2>
                        <p class="text-gray-700 mb-6">
                            To process your orders, communicate with you, and
                            improve our services.
                        </p>

                        <h2 class="text-xl font-semibold text-gray-900 mb-4">
                            Data Security
                        </h2>
                        <p class="text-gray-700 mb-6">
                            We implement security measures to protect your
                            personal information.
                        </p>

                        <h2 class="text-xl font-semibold text-gray-900 mb-4">
                            Your Rights
                        </h2>
                        <p class="text-gray-700 mb-6">
                            You can access, correct, or delete your personal
                            information by contacting us.
                        </p>

                        <h2 class="text-xl font-semibold text-gray-900 mb-4">
                            Contact Us
                        </h2>
                        <p class="text-gray-700">
                            For privacy concerns, email us at privacy@pustok.com
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
</script>
