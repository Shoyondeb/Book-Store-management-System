<template>
    <AdminLayout>
        <!-- Header Section -->
        <div class="mb-8">
            <div
                class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4"
            >
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">
                        Orders Management
                    </h1>
                    <p class="mt-2 text-gray-600">
                        Manage and track customer orders
                    </p>
                </div>
                <div class="flex items-center space-x-3">
                    <button
                        v-if="orders.data.length > 0"
                        @click="printAllOrders"
                        class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200 shadow-sm"
                    >
                        <svg
                            class="w-4 h-4 mr-2"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"
                            />
                        </svg>
                        Print All
                    </button>
                </div>
            </div>
        </div>

        <!-- Payment Verification Warning -->
        <div
            v-if="paymentSubmittedOrders.length > 0"
            class="mb-6 bg-yellow-50 border-l-4 border-yellow-400 p-4 rounded-r-lg"
        >
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg
                        class="h-5 w-5 text-yellow-400"
                        fill="currentColor"
                        viewBox="0 0 20 20"
                    >
                        <path
                            fill-rule="evenodd"
                            d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z"
                            clip-rule="evenodd"
                        />
                    </svg>
                </div>
                <div class="ml-3 flex-1">
                    <div class="flex justify-between items-center">
                        <div>
                            <h3 class="text-lg font-medium text-yellow-800">
                                Payment Verification Required
                            </h3>
                            <div class="mt-1 text-sm text-yellow-700">
                                <p>
                                    {{ paymentSubmittedOrders.length }} order(s)
                                    with payment_submitted status need
                                    verification
                                </p>
                            </div>
                        </div>
                        <button
                            @click="
                                showVerificationSection =
                                    !showVerificationSection
                            "
                            class="text-yellow-600 hover:text-yellow-900"
                        >
                            <svg
                                class="w-5 h-5"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    v-if="!showVerificationSection"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M19 9l-7 7-7-7"
                                />
                                <path
                                    v-else
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M5 15l7-7 7 7"
                                />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Payment Verification Section -->
        <div
            v-if="showVerificationSection && paymentSubmittedOrders.length > 0"
            class="mb-6 bg-white rounded-lg shadow border border-gray-200"
        >
            <div class="px-6 py-4 border-b border-gray-200">
                <h4 class="text-lg font-semibold text-gray-900">
                    Pending Payment Verification
                </h4>
            </div>
            <div class="divide-y divide-gray-200">
                <div
                    v-for="order in paymentSubmittedOrders"
                    :key="order.id"
                    class="px-6 py-4 hover:bg-gray-50"
                >
                    <div
                        class="flex flex-col md:flex-row md:items-center justify-between gap-4"
                    >
                        <div class="flex-1">
                            <div class="flex items-center gap-3">
                                <div class="bg-yellow-100 p-2 rounded-lg">
                                    <svg
                                        class="w-6 h-6 text-yellow-600"
                                        fill="none"
                                        stroke="currentColor"
                                        viewBox="0 0 24 24"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"
                                        />
                                    </svg>
                                </div>
                                <div>
                                    <div class="flex items-center gap-2">
                                        <span
                                            class="font-semibold text-gray-900"
                                            >Order #{{
                                                order.order_number
                                            }}</span
                                        >
                                        <span
                                            class="px-2 py-1 text-xs font-medium bg-yellow-100 text-yellow-800 rounded-full"
                                            >Needs Verification</span
                                        >
                                    </div>
                                    <div class="text-sm text-gray-600 mt-1">
                                        Customer:
                                        {{
                                            order.user?.name || "Guest Customer"
                                        }}
                                    </div>
                                    <div class="text-sm text-gray-600">
                                        Amount: ৳{{ order.total_amount }}
                                    </div>
                                    <!-- Payment Details -->
                                    <div
                                        v-if="order.payment_details"
                                        class="mt-2 space-y-1 text-sm"
                                    >
                                        <div class="flex items-center gap-2">
                                            <span
                                                class="font-medium text-gray-700"
                                                >Payment Method:</span
                                            >
                                            <span class="text-gray-600">{{
                                                order.payment_method
                                            }}</span>
                                        </div>
                                        <div class="flex items-center gap-2">
                                            <span
                                                class="font-medium text-gray-700"
                                                >Mobile:</span
                                            >
                                            <span class="text-gray-600">{{
                                                getPaymentDetail(
                                                    order,
                                                    "mobile_number"
                                                ) || "N/A"
                                            }}</span>
                                        </div>
                                        <div class="flex items-center gap-2">
                                            <span
                                                class="font-medium text-gray-700"
                                                >Transaction ID:</span
                                            >
                                            <span
                                                class="text-gray-600 font-mono"
                                                >{{
                                                    order.transaction_id ||
                                                    "N/A"
                                                }}</span
                                            >
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Book Items -->
                            <div class="mt-3 ml-11">
                                <div
                                    class="text-xs font-medium text-gray-500 mb-1"
                                >
                                    Books:
                                </div>
                                <div class="flex flex-wrap gap-2">
                                    <span
                                        v-for="item in order.order_items || []"
                                        :key="item.id"
                                        class="inline-flex items-center px-2 py-1 text-xs bg-blue-50 text-blue-700 rounded border border-blue-100"
                                    >
                                        {{ item.book?.title }} (x{{
                                            item.quantity
                                        }})
                                    </span>
                                </div>
                            </div>
                        </div>
                        <!-- Verification Actions -->
                        <div class="flex flex-col gap-2 md:w-48">
                            <button
                                @click="verifyPayment(order, 'paid')"
                                :disabled="isVerifying(order.id, 'paid')"
                                class="w-full flex items-center justify-center px-4 py-2 bg-green-600 text-white text-sm font-medium rounded-lg hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 transition-colors duration-200 disabled:opacity-50 disabled:cursor-not-allowed"
                            >
                                <svg
                                    class="w-4 h-4 mr-2"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M5 13l4 4L19 7"
                                    />
                                </svg>
                                <span v-if="isVerifying(order.id, 'paid')"
                                    >Verifying...</span
                                >
                                <span v-else> ✅ Verify Payment </span>
                            </button>
                            <button
                                @click="verifyPayment(order, 'payment_failed')"
                                :disabled="
                                    isVerifying(order.id, 'payment_failed')
                                "
                                class="w-full flex items-center justify-center px-4 py-2 bg-red-600 text-white text-sm font-medium rounded-lg hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 transition-colors duration-200 disabled:opacity-50 disabled:cursor-not-allowed"
                            >
                                <svg
                                    class="w-4 h-4 mr-2"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12"
                                    />
                                </svg>
                                <span
                                    v-if="
                                        isVerifying(order.id, 'payment_failed')
                                    "
                                    >Rejecting...</span
                                >
                                <span v-else> ❌ Reject Payment </span>
                            </button>
                            <button
                                @click="viewOrder(order)"
                                class="w-full flex items-center justify-center px-4 py-2 border border-gray-300 text-gray-700 text-sm font-medium rounded-lg hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-gray-500 transition-colors duration-200"
                            >
                                View Details
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pagination Controls -->
        <div
            class="bg-white shadow-lg rounded-xl p-6 mb-6 border border-gray-100"
        >
            <div
                class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-6"
            >
                <!-- Pagination Info -->
                <div class="text-sm text-gray-700">
                    Showing
                    <span class="font-semibold text-gray-900">{{
                        orders?.from || 0
                    }}</span>
                    to
                    <span class="font-semibold text-gray-900">{{
                        orders?.to || 0
                    }}</span>
                    of
                    <span class="font-semibold text-gray-900">{{
                        orders?.total || 0
                    }}</span>
                    orders
                </div>

                <!-- Items Per Page Select -->
                <div class="flex items-center space-x-4">
                    <label
                        for="perPage"
                        class="text-sm font-medium text-gray-700 whitespace-nowrap"
                    >
                        <span class="hidden sm:inline">Items per page:</span>
                        <span class="sm:hidden">Show:</span>
                    </label>
                    <div class="relative">
                        <select
                            id="perPage"
                            v-model="perPageInput"
                            @change="updatePerPage"
                            class="w-full sm:w-36 appearance-none bg-white border border-gray-300 rounded-lg px-4 py-2.5 pr-10 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 cursor-pointer hover:border-gray-400 transition-all duration-200 shadow-sm"
                        >
                            <option value="5">5 items</option>
                            <option value="10">10 items</option>
                            <option value="15">15 items</option>
                            <option value="20">20 items</option>
                            <option value="25">25 items</option>
                            <option value="30">30 items</option>
                            <option value="50">50 items</option>
                            <option value="100">100 items</option>
                        </select>
                        <div
                            class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-500"
                        >
                            <svg
                                class="w-5 h-5"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            ></svg>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Stats Overview -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div
                class="bg-gradient-to-br from-blue-50 to-white p-6 rounded-2xl shadow-lg border border-blue-100"
            >
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">
                            Total Orders
                        </p>
                        <p class="text-2xl font-bold text-gray-900 mt-1">
                            {{ total_orders_count }}
                        </p>
                    </div>
                    <div class="p-3 bg-blue-100 rounded-xl">
                        <svg
                            class="w-6 h-6 text-blue-600"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"
                            />
                        </svg>
                    </div>
                </div>
            </div>

            <div
                class="bg-gradient-to-br from-yellow-50 to-white p-6 rounded-2xl shadow-lg border border-yellow-100"
            >
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">
                            Pending Verification
                        </p>
                        <p class="text-2xl font-bold text-gray-900 mt-1">
                            {{ total_payment_submitted_orders_count }}
                        </p>
                    </div>
                    <div class="p-3 bg-yellow-100 rounded-xl">
                        <svg
                            class="w-6 h-6 text-yellow-600"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"
                            />
                        </svg>
                    </div>
                </div>
            </div>

            <div
                class="bg-gradient-to-br from-green-50 to-white p-6 rounded-2xl shadow-lg border border-green-100"
            >
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">
                            Completed
                        </p>
                        <p class="text-2xl font-bold text-gray-900 mt-1">
                            {{ total_completed_orders_count }}
                        </p>
                    </div>
                    <div class="p-3 bg-green-100 rounded-xl">
                        <svg
                            class="w-6 h-6 text-green-600"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M5 13l4 4L19 7"
                            />
                        </svg>
                    </div>
                </div>
            </div>

            <div
                class="bg-gradient-to-br from-purple-50 to-white p-6 rounded-2xl shadow-lg border border-purple-100"
            >
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">
                            Total Revenue
                        </p>
                        <p class="text-2xl font-bold text-gray-900 mt-1">
                            ৳{{ parseFloat(total_revenue || 0).toFixed(2) }}
                        </p>
                    </div>
                    <div class="p-3 bg-purple-100 rounded-xl">
                        <svg
                            class="w-6 h-6 text-purple-600"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"
                            />
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Orders Table -->
        <div
            class="bg-white shadow-xl rounded-2xl overflow-hidden border border-gray-100"
        >
            <div
                class="px-6 py-5 bg-gradient-to-r from-gray-50 to-white border-b border-gray-200"
            >
                <div
                    class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4"
                >
                    <h3 class="text-xl font-bold text-gray-900">Order List</h3>
                    <div class="text-sm text-gray-700">
                        Page {{ orders.current_page }} of {{ orders.last_page }}
                    </div>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th
                                class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider"
                            >
                                Order Details
                            </th>
                            <th
                                class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider"
                            >
                                Customer
                            </th>
                            <th
                                class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider"
                            >
                                Amount
                            </th>
                            <th
                                class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider"
                            >
                                Status
                            </th>
                            <th
                                class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider"
                            >
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-100">
                        <tr
                            v-for="order in orders.data"
                            :key="order.id"
                            class="hover:bg-gray-50 transition-colors duration-200"
                        >
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div
                                        class="h-12 w-12 flex items-center justify-center bg-gradient-to-br from-blue-100 to-blue-50 rounded-xl shadow-sm"
                                    >
                                        <svg
                                            class="w-6 h-6 text-blue-600"
                                            fill="none"
                                            stroke="currentColor"
                                            viewBox="0 0 24 24"
                                        >
                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                stroke-width="2"
                                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"
                                            />
                                        </svg>
                                    </div>
                                    <div class="ml-4">
                                        <div
                                            class="text-sm font-semibold text-gray-900"
                                        >
                                            Order #{{ order.order_number }}
                                        </div>
                                        <div class="text-sm text-gray-500">
                                            {{ formatDate(order.created_at) }}
                                        </div>
                                        <!-- Payment details for payment_submitted -->
                                        <div
                                            v-if="
                                                order.status ===
                                                'payment_submitted'
                                            "
                                            class="mt-2 space-y-1 text-xs"
                                        >
                                            <div class="text-gray-600">
                                                <span class="font-medium"
                                                    >{{
                                                        order.payment_method
                                                    }}:</span
                                                >
                                                {{
                                                    getPaymentDetail(
                                                        order,
                                                        "mobile_number"
                                                    ) || "N/A"
                                                }}
                                            </div>
                                            <div class="text-gray-600">
                                                <span class="font-medium"
                                                    >Txn ID:</span
                                                >
                                                {{
                                                    order.transaction_id ||
                                                    "N/A"
                                                }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td
                                class="px-6 py-4 whitespace-nowrap text-sm text-gray-600"
                            >
                                {{ order.user?.name || "Guest Customer" }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span
                                    class="text-sm font-semibold text-gray-900"
                                    >৳{{ order.total_amount }}</span
                                >
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <!-- Status Display -->
                                <div
                                    v-if="
                                        [
                                            'completed',
                                            'cancelled',
                                            'payment_failed',
                                        ].includes(order.status)
                                    "
                                >
                                    <!-- Static Badges -->
                                    <div
                                        v-if="order.status === 'completed'"
                                        class="flex items-center"
                                    >
                                        <span
                                            class="inline-flex items-center px-3 py-1.5 rounded-full text-sm font-medium bg-gradient-to-r from-green-100 to-green-50 border border-green-200 text-green-800"
                                        >
                                            <span
                                                class="w-2 h-2 rounded-full bg-green-500 mr-2"
                                            ></span>
                                            <svg
                                                class="w-4 h-4 mr-1.5"
                                                fill="none"
                                                stroke="currentColor"
                                                viewBox="0 0 24 24"
                                            >
                                                <path
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    stroke-width="2"
                                                    d="M5 13l4 4L19 7"
                                                />
                                            </svg>
                                            Completed
                                        </span>
                                    </div>

                                    <div
                                        v-else-if="order.status === 'cancelled'"
                                        class="flex items-center"
                                    >
                                        <span
                                            class="inline-flex items-center px-3 py-1.5 rounded-full text-sm font-medium bg-gradient-to-r from-red-100 to-red-50 border border-red-200 text-red-800"
                                        >
                                            <span
                                                class="w-2 h-2 rounded-full bg-red-500 mr-2"
                                            ></span>
                                            <svg
                                                class="w-4 h-4 mr-1.5"
                                                fill="none"
                                                stroke="currentColor"
                                                viewBox="0 0 24 24"
                                            >
                                                <path
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    stroke-width="2"
                                                    d="M6 18L18 6M6 6l12 12"
                                                />
                                            </svg>
                                            Cancelled
                                        </span>
                                    </div>

                                    <div
                                        v-else-if="
                                            order.status === 'payment_failed'
                                        "
                                        class="flex items-center"
                                    >
                                        <span
                                            class="inline-flex items-center px-3 py-1.5 rounded-full text-sm font-medium bg-gradient-to-r from-red-100 to-red-50 border border-red-200 text-red-800"
                                        >
                                            <span
                                                class="w-2 h-2 rounded-full bg-red-500 mr-2"
                                            ></span>
                                            ⚠️ Payment Failed
                                        </span>
                                    </div>
                                </div>

                                <!-- Payment Submitted - Special Treatment -->
                                <div
                                    v-else-if="
                                        order.status === 'payment_submitted'
                                    "
                                >
                                    <div class="flex items-center gap-2">
                                        <span
                                            class="inline-flex items-center px-3 py-1.5 rounded-full text-sm font-medium bg-gradient-to-r from-yellow-100 to-yellow-50 border border-yellow-200 text-yellow-800"
                                        >
                                            <span
                                                class="w-2 h-2 rounded-full bg-yellow-500 mr-2 animate-pulse"
                                            ></span>
                                            🔍 Payment Submitted
                                        </span>
                                        <button
                                            @click="quickVerify(order, 'paid')"
                                            :disabled="
                                                isVerifying(order.id, 'paid')
                                            "
                                            class="inline-flex items-center px-2 py-1 text-xs bg-green-600 text-white rounded hover:bg-green-700 transition-colors duration-200 disabled:opacity-50 disabled:cursor-not-allowed"
                                        >
                                            <svg
                                                class="w-3 h-3 mr-1"
                                                fill="none"
                                                stroke="currentColor"
                                                viewBox="0 0 24 24"
                                            >
                                                <path
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    stroke-width="2"
                                                    d="M5 13l4 4L19 7"
                                                />
                                            </svg>
                                            <span
                                                v-if="
                                                    isVerifying(
                                                        order.id,
                                                        'paid'
                                                    )
                                                "
                                                >...</span
                                            >
                                            <span v-else>Verify</span>
                                        </button>
                                    </div>
                                </div>

                                <!-- Status Change Dropdown for Other Active Orders -->
                                <select
                                    v-else
                                    v-model="order.status"
                                    @change="updateOrderStatus(order)"
                                    :class="[
                                        'text-sm border rounded-lg px-3 py-1.5 font-medium focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors min-w-[180px]',
                                        order.status === 'pending'
                                            ? 'bg-yellow-50 border-yellow-300 text-yellow-700 hover:bg-yellow-100'
                                            : order.status ===
                                              'payment_verification'
                                            ? 'bg-indigo-50 border-indigo-300 text-indigo-700 hover:bg-indigo-100'
                                            : order.status === 'paid'
                                            ? 'bg-blue-50 border-blue-300 text-blue-700 hover:bg-blue-100'
                                            : order.status === 'processing'
                                            ? 'bg-purple-50 border-purple-300 text-purple-700 hover:bg-purple-100'
                                            : order.status === 'shipped'
                                            ? 'bg-teal-50 border-teal-300 text-teal-700 hover:bg-teal-100'
                                            : order.status ===
                                              'ready_for_pickup'
                                            ? 'bg-cyan-50 border-cyan-300 text-cyan-700 hover:bg-cyan-100'
                                            : 'bg-gray-50 border-gray-300 text-gray-700 hover:bg-gray-100',
                                    ]"
                                >
                                    <option value="pending" class="bg-white">
                                        ⏳ Pending
                                    </option>
                                    <option
                                        value="payment_verification"
                                        class="bg-white"
                                    >
                                        🔍 Payment Verification
                                    </option>
                                    <option value="paid" class="bg-white">
                                        ✅ Paid
                                    </option>
                                    <option value="processing" class="bg-white">
                                        🔄 Processing
                                    </option>
                                    <option value="shipped" class="bg-white">
                                        🚚 Shipped
                                    </option>
                                    <option
                                        value="ready_for_pickup"
                                        class="bg-white"
                                    >
                                        📦 Ready for Pickup
                                    </option>
                                    <option value="completed" class="bg-white">
                                        🎉 Completed
                                    </option>
                                    <option value="cancelled" class="bg-white">
                                        ❌ Cancelled
                                    </option>
                                    <option
                                        value="payment_failed"
                                        class="bg-white"
                                    >
                                        ⚠️ Payment Failed
                                    </option>
                                </select>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center space-x-2">
                                    <button
                                        @click="printSingleOrder(order)"
                                        class="inline-flex items-center px-3 py-1.5 border border-gray-300 text-sm font-medium rounded-lg text-gray-700 bg-gray-50 hover:bg-gray-100 hover:border-gray-400 transition-all duration-200"
                                        title="Print Order"
                                    >
                                        <svg
                                            class="w-4 h-4 mr-1"
                                            fill="none"
                                            stroke="currentColor"
                                            viewBox="0 0 24 24"
                                        >
                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                stroke-width="2"
                                                d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"
                                            />
                                        </svg>
                                        Print
                                    </button>

                                    <button
                                        @click="viewOrder(order)"
                                        class="inline-flex items-center px-3 py-1.5 border border-blue-300 text-sm font-medium rounded-lg text-blue-700 bg-blue-50 hover:bg-blue-100 hover:border-blue-400 transition-all duration-200"
                                    >
                                        <svg
                                            class="w-4 h-4 mr-1"
                                            fill="none"
                                            stroke="currentColor"
                                            viewBox="0 0 24 24"
                                        >
                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                stroke-width="2"
                                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"
                                            />
                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                stroke-width="2"
                                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"
                                            />
                                        </svg>
                                        View
                                    </button>

                                    <!-- Quick Action for Payment Submitted -->
                                    <button
                                        v-if="
                                            order.status === 'payment_submitted'
                                        "
                                        @click="quickVerify(order, 'paid')"
                                        :disabled="
                                            isVerifying(order.id, 'paid')
                                        "
                                        class="inline-flex items-center px-3 py-1.5 border border-green-300 text-sm font-medium rounded-lg text-green-700 bg-green-50 hover:bg-green-100 hover:border-green-400 transition-all duration-200 disabled:opacity-50 disabled:cursor-not-allowed"
                                    >
                                        <svg
                                            class="w-4 h-4 mr-1"
                                            fill="none"
                                            stroke="currentColor"
                                            viewBox="0 0 24 24"
                                        >
                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                stroke-width="2"
                                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"
                                            />
                                        </svg>
                                        <span
                                            v-if="isVerifying(order.id, 'paid')"
                                            >Verifying...</span
                                        >
                                        <span v-else>Verify Payment</span>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Pagination -->
        <div
            class="mt-6 flex flex-col sm:flex-row sm:items-center sm:justify-between"
        >
            <div class="text-sm text-gray-700 mb-4 sm:mb-0">
                Page {{ orders.current_page }} of {{ orders.last_page }}
            </div>
            <Pagination :links="orders.links" />
        </div>

        <!-- Order Details Modal -->
        <div
            v-if="showOrderModal"
            class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50 transition-opacity duration-300"
            @click="closeModal"
        >
            <div
                class="relative top-10 mx-auto p-5 border w-11/12 md:max-w-2xl lg:max-w-4xl shadow-xl rounded-lg bg-white transform transition-transform duration-300"
                @click.stop
            >
                <div class="mt-3">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-2xl font-bold text-gray-900">
                            Order Details - #{{ selectedOrder?.order_number }}
                        </h3>
                        <div class="flex space-x-2">
                            <button
                                v-if="selectedOrder"
                                @click="printSingleOrder(selectedOrder)"
                                class="inline-flex items-center px-3 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200"
                            >
                                <svg
                                    class="w-4 h-4 mr-1"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"
                                    />
                                </svg>
                                Print
                            </button>
                            <button
                                @click="closeModal"
                                class="text-gray-400 hover:text-gray-600 transition-colors duration-200"
                            >
                                <svg
                                    class="w-6 h-6"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12"
                                    />
                                </svg>
                            </button>
                        </div>
                    </div>

                    <div v-if="selectedOrder" class="space-y-6">
                        <!-- Order Summary Section -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Customer & Shipping Info -->
                            <div class="space-y-4">
                                <!-- Customer Information Card -->
                                <div
                                    class="bg-white border border-gray-200 rounded-lg p-4 shadow-sm"
                                >
                                    <h4
                                        class="font-semibold text-gray-900 mb-3 flex items-center"
                                    >
                                        <svg
                                            class="w-5 h-5 mr-2 text-blue-500"
                                            fill="none"
                                            stroke="currentColor"
                                            viewBox="0 0 24 24"
                                        >
                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                stroke-width="2"
                                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"
                                            />
                                        </svg>
                                        Customer Information
                                    </h4>
                                    <div class="space-y-2 text-sm">
                                        <div class="flex">
                                            <span
                                                class="font-medium text-gray-700 w-28"
                                                >Name:</span
                                            >
                                            <span class="text-gray-900">{{
                                                selectedOrder.user?.name ||
                                                "Guest Customer"
                                            }}</span>
                                        </div>
                                        <div class="flex">
                                            <span
                                                class="font-medium text-gray-700 w-28"
                                                >Email:</span
                                            >
                                            <span class="text-gray-900">{{
                                                selectedOrder.user?.email ||
                                                "No email"
                                            }}</span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Shipping Address Card -->
                                <div
                                    class="bg-white border border-gray-200 rounded-lg p-4 shadow-sm"
                                >
                                    <h4
                                        class="font-semibold text-gray-900 mb-3 flex items-center"
                                    >
                                        <svg
                                            class="w-5 h-5 mr-2 text-green-500"
                                            fill="none"
                                            stroke="currentColor"
                                            viewBox="0 0 24 24"
                                        >
                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                stroke-width="2"
                                                d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"
                                            />
                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                stroke-width="2"
                                                d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"
                                            />
                                        </svg>
                                        Shipping Address
                                    </h4>

                                    <div
                                        v-if="
                                            selectedOrder.shipping_address &&
                                            hasShippingAddressData(
                                                selectedOrder.shipping_address
                                            )
                                        "
                                        class="space-y-2 text-sm"
                                    >
                                        <!-- Full Name -->
                                        <div
                                            v-if="
                                                selectedOrder.shipping_address
                                                    .full_name
                                            "
                                            class="flex"
                                        >
                                            <span
                                                class="font-medium text-gray-700 w-28"
                                                >Name:</span
                                            >
                                            <span class="text-gray-900">{{
                                                selectedOrder.shipping_address
                                                    .full_name
                                            }}</span>
                                        </div>

                                        <!-- Phone -->
                                        <div
                                            v-if="
                                                selectedOrder.shipping_address
                                                    .phone
                                            "
                                            class="flex"
                                        >
                                            <span
                                                class="font-medium text-gray-700 w-28"
                                                >Phone:</span
                                            >
                                            <span
                                                class="text-gray-900 flex items-center"
                                            >
                                                <svg
                                                    class="w-4 h-4 mr-1 text-gray-500"
                                                    fill="none"
                                                    stroke="currentColor"
                                                    viewBox="0 0 24 24"
                                                >
                                                    <path
                                                        stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"
                                                    />
                                                </svg>
                                                {{
                                                    selectedOrder
                                                        .shipping_address.phone
                                                }}
                                            </span>
                                        </div>

                                        <!-- Address Lines -->
                                        <div
                                            v-if="
                                                selectedOrder.shipping_address
                                                    .address_line1
                                            "
                                            class="flex"
                                        >
                                            <span
                                                class="font-medium text-gray-700 w-28"
                                                >Address:</span
                                            >
                                            <div class="text-gray-900">
                                                <div>
                                                    {{
                                                        selectedOrder
                                                            .shipping_address
                                                            .address_line1
                                                    }}
                                                </div>
                                                <div
                                                    v-if="
                                                        selectedOrder
                                                            .shipping_address
                                                            .address_line2
                                                    "
                                                    class="text-gray-600"
                                                >
                                                    {{
                                                        selectedOrder
                                                            .shipping_address
                                                            .address_line2
                                                    }}
                                                </div>
                                            </div>
                                        </div>

                                        <!-- City/State/Zip -->
                                        <div
                                            v-if="
                                                selectedOrder.shipping_address
                                                    .city ||
                                                selectedOrder.shipping_address
                                                    .state ||
                                                selectedOrder.shipping_address
                                                    .zip_code
                                            "
                                            class="flex"
                                        >
                                            <span
                                                class="font-medium text-gray-700 w-28"
                                                >Location:</span
                                            >
                                            <span class="text-gray-900">
                                                {{
                                                    [
                                                        selectedOrder
                                                            .shipping_address
                                                            .city,
                                                        selectedOrder
                                                            .shipping_address
                                                            .state,
                                                        selectedOrder
                                                            .shipping_address
                                                            .zip_code,
                                                    ]
                                                        .filter(Boolean)
                                                        .join(", ")
                                                }}
                                            </span>
                                        </div>

                                        <!-- Country -->
                                        <div
                                            v-if="
                                                selectedOrder.shipping_address
                                                    .country
                                            "
                                            class="flex"
                                        >
                                            <span
                                                class="font-medium text-gray-700 w-28"
                                                >Country:</span
                                            >
                                            <span class="text-gray-900">{{
                                                selectedOrder.shipping_address
                                                    .country
                                            }}</span>
                                        </div>
                                    </div>

                                    <!-- No Address Message -->
                                    <div v-else class="text-center py-6">
                                        <svg
                                            class="w-12 h-12 mx-auto text-gray-300 mb-2"
                                            fill="none"
                                            stroke="currentColor"
                                            viewBox="0 0 24 24"
                                        >
                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                stroke-width="2"
                                                d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"
                                            />
                                        </svg>
                                        <p class="text-gray-500 text-sm">
                                            No shipping address provided
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <!-- Order Information Card -->
                            <div
                                class="bg-white border border-gray-200 rounded-lg p-4 shadow-sm"
                            >
                                <h4
                                    class="font-semibold text-gray-900 mb-3 flex items-center"
                                >
                                    <svg
                                        class="w-5 h-5 mr-2 text-purple-500"
                                        fill="none"
                                        stroke="currentColor"
                                        viewBox="0 0 24 24"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"
                                        />
                                    </svg>
                                    Order Information
                                </h4>
                                <div class="space-y-2 text-sm">
                                    <div class="flex justify-between">
                                        <span class="font-medium text-gray-700"
                                            >Order Number:</span
                                        >
                                        <span
                                            class="text-gray-900 font-semibold"
                                            >#{{
                                                selectedOrder.order_number
                                            }}</span
                                        >
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="font-medium text-gray-700"
                                            >Date:</span
                                        >
                                        <span class="text-gray-900">{{
                                            formatDate(selectedOrder.created_at)
                                        }}</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="font-medium text-gray-700"
                                            >Total Amount:</span
                                        >
                                        <span
                                            class="text-gray-900 font-bold text-lg"
                                            >৳{{
                                                selectedOrder.total_amount
                                            }}</span
                                        >
                                    </div>
                                    <div
                                        class="flex justify-between items-center"
                                    >
                                        <span class="font-medium text-gray-700"
                                            >Status:</span
                                        >
                                        <span
                                            :class="
                                                getStatusClasses(
                                                    selectedOrder.status
                                                )
                                            "
                                            class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium"
                                        >
                                            <span
                                                :class="
                                                    getStatusDotClasses(
                                                        selectedOrder.status
                                                    )
                                                "
                                                class="w-2 h-2 rounded-full mr-2"
                                            ></span>
                                            {{
                                                getStatusDisplay(
                                                    selectedOrder.status
                                                )
                                            }}
                                        </span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="font-medium text-gray-700"
                                            >Payment Method:</span
                                        >
                                        <span class="text-gray-900">{{
                                            selectedOrder.payment_method ||
                                            "N/A"
                                        }}</span>
                                    </div>
                                    <div
                                        v-if="selectedOrder.transaction_id"
                                        class="flex justify-between"
                                    >
                                        <span class="font-medium text-gray-700"
                                            >Transaction ID:</span
                                        >
                                        <span
                                            class="text-gray-900 font-mono text-xs"
                                            >{{
                                                selectedOrder.transaction_id
                                            }}</span
                                        >
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Order Items Section -->
                        <div
                            class="bg-white border border-gray-200 rounded-lg p-4 shadow-sm"
                        >
                            <h4
                                class="font-semibold text-gray-900 mb-4 text-lg flex items-center"
                            >
                                <svg
                                    class="w-5 h-5 mr-2 text-orange-500"
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
                                Order Items ({{
                                    selectedOrder.order_items?.length || 0
                                }}
                                items)
                            </h4>

                            <div
                                class="border border-gray-200 rounded-lg divide-y divide-gray-200"
                            >
                                <div
                                    v-for="item in selectedOrder.order_items ||
                                    []"
                                    :key="item.id"
                                    class="flex justify-between items-center p-4 hover:bg-gray-50 transition-colors duration-150"
                                >
                                    <div
                                        class="flex items-center space-x-4 flex-1"
                                    >
                                        <img
                                            :src="
                                                item.book?.image_url ||
                                                '/images/book-placeholder.png'
                                            "
                                            :alt="item.book?.title || 'Book'"
                                            class="h-16 w-12 object-cover rounded shadow-sm border"
                                            @error="handleImageError"
                                        />
                                        <div class="flex-1">
                                            <p
                                                class="font-semibold text-gray-900 line-clamp-1"
                                            >
                                                {{
                                                    item.book?.title ||
                                                    "Unknown Book"
                                                }}
                                            </p>
                                            <p
                                                class="text-sm text-gray-500 mt-1"
                                            >
                                                by
                                                {{
                                                    item.book?.author?.name ||
                                                    "Unknown Author"
                                                }}
                                            </p>
                                            <div
                                                class="flex items-center space-x-3 mt-1"
                                            >
                                                <span
                                                    class="text-xs text-gray-400"
                                                >
                                                    ISBN:
                                                    {{
                                                        item.book?.isbn || "N/A"
                                                    }}
                                                </span>
                                                <span
                                                    class="text-xs px-2 py-1 bg-blue-50 text-blue-700 rounded"
                                                >
                                                    Qty: {{ item.quantity }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <p class="text-sm text-gray-600">
                                            Price: ৳{{ item.price }}
                                        </p>
                                        <p
                                            class="font-semibold text-gray-900 mt-1"
                                        >
                                            ৳{{
                                                (
                                                    item.price * item.quantity
                                                ).toFixed(2)
                                            }}
                                        </p>
                                    </div>
                                </div>

                                <!-- Order Total -->
                                <div class="p-4 bg-gray-50">
                                    <div
                                        class="flex justify-between items-center text-lg font-bold text-gray-900"
                                    >
                                        <span>Total Amount:</span>
                                        <span class="text-xl"
                                            >৳{{
                                                selectedOrder.total_amount
                                            }}</span
                                        >
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Payment Verification Section (if payment_submitted) -->
                        <div
                            v-if="selectedOrder.status === 'payment_submitted'"
                            class="bg-yellow-50 border border-yellow-200 rounded-lg p-4"
                        >
                            <h4 class="font-semibold text-yellow-900 mb-3">
                                Payment Verification Required
                            </h4>
                            <div
                                class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4"
                            >
                                <div>
                                    <label
                                        class="block text-sm font-medium text-gray-700"
                                        >Payment Method</label
                                    >
                                    <div
                                        class="mt-1 text-lg font-semibold text-gray-900"
                                    >
                                        {{
                                            selectedOrder.payment_method?.toUpperCase() ||
                                            "N/A"
                                        }}
                                    </div>
                                </div>
                                <div>
                                    <label
                                        class="block text-sm font-medium text-gray-700"
                                        >Transaction ID</label
                                    >
                                    <div
                                        class="mt-1 text-lg font-semibold text-gray-900"
                                    >
                                        {{
                                            selectedOrder.transaction_id ||
                                            "N/A"
                                        }}
                                    </div>
                                </div>
                                <div>
                                    <label
                                        class="block text-sm font-medium text-gray-700"
                                        >Mobile Number</label
                                    >
                                    <div
                                        class="mt-1 text-lg font-semibold text-gray-900"
                                    >
                                        {{
                                            getPaymentDetail(
                                                selectedOrder,
                                                "mobile_number"
                                            ) || "N/A"
                                        }}
                                    </div>
                                </div>
                                <div>
                                    <label
                                        class="block text-sm font-medium text-gray-700"
                                        >Amount</label
                                    >
                                    <div
                                        class="mt-1 text-lg font-semibold text-green-600"
                                    >
                                        ৳{{ selectedOrder.total_amount }}
                                    </div>
                                </div>
                            </div>
                            <div class="flex space-x-3">
                                <button
                                    @click="
                                        verifyPayment(selectedOrder, 'paid')
                                    "
                                    :disabled="
                                        isVerifying(selectedOrder.id, 'paid')
                                    "
                                    class="flex-1 flex items-center justify-center px-4 py-2 bg-green-600 text-white font-medium rounded-lg hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 transition-colors duration-200 disabled:opacity-50 disabled:cursor-not-allowed"
                                >
                                    <svg
                                        class="w-5 h-5 mr-2"
                                        fill="none"
                                        stroke="currentColor"
                                        viewBox="0 0 24 24"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M5 13l4 4L19 7"
                                        />
                                    </svg>
                                    <span
                                        v-if="
                                            isVerifying(
                                                selectedOrder.id,
                                                'paid'
                                            )
                                        "
                                        >Verifying...</span
                                    >
                                    <span v-else> ✅ Approve Payment </span>
                                </button>
                                <button
                                    @click="
                                        verifyPayment(
                                            selectedOrder,
                                            'payment_failed'
                                        )
                                    "
                                    :disabled="
                                        isVerifying(
                                            selectedOrder.id,
                                            'payment_failed'
                                        )
                                    "
                                    class="flex-1 flex items-center justify-center px-4 py-2 bg-red-600 text-white font-medium rounded-lg hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 transition-colors duration-200 disabled:opacity-50 disabled:cursor-not-allowed"
                                >
                                    <svg
                                        class="w-5 h-5 mr-2"
                                        fill="none"
                                        stroke="currentColor"
                                        viewBox="0 0 24 24"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M6 18L18 6M6 6l12 12"
                                        />
                                    </svg>
                                    <span
                                        v-if="
                                            isVerifying(
                                                selectedOrder.id,
                                                'payment_failed'
                                            )
                                        "
                                        >Rejecting...</span
                                    >
                                    <span v-else> ❌ Reject Payment </span>
                                </button>
                            </div>
                        </div>
                    </div>

                    <div
                        class="flex justify-end mt-8 pt-6 border-t border-gray-200"
                    >
                        <button
                            @click="closeModal"
                            class="px-6 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200"
                        >
                            Close
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Printable Content (Hidden) -->
        <div v-if="printContent" ref="printableContent" class="hidden">
            <!-- Single Order Invoice -->
            <div v-if="printType === 'single' && printOrder" class="invoice">
                <!-- Header with Logo -->
                <div class="invoice-header">
                    <div class="company-info">
                        <div class="logo">
                            <!-- Replace emoji with logo -->
                            <img
                                src="/images/logo.png"
                                alt="PUSTOK Logo"
                                class="logo-image"
                                style="
                                    width: 70px;
                                    height: 70px;
                                    object-fit: contain;
                                "
                            />
                        </div>
                        <div>
                            <h1>PUSTOK</h1>
                            <p class="company-details">
                                123 Book Street, Zindabazar, Sylhet
                            </p>
                            <p class="company-contact">
                                shoyondeb18246@gmail.com
                            </p>
                        </div>
                    </div>
                    <div class="invoice-title">
                        <h2>ORDER INVOICE</h2>
                        <div class="invoice-number">
                            INV-{{ printOrder.order_number }}
                        </div>
                    </div>
                </div>

                <!-- Invoice Details -->
                <div class="invoice-details">
                    <div class="details-grid">
                        <!-- Customer & Billing Info -->
                        <div class="detail-section">
                            <div class="section-header">
                                <svg
                                    class="header-icon"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"
                                    />
                                </svg>
                                <h3>CUSTOMER INFORMATION</h3>
                            </div>
                            <div class="detail-content">
                                <div class="detail-row">
                                    <span class="label">Name:</span>
                                    <span class="value">{{
                                        printOrder.user?.name ||
                                        "Guest Customer"
                                    }}</span>
                                </div>
                                <div class="detail-row">
                                    <span class="label">Email:</span>
                                    <span class="value">{{
                                        printOrder.user?.email ||
                                        "No email provided"
                                    }}</span>
                                </div>
                                <div class="detail-row">
                                    <span class="label">Order Date:</span>
                                    <span class="value">{{
                                        formatDate(printOrder.created_at)
                                    }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Shipping Address -->
                        <div class="detail-section">
                            <div class="section-header">
                                <svg
                                    class="header-icon"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"
                                    />
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"
                                    />
                                </svg>
                                <h3>SHIPPING ADDRESS</h3>
                            </div>
                            <div class="detail-content">
                                <div
                                    v-if="
                                        printOrder.shipping_address &&
                                        hasShippingAddressData(
                                            printOrder.shipping_address
                                        )
                                    "
                                    class="shipping-address-details"
                                >
                                    <div
                                        v-if="
                                            printOrder.shipping_address
                                                .full_name
                                        "
                                        class="address-line"
                                    >
                                        <strong>Name:</strong>
                                        {{
                                            printOrder.shipping_address
                                                .full_name
                                        }}
                                    </div>
                                    <div
                                        v-if="printOrder.shipping_address.phone"
                                        class="address-line"
                                    >
                                        <strong>Phone:</strong>
                                        {{ printOrder.shipping_address.phone }}
                                    </div>
                                    <div
                                        v-if="
                                            printOrder.shipping_address
                                                .address_line1
                                        "
                                        class="address-line"
                                    >
                                        <strong>Address:</strong>
                                        {{
                                            printOrder.shipping_address
                                                .address_line1
                                        }}
                                    </div>
                                    <div
                                        v-if="
                                            printOrder.shipping_address
                                                .address_line2
                                        "
                                        class="address-line"
                                    >
                                        {{
                                            printOrder.shipping_address
                                                .address_line2
                                        }}
                                    </div>
                                    <div
                                        v-if="
                                            printOrder.shipping_address.city ||
                                            printOrder.shipping_address.state ||
                                            printOrder.shipping_address.zip_code
                                        "
                                        class="address-line"
                                    >
                                        <strong>Location:</strong>
                                        {{
                                            [
                                                printOrder.shipping_address
                                                    .city,
                                                printOrder.shipping_address
                                                    .state,
                                                printOrder.shipping_address
                                                    .zip_code,
                                            ]
                                                .filter(Boolean)
                                                .join(", ")
                                        }}
                                    </div>
                                    <div
                                        v-if="
                                            printOrder.shipping_address.country
                                        "
                                        class="address-line"
                                    >
                                        <strong>Country:</strong>
                                        {{
                                            printOrder.shipping_address.country
                                        }}
                                    </div>
                                </div>
                                <div v-else class="no-address">
                                    <svg
                                        class="no-data-icon"
                                        fill="none"
                                        stroke="currentColor"
                                        viewBox="0 0 24 24"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"
                                        />
                                    </svg>
                                    <p>No shipping address provided</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Order Status & Payment Info -->
                <div class="order-meta-section">
                    <div class="meta-grid">
                        <div class="meta-item">
                            <span class="meta-label">Order Status</span>
                            <span
                                :class="
                                    'status-badge status-' + printOrder.status
                                "
                            >
                                {{ getStatusDisplayName(printOrder.status) }}
                            </span>
                        </div>
                        <div class="meta-item">
                            <span class="meta-label">Payment Method</span>
                            <span class="meta-value">{{
                                printOrder.payment_method || "N/A"
                            }}</span>
                        </div>
                        <div class="meta-item">
                            <span class="meta-label">Total Amount</span>
                            <span class="meta-value total-amount"
                                >৳{{ printOrder.total_amount }}</span
                            >
                        </div>
                    </div>
                </div>

                <!-- Items Table -->
                <div class="invoice-items">
                    <div class="section-header">
                        <svg
                            class="header-icon"
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
                        <h3>ORDER ITEMS</h3>
                    </div>
                    <table class="items-table">
                        <thead>
                            <tr>
                                <th class="serial">#</th>
                                <th class="description">ITEM DESCRIPTION</th>
                                <th class="qty">QTY</th>
                                <th class="price">UNIT PRICE</th>
                                <th class="total">TOTAL</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr
                                v-for="(
                                    item, index
                                ) in printOrder.order_items || []"
                                :key="item.id"
                            >
                                <td class="serial">{{ index + 1 }}</td>
                                <td class="description">
                                    <div class="item-title">
                                        {{ item.book?.title || "Unknown Book" }}
                                    </div>
                                    <div class="item-author">
                                        {{
                                            item.book?.author?.name ||
                                            "Unknown Author"
                                        }}
                                    </div>
                                </td>
                                <td class="qty">{{ item.quantity }}</td>
                                <td class="price">৳{{ item.price }}</td>
                                <td class="total">
                                    ৳{{
                                        (item.price * item.quantity).toFixed(2)
                                    }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Totals -->
                <div class="invoice-totals">
                    <div class="totals-grid">
                        <div></div>
                        <div class="totals-section">
                            <div class="total-row">
                                <span class="label">Subtotal:</span>
                                <span class="value"
                                    >৳{{ printOrder.total_amount }}</span
                                >
                            </div>
                            <div class="total-row">
                                <span class="label">Shipping:</span>
                                <span class="value">৳0.00</span>
                            </div>
                            <div class="total-row">
                                <span class="label">Tax:</span>
                                <span class="value">৳0.00</span>
                            </div>
                            <div class="total-row grand-total">
                                <span class="label">GRAND TOTAL:</span>
                                <span class="value"
                                    >৳{{ printOrder.total_amount }}</span
                                >
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Footer -->
                <div class="invoice-footer">
                    <div class="thank-you">
                        <p>Thank you for your purchase!</p>
                        <small
                            >This invoice is computer generated and does not
                            require a signature.</small
                        >
                    </div>
                    <div class="print-info">
                        <p>Printed on: {{ new Date().toLocaleDateString() }}</p>
                        <p>
                            Printed by:
                            {{ auth?.user?.name || "Administrator" }}
                        </p>
                    </div>
                </div>

                <!-- Watermark -->
                <div class="watermark">BookStore Manager</div>
            </div>

            <!-- All Orders Report -->
            <div v-if="printType === 'all'" class="report">
                <!-- Report Header -->
                <div class="report-header">
                    <div class="company-info">
                        <div class="logo">
                            <!-- Replace emoji with logo -->
                            <img
                                src="/images/logo.png"
                                alt="PUSTOK Logo"
                                class="logo-image"
                                style="
                                    width: 60px;
                                    height: 60px;
                                    object-fit: contain;
                                "
                            />
                        </div>
                        <div>
                            <h1>PUSTOK</h1>
                            <p class="company-details">Order History Report</p>
                        </div>
                    </div>
                    <div class="report-title">
                        <h2>ORDER HISTORY</h2>
                        <p class="report-date">
                            Generated: {{ new Date().toLocaleDateString() }}
                        </p>
                    </div>
                </div>

                <!-- Report Summary -->
                <div class="report-summary">
                    <div class="stats-grid">
                        <div class="stat-card">
                            <div class="stat-number">
                                {{ total_orders_count }}
                            </div>
                            <div class="stat-label">Total Orders</div>
                        </div>
                        <div class="stat-card">
                            <div class="stat-number">
                                ৳{{ parseFloat(total_revenue || 0).toFixed(2) }}
                            </div>
                            <div class="stat-label">Total Revenue</div>
                        </div>
                        <div class="stat-card">
                            <div class="stat-number">
                                {{ total_completed_orders_count }}
                            </div>
                            <div class="stat-label">Completed</div>
                        </div>
                        <div class="stat-card">
                            <div class="stat-number">
                                {{ total_payment_submitted_orders_count }}
                            </div>
                            <div class="stat-label">Pending Verification</div>
                        </div>
                    </div>
                </div>

                <!-- Orders List -->
                <div class="orders-section">
                    <h3>ORDER DETAILS</h3>
                    <div
                        v-for="order in orders.data"
                        :key="order.id"
                        class="order-card"
                    >
                        <div class="order-header">
                            <div class="order-meta">
                                <span class="order-number"
                                    >Order #{{ order.order_number }}</span
                                >
                                <span :class="'status status-' + order.status">
                                    {{ getStatusDisplayName(order.status) }}
                                </span>
                            </div>
                            <div class="order-details">
                                <span class="date">{{
                                    formatDate(order.created_at)
                                }}</span>
                                <span class="total"
                                    >৳{{ order.total_amount }}</span
                                >
                            </div>
                        </div>

                        <table class="order-items">
                            <thead>
                                <tr>
                                    <th>Book Title</th>
                                    <th class="text-center">Qty</th>
                                    <th class="text-right">Price</th>
                                    <th class="text-right">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr
                                    v-for="item in order.order_items || []"
                                    :key="item.id"
                                >
                                    <td class="item-title">
                                        {{ item.book?.title || "Unknown Book" }}
                                    </td>
                                    <td class="text-center">
                                        {{ item.quantity }}
                                    </td>
                                    <td class="text-right">
                                        ৳{{ item.price }}
                                    </td>
                                    <td class="text-right">
                                        ৳{{
                                            (
                                                item.price * item.quantity
                                            ).toFixed(2)
                                        }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>

                        <!-- Customer & Shipping Info -->
                        <div class="order-meta-grid">
                            <div class="customer-info">
                                <div class="meta-label">Customer:</div>
                                <div class="meta-value">
                                    {{ order.user?.name || "Guest Customer" }}
                                </div>
                            </div>
                            <div class="payment-info">
                                <div class="meta-label">Payment Method:</div>
                                <div class="meta-value">
                                    {{ order.payment_method || "N/A" }}
                                </div>
                            </div>
                        </div>

                        <!-- Shipping Address -->
                        <div
                            v-if="
                                order.shipping_address &&
                                hasShippingAddressData(order.shipping_address)
                            "
                            class="shipping-info-section"
                        >
                            <div class="section-title">Shipping Address</div>
                            <div class="shipping-details">
                                <div
                                    v-if="order.shipping_address.full_name"
                                    class="shipping-line"
                                >
                                    <span class="label">Name:</span>
                                    {{ order.shipping_address.full_name }}
                                </div>
                                <div
                                    v-if="order.shipping_address.phone"
                                    class="shipping-line"
                                >
                                    <span class="label">Phone:</span>
                                    {{ order.shipping_address.phone }}
                                </div>
                                <div
                                    v-if="order.shipping_address.address_line1"
                                    class="shipping-line"
                                >
                                    <span class="label">Address:</span>
                                    {{ order.shipping_address.address_line1 }}
                                </div>
                                <div
                                    v-if="
                                        order.shipping_address.city ||
                                        order.shipping_address.state
                                    "
                                    class="shipping-line"
                                >
                                    <span class="label">Location:</span>
                                    {{
                                        [
                                            order.shipping_address.city,
                                            order.shipping_address.state,
                                        ]
                                            .filter(Boolean)
                                            .join(", ")
                                    }}
                                </div>
                            </div>
                        </div>

                        <div class="order-footer">
                            <div class="item-count">
                                {{
                                    getItemCountText(
                                        order.order_items?.length || 0
                                    )
                                }}
                            </div>
                            <div class="order-date">
                                {{ formatDate(order.created_at) }}
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Report Footer -->
                <div class="report-footer">
                    <div class="pagination-info">
                        <p>
                            Page {{ orders.current_page }} of
                            {{ orders.last_page }}
                        </p>
                        <p>
                            Showing orders {{ orders.from }} -
                            {{ orders.to }} of {{ orders.total }}
                        </p>
                    </div>
                    <div class="report-meta">
                        <p>Report generated by BookStore Management System</p>
                        <p>shoyondeb18246@gmail.com</p>
                    </div>
                </div>

                <!-- Watermark -->
                <div class="watermark">CONFIDENTIAL</div>
            </div>
        </div>
    </AdminLayout>
</template>

<script setup>
import { ref, watch, nextTick, computed, reactive } from "vue";
import { router } from "@inertiajs/vue3";
import AdminLayout from "@/Layouts/AdminLayout.vue";
import Pagination from "@/Components/Pagination.vue";

const props = defineProps({
    orders: Object,
    per_page: {
        type: Number,
        default: 10,
    },
    auth: Object,
    total_orders_count: Number,
    total_completed_orders_count: Number,
    total_payment_submitted_orders_count: Number,
    total_revenue: Number,
});

const showOrderModal = ref(false);
const selectedOrder = ref(null);
const printContent = ref(false);
const printType = ref("");
const printOrder = ref(null);
const printableContent = ref(null);
const showVerificationSection = ref(true);
const perPageInput = ref(props.per_page);

// Track verification status
const verifyingOrders = reactive({});

// Computed properties
const paymentSubmittedOrders = computed(() => {
    return props.orders.data.filter(
        (order) => order.status === "payment_submitted"
    );
});

// Watch for props changes
watch(
    () => props.per_page,
    (newPerPage) => {
        perPageInput.value = newPerPage;
    }
);

const updatePerPage = () => {
    let perPageValue = parseInt(perPageInput.value);

    if (isNaN(perPageValue) || perPageValue < 1) {
        perPageValue = 1;
        perPageInput.value = 1;
    }

    if (perPageValue > 100) {
        perPageValue = 100;
        perPageInput.value = 100;
    }

    if (perPageValue !== props.per_page) {
        router.get(
            route("admin.orders.index"),
            {
                per_page: perPageValue,
                page: 1,
            },
            {
                preserveState: true,
                preserveScroll: true,
                replace: true,
                onSuccess: () => {
                    perPageInput.value = perPageValue;
                },
            }
        );
    }
};

// View order details
const viewOrder = (order) => {
    selectedOrder.value = { ...order };
    showOrderModal.value = true;
};

const closeModal = () => {
    showOrderModal.value = false;
    selectedOrder.value = null;
};

// Check if an order is being verified
const isVerifying = (orderId, status) => {
    return verifyingOrders[`${orderId}_${status}`] === true;
};

// Set verifying status
const setVerifying = (orderId, status, value) => {
    verifyingOrders[`${orderId}_${status}`] = value;
};

// Update order status
const updateOrderStatus = async (order) => {
    try {
        await router.put(
            route("admin.orders.update-status", order.id),
            {
                status: order.status,
            },
            {
                preserveScroll: true,
                onSuccess: () => {
                    // Refresh the page to get updated data
                    router.reload({
                        preserveScroll: true,
                        preserveState: false,
                    });
                },
                onError: (errors) => {
                    console.error("Failed to update order status:", errors);
                    showNotification(
                        "Failed to update order status. Please try again.",
                        "error"
                    );
                },
            }
        );
    } catch (error) {
        console.error("Failed to update order status:", error);
        showNotification(
            "Failed to update order status. Please try again.",
            "error"
        );
    }
};

// Verify payment (for payment_submitted orders)
const verifyPayment = async (order, status) => {
    if (
        !confirm(
            `Are you sure you want to ${
                status === "paid" ? "approve" : "reject"
            } this payment?`
        )
    ) {
        return;
    }

    // Set verifying status
    setVerifying(order.id, status, true);

    try {
        const response = await router.put(
            route("admin.orders.verify-payment", order.id),
            {
                status: status,
            },
            {
                preserveScroll: true,
                preserveState: true,
                onFinish: () => {
                    // Remove from verifying orders when request finishes
                    setVerifying(order.id, status, false);
                },
            }
        );

        // Show success message
        showNotification(
            `Payment ${
                status === "paid" ? "verified" : "rejected"
            } successfully!`,
            "success"
        );

        // Refresh the page to get updated data
        router.reload({
            preserveScroll: true,
            preserveState: false,
        });
    } catch (error) {
        console.error("Failed to verify payment:", error);
        setVerifying(order.id, status, false);

        let errorMessage = "Failed to verify payment. Please try again.";

        if (error.message?.includes("Network Error")) {
            errorMessage = "Network error. Please check your connection.";
        } else if (error.message) {
            errorMessage = error.message;
        }
        showNotification(errorMessage, "error");
    }
};

// Quick verify (direct from table)
const quickVerify = async (order, status) => {
    if (
        !confirm(
            `Are you sure you want to ${
                status === "paid" ? "approve" : "reject"
            } this payment?`
        )
    ) {
        return;
    }

    // Set verifying status
    setVerifying(order.id, status, true);

    try {
        const response = await router.put(
            route("admin.orders.verify-payment", order.id),
            {
                status: status,
            },
            {
                preserveScroll: true,
                preserveState: true,
                onFinish: () => {
                    // Remove from verifying orders when request finishes
                    setVerifying(order.id, status, false);
                },
            }
        );

        // Show success message
        showNotification(
            `Payment ${
                status === "paid" ? "verified" : "rejected"
            } successfully!`,
            "success"
        );

        // Refresh the page to get updated data
        router.reload({
            preserveScroll: true,
            preserveState: false,
        });
    } catch (error) {
        console.error("Failed to verify payment:", error);
        setVerifying(order.id, status, false);

        let errorMessage = "Failed to verify payment. Please try again.";

        if (error.message?.includes("Network Error")) {
            errorMessage = "Network error. Please check your connection.";
        } else if (error.message) {
            errorMessage = error.message;
        }

        showNotification(errorMessage, "error");
    }
};

// Helper function to extract payment details
const getPaymentDetail = (order, key) => {
    try {
        if (order.payment_details) {
            const details =
                typeof order.payment_details === "string"
                    ? JSON.parse(order.payment_details)
                    : order.payment_details;
            return details[key] || null;
        }
        return null;
    } catch (e) {
        return null;
    }
};

// Helper function to check if shipping address has data
const hasShippingAddressData = (address) => {
    if (!address || typeof address !== "object") return false;

    const addressFields = [
        "full_name",
        "phone",
        "address_line1", // Note: your database uses address_line1 (without underscore)
        "address_line2", // Note: your database uses address_line2 (without underscore)
        "city",
        "state",
        "zip_code", // Note: your database uses zip_code (not postal_code)
        "country",
    ];

    return addressFields.some(
        (field) => address[field] && address[field].toString().trim() !== ""
    );
};

// Helper to format address for display
const formatShippingAddress = (address) => {
    if (!address || !hasShippingAddressData(address)) {
        return "No shipping address provided";
    }

    const parts = [];

    if (address.full_name) parts.push(`Name: ${address.full_name}`);
    if (address.phone) parts.push(`Phone: ${address.phone}`);
    if (address.address_line1) parts.push(address.address_line1);
    if (address.address_line2) parts.push(address.address_line2);

    const location = [
        address.city,
        address.state,
        address.zip_code, // Note: using zip_code from your database
    ]
        .filter(Boolean)
        .join(", ");

    if (location) parts.push(location);
    if (address.country) parts.push(address.country);

    return parts.join("\n");
};

// Status helpers
const getStatusClasses = (status) => {
    const classes = {
        pending: "bg-yellow-100 text-yellow-800",
        payment_submitted: "bg-yellow-100 text-yellow-800",
        payment_verification: "bg-indigo-100 text-indigo-800",
        paid: "bg-blue-100 text-blue-800",
        processing: "bg-purple-100 text-purple-800",
        shipped: "bg-teal-100 text-teal-800",
        ready_for_pickup: "bg-cyan-100 text-cyan-800",
        completed: "bg-green-100 text-green-800",
        cancelled: "bg-red-100 text-red-800",
        payment_failed: "bg-red-100 text-red-800",
    };
    return classes[status] || "bg-gray-100 text-gray-800";
};

const getStatusDotClasses = (status) => {
    const classes = {
        pending: "bg-yellow-500",
        payment_submitted: "bg-yellow-500",
        payment_verification: "bg-indigo-500",
        paid: "bg-blue-500",
        processing: "bg-purple-500",
        shipped: "bg-teal-500",
        ready_for_pickup: "bg-cyan-500",
        completed: "bg-green-500",
        cancelled: "bg-red-500",
        payment_failed: "bg-red-500",
    };
    return classes[status] || "bg-gray-500";
};

const getStatusDisplay = (status) => {
    const display = {
        pending: "Pending",
        payment_submitted: "Payment Submitted",
        payment_verification: "Payment Verification",
        paid: "Paid",
        processing: "Processing",
        shipped: "Shipped",
        ready_for_pickup: "Ready for Pickup",
        completed: "Completed",
        cancelled: "Cancelled",
        payment_failed: "Payment Failed",
    };
    return display[status] || status;
};

// Notification helper
const showNotification = (message, type = "success") => {
    // You can implement a proper notification system here
    // For now, we'll use a simple alert
    if (type === "success") {
        alert("✅ " + message);
    } else {
        alert("❌ " + message);
    }
};

// Existing helper functions
const getTotalRevenue = () => {
    return props.orders.data
        .reduce((total, order) => {
            return total + (parseFloat(order.total_amount) || 0);
        }, 0)
        .toFixed(2);
};

const getStatusCount = (status) => {
    return props.orders.data.filter((order) => order.status === status).length;
};

const getItemCountText = (count) => {
    return count === 1 ? "1 item" : `${count} items`;
};

const getStatusDisplayName = (status) => {
    const statusMap = {
        pending: "PENDING",
        payment_submitted: "PAYMENT SUBMITTED",
        payment_verification: "PAYMENT VERIFICATION",
        paid: "PAID",
        processing: "PROCESSING",
        shipped: "SHIPPED",
        ready_for_pickup: "READY FOR PICKUP",
        completed: "COMPLETED",
        cancelled: "CANCELLED",
        payment_failed: "PAYMENT FAILED",
    };
    return statusMap[status] || status.toUpperCase();
};

const formatDate = (dateString) => {
    return new Date(dateString).toLocaleDateString("en-US", {
        year: "numeric",
        month: "short",
        day: "numeric",
    });
};

const handleImageError = (event) => {
    event.target.src = "/images/book-placeholder.png";
};

// Print functions
// Replace the printSingleOrder function with this updated version:
const printSingleOrder = (order) => {
    printType.value = "single";
    printOrder.value = order;
    printContent.value = true;

    nextTick(() => {
        setTimeout(() => {
            const printWindow = window.open("", "_blank");
            if (!printWindow) {
                alert("Please allow popups for printing");
                printContent.value = false;
                return;
            }

            const content = printableContent.value.innerHTML;

            printWindow.document.write(`
                <!DOCTYPE html>
                <html>
                <head>
                    <title>Invoice #${order.order_number} - BookStore</title>
                    <meta charset="UTF-8">
                    <style>
                        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');
                        
                        * {
                            margin: 0;
                            padding: 0;
                            box-sizing: border-box;
                        }
                        
                        body {
                            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
                            padding: 15px;
                            color: #333;
                            background: white;
                            line-height: 1.4;
                            font-size: 12px;
                        }
                        
                        .invoice {
                            max-width: 750px;
                            margin: 0 auto;
                            position: relative;
                        }
                        
                        /* Invoice Header - Compact */
                        .invoice-header {
                            display: flex;
                            justify-content: space-between;
                            align-items: flex-start;
                            margin-bottom: 20px;
                            padding-bottom: 15px;
                            border-bottom: 2px solid #2c3e50;
                        }
                        
                        .company-info {
                            display: flex;
                            align-items: center;
                            gap: 15px;
                        }
                        
                        .logo-circle {
                            width: 50px;
                            height: 50px;
                            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                            border-radius: 50%;
                            display: flex;
                            align-items: center;
                            justify-content: center;
                            font-size: 24px;
                            color: white;
                        }
                        
                        .company-info h1 {
                            font-size: 20px;
                            font-weight: 700;
                            color: #2c3e50;
                            letter-spacing: -0.5px;
                        }
                        
                        .company-details {
                            color: #666;
                            font-size: 11px;
                            margin-top: 2px;
                        }
                        
                        .company-contact {
                            color: #888;
                            font-size: 10px;
                            margin-top: 1px;
                        }
                        
                        .invoice-title {
                            text-align: right;
                        }
                        
                        .invoice-title h2 {
                            font-size: 18px;
                            color: #2c3e50;
                            margin-bottom: 5px;
                            font-weight: 700;
                        }
                        
                        .invoice-number {
                            font-size: 14px;
                            color: #667eea;
                            font-weight: 600;
                            letter-spacing: 0.5px;
                        }
                        
                        /* Invoice Details - Compact */
                        .invoice-details {
                            margin-bottom: 20px;
                        }
                        
                        .details-grid {
                            display: grid;
                            grid-template-columns: 1fr 1fr;
                            gap: 20px;
                            margin-bottom: 20px;
                        }
                        
                        .detail-section {
                            background: #f8f9fa;
                            border-radius: 6px;
                            padding: 15px;
                            border: 1px solid #e9ecef;
                        }
                        
                        .section-header {
                            display: flex;
                            align-items: center;
                            margin-bottom: 10px;
                            padding-bottom: 8px;
                            border-bottom: 1px solid #e9ecef;
                        }
                        
                        .header-icon {
                            width: 16px;
                            height: 16px;
                            margin-right: 8px;
                            color: #667eea;
                        }
                        
                        .section-header h3 {
                            font-size: 12px;
                            color: #2c3e50;
                            text-transform: uppercase;
                            letter-spacing: 0.5px;
                            font-weight: 600;
                        }
                        
                        .detail-content {
                            font-size: 11px;
                        }
                        
                        .detail-row {
                            display: flex;
                            justify-content: space-between;
                            margin-bottom: 6px;
                        }
                        
                        .detail-row .label {
                            color: #666;
                            font-weight: 500;
                        }
                        
                        .detail-row .value {
                            color: #333;
                            font-weight: 500;
                        }
                        
                        /* Shipping Address - Compact */
                        .shipping-address-details {
                            margin-top: 8px;
                        }
                        
                        .address-line {
                            margin-bottom: 4px;
                            line-height: 1.3;
                            font-size: 11px;
                        }
                        
                        .address-line strong {
                            color: #4b5563;
                            font-weight: 600;
                            margin-right: 4px;
                        }
                        
                        .no-address {
                            text-align: center;
                            padding: 15px 0;
                            color: #9ca3af;
                        }
                        
                        .no-data-icon {
                            width: 30px;
                            height: 30px;
                            margin: 0 auto 8px;
                            color: #d1d5db;
                        }
                        
                        .no-address p {
                            font-size: 12px;
                            font-style: italic;
                        }
                        
                        /* Order Meta Section - Compact */
                        .order-meta-section {
                            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                            border-radius: 6px;
                            padding: 15px;
                            margin-bottom: 20px;
                            color: white;
                        }
                        
                        .meta-grid {
                            display: grid;
                            grid-template-columns: repeat(3, 1fr);
                            gap: 15px;
                        }
                        
                        .meta-item {
                            text-align: center;
                        }
                        
                        .meta-label {
                            display: block;
                            font-size: 10px;
                            text-transform: uppercase;
                            letter-spacing: 0.3px;
                            opacity: 0.9;
                            margin-bottom: 4px;
                        }
                        
                        .meta-value {
                            font-size: 14px;
                            font-weight: 600;
                        }
                        
                        .total-amount {
                            font-size: 16px;
                            font-weight: 700;
                        }
                        
                        .status-badge {
                            display: inline-block;
                            padding: 3px 10px;
                            border-radius: 15px;
                            font-size: 10px;
                            font-weight: 600;
                            text-transform: uppercase;
                            letter-spacing: 0.3px;
                            background: rgba(255, 255, 255, 0.2);
                        }
                        
                        .status-pending { background: #fff3cd; color: #856404; }
                        .status-payment_submitted { background: #ffedd5; color: #9a3412; }
                        .status-payment_verification { background: #e0e7ff; color: #3730a3; }
                        .status-paid { background: #dbeafe; color: #1e40af; }
                        .status-processing { background: #f3e8ff; color: #6b21a8; }
                        .status-shipped { background: #d1fae5; color: #065f46; }
                        .status-ready_for_pickup { background: #cffafe; color: #155e75; }
                        .status-completed { background: #dcfce7; color: #166534; }
                        .status-cancelled { background: #fee2e2; color: #991b1b; }
                        .status-payment_failed { background: #fef3c7; color: #92400e; }
                        
                        /* Items Table - Compact */
                        .invoice-items {
                            margin-bottom: 25px;
                        }
                        
                        .invoice-items .section-header {
                            margin-bottom: 15px;
                        }
                        
                        .items-table {
                            width: 100%;
                            border-collapse: collapse;
                            font-size: 11px;
                            table-layout: fixed;
                        }
                        
                        .items-table thead {
                            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                            color: white;
                        }
                        
                        .items-table th {
                            padding: 10px 8px;
                            text-align: left;
                            font-weight: 600;
                            text-transform: uppercase;
                            letter-spacing: 0.3px;
                            font-size: 10px;
                            white-space: nowrap;
                            overflow: hidden;
                            text-overflow: ellipsis;
                        }
                        
                        .items-table td {
                            padding: 10px 8px;
                            border-bottom: 1px solid #eee;
                            vertical-align: top;
                        }
                        
                        .items-table tbody tr:hover {
                            background: #f8f9fa;
                        }
                        
                        .items-table .serial {
                            width: 30px;
                            text-align: center;
                            color: #666;
                            font-weight: 500;
                        }
                        
                        .items-table .description {
                            width: 45%;
                        }
                        
                        .item-title {
                            font-weight: 600;
                            color: #2c3e50;
                            margin-bottom: 2px;
                            font-size: 11px;
                            line-height: 1.3;
                        }
                        
                        .item-author {
                            color: #666;
                            font-size: 10px;
                            font-style: italic;
                            line-height: 1.2;
                        }
                        
                        .items-table .qty {
                            width: 40px;
                            text-align: center;
                        }
                        
                        .items-table .price,
                        .items-table .total {
                            width: 80px;
                            text-align: right;
                            font-family: 'SF Mono', 'Monaco', monospace;
                            font-weight: 500;
                        }
                        
                        /* Invoice Totals - Compact */
                        .invoice-totals {
                            margin-bottom: 20px;
                        }
                        
                        .totals-grid {
                            display: grid;
                            grid-template-columns: 1fr 250px;
                        }
                        
                        .totals-section {
                            background: #f8f9fa;
                            border-radius: 6px;
                            padding: 15px;
                        }
                        
                        .total-row {
                            display: flex;
                            justify-content: space-between;
                            margin-bottom: 10px;
                            font-size: 12px;
                        }
                        
                        .total-row .label {
                            color: #666;
                        }
                        
                        .total-row .value {
                            color: #333;
                            font-weight: 500;
                        }
                        
                        .grand-total {
                            border-top: 2px solid #ddd;
                            padding-top: 10px;
                            margin-top: 10px;
                            font-size: 14px;
                            font-weight: 700;
                        }
                        
                        .grand-total .label {
                            color: #2c3e50;
                        }
                        
                        .grand-total .value {
                            color: #667eea;
                            font-size: 16px;
                        }
                        
                        /* Invoice Footer - Compact */
                        .invoice-footer {
                            padding-top: 20px;
                            border-top: 1px solid #eee;
                            display: flex;
                            justify-content: space-between;
                            align-items: flex-end;
                            font-size: 10px;
                        }
                        
                        .thank-you p {
                            font-size: 14px;
                            color: #2c3e50;
                            font-weight: 600;
                            margin-bottom: 3px;
                        }
                        
                        .thank-you small {
                            color: #888;
                            font-size: 9px;
                        }
                        
                        .print-info {
                            text-align: right;
                            color: #888;
                        }
                        
                        /* Watermark - Subtle */
                        .watermark {
                            position: fixed;
                            top: 50%;
                            left: 50%;
                            transform: translate(-50%, -50%) rotate(-45deg);
                            font-size: 40px;
                            color: rgba(0, 0, 0, 0.03);
                            font-weight: 800;
                            pointer-events: none;
                            z-index: -1;
                            white-space: nowrap;
                        }
                        
                        /* Print Optimizations */
                        @media print {
                            body {
                                padding: 10px !important;
                                font-size: 11px !important;
                            }
                            
                            .invoice {
                                max-width: 100% !important;
                                margin: 0 !important;
                            }
                            
                            /* Ensure backgrounds print */
                            * {
                                -webkit-print-color-adjust: exact !important;
                                print-color-adjust: exact !important;
                            }
                            
                            /* Reduce margins for better fit */
                            .invoice-header {
                                margin-bottom: 15px !important;
                                padding-bottom: 10px !important;
                            }
                            
                            .invoice-details {
                                margin-bottom: 15px !important;
                            }
                            
                            .order-meta-section {
                                margin-bottom: 15px !important;
                                padding: 12px !important;
                            }
                            
                            .invoice-items {
                                margin-bottom: 20px !important;
                            }
                            
                            .items-table th,
                            .items-table td {
                                padding: 8px 6px !important;
                            }
                            
                            .items-table {
                                font-size: 10px !important;
                            }
                            
                            .item-title {
                                font-size: 10px !important;
                            }
                            
                            .item-author {
                                font-size: 9px !important;
                            }
                            
                            .invoice-totals {
                                margin-bottom: 15px !important;
                            }
                            
                            .totals-section {
                                padding: 12px !important;
                            }
                            
                            .total-row {
                                margin-bottom: 8px !important;
                                font-size: 11px !important;
                            }
                            
                            .grand-total {
                                font-size: 13px !important;
                            }
                            
                            .grand-total .value {
                                font-size: 14px !important;
                            }
                            
                            .invoice-footer {
                                padding-top: 15px !important;
                                font-size: 9px !important;
                            }
                            
                            .thank-you p {
                                font-size: 12px !important;
                            }
                            
                            .thank-you small {
                                font-size: 8px !important;
                            }
                            
                            /* Hide watermark on print if needed */
                            .watermark {
                                opacity: 0.05;
                                font-size: 30px !important;
                            }
                            
                            /* Prevent page breaks inside important sections */
                            .details-grid,
                            .order-meta-section,
                            .invoice-items,
                            .invoice-totals {
                                page-break-inside: avoid;
                            }
                            
                            @page {
                                margin: 10mm;
                                size: A4 portrait;
                            }
                        }
                    </style>
                </head>
                <body>
                    ${content}
                </body>
                </html>
            `);

            printWindow.document.close();

            setTimeout(() => {
                printWindow.focus();
                printWindow.print();

                printWindow.onafterprint = () => {
                    printWindow.close();
                    printContent.value = false;
                };
            }, 500);
        }, 300);
    });
};

const printAllOrders = () => {
    printType.value = "all";
    printContent.value = true;

    nextTick(() => {
        setTimeout(() => {
            const printWindow = window.open("", "_blank");
            if (!printWindow) {
                alert("Please allow popups for printing");
                printContent.value = false;
                return;
            }

            const content = printableContent.value.innerHTML;

            printWindow.document.write(`
                <!DOCTYPE html>
                <html>
                <head>
                    <title>Order History Report - BookStore</title>
                    <meta charset="UTF-8">
                    <style>
                         @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&display=swap');
                        
                        * {
                            margin: 0;
                            padding: 0;
                            box-sizing: border-box;
                        }
                        
                        body {
                            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
                            padding: 20px;
                            color: #333;
                            background: white;
                            line-height: 1.4;
                            font-size: 11px;
                        }
                        
                        .report {
                            max-width: 800px;
                            margin: 0 auto;
                            position: relative;
                        }
                        
                        /* Report Header - Compact */
                        .report-header {
                            display: flex;
                            justify-content: space-between;
                            align-items: flex-start;
                            margin-bottom: 30px;
                            padding-bottom: 15px;
                            border-bottom: 2px solid #2c3e50;
                        }
                        
                        .company-info {
                            display: flex;
                            align-items: center;
                            gap: 15px;
                        }
                        
                        .logo-circle {
                            width: 60px;
                            height: 60px;
                            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                            border-radius: 50%;
                            display: flex;
                            align-items: center;
                            justify-content: center;
                            font-size: 30px;
                            color: white;
                        }
                        
                        .company-info h1 {
                            font-size: 22px;
                            font-weight: 700;
                            color: #2c3e50;
                        }
                        
                        .company-details {
                            color: #666;
                            font-size: 12px;
                            margin-top: 2px;
                        }
                        
                        .report-title h2 {
                            font-size: 20px;
                            color: #2c3e50;
                            margin-bottom: 4px;
                            font-weight: 700;
                        }
                        
                        .report-date {
                            color: #666;
                            font-size: 11px;
                            text-align: right;
                        }
                        
                        /* Summary Stats - Compact */
                        .report-summary {
                            margin-bottom: 30px;
                        }
                        
                        .stats-grid {
                            display: grid;
                            grid-template-columns: repeat(4, 1fr);
                            gap: 12px;
                        }
                        
                        .stat-card {
                            background: white;
                            border: 1px solid #e9ecef;
                            border-radius: 8px;
                            padding: 15px;
                            text-align: center;
                        }
                        
                        .stat-number {
                            font-size: 20px;
                            font-weight: 700;
                            color: #2c3e50;
                            margin-bottom: 4px;
                        }
                        
                        .stat-label {
                            font-size: 10px;
                            color: #666;
                            text-transform: uppercase;
                            letter-spacing: 0.5px;
                        }
                        
                        /* Orders List - Compact */
                        .orders-section h3 {
                            font-size: 14px;
                            color: #2c3e50;
                            margin-bottom: 15px;
                            font-weight: 600;
                            text-transform: uppercase;
                            letter-spacing: 0.5px;
                        }
                        
                        .order-card {
                            background: white;
                            border: 1px solid #e9ecef;
                            border-radius: 6px;
                            padding: 16px;
                            margin-bottom: 20px;
                            page-break-inside: avoid;
                        }
                        
                        .order-header {
                            display: flex;
                            justify-content: space-between;
                            align-items: center;
                            margin-bottom: 12px;
                        }
                        
                        .order-meta {
                            display: flex;
                            align-items: center;
                            gap: 8px;
                        }
                        
                        .order-number {
                            font-size: 14px;
                            font-weight: 600;
                            color: #2c3e50;
                        }
                        
                        .status {
                            padding: 3px 8px;
                            border-radius: 12px;
                            font-size: 9px;
                            font-weight: 600;
                            text-transform: uppercase;
                            letter-spacing: 0.3px;
                        }
                        
                        .status-pending { background: #fff3cd; color: #856404; }
                        .status-payment_submitted { background: #ffedd5; color: #9a3412; }
                        .status-payment_verification { background: #e0e7ff; color: #3730a3; }
                        .status-paid { background: #dbeafe; color: #1e40af; }
                        .status-processing { background: #f3e8ff; color: #6b21a8; }
                        .status-shipped { background: #d1fae5; color: #065f46; }
                        .status-ready_for_pickup { background: #cffafe; color: #155e75; }
                        .status-completed { background: #dcfce7; color: #166534; }
                        .status-cancelled { background: #fee2e2; color: #991b1b; }
                        .status-payment_failed { background: #fef3c7; color: #92400e; }
                        
                        .order-details {
                            display: flex;
                            flex-direction: column;
                            align-items: flex-end;
                            gap: 2px;
                        }
                        
                        .order-details .date {
                            color: #666;
                            font-size: 10px;
                        }
                        
                        .order-details .total {
                            font-size: 14px;
                            font-weight: 600;
                            color: #10b981;
                        }
                        
                        .order-items {
                            width: 100%;
                            border-collapse: collapse;
                            margin-bottom: 12px;
                            font-size: 10px;
                        }
                        
                        .order-items th {
                            padding: 8px;
                            text-align: left;
                            background: #f8f9fa;
                            color: #666;
                            font-size: 9px;
                            text-transform: uppercase;
                            letter-spacing: 0.3px;
                        }
                        
                        .order-items td {
                            padding: 8px;
                            border-bottom: 1px solid #eee;
                        }
                        
                        .order-items .item-title {
                            color: #2c3e50;
                            font-weight: 500;
                        }
                        
                        /* Order Meta Grid */
                        .order-meta-grid {
                            display: grid;
                            grid-template-columns: 1fr 1fr;
                            gap: 15px;
                            margin: 15px 0;
                            padding: 12px;
                            background: #f8f9fa;
                            border-radius: 4px;
                            font-size: 10px;
                        }
                        
                        .meta-label {
                            font-weight: 600;
                            color: #4b5563;
                            margin-bottom: 2px;
                        }
                        
                        .meta-value {
                            color: #111827;
                        }
                        
                        /* Shipping Info Section */
                        .shipping-info-section {
                            margin: 15px 0;
                            padding: 12px;
                            background: #f0f9ff;
                            border-radius: 4px;
                            border: 1px solid #e0f2fe;
                            font-size: 10px;
                        }
                        
                        .section-title {
                            font-size: 11px;
                            font-weight: 600;
                            color: #0369a1;
                            margin-bottom: 8px;
                        }
                        
                        .shipping-details {
                            color: #374151;
                        }
                        
                        .shipping-line {
                            margin-bottom: 4px;
                            line-height: 1.3;
                        }
                        
                        .shipping-line .label {
                            font-weight: 600;
                            color: #4b5563;
                            margin-right: 4px;
                        }
                        
                        .order-footer {
                            display: flex;
                            justify-content: space-between;
                            align-items: center;
                            color: #666;
                            font-size: 9px;
                            padding-top: 8px;
                            border-top: 1px solid #eee;
                        }
                        
                        /* Report Footer */
                        .report-footer {
                            padding-top: 20px;
                            border-top: 1px solid #eee;
                            display: flex;
                            justify-content: space-between;
                            align-items: flex-end;
                        }
                        
                        .pagination-info,
                        .report-meta {
                            color: #666;
                            font-size: 9px;
                        }
                        
                        /* Watermark */
                        .watermark {
                            position: fixed;
                            top: 50%;
                            left: 50%;
                            transform: translate(-50%, -50%) rotate(-45deg);
                            font-size: 40px;
                            color: rgba(0, 0, 0, 0.03);
                            font-weight: 800;
                            pointer-events: none;
                            z-index: -1;
                        }
                        
                        /* Utility Classes */
                        .text-center { text-align: center; }
                        .text-right { text-align: right; }
                        
                        /* Print Optimizations */
                        @media print {
                            body {
                                padding: 10px !important;
                                font-size: 9px !important;
                            }
                            
                            .report {
                                max-width: 100% !important;
                            }
                            
                            * {
                                -webkit-print-color-adjust: exact !important;
                                print-color-adjust: exact !important;
                            }
                            
                            /* Page break control */
                            .order-card {
                                page-break-inside: avoid;
                                page-break-after: auto;
                            }
                            
                            /* Compact tables for print */
                            .order-items {
                                font-size: 8px !important;
                            }
                            
                            .order-items th,
                            .order-items td {
                                padding: 4px 6px !important;
                            }
                            @page {
                                margin: 10mm;
                                size: A4;
                            }
                        }
                    </style>
                </head>
                <body>
                    ${content}
                </body>
                </html>
            `);

            printWindow.document.close();

            setTimeout(() => {
                printWindow.focus();
                printWindow.print();

                printWindow.onafterprint = () => {
                    printWindow.close();
                    printContent.value = false;
                };
            }, 500);
        }, 300);
    });
};
</script>

<style scoped>
.line-clamp-1 {
    display: -webkit-box;
    -webkit-line-clamp: 1;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.transform {
    transform: scale(1);
}

@media print {
    .no-print {
        display: none !important;
    }
}

.hidden {
    display: none !important;
}

/* Print styles */
@media print {
    body {
        margin: 0 !important;
        padding: 0 !important;
    }

    .no-print {
        display: none !important;
    }

    .hidden {
        display: block !important;
    }
}

/* Keep your existing styles */
.animate-pulse {
    animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
}

@keyframes pulse {
    0%,
    100% {
        opacity: 1;
    }

    50% {
        opacity: 0.5;
    }
}
</style>
