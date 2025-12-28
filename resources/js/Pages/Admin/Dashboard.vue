<template>
    <AdminLayout>
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Dashboard</h1>
            <p class="mt-2 text-gray-600">Overview of your book store</p>
        </div>

        <!-- Stats Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <div
                class="bg-gradient-to-br from-blue-50 to-white p-6 rounded-2xl shadow-lg border border-blue-100 transition-all duration-300 hover:shadow-xl hover:-translate-y-1"
            >
                <div class="flex items-center">
                    <div
                        class="p-3 bg-gradient-to-r from-blue-500 to-blue-600 rounded-xl shadow-md"
                    >
                        <svg
                            class="w-6 h-6 text-white"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"
                            />
                        </svg>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-sm font-medium text-gray-500">
                            Total Books
                        </h3>
                        <p class="text-2xl font-bold text-gray-900">
                            {{ stats.total_books }}
                        </p>
                    </div>
                </div>
            </div>

            <div
                class="bg-gradient-to-br from-green-50 to-white p-6 rounded-2xl shadow-lg border border-green-100 transition-all duration-300 hover:shadow-xl hover:-translate-y-1"
            >
                <div class="flex items-center">
                    <div
                        class="p-3 bg-gradient-to-r from-green-500 to-green-600 rounded-xl shadow-md"
                    >
                        <svg
                            class="w-6 h-6 text-white"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"
                            />
                        </svg>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-sm font-medium text-gray-500">
                            Total Sales
                        </h3>
                        <p class="text-2xl font-bold text-gray-900">
                            ৳{{ stats.total_sales }}
                        </p>
                    </div>
                </div>
            </div>

            <div
                class="bg-gradient-to-br from-purple-50 to-white p-6 rounded-2xl shadow-lg border border-purple-100 transition-all duration-300 hover:shadow-xl hover:-translate-y-1"
            >
                <div class="flex items-center">
                    <div
                        class="p-3 bg-gradient-to-r from-purple-500 to-purple-600 rounded-xl shadow-md"
                    >
                        <svg
                            class="w-6 h-6 text-white"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"
                            />
                        </svg>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-sm font-medium text-gray-500">
                            Total Users
                        </h3>
                        <p class="text-2xl font-bold text-gray-900">
                            {{ stats.total_users }}
                        </p>
                    </div>
                </div>
            </div>

            <div
                class="bg-gradient-to-br from-orange-50 to-white p-6 rounded-2xl shadow-lg border border-orange-100 transition-all duration-300 hover:shadow-xl hover:-translate-y-1"
            >
                <div class="flex items-center">
                    <div
                        class="p-3 bg-gradient-to-r from-orange-500 to-orange-600 rounded-xl shadow-md"
                    >
                        <svg
                            class="w-6 h-6 text-white"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"
                            />
                        </svg>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-sm font-medium text-gray-500">
                            Total Orders
                        </h3>
                        <p class="text-2xl font-bold text-gray-900">
                            {{ stats.total_orders }}
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Orders -->
        <div
            class="bg-white shadow-xl rounded-2xl overflow-hidden border border-gray-100"
        >
            <div
                class="px-6 py-5 bg-gradient-to-r from-gray-50 to-white border-b border-gray-200"
            >
                <div class="flex items-center justify-between">
                    <h3 class="text-xl font-bold text-gray-900">
                        Recent Orders
                    </h3>
                    <span
                        class="text-sm text-blue-600 font-medium cursor-pointer hover:text-blue-700 transition-colors"
                    >
                        View all
                    </span>
                </div>
            </div>
            <div class="p-6">
                <div
                    v-if="stats.recent_orders.length === 0"
                    class="text-center py-8 text-gray-500"
                >
                    <div
                        class="w-16 h-16 mx-auto mb-4 bg-gray-100 rounded-full flex items-center justify-center"
                    >
                        <svg
                            class="w-8 h-8 text-gray-400"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"
                            ></path>
                        </svg>
                    </div>
                    No recent orders
                </div>
                <div v-else class="space-y-4">
                    <div
                        v-for="order in stats.recent_orders"
                        :key="order.id"
                        class="flex items-center justify-between p-4 bg-gray-50 rounded-xl hover:bg-white hover:shadow-md transition-all duration-300 border border-gray-100"
                    >
                        <div class="flex items-center space-x-4">
                            <div
                                class="w-10 h-10 bg-white rounded-lg shadow-sm flex items-center justify-center"
                            >
                                <svg
                                    class="w-5 h-5 text-gray-600"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"
                                    ></path>
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm font-semibold text-gray-900">
                                    Order #{{ order.id }}
                                </p>
                                <p class="text-sm text-gray-500">
                                    by {{ order.user.name }}
                                </p>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="text-lg font-bold text-gray-900">
                                ৳{{ order.total_amount }}
                            </p>
                            <span
                                class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold shadow-sm"
                                :class="statusClasses[order.status]"
                            >
                                {{ order.status }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>

<script setup>
import AdminLayout from "@/Layouts/AdminLayout.vue";

const props = defineProps({
    stats: Object,
});

const statusClasses = {
    pending: "bg-yellow-100 text-yellow-800 border border-yellow-200",
    processing: "bg-blue-100 text-blue-800 border border-blue-200",
    completed: "bg-green-100 text-green-800 border border-green-200",
    cancelled: "bg-red-100 text-red-800 border border-red-200",
};
</script>
