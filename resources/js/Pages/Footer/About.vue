<template>
    <AppLayout>
        <div class="min-h-screen bg-gray-50">
            <!-- Simple Header -->
            <div class="bg-white py-12 shadow-sm">
                <div class="max-w-4xl mx-auto px-4">
                    <h1 class="text-3xl font-bold text-gray-900 mb-4">
                        About PUSTOK
                    </h1>
                    <p class="text-gray-600">
                        Your online bookstore for amazing reads.
                    </p>
                </div>
            </div>

            <!-- Simple Content -->
            <div class="max-w-4xl mx-auto px-4 py-12">
                <div class="bg-white rounded-lg shadow p-6">
                    <div class="prose max-w-none">
                        <h2 class="text-xl font-semibold text-gray-900 mb-4">
                            Who We Are
                        </h2>
                        <p class="text-gray-700 mb-4">
                            PUSTOK is your trusted online bookstore. We connect
                            readers with amazing books from around the world.
                        </p>

                        <h2
                            class="text-xl font-semibold text-gray-900 mb-4 mt-8"
                        >
                            Our Mission
                        </h2>
                        <p class="text-gray-700 mb-4">
                            To make quality books accessible to everyone,
                            everywhere.
                        </p>

                        <h2
                            class="text-xl font-semibold text-gray-900 mb-4 mt-8"
                        >
                            Our Story
                        </h2>
                        <p class="text-gray-700">
                            Started by book lovers, for book lovers. We're
                            passionate about bringing great stories to your
                            doorstep.
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
