<template>
    <AppLayout>
        <div class="min-h-screen bg-gray-50">
            <!-- Simple Header -->
            <div class="bg-white py-12 shadow-sm">
                <div class="max-w-4xl mx-auto px-4">
                    <h1 class="text-3xl font-bold text-gray-900 mb-4">
                        Terms & Conditions
                    </h1>
                    <p class="text-gray-600">
                        Please read these terms carefully.
                    </p>
                </div>
            </div>

            <!-- Simple Content -->
            <div class="max-w-4xl mx-auto px-4 py-12">
                <div class="bg-white rounded-lg shadow p-6">
                    <div class="prose max-w-none">
                        <p class="text-gray-700 mb-6">
                            By using PUSTOK, you agree to these terms and
                            conditions.
                        </p>

                        <h2 class="text-xl font-semibold text-gray-900 mb-4">
                            Account Registration
                        </h2>
                        <p class="text-gray-700 mb-6">
                            You must provide accurate information when creating
                            an account.
                        </p>

                        <h2 class="text-xl font-semibold text-gray-900 mb-4">
                            Orders & Payments
                        </h2>
                        <p class="text-gray-700 mb-6">
                            All orders are subject to availability and
                            confirmation. Prices may change.
                        </p>

                        <h2 class="text-xl font-semibold text-gray-900 mb-4">
                            Returns & Refunds
                        </h2>
                        <p class="text-gray-700 mb-6">
                            Books in good condition may be returned within 7
                            days. Digital items are non-refundable.
                        </p>

                        <h2 class="text-xl font-semibold text-gray-900 mb-4">
                            Intellectual Property
                        </h2>
                        <p class="text-gray-700 mb-6">
                            All content on this site is owned by PUSTOK or its
                            licensors.
                        </p>

                        <h2 class="text-xl font-semibold text-gray-900 mb-4">
                            Limitation of Liability
                        </h2>
                        <p class="text-gray-700 mb-6">
                            PUSTOK is not liable for indirect damages arising
                            from use of our services.
                        </p>

                        <h2 class="text-xl font-semibold text-gray-900 mb-4">
                            Changes to Terms
                        </h2>
                        <p class="text-gray-700">
                            We may update these terms. Continued use means you
                            accept the changes.
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
