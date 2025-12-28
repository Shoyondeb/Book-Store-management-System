<template>
    <AppLayout>
        <div class="max-w-4xl mx-auto px-4 py-8">
            <div class="mb-6">
                <h1 class="text-3xl font-bold text-gray-900">Order Details</h1>
                <p class="text-gray-600">Order #{{ order.order_number }}</p>
            </div>

            <div class="bg-white shadow-lg rounded-lg overflow-hidden">
                <!-- Order Header -->
                <div class="px-6 py-4 bg-gray-50 border-b">
                    <div class="flex justify-between items-center">
                        <div>
                            <span
                                class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium"
                                :class="statusClasses[order.status]"
                            >
                                {{ order.status }}
                            </span>
                            <p class="text-sm text-gray-500 mt-1">
                                Placed on {{ formatDate(order.created_at) }}
                            </p>
                        </div>
                        <div class="text-right">
                            <p class="text-2xl font-bold text-gray-900">
                                ${{ order.total_amount }}
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Order Items -->
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">
                        Items in this order
                    </h3>

                    <div
                        v-for="item in order.order_items"
                        :key="item.id"
                        class="flex items-center justify-between py-4 border-b"
                    >
                        <div class="flex items-center">
                            <img
                                :src="item.book.image_url"
                                :alt="item.book.title"
                                class="h-16 w-16 object-cover rounded"
                            />
                            <div class="ml-4">
                                <p class="font-medium text-gray-900">
                                    {{ item.book.title }}
                                </p>
                                <p class="text-sm text-gray-500">
                                    by {{ item.book.author }}
                                </p>
                                <p class="text-sm text-gray-500">
                                    Quantity: {{ item.quantity }}
                                </p>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="font-medium text-gray-900">
                                ${{ item.price }}
                            </p>
                            <p class="text-sm text-gray-500">
                                Subtotal: ${{
                                    (item.price * item.quantity).toFixed(2)
                                }}
                            </p>
                        </div>
                    </div>

                    <!-- Order Total -->
                    <div class="mt-6 pt-6 border-t">
                        <div class="flex justify-between text-xl font-semibold">
                            <span>Total:</span>
                            <span>${{ order.total_amount }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-6">
                <Link
                    :href="route('orders.history')"
                    class="bg-blue-500 text-white px-6 py-2 rounded-md hover:bg-blue-600"
                >
                    ← Back to Order History
                </Link>
            </div>
        </div>
    </AppLayout>
</template>

<script setup>
import { Link } from "@inertiajs/vue3";
import AppLayout from "@/Layouts/AppLayout.vue";

const props = defineProps({
    order: Object,
});

const statusClasses = {
    pending: "bg-yellow-100 text-yellow-800",
    processing: "bg-blue-100 text-blue-800",
    shipped: "bg-purple-100 text-purple-800",
    delivered: "bg-green-100 text-green-800",
    cancelled: "bg-red-100 text-red-800",
};

const formatDate = (dateString) => {
    return new Date(dateString).toLocaleDateString("en-US", {
        year: "numeric",
        month: "long",
        day: "numeric",
        hour: "2-digit",
        minute: "2-digit",
    });
};
</script>
