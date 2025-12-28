<template>
    <AppLayout>
        <div class="max-w-2xl mx-auto px-4 py-16 text-center">
            <div
                class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6"
            >
                <h2 class="text-2xl font-bold">Payment Successful!</h2>
                <p class="mt-2">Thank you for your purchase.</p>
            </div>
            <Link
                :href="route('shop.home')"
                class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700"
            >
                Continue Shopping
            </Link>
        </div>
    </AppLayout>
</template>

<script setup>
import { Link } from "@inertiajs/vue3";
import AppLayout from "@/Layouts/AppLayout.vue";
</script>
