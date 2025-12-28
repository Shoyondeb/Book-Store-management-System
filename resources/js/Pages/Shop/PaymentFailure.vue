<template>
    <div class="min-h-screen bg-gray-50 py-16">
        <div class="container mx-auto px-4">
            <div
                class="max-w-2xl mx-auto bg-white rounded-lg shadow-md p-8 text-center"
            >
                <div class="text-red-500 text-6xl mb-6">❌</div>
                <h1 class="text-3xl font-bold text-red-600 mb-4">
                    Payment Failed
                </h1>
                <p class="text-gray-600 mb-6">{{ error }}</p>

                <div
                    class="space-y-4 sm:space-y-0 sm:space-x-4 sm:flex sm:justify-center"
                >
                    <Link
                        :href="route('cart.index')"
                        class="block sm:inline-block bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition-colors"
                    >
                        Try Again
                    </Link>
                    <Link
                        :href="route('shop.home')"
                        class="block sm:inline-block bg-gray-600 text-white px-6 py-3 rounded-lg hover:bg-gray-700 transition-colors"
                    >
                        Continue Shopping
                    </Link>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { Link } from "@inertiajs/vue3";

defineProps({
    error: String,
});
</script>
