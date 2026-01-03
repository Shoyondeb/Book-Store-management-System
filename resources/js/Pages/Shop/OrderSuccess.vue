<template>
    <AppLayout>
        <div class="max-w-4xl mx-auto px-4 py-8">
            <div class="mb-6">
                <h1 class="text-3xl font-bold text-gray-900">
                    Order Complete!
                </h1>
                <p class="text-gray-600">Thank you for your purchase</p>
            </div>

            <div class="bg-white shadow-lg rounded-lg p-6">
                <div class="mb-6 text-center">
                    <div class="text-green-500 text-6xl mb-4">✅</div>
                    <h2 class="text-xl font-semibold text-green-600 mb-2">
                        Payment Successfully!
                    </h2>
                    <p class="text-gray-600">
                        Your order has been confirmed. Order number:
                        <strong>#{{ order.order_number }}</strong>
                    </p>
                    <p class="text-sm text-gray-500 mt-2">
                        Transaction ID: {{ transaction_id }}
                    </p>
                </div>

                <div class="border-t border-gray-200 pt-4">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">
                        Order Summary
                    </h3>

                    <div
                        v-for="item in order.order_items"
                        :key="item.id"
                        class="flex items-center justify-between py-3 border-b"
                    >
                        <div class="flex items-center">
                            <img
                                :src="
                                    item.book.image_url ||
                                    '/images/default-book.jpg'
                                "
                                :alt="item.book.title"
                                class="h-12 w-12 object-cover rounded"
                            />
                            <div class="ml-4">
                                <p class="font-medium">{{ item.book.title }}</p>
                                <p class="text-sm text-gray-500">
                                    Qty: {{ item.quantity }}
                                </p>
                            </div>
                        </div>
                        <p class="font-medium">
                            ${{ (item.price * item.quantity).toFixed(2) }}
                        </p>
                    </div>

                    <div class="mt-4 pt-4 border-t">
                        <div class="flex justify-between text-lg font-semibold">
                            <span>Total Paid:</span>
                            <span>${{ order.total_amount }}</span>
                        </div>
                    </div>
                </div>

                <div class="mt-6 flex justify-between">
                    <Link
                        :href="route('shop.home')"
                        class="bg-gray-500 text-white px-6 py-2 rounded-md hover:bg-gray-600"
                    >
                        Continue Shopping
                    </Link>
                    <Link
                        :href="route('orders.history')"
                        class="bg-blue-500 text-white px-6 py-2 rounded-md hover:bg-blue-600"
                    >
                        View Order History
                    </Link>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<script setup>
import { Link } from "@inertiajs/vue3";
import AppLayout from "@/Layouts/AppLayout.vue";

const props = defineProps({
    order: Object,
    transaction_id: String,
});
</script>
