<template>
    <AppLayout>
        <div
            class="min-h-screen bg-gradient-to-br from-gray-50 to-blue-50 py-4 sm:py-8"
        >
            <div class="max-w-7xl mx-auto px-3 sm:px-4 lg:px-8">
                <!-- Header Section -->
                <div class="mb-6 sm:mb-10">
                    <div
                        class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 sm:gap-6"
                    >
                        <div class="text-center md:text-left">
                            <div
                                class="flex items-center gap-3 justify-center md:justify-start mb-2"
                            >
                                <div
                                    class="p-2.5 bg-gradient-to-r from-blue-600 to-indigo-600 rounded-xl shadow-lg"
                                >
                                    <svg
                                        class="w-6 h-6 sm:w-7 sm:h-7 text-white"
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
                                <h1
                                    class="text-2xl sm:text-3xl lg:text-4xl font-extrabold text-gray-900 tracking-tight"
                                >
                                    Order History
                                </h1>
                            </div>
                            <p class="text-gray-600 text-sm sm:text-base">
                                Track and manage all your purchases in one place
                            </p>
                        </div>

                        <!-- Desktop Print Button -->
                        <div class="hidden md:block"></div>
                    </div>
                </div>

                <!-- Stats Overview Cards -->
                <div
                    class="grid grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4 mb-6 sm:mb-8"
                >
                    <div
                        class="bg-white p-4 sm:p-5 rounded-2xl border border-gray-200 shadow-lg"
                    >
                        <div class="flex items-center gap-3 mb-3">
                            <div class="p-2 bg-blue-100 rounded-lg">
                                <svg
                                    class="w-5 h-5 sm:w-6 sm:h-6 text-blue-600"
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
                            <span
                                class="text-sm sm:text-base font-medium text-gray-700"
                                >Total Orders</span
                            >
                        </div>
                        <div
                            class="text-2xl sm:text-3xl font-bold text-gray-900"
                        >
                            {{ orders.total || 0 }}
                        </div>
                    </div>

                    <div
                        class="bg-white p-4 sm:p-5 rounded-2xl border border-gray-200 shadow-lg"
                    >
                        <div class="flex items-center gap-3 mb-3">
                            <div class="p-2 bg-green-100 rounded-lg">
                                <svg
                                    class="w-5 h-5 sm:w-6 sm:h-6 text-green-600"
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
                            <span
                                class="text-sm sm:text-base font-medium text-gray-700"
                                >Total Spent</span
                            >
                        </div>
                        <div
                            class="text-2xl sm:text-3xl font-bold text-gray-900"
                        >
                            ৳{{ getTotalRevenue() }}
                        </div>
                    </div>

                    <div
                        class="bg-white p-4 sm:p-5 rounded-2xl border border-gray-200 shadow-lg"
                    >
                        <div class="flex items-center gap-3 mb-3">
                            <div class="p-2 bg-purple-100 rounded-lg">
                                <svg
                                    class="w-5 h-5 sm:w-6 sm:h-6 text-purple-600"
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
                            <span
                                class="text-sm sm:text-base font-medium text-gray-700"
                                >Completed</span
                            >
                        </div>
                        <div
                            class="text-2xl sm:text-3xl font-bold text-gray-900"
                        >
                            {{ getStatusCount("completed") }}
                        </div>
                    </div>

                    <div
                        class="bg-white p-4 sm:p-5 rounded-2xl border border-gray-200 shadow-lg"
                    >
                        <div class="flex items-center gap-3 mb-3">
                            <div class="p-2 bg-yellow-100 rounded-lg">
                                <svg
                                    class="w-5 h-5 sm:w-6 sm:h-6 text-yellow-600"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"
                                    />
                                </svg>
                            </div>
                            <span
                                class="text-sm sm:text-base font-medium text-gray-700"
                                >Pending</span
                            >
                        </div>
                        <div
                            class="text-2xl sm:text-3xl font-bold text-gray-900"
                        >
                            {{ getStatusCount("pending") }}
                        </div>
                    </div>
                </div>

                <!-- Controls Bar -->
                <div
                    class="bg-white rounded-2xl shadow-lg border border-gray-200 p-4 sm:p-6 mb-6 sm:mb-8"
                >
                    <div
                        class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 sm:gap-6"
                    >
                        <!-- Pagination Info -->
                        <div
                            class="flex flex-col sm:flex-row sm:items-center gap-3 sm:gap-6"
                        >
                            <div class="flex items-center gap-2">
                                <div class="p-2 bg-blue-100 rounded-lg">
                                    <svg
                                        class="w-5 h-5 text-blue-600"
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
                                <div class="text-sm font-medium text-gray-700">
                                    Showing
                                    <span class="font-bold text-gray-900">{{
                                        orders?.from || 0
                                    }}</span>
                                    -
                                    <span class="font-bold text-gray-900">{{
                                        orders?.to || 0
                                    }}</span>
                                    of
                                    <span class="font-bold text-gray-900">{{
                                        orders?.total || 0
                                    }}</span>
                                    orders
                                </div>
                            </div>
                        </div>

                        <!-- Mobile Print Button -->
                        <div class="md:hidden">
                            <button
                                @click="printAllOrders"
                                class="w-full flex items-center justify-center gap-2 px-4 py-2.5 bg-gradient-to-r from-white to-gray-50 border-2 border-gray-200 text-gray-800 rounded-xl hover:border-blue-500 hover:bg-blue-50 hover:text-blue-700 transition-all duration-300 font-medium shadow-sm"
                            >
                                <svg
                                    class="w-4 h-4"
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

                        <!-- Items Per Page Selector -->
                        <div class="flex items-center gap-3">
                            <label
                                for="perPage"
                                class="text-sm font-medium text-gray-700 whitespace-nowrap"
                            >
                                Show:
                            </label>
                            <div class="relative">
                                <select
                                    id="perPage"
                                    v-model="perPageInput"
                                    @change="updatePerPage"
                                    class="w-28 sm:w-36 appearance-none bg-white border-2 border-gray-300 rounded-xl px-4 py-2.5 pr-10 text-sm font-medium focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 cursor-pointer hover:border-blue-400 transition-all duration-200 shadow-sm"
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
                                    class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-gray-500"
                                >
                                    <svg
                                        class="w-4 h-4"
                                        fill="none"
                                        stroke="currentColor"
                                        viewBox="0 0 24 24"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M19 9l-7 7-7-7"
                                        />
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- No Orders State -->
                <div
                    v-if="orders.data.length === 0"
                    class="bg-white rounded-3xl shadow-xl border border-gray-200 p-8 sm:p-12 text-center"
                >
                    <div class="max-w-md mx-auto">
                        <div class="w-24 h-24 mx-auto mb-6 text-gray-300">
                            <svg
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="1.5"
                                    d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"
                                />
                            </svg>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900 mb-3">
                            No Orders Yet
                        </h3>
                        <p class="text-gray-600 mb-8">
                            Start shopping to see your orders here. Your order
                            history will appear once you make a purchase.
                        </p>
                        <Link
                            :href="route('shop.home')"
                            class="inline-flex items-center gap-3 px-6 py-3.5 bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-semibold rounded-xl hover:from-blue-700 hover:to-indigo-700 shadow-lg hover:shadow-xl transition-all duration-300"
                        >
                            <svg
                                class="w-5 h-5"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"
                                />
                            </svg>
                            Start Shopping
                        </Link>
                    </div>
                </div>

                <!-- Orders List -->
                <div v-else class="space-y-4 sm:space-y-6">
                    <!-- Order Cards -->
                    <div
                        v-for="order in orders.data"
                        :key="order.id"
                        class="group bg-white rounded-2xl border-2 border-gray-200 hover:border-blue-500 hover:shadow-xl transition-all duration-300 overflow-hidden"
                    >
                        <div class="p-4 sm:p-6">
                            <!-- Order Header -->
                            <div
                                class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-4"
                            >
                                <div class="flex items-center gap-3">
                                    <div
                                        class="flex flex-col sm:flex-row sm:items-center gap-2 sm:gap-4"
                                    >
                                        <span
                                            class="text-lg sm:text-xl font-bold text-gray-900"
                                        >
                                            #{{ order.order_number }}
                                        </span>

                                        <!-- Pending Status -->
                                        <span
                                            v-if="order.status === 'pending'"
                                            class="inline-flex items-center gap-2 px-4 py-2 rounded-xl text-sm font-semibold transition-all duration-300 group relative"
                                            :class="
                                                statusClasses.pending.container
                                            "
                                        >
                                            <div
                                                :class="
                                                    statusClasses.pending.iconBg
                                                "
                                                class="p-1.5 rounded-lg group-hover:scale-110 transition-transform"
                                            >
                                                <svg
                                                    class="w-4 h-4"
                                                    :class="
                                                        statusClasses.pending
                                                            .icon
                                                    "
                                                    fill="none"
                                                    stroke="currentColor"
                                                    viewBox="0 0 24 24"
                                                >
                                                    <path
                                                        stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"
                                                    />
                                                </svg>
                                            </div>
                                            <span
                                                :class="
                                                    statusClasses.pending.text
                                                "
                                                >Awaiting Payment</span
                                            >
                                            <div
                                                class="absolute inset-0 bg-gradient-to-r opacity-0 group-hover:opacity-10 transition-opacity"
                                                :class="
                                                    statusClasses.pending
                                                        .gradient
                                                "
                                            ></div>
                                        </span>

                                        <!-- Payment Submitted Status -->
                                        <span
                                            v-else-if="
                                                order.status ===
                                                'payment_submitted'
                                            "
                                            class="inline-flex items-center gap-2 px-4 py-2 rounded-xl text-sm font-semibold transition-all duration-300 group relative"
                                            :class="
                                                statusClasses.payment_submitted
                                                    .container
                                            "
                                        >
                                            <div
                                                :class="
                                                    statusClasses
                                                        .payment_submitted
                                                        .iconBg
                                                "
                                                class="p-1.5 rounded-lg group-hover:translate-y-1 transition-transform"
                                            >
                                                <svg
                                                    class="w-4 h-4"
                                                    :class="
                                                        statusClasses
                                                            .payment_submitted
                                                            .icon
                                                    "
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
                                            <span
                                                :class="
                                                    statusClasses
                                                        .payment_submitted.text
                                                "
                                                >Payment Submitted</span
                                            >
                                            <div
                                                class="absolute inset-0 bg-gradient-to-r opacity-0 group-hover:opacity-10 transition-opacity"
                                                :class="
                                                    statusClasses
                                                        .payment_submitted
                                                        .gradient
                                                "
                                            ></div>
                                        </span>

                                        <!-- Payment Verification Status -->
                                        <span
                                            v-else-if="
                                                order.status ===
                                                'payment_verification'
                                            "
                                            class="inline-flex items-center gap-2 px-4 py-2 rounded-xl text-sm font-semibold transition-all duration-300 group relative"
                                            :class="
                                                statusClasses
                                                    .payment_verification
                                                    .container
                                            "
                                        >
                                            <div
                                                :class="
                                                    statusClasses
                                                        .payment_verification
                                                        .iconBg
                                                "
                                                class="p-1.5 rounded-lg group-hover:rotate-45 transition-transform"
                                            >
                                                <svg
                                                    class="w-4 h-4"
                                                    :class="
                                                        statusClasses
                                                            .payment_verification
                                                            .icon
                                                    "
                                                    fill="none"
                                                    stroke="currentColor"
                                                    viewBox="0 0 24 24"
                                                >
                                                    <path
                                                        stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"
                                                    />
                                                </svg>
                                            </div>
                                            <span
                                                :class="
                                                    statusClasses
                                                        .payment_verification
                                                        .text
                                                "
                                                >Verifying Payment</span
                                            >
                                            <div
                                                class="absolute inset-0 bg-gradient-to-r opacity-0 group-hover:opacity-10 transition-opacity"
                                                :class="
                                                    statusClasses
                                                        .payment_verification
                                                        .gradient
                                                "
                                            ></div>
                                        </span>

                                        <!-- Paid Status -->
                                        <span
                                            v-else-if="order.status === 'paid'"
                                            class="inline-flex items-center gap-2 px-4 py-2 rounded-xl text-sm font-semibold transition-all duration-300 group relative"
                                            :class="
                                                statusClasses.paid.container
                                            "
                                        >
                                            <div
                                                :class="
                                                    statusClasses.paid.iconBg
                                                "
                                                class="p-1.5 rounded-lg group-hover:scale-110 transition-transform"
                                            >
                                                <svg
                                                    class="w-4 h-4"
                                                    :class="
                                                        statusClasses.paid.icon
                                                    "
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
                                            <span
                                                :class="statusClasses.paid.text"
                                                >Paid</span
                                            >
                                            <div
                                                class="absolute inset-0 bg-gradient-to-r opacity-0 group-hover:opacity-10 transition-opacity"
                                                :class="
                                                    statusClasses.paid.gradient
                                                "
                                            ></div>
                                        </span>

                                        <!-- Processing Status -->
                                        <span
                                            v-else-if="
                                                order.status === 'processing'
                                            "
                                            class="inline-flex items-center gap-2 px-4 py-2 rounded-xl text-sm font-semibold transition-all duration-300 group relative"
                                            :class="
                                                statusClasses.processing
                                                    .container
                                            "
                                        >
                                            <div
                                                :class="
                                                    statusClasses.processing
                                                        .iconBg
                                                "
                                                class="p-1.5 rounded-lg group-hover:rotate-90 transition-transform"
                                            >
                                                <svg
                                                    class="w-4 h-4"
                                                    :class="
                                                        statusClasses.processing
                                                            .icon
                                                    "
                                                    fill="none"
                                                    stroke="currentColor"
                                                    viewBox="0 0 24 24"
                                                >
                                                    <path
                                                        stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"
                                                    />
                                                </svg>
                                            </div>
                                            <span
                                                :class="
                                                    statusClasses.processing
                                                        .text
                                                "
                                                >Processing</span
                                            >
                                            <div
                                                class="absolute inset-0 bg-gradient-to-r opacity-0 group-hover:opacity-10 transition-opacity"
                                                :class="
                                                    statusClasses.processing
                                                        .gradient
                                                "
                                            ></div>
                                        </span>

                                        <!-- Shipped Status -->
                                        <span
                                            v-else-if="
                                                order.status === 'shipped'
                                            "
                                            class="inline-flex items-center gap-2 px-4 py-2 rounded-xl text-sm font-semibold transition-all duration-300 group relative"
                                            :class="
                                                statusClasses.shipped.container
                                            "
                                        >
                                            <div
                                                :class="
                                                    statusClasses.shipped.iconBg
                                                "
                                                class="p-1.5 rounded-lg group-hover:translate-x-1 transition-transform"
                                            >
                                                <svg
                                                    class="w-4 h-4"
                                                    :class="
                                                        statusClasses.shipped
                                                            .icon
                                                    "
                                                    fill="none"
                                                    stroke="currentColor"
                                                    viewBox="0 0 24 24"
                                                >
                                                    <path
                                                        stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"
                                                    />
                                                </svg>
                                            </div>
                                            <span
                                                :class="
                                                    statusClasses.shipped.text
                                                "
                                                >Shipped</span
                                            >
                                            <div
                                                class="absolute inset-0 bg-gradient-to-r opacity-0 group-hover:opacity-10 transition-opacity"
                                                :class="
                                                    statusClasses.shipped
                                                        .gradient
                                                "
                                            ></div>
                                        </span>

                                        <!-- Ready for Pickup Status -->
                                        <span
                                            v-else-if="
                                                order.status ===
                                                'ready_for_pickup'
                                            "
                                            class="inline-flex items-center gap-2 px-4 py-2 rounded-xl text-sm font-semibold transition-all duration-300 group relative"
                                            :class="
                                                statusClasses.ready_for_pickup
                                                    .container
                                            "
                                        >
                                            <div
                                                :class="
                                                    statusClasses
                                                        .ready_for_pickup.iconBg
                                                "
                                                class="p-1.5 rounded-lg group-hover:scale-110 transition-transform"
                                            >
                                                <svg
                                                    class="w-4 h-4"
                                                    :class="
                                                        statusClasses
                                                            .ready_for_pickup
                                                            .icon
                                                    "
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
                                            <span
                                                :class="
                                                    statusClasses
                                                        .ready_for_pickup.text
                                                "
                                                >Ready for Pickup</span
                                            >
                                            <div
                                                class="absolute inset-0 bg-gradient-to-r opacity-0 group-hover:opacity-10 transition-opacity"
                                                :class="
                                                    statusClasses
                                                        .ready_for_pickup
                                                        .gradient
                                                "
                                            ></div>
                                        </span>

                                        <!-- Completed Status -->
                                        <span
                                            v-else-if="
                                                order.status === 'completed'
                                            "
                                            class="inline-flex items-center gap-2 px-4 py-2 rounded-xl text-sm font-semibold transition-all duration-300 group relative"
                                            :class="
                                                statusClasses.completed
                                                    .container
                                            "
                                        >
                                            <div
                                                :class="
                                                    statusClasses.completed
                                                        .iconBg
                                                "
                                                class="p-1.5 rounded-lg group-hover:scale-110 transition-transform"
                                            >
                                                <svg
                                                    class="w-4 h-4"
                                                    :class="
                                                        statusClasses.completed
                                                            .icon
                                                    "
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
                                            <span
                                                :class="
                                                    statusClasses.completed.text
                                                "
                                                >Completed</span
                                            >
                                            <div
                                                class="absolute inset-0 bg-gradient-to-red opacity-0 group-hover:opacity-10 transition-opacity"
                                                :class="
                                                    statusClasses.completed
                                                        .gradient
                                                "
                                            ></div>
                                        </span>

                                        <!-- Cancelled Status -->
                                        <span
                                            v-else-if="
                                                order.status === 'cancelled'
                                            "
                                            class="inline-flex items-center gap-2 px-4 py-2 rounded-xl text-sm font-semibold transition-all duration-300 group relative"
                                            :class="
                                                statusClasses.cancelled
                                                    .container
                                            "
                                        >
                                            <div
                                                :class="
                                                    statusClasses.cancelled
                                                        .iconBg
                                                "
                                                class="p-1.5 rounded-lg group-hover:rotate-45 transition-transform"
                                            >
                                                <svg
                                                    class="w-4 h-4"
                                                    :class="
                                                        statusClasses.cancelled
                                                            .icon
                                                    "
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
                                            </div>
                                            <span
                                                :class="
                                                    statusClasses.cancelled.text
                                                "
                                                >Cancelled</span
                                            >
                                            <div
                                                class="absolute inset-0 bg-gradient-to-r opacity-0 group-hover:opacity-10 transition-opacity"
                                                :class="
                                                    statusClasses.cancelled
                                                        .gradient
                                                "
                                            ></div>
                                        </span>

                                        <!-- Payment Failed Status -->
                                        <span
                                            v-else-if="
                                                order.status ===
                                                'payment_failed'
                                            "
                                            class="inline-flex items-center gap-2 px-4 py-2 rounded-xl text-sm font-semibold transition-all duration-300 group relative"
                                            :class="
                                                statusClasses.payment_failed
                                                    .container
                                            "
                                        >
                                            <div
                                                :class="
                                                    statusClasses.payment_failed
                                                        .iconBg
                                                "
                                                class="p-1.5 rounded-lg group-hover:scale-110 transition-transform"
                                            >
                                                <svg
                                                    class="w-4 h-4"
                                                    :class="
                                                        statusClasses
                                                            .payment_failed.icon
                                                    "
                                                    fill="none"
                                                    stroke="currentColor"
                                                    viewBox="0 0 24 24"
                                                >
                                                    <path
                                                        stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"
                                                    />
                                                </svg>
                                            </div>
                                            <span
                                                :class="
                                                    statusClasses.payment_failed
                                                        .text
                                                "
                                                >Payment Failed</span
                                            >
                                            <div
                                                class="absolute inset-0 bg-gradient-to-r opacity-0 group-hover:opacity-10 transition-opacity"
                                                :class="
                                                    statusClasses.payment_failed
                                                        .gradient
                                                "
                                            ></div>
                                        </span>
                                        <!-- Cash on Delivery (COD) Status -->
                                        <span
                                            v-else-if="
                                                order.status === 'COD' ||
                                                order.status === 'cod'
                                            "
                                            class="inline-flex items-center gap-2 px-4 py-2 rounded-xl text-sm font-semibold transition-all duration-300 group relative"
                                            :class="statusClasses.cod.container"
                                        >
                                            <div
                                                :class="
                                                    statusClasses.cod.iconBg
                                                "
                                                class="p-1.5 rounded-lg group-hover:scale-110 transition-transform"
                                            >
                                                <svg
                                                    class="w-4 h-4"
                                                    :class="
                                                        statusClasses.cod.icon
                                                    "
                                                    fill="none"
                                                    stroke="currentColor"
                                                    viewBox="0 0 24 24"
                                                >
                                                    <path
                                                        stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"
                                                    />
                                                </svg>
                                            </div>
                                            <span
                                                :class="statusClasses.cod.text"
                                                >Cash on Delivery</span
                                            >
                                            <div
                                                class="absolute inset-0 bg-gradient-to-r opacity-0 group-hover:opacity-10 transition-opacity"
                                                :class="
                                                    statusClasses.cod.gradient
                                                "
                                            ></div>
                                        </span>
                                    </div>
                                </div>

                                <!-- Price on the right side -->
                                <div class="flex items-center gap-2">
                                    <span
                                        class="text-lg sm:text-xl font-bold text-green-600"
                                    >
                                        ৳{{ order.total_amount }}
                                    </span>
                                </div>
                            </div>

                            <!-- Order Info -->
                            <div
                                class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 mb-4"
                            >
                                <div class="flex items-center gap-3">
                                    <div class="p-2 bg-blue-50 rounded-lg">
                                        <svg
                                            class="w-4 h-4 sm:w-5 sm:h-5 text-blue-600"
                                            fill="none"
                                            stroke="currentColor"
                                            viewBox="0 0 24 24"
                                        >
                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                stroke-width="2"
                                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"
                                            />
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-xs text-gray-500">
                                            Order Date
                                        </p>
                                        <p
                                            class="text-sm font-medium text-gray-900"
                                        >
                                            {{ formatDate(order.created_at) }}
                                        </p>
                                    </div>
                                </div>

                                <div class="flex items-center gap-3">
                                    <div class="p-2 bg-purple-50 rounded-lg">
                                        <svg
                                            class="w-4 h-4 sm:w-5 sm:h-5 text-purple-600"
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
                                    </div>
                                    <div>
                                        <p class="text-xs text-gray-500">
                                            Customer
                                        </p>
                                        <p
                                            class="text-sm font-medium text-gray-900"
                                        >
                                            {{ order.user.name }}
                                        </p>
                                    </div>
                                </div>

                                <div class="flex items-center gap-3">
                                    <div class="p-2 bg-green-50 rounded-lg">
                                        <svg
                                            class="w-4 h-4 sm:w-5 sm:h-5 text-green-600"
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
                                    <div>
                                        <p class="text-xs text-gray-500">
                                            Items
                                        </p>
                                        <p
                                            class="text-sm font-medium text-gray-900"
                                        >
                                            {{
                                                getItemCountText(
                                                    order.order_items.length
                                                )
                                            }}
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <!-- Action Buttons -->
                            <div
                                class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 pt-4 border-t border-gray-100"
                            >
                                <div class="text-sm text-gray-600">
                                    Last updated:
                                    {{ formatDate(order.updated_at) }}
                                </div>
                                <div class="flex items-center gap-3">
                                    <button
                                        @click="printSingleOrder(order)"
                                        class="group/print inline-flex items-center gap-2 px-4 py-2.5 bg-gradient-to-r from-gray-50 to-white border-2 border-gray-300 text-gray-800 rounded-xl hover:border-blue-500 hover:bg-blue-50 hover:text-blue-700 transition-all duration-300 font-medium"
                                    >
                                        <svg
                                            class="w-4 h-4 group-hover/print:scale-110 transition-transform"
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
                                        <span class="hidden sm:inline"
                                            >Print</span
                                        >
                                    </button>
                                    <button
                                        @click="viewOrder(order)"
                                        class="inline-flex items-center gap-3 px-5 py-2.5 bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-xl hover:from-blue-700 hover:to-indigo-700 shadow-lg hover:shadow-xl transition-all duration-300 font-semibold"
                                    >
                                        View Details
                                        <svg
                                            class="w-4 h-4"
                                            fill="none"
                                            stroke="currentColor"
                                            viewBox="0 0 24 24"
                                        >
                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                stroke-width="2"
                                                d="M14 5l7 7m0 0l-7 7m7-7H3"
                                            />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Pagination -->
                    <div class="mt-8">
                        <Pagination :links="orders.links" />
                    </div>
                </div>
            </div>
        </div>

        <!-- Order Details Modal -->
        <div
            v-if="showOrderModal"
            class="fixed inset-0 z-50 overflow-y-auto"
            aria-labelledby="modal-title"
            role="dialog"
            aria-modal="true"
        >
            <!-- Overlay -->
            <div
                class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"
                @click="closeModal"
            ></div>

            <!-- Modal Container -->
            <div
                class="flex min-h-screen items-center justify-center p-3 sm:p-4"
            >
                <!-- Modal Content -->
                <div
                    class="relative bg-white rounded-3xl shadow-2xl w-full max-w-4xl max-h-[90vh] overflow-hidden transform transition-all"
                    @click.stop
                >
                    <!-- Modal Header -->
                    <div
                        class="sticky top-0 z-10 bg-gradient-to-r from-blue-600 to-indigo-600 px-4 sm:px-6 py-4 sm:py-5"
                    >
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-3 sm:gap-4">
                                <div
                                    class="p-2 bg-white bg-opacity-20 rounded-lg"
                                >
                                    <svg
                                        class="w-5 h-5 sm:w-6 sm:h-6 text-white"
                                        fill="none"
                                        stroke="currentColor"
                                        viewBox="0 0 24 24"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"
                                        />
                                    </svg>
                                </div>
                                <div>
                                    <h2
                                        class="text-lg sm:text-xl lg:text-2xl font-bold text-white"
                                    >
                                        Order #{{ selectedOrder?.order_number }}
                                    </h2>
                                    <p class="text-blue-100 text-xs sm:text-sm">
                                        {{
                                            formatDate(
                                                selectedOrder?.created_at
                                            )
                                        }}
                                    </p>
                                </div>
                            </div>
                            <div class="flex items-center gap-2 sm:gap-3">
                                <button
                                    v-if="selectedOrder"
                                    @click="printSingleOrder(selectedOrder)"
                                    class="inline-flex items-center gap-2 px-3 sm:px-4 py-2 bg-white bg-opacity-20 text-white rounded-xl hover:bg-opacity-30 transition-all duration-200 font-medium"
                                >
                                    <svg
                                        class="w-4 h-4"
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
                                    <span class="hidden sm:inline">Print</span>
                                </button>
                                <button
                                    @click="closeModal"
                                    class="p-2 text-white hover:bg-white hover:bg-opacity-20 rounded-xl transition-colors"
                                >
                                    <svg
                                        class="w-5 h-5 sm:w-6 sm:h-6"
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
                    </div>

                    <!-- Modal Body -->
                    <div
                        class="overflow-y-auto max-h-[calc(90vh-80px)] p-4 sm:p-6"
                    >
                        <div v-if="selectedOrder" class="space-y-6">
                            <!-- Order Status Bar -->
                            <div
                                class="bg-gradient-to-r from-gray-50 to-white rounded-2xl border-2 border-gray-200 p-4 sm:p-5"
                            >
                                <div
                                    class="flex items-center justify-between mb-4"
                                >
                                    <h3 class="font-bold text-gray-900 text-lg">
                                        Order Status
                                    </h3>
                                    <span
                                        :class="
                                            statusClasses[selectedOrder.status]
                                                .container
                                        "
                                        class="inline-flex items-center gap-3 px-5 py-2.5 rounded-xl font-semibold transition-all duration-300 group relative overflow-hidden"
                                    >
                                        <div
                                            :class="
                                                statusClasses[
                                                    selectedOrder.status
                                                ].iconBg
                                            "
                                            class="p-2 rounded-lg transition-transform group-hover:scale-110"
                                        >
                                            <svg
                                                class="w-5 h-5 text-white"
                                                fill="none"
                                                stroke="currentColor"
                                                viewBox="0 0 24 24"
                                            >
                                                <!-- Pending -->
                                                <path
                                                    v-if="
                                                        selectedOrder.status ===
                                                        'pending'
                                                    "
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    stroke-width="2"
                                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"
                                                />
                                                <!-- Payment Submitted -->
                                                <path
                                                    v-if="
                                                        selectedOrder.status ===
                                                        'payment_submitted'
                                                    "
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    stroke-width="2"
                                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"
                                                />
                                                <!-- Payment Verification -->
                                                <path
                                                    v-if="
                                                        selectedOrder.status ===
                                                        'payment_verification'
                                                    "
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    stroke-width="2"
                                                    d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"
                                                />
                                                <!-- Paid -->
                                                <path
                                                    v-if="
                                                        selectedOrder.status ===
                                                        'paid'
                                                    "
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    stroke-width="2"
                                                    d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"
                                                />
                                                <!-- Processing -->
                                                <path
                                                    v-if="
                                                        selectedOrder.status ===
                                                        'processing'
                                                    "
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    stroke-width="2"
                                                    d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"
                                                />
                                                <!-- Shipped -->
                                                <path
                                                    v-if="
                                                        selectedOrder.status ===
                                                        'shipped'
                                                    "
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    stroke-width="2"
                                                    d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"
                                                />
                                                <!-- Ready for Pickup -->
                                                <path
                                                    v-if="
                                                        selectedOrder.status ===
                                                        'ready_for_pickup'
                                                    "
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    stroke-width="2"
                                                    d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"
                                                />
                                                <!-- Completed -->
                                                <path
                                                    v-if="
                                                        selectedOrder.status ===
                                                        'completed'
                                                    "
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    stroke-width="2"
                                                    d="M5 13l4 4L19 7"
                                                />
                                                <!-- Cancelled -->
                                                <path
                                                    v-if="
                                                        selectedOrder.status ===
                                                        'cancelled'
                                                    "
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    stroke-width="2"
                                                    d="M6 18L18 6M6 6l12 12"
                                                />
                                                <!-- Payment Failed -->
                                                <path
                                                    v-if="
                                                        selectedOrder.status ===
                                                        'payment_failed'
                                                    "
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    stroke-width="2"
                                                    d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"
                                                />
                                            </svg>
                                        </div>
                                        <div class="flex flex-col">
                                            <span
                                                :class="
                                                    statusClasses[
                                                        selectedOrder.status
                                                    ].text
                                                "
                                                class="font-bold uppercase tracking-wide"
                                            >
                                                {{
                                                    selectedOrder.status.replace(
                                                        "_",
                                                        " "
                                                    )
                                                }}
                                            </span>
                                            <span class="text-xs opacity-75">
                                                {{
                                                    statusClasses[
                                                        selectedOrder.status
                                                    ].description
                                                }}
                                            </span>
                                        </div>
                                        <div
                                            class="absolute inset-0 bg-gradient-to-r opacity-0 group-hover:opacity-20 transition-opacity duration-300"
                                            :class="
                                                statusClasses[
                                                    selectedOrder.status
                                                ].gradient
                                            "
                                        ></div>
                                    </span>
                                </div>
                                <div class="flex items-center justify-between">
                                    <div class="text-center">
                                        <div
                                            class="w-10 h-10 mx-auto mb-2 rounded-full bg-green-100 flex items-center justify-center"
                                        >
                                            <svg
                                                class="w-5 h-5 text-green-600"
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
                                        <p class="text-xs text-gray-600">
                                            Order Placed
                                        </p>
                                    </div>
                                    <div
                                        class="flex-1 h-1 bg-gray-200 mx-2"
                                    ></div>
                                    <div class="text-center">
                                        <div
                                            class="w-10 h-10 mx-auto mb-2 rounded-full bg-blue-100 flex items-center justify-center"
                                        >
                                            <svg
                                                class="w-5 h-5 text-blue-600"
                                                fill="none"
                                                stroke="currentColor"
                                                viewBox="0 0 24 24"
                                            >
                                                <path
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    stroke-width="2"
                                                    d="M13 10V3L4 14h7v7l9-11h-7z"
                                                />
                                            </svg>
                                        </div>
                                        <p class="text-xs text-gray-600">
                                            Processing
                                        </p>
                                    </div>
                                    <div
                                        class="flex-1 h-1 bg-gray-200 mx-2"
                                    ></div>
                                    <div class="text-center">
                                        <div
                                            class="w-10 h-10 mx-auto mb-2 rounded-full bg-purple-100 flex items-center justify-center"
                                        >
                                            <svg
                                                class="w-5 h-5 text-purple-600"
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
                                        <p class="text-xs text-gray-600">
                                            Shipped
                                        </p>
                                    </div>
                                    <div
                                        class="flex-1 h-1 bg-gray-200 mx-2"
                                    ></div>
                                    <div class="text-center">
                                        <div
                                            class="w-10 h-10 mx-auto mb-2 rounded-full bg-indigo-100 flex items-center justify-center"
                                        >
                                            <svg
                                                class="w-5 h-5 text-indigo-600"
                                                fill="none"
                                                stroke="currentColor"
                                                viewBox="0 0 24 24"
                                            >
                                                <path
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    stroke-width="2"
                                                    d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"
                                                />
                                            </svg>
                                        </div>
                                        <p class="text-xs text-gray-600">
                                            Delivered
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <!-- Order Information Grid -->
                            <div
                                class="bg-gradient-to-br from-blue-50 to-indigo-50 rounded-2xl border border-blue-200 p-4 sm:p-5"
                            >
                                <h3
                                    class="font-bold text-gray-900 mb-3 flex items-center gap-2"
                                >
                                    <svg
                                        class="w-5 h-5 text-blue-600"
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
                                </h3>
                                <div class="space-y-2">
                                    <div class="flex justify-between">
                                        <span class="text-sm text-gray-600"
                                            >Name</span
                                        >
                                        <span
                                            class="font-medium text-gray-900"
                                            >{{ selectedOrder.user.name }}</span
                                        >
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-sm text-gray-600"
                                            >Email</span
                                        >
                                        <span
                                            class="font-medium text-gray-900"
                                            >{{
                                                selectedOrder.user.email
                                            }}</span
                                        >
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-sm text-gray-600"
                                            >Phone</span
                                        >
                                        <span class="font-medium text-gray-900">
                                            {{
                                                selectedOrder.shipping_address
                                                    ?.phone || "Not provided"
                                            }}
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <!-- Order Summary -->
                            <div
                                class="bg-gradient-to-br from-green-50 to-emerald-50 rounded-2xl border border-green-200 p-4 sm:p-5"
                            >
                                <h3
                                    class="font-bold text-gray-900 mb-3 flex items-center gap-2"
                                >
                                    <svg
                                        class="w-5 h-5 text-green-600"
                                        fill="none"
                                        stroke="currentColor"
                                        viewBox="0 0 24 24"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"
                                        />
                                    </svg>
                                    Shipping Information
                                </h3>
                                <div
                                    class="space-y-2"
                                    v-if="selectedOrder.shipping_address"
                                >
                                    <div class="flex justify-between">
                                        <span class="text-sm text-gray-600"
                                            >Full Name</span
                                        >
                                        <span
                                            class="font-medium text-gray-900 text-right"
                                        >
                                            {{
                                                selectedOrder.shipping_address
                                                    .full_name
                                            }}
                                        </span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-sm text-gray-600"
                                            >Address</span
                                        >
                                        <span
                                            class="font-medium text-gray-900 text-right"
                                        >
                                            {{
                                                selectedOrder.shipping_address
                                                    .address_line1
                                            }}
                                            <span
                                                v-if="
                                                    selectedOrder
                                                        .shipping_address
                                                        .address_line2
                                                "
                                            >
                                                ,
                                                {{
                                                    selectedOrder
                                                        .shipping_address
                                                        .address_line2
                                                }}
                                            </span>
                                        </span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-sm text-gray-600"
                                            >City/State/ZIP</span
                                        >
                                        <span
                                            class="font-medium text-gray-900 text-right"
                                        >
                                            {{
                                                selectedOrder.shipping_address
                                                    .city
                                            }},
                                            {{
                                                selectedOrder.shipping_address
                                                    .state
                                            }}
                                            {{
                                                selectedOrder.shipping_address
                                                    .zip_code
                                            }}
                                        </span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-sm text-gray-600"
                                            >Country</span
                                        >
                                        <span class="font-medium text-gray-900">
                                            {{
                                                selectedOrder.shipping_address
                                                    .country
                                            }}
                                        </span>
                                    </div>
                                </div>
                                <div
                                    v-else
                                    class="text-center py-4 text-gray-500"
                                >
                                    No shipping address provided
                                </div>
                            </div>

                            <!-- Order Items -->
                            <div
                                class="bg-white rounded-2xl border border-gray-200 overflow-hidden"
                            >
                                <div
                                    class="px-4 sm:px-6 py-4 bg-gradient-to-r from-gray-50 to-white border-b border-gray-200"
                                >
                                    <h3
                                        class="font-bold text-gray-900 flex items-center gap-2"
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
                                            />
                                        </svg>
                                        Order Items ({{
                                            getItemCountText(
                                                selectedOrder.order_items.length
                                            )
                                        }})
                                    </h3>
                                </div>
                                <div class="divide-y divide-gray-100">
                                    <div
                                        v-for="(
                                            item, index
                                        ) in selectedOrder.order_items"
                                        :key="item.id"
                                        class="p-4 sm:p-6 hover:bg-gray-50 transition-colors"
                                    >
                                        <div
                                            class="flex flex-col sm:flex-row sm:items-center justify-between gap-4"
                                        >
                                            <!-- Book Info -->
                                            <div
                                                class="flex items-start gap-3 sm:gap-4"
                                            >
                                                <img
                                                    :src="
                                                        item.book.image_url ||
                                                        '/images/book-placeholder.png'
                                                    "
                                                    :alt="item.book.title"
                                                    class="w-16 h-20 sm:w-20 sm:h-24 object-cover rounded-lg shadow-md"
                                                    @error="handleImageError"
                                                />
                                                <div class="flex-1">
                                                    <div
                                                        class="flex items-start justify-between"
                                                    >
                                                        <div>
                                                            <h4
                                                                class="font-bold text-gray-900 text-sm sm:text-base line-clamp-2"
                                                            >
                                                                {{
                                                                    item.book
                                                                        .title
                                                                }}
                                                            </h4>
                                                            <p
                                                                class="text-gray-600 text-xs sm:text-sm mt-1"
                                                            >
                                                                by
                                                                {{
                                                                    item.book
                                                                        .author
                                                                        ?.name ||
                                                                    "Unknown Author"
                                                                }}
                                                            </p>
                                                        </div>
                                                        <span
                                                            class="text-xs text-gray-500 ml-2"
                                                        >
                                                            #{{ index + 1 }}
                                                        </span>
                                                    </div>
                                                    <div
                                                        class="mt-2 sm:mt-3 flex flex-wrap items-center gap-2 sm:gap-3"
                                                    >
                                                        <span
                                                            class="text-xs text-gray-500"
                                                        >
                                                            ISBN:
                                                            {{
                                                                item.book
                                                                    .isbn ||
                                                                "N/A"
                                                            }}
                                                        </span>
                                                        <span
                                                            class="text-xs text-gray-500"
                                                        >
                                                            Category:
                                                            {{
                                                                item.book
                                                                    .category
                                                                    ?.name ||
                                                                "N/A"
                                                            }}
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Price & Quantity -->
                                            <div
                                                class="flex items-center justify-between sm:justify-end sm:w-48 gap-4"
                                            >
                                                <div class="text-center">
                                                    <p
                                                        class="text-sm text-gray-600"
                                                    >
                                                        Quantity
                                                    </p>
                                                    <p
                                                        class="font-bold text-gray-900 text-lg"
                                                    >
                                                        {{ item.quantity }}
                                                    </p>
                                                </div>
                                                <div class="text-center">
                                                    <p
                                                        class="text-sm text-gray-600"
                                                    >
                                                        Unit Price
                                                    </p>
                                                    <p
                                                        class="font-bold text-gray-900 text-lg"
                                                    >
                                                        ৳{{ item.price }}
                                                    </p>
                                                </div>
                                                <div class="text-center">
                                                    <p
                                                        class="text-sm text-gray-600"
                                                    >
                                                        Subtotal
                                                    </p>
                                                    <p
                                                        class="font-bold text-green-600 text-lg"
                                                    >
                                                        ৳{{
                                                            (
                                                                item.price *
                                                                item.quantity
                                                            ).toFixed(2)
                                                        }}
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Order Total -->
                                <div
                                    class="bg-gradient-to-r from-gray-50 to-white border-t border-gray-200 p-4 sm:p-6"
                                >
                                    <div
                                        class="flex justify-between items-center"
                                    >
                                        <div>
                                            <p class="text-gray-600">
                                                Total Items:
                                                {{
                                                    selectedOrder.order_items
                                                        .length
                                                }}
                                            </p>
                                            <p class="text-gray-600 text-sm">
                                                Order #{{
                                                    selectedOrder.order_number
                                                }}
                                            </p>
                                        </div>
                                        <div class="text-right">
                                            <p class="text-gray-600">
                                                Grand Total
                                            </p>
                                            <p
                                                class="text-2xl sm:text-3xl font-bold text-green-600"
                                            >
                                                ৳{{
                                                    selectedOrder.total_amount
                                                }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Modal Footer -->
                    <div
                        class="sticky bottom-0 bg-white border-t border-gray-200 px-4 sm:px-6 py-4"
                    >
                        <div
                            class="flex flex-col sm:flex-row sm:items-center justify-between gap-3"
                        >
                            <button
                                @click="closeModal"
                                class="order-2 sm:order-1 w-full sm:w-auto px-6 py-3 border-2 border-gray-300 text-gray-700 rounded-xl hover:bg-gray-50 transition-colors font-medium"
                            >
                                Close
                            </button>
                            <div
                                class="order-1 sm:order-2 flex items-center gap-2 text-sm text-gray-600"
                            >
                                <svg
                                    class="w-4 h-4"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"
                                    />
                                </svg>
                                Secure Order • Last updated:
                                {{ formatDate(selectedOrder?.updated_at) }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Printable Content -->
        <div v-if="printContent" ref="printableContent" class="hidden">
            <!-- Single Order Invoice -->
            <div v-if="printType === 'single' && printOrder" class="invoice">
                <!-- Header with Logo -->
                <div
                    class="invoice-header"
                    style="
                        display: flex;
                        justify-content: space-between;
                        align-items: center;
                        margin-bottom: 30px;
                        padding-bottom: 15px;
                        border-bottom: 2px solid #1e40af;
                    "
                >
                    <div
                        class="company-info"
                        style="display: flex; align-items: center; gap: 15px"
                    >
                        <!-- Logo -->
                        <div
                            style="
                                background: white;
                                padding: 10px;
                                border-radius: 50%;
                                display: inline-flex;
                                justify-content: center;
                                align-items: center;
                                width: 90px;
                                height: 90px;
                                box-shadow: 0 2px 6px rgba(0, 0, 0, 0.15);
                            "
                        >
                            <img
                                src="/images/logo.png"
                                alt="PUSTOK Logo"
                                style="
                                    width: 78px;
                                    height: 78px;
                                    object-fit: cover;
                                    border-radius: 50%;
                                "
                            />
                        </div>

                        <!-- Company Details -->
                        <div>
                            <h1
                                style="
                                    margin: 0;
                                    color: #1e40af;
                                    font-size: 24px;
                                    font-weight: 700;
                                "
                            >
                                PUSTOK.com
                            </h1>
                            <p
                                style="
                                    margin: 4px 0 0 0;
                                    color: #6b7280;
                                    font-size: 12px;
                                "
                            >
                                123 Book Street, Zindabazar, Sylhet
                            </p>
                            <p
                                style="
                                    margin: 2px 0 0 0;
                                    color: #6b7280;
                                    font-size: 12px;
                                "
                            >
                                Email: shoyondeb18246@gmail.com
                            </p>
                        </div>
                    </div>

                    <!-- Invoice Details -->
                    <div class="invoice-title" style="text-align: right">
                        <h2
                            style="
                                margin: 0;
                                color: #111827;
                                font-size: 20px;
                                font-weight: 700;
                            "
                        >
                            INVOICE
                        </h2>
                        <div
                            style="
                                margin-top: 8px;
                                font-size: 18px;
                                font-weight: 600;
                                color: #1e40af;
                            "
                        >
                            INV-{{ printOrder.order_number }}
                        </div>
                        <div
                            style="
                                margin-top: 4px;
                                font-size: 13px;
                                color: #6b7280;
                            "
                        >
                            Date: {{ formatDate(printOrder.created_at) }}
                        </div>
                    </div>
                </div>

                <!-- Customer & Order Info -->
                <div class="invoice-details" style="margin-bottom: 30px">
                    <div
                        class="details-grid"
                        style="
                            display: grid;
                            grid-template-columns: repeat(2, 1fr);
                            gap: 20px;
                            margin-bottom: 20px;
                        "
                    >
                        <!-- Customer Info -->
                        <div
                            class="detail-section"
                            style="
                                border: 1px solid #e5e7eb;
                                border-radius: 8px;
                                padding: 15px;
                            "
                        >
                            <h3
                                style="
                                    margin: 0 0 12px 0;
                                    color: #1f2937;
                                    font-size: 14px;
                                    font-weight: 600;
                                "
                            >
                                CUSTOMER INFORMATION
                            </h3>
                            <div style="font-size: 13px">
                                <div
                                    style="
                                        display: flex;
                                        justify-content: space-between;
                                        margin-bottom: 6px;
                                    "
                                >
                                    <span style="color: #6b7280">Name:</span>
                                    <span
                                        style="color: #111827; font-weight: 500"
                                        >{{ printOrder.user.name }}</span
                                    >
                                </div>
                                <div
                                    style="
                                        display: flex;
                                        justify-content: space-between;
                                        margin-bottom: 6px;
                                    "
                                >
                                    <span style="color: #6b7280">Email:</span>
                                    <span
                                        style="color: #111827; font-weight: 500"
                                        >{{ printOrder.user.email }}</span
                                    >
                                </div>
                                <div
                                    style="
                                        display: flex;
                                        justify-content: space-between;
                                    "
                                >
                                    <span style="color: #6b7280"
                                        >Order Date:</span
                                    >
                                    <span
                                        style="color: #111827; font-weight: 500"
                                        >{{
                                            formatDate(printOrder.created_at)
                                        }}</span
                                    >
                                </div>
                            </div>
                        </div>

                        <!-- Shipping Address -->
                        <div
                            class="detail-section"
                            style="
                                border: 1px solid #e5e7eb;
                                border-radius: 8px;
                                padding: 15px;
                            "
                        >
                            <h3
                                style="
                                    margin: 0 0 12px 0;
                                    color: #1f2937;
                                    font-size: 14px;
                                    font-weight: 600;
                                "
                            >
                                SHIPPING ADDRESS
                            </h3>
                            <div
                                v-if="printOrder.shipping_address"
                                style="font-size: 13px"
                            >
                                <div style="margin-bottom: 6px">
                                    <div style="color: #6b7280">Name:</div>
                                    <div style="color: #111827">
                                        {{
                                            printOrder.shipping_address
                                                .full_name
                                        }}
                                    </div>
                                </div>
                                <div style="margin-bottom: 6px">
                                    <div style="color: #6b7280">Phone:</div>
                                    <div style="color: #111827">
                                        {{ printOrder.shipping_address.phone }}
                                    </div>
                                </div>
                                <div style="margin-bottom: 6px">
                                    <div style="color: #6b7280">Address:</div>
                                    <div style="color: #111827">
                                        {{
                                            printOrder.shipping_address
                                                .address_line1
                                        }}
                                        <span
                                            v-if="
                                                printOrder.shipping_address
                                                    .address_line2
                                            "
                                        >
                                            ,
                                            {{
                                                printOrder.shipping_address
                                                    .address_line2
                                            }}
                                        </span>
                                    </div>
                                </div>
                                <div>
                                    <div style="color: #6b7280">Location:</div>
                                    <div style="color: #111827">
                                        {{ printOrder.shipping_address.city }},
                                        {{ printOrder.shipping_address.state }}
                                        {{
                                            printOrder.shipping_address.zip_code
                                        }}
                                    </div>
                                </div>
                            </div>
                            <div
                                v-else
                                style="
                                    color: #9ca3af;
                                    font-size: 13px;
                                    text-align: center;
                                    padding: 10px;
                                "
                            >
                                No shipping address provided
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Order Status & Payment Info -->
                <div
                    class="order-meta-section"
                    style="
                        background: #f8fafc;
                        border-radius: 8px;
                        padding: 15px;
                        margin-bottom: 30px;
                        border: 1px solid #e5e7eb;
                    "
                >
                    <div
                        class="meta-grid"
                        style="
                            display: grid;
                            grid-template-columns: repeat(3, 1fr);
                            gap: 15px;
                        "
                    >
                        <div class="meta-item" style="text-align: center">
                            <div
                                style="
                                    color: #6b7280;
                                    font-size: 12px;
                                    margin-bottom: 8px;
                                "
                            >
                                ORDER STATUS
                            </div>
                            <span
                                :style="{
                                    display: 'inline-block',
                                    padding: '6px 12px',
                                    borderRadius: '4px',
                                    fontSize: '12px',
                                    fontWeight: '600',
                                    background: getStatusBackground(
                                        printOrder.status
                                    ),
                                    color: getStatusColor(printOrder.status),
                                }"
                            >
                                {{ getStatusDisplayName(printOrder.status) }}
                            </span>
                        </div>
                        <div class="meta-item" style="text-align: center">
                            <div
                                style="
                                    color: #6b7280;
                                    font-size: 12px;
                                    margin-bottom: 8px;
                                "
                            >
                                PAYMENT METHOD
                            </div>
                            <div
                                style="
                                    color: #111827;
                                    font-size: 14px;
                                    font-weight: 600;
                                "
                            >
                                {{ printOrder.payment_method || "N/A" }}
                            </div>
                        </div>
                        <div class="meta-item" style="text-align: center">
                            <div
                                style="
                                    color: #6b7280;
                                    font-size: 12px;
                                    margin-bottom: 8px;
                                "
                            >
                                TOTAL AMOUNT
                            </div>
                            <div
                                style="
                                    color: #10b981;
                                    font-size: 18px;
                                    font-weight: 700;
                                "
                            >
                                ৳{{ printOrder.total_amount }}
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Order Items Table -->
                <div class="invoice-items" style="margin-bottom: 30px">
                    <h3
                        style="
                            margin: 0 0 15px 0;
                            color: #1f2937;
                            font-size: 16px;
                            font-weight: 600;
                        "
                    >
                        ORDER ITEMS
                    </h3>

                    <table
                        class="items-table"
                        style="
                            width: 100%;
                            border-collapse: collapse;
                            font-size: 13px;
                        "
                    >
                        <thead
                            style="
                                background: #f9fafb;
                                border: 1px solid #e5e7eb;
                            "
                        >
                            <tr>
                                <th
                                    style="
                                        text-align: left;
                                        padding: 12px;
                                        font-weight: 600;
                                        color: #374151;
                                    "
                                >
                                    #
                                </th>
                                <th
                                    style="
                                        text-align: left;
                                        padding: 12px;
                                        font-weight: 600;
                                        color: #374151;
                                    "
                                >
                                    BOOK TITLE
                                </th>
                                <th
                                    style="
                                        text-align: center;
                                        padding: 12px;
                                        font-weight: 600;
                                        color: #374151;
                                    "
                                >
                                    QTY
                                </th>
                                <th
                                    style="
                                        text-align: right;
                                        padding: 12px;
                                        font-weight: 600;
                                        color: #374151;
                                    "
                                >
                                    UNIT PRICE
                                </th>
                                <th
                                    style="
                                        text-align: right;
                                        padding: 12px;
                                        font-weight: 600;
                                        color: #374151;
                                    "
                                >
                                    SUBTOTAL
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr
                                v-for="(item, index) in printOrder.order_items"
                                :key="item.id"
                                style="border-bottom: 1px solid #e5e7eb"
                            >
                                <td
                                    style="
                                        text-align: left;
                                        padding: 12px;
                                        color: #6b7280;
                                    "
                                >
                                    {{ index + 1 }}
                                </td>
                                <td style="text-align: left; padding: 12px">
                                    <div
                                        style="font-weight: 500; color: #111827"
                                    >
                                        {{ item.book.title }}
                                    </div>
                                    <div
                                        style="color: #6b7280; font-size: 12px"
                                    >
                                        by
                                        {{
                                            item.book.author?.name ||
                                            "Unknown Author"
                                        }}
                                    </div>
                                </td>
                                <td style="text-align: center; padding: 12px">
                                    <span
                                        style="
                                            display: inline-block;
                                            background: #eff6ff;
                                            color: #1e40af;
                                            padding: 4px 8px;
                                            border-radius: 4px;
                                            font-weight: 600;
                                        "
                                    >
                                        {{ item.quantity }}
                                    </span>
                                </td>
                                <td
                                    style="
                                        text-align: right;
                                        padding: 12px;
                                        color: #111827;
                                        font-weight: 500;
                                    "
                                >
                                    ৳{{ parseFloat(item.price).toFixed(2) }}
                                </td>
                                <td
                                    style="
                                        text-align: right;
                                        padding: 12px;
                                        color: #111827;
                                        font-weight: 600;
                                    "
                                >
                                    ৳{{
                                        (
                                            parseFloat(item.price) *
                                            item.quantity
                                        ).toFixed(2)
                                    }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Order Totals -->
                <div class="invoice-totals" style="margin-bottom: 30px">
                    <div
                        class="totals-grid"
                        style="
                            display: grid;
                            grid-template-columns: 1fr 300px;
                            gap: 20px;
                        "
                    >
                        <div></div>
                        <div
                            class="totals-section"
                            style="
                                border: 1px solid #e5e7eb;
                                border-radius: 8px;
                                padding: 20px;
                                background: #f8fafc;
                            "
                        >
                            <div
                                class="total-row"
                                style="
                                    display: flex;
                                    justify-content: space-between;
                                    margin-bottom: 12px;
                                "
                            >
                                <span style="color: #6b7280; font-size: 14px"
                                    >Subtotal:</span
                                >
                                <span
                                    style="
                                        color: #111827;
                                        font-weight: 600;
                                        font-size: 14px;
                                    "
                                    >৳{{ printOrder.total_amount }}</span
                                >
                            </div>
                            <div
                                class="total-row"
                                style="
                                    display: flex;
                                    justify-content: space-between;
                                    margin-bottom: 12px;
                                "
                            >
                                <span style="color: #6b7280; font-size: 14px"
                                    >Shipping:</span
                                >
                                <span
                                    style="
                                        color: #111827;
                                        font-weight: 600;
                                        font-size: 14px;
                                    "
                                    >৳0.00</span
                                >
                            </div>
                            <div
                                class="total-row"
                                style="
                                    display: flex;
                                    justify-content: space-between;
                                    margin-bottom: 15px;
                                    padding-bottom: 12px;
                                    border-bottom: 1px solid #e5e7eb;
                                "
                            >
                                <span style="color: #6b7280; font-size: 14px"
                                    >Tax:</span
                                >
                                <span
                                    style="
                                        color: #111827;
                                        font-weight: 600;
                                        font-size: 14px;
                                    "
                                    >৳0.00</span
                                >
                            </div>
                            <div
                                class="total-row grand-total"
                                style="
                                    display: flex;
                                    justify-content: space-between;
                                "
                            >
                                <span
                                    style="
                                        color: #1f2937;
                                        font-size: 16px;
                                        font-weight: 700;
                                    "
                                    >GRAND TOTAL</span
                                >
                                <span
                                    style="
                                        color: #10b981;
                                        font-size: 20px;
                                        font-weight: 800;
                                    "
                                    >৳{{ printOrder.total_amount }}</span
                                >
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Simple Footer -->
                <div
                    class="invoice-footer"
                    style="padding-top: 20px; border-top: 1px solid #e5e7eb"
                >
                    <div
                        style="
                            text-align: center;
                            color: #6b7280;
                            font-size: 13px;
                        "
                    >
                        <p style="margin: 0 0 8px 0">
                            Thank you for shopping with PUSTOK!
                        </p>
                        <p style="margin: 0; font-size: 12px">
                            123 Book Street, Zindabazar, Sylhet |
                            shoyondeb18246@gmail.com
                        </p>
                        <p
                            style="
                                margin: 10px 0 0 0;
                                font-size: 11px;
                                color: #9ca3af;
                            "
                        >
                            Invoice #{{ printOrder.order_number }} | Printed on
                            {{ new Date().toLocaleDateString() }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<script setup>
import { ref, watch } from "vue";
import { router } from "@inertiajs/vue3";
import { Link } from "@inertiajs/vue3";
import AppLayout from "@/Layouts/AppLayout.vue";
import Pagination from "@/Components/Pagination.vue";
import { nextTick } from "vue";

const props = defineProps({
    orders: Object,
    per_page: {
        type: Number,
        default: 10,
    },
});

const showOrderModal = ref(false);
const selectedOrder = ref(null);
const printContent = ref(false);
const printType = ref("");
const printOrder = ref(null);
const printableContent = ref(null);
const perPageInput = ref(props.per_page);

watch(
    () => props.per_page,
    (newPerPage) => {
        perPageInput.value = newPerPage;
    }
);

const updatePerPage = () => {
    let perPageValue = parseInt(perPageInput.value);
    if (isNaN(perPageValue) || perPageValue < 1) perPageValue = 1;
    if (perPageValue > 100) perPageValue = 100;

    if (perPageValue !== props.per_page) {
        router.get(
            route("orders.history"),
            { per_page: perPageValue, page: 1 },
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

const viewOrder = (order) => {
    selectedOrder.value = order;
    showOrderModal.value = true;
};

const closeModal = () => {
    showOrderModal.value = false;
    selectedOrder.value = null;
};

// PRINT FUNCTIONS
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
                    <title>Invoice #${order.order_number} - PUSTOK</title>
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
                        
                        @page {
                            size: A4 portrait;
                            margin: 10mm;
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
                        
                        .detail-section h3 {
                            font-size: 12px;
                            color: #2c3e50;
                            text-transform: uppercase;
                            letter-spacing: 0.5px;
                            margin-bottom: 12px;
                            font-weight: 600;
                        }
                        
                        .customer-name {
                            font-size: 16px;
                            font-weight: 600;
                            color: #2c3e50;
                            margin-bottom: 4px;
                        }
                        
                        .customer-email {
                            color: #666;
                            font-size: 11px;
                        }
                        
                        .customer-address, .customer-location, .customer-country, .customer-phone {
                            color: #555;
                            font-size: 11px;
                            line-height: 1.4;
                            margin: 4px 0;
                        }
                        
                        .detail-row {
                            display: flex;
                            justify-content: space-between;
                            margin-bottom: 6px;
                            font-size: 11px;
                        }
                        
                        .detail-row .label {
                            color: #666;
                            font-weight: 500;
                        }
                        
                        .detail-row .value {
                            color: #333;
                            font-weight: 500;
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
                        .status-cod { background: #fed7aa; color: #9a3412; }
                        .status-payment_failed { background: #fef3c7; color: #92400e; }
                        
                        
                        /* Items Table - Compact */
                        .invoice-items {
                            margin-bottom: 20px;
                        }
                        
                        .invoice-items h3 {
                            font-size: 13px;
                            color: #2c3e50;
                            margin-bottom: 15px;
                            font-weight: 600;
                            text-transform: uppercase;
                            letter-spacing: 0.5px;
                        }
                        
                        .items-table {
                            width: 100%;
                            border-collapse: collapse;
                            font-size: 11px;
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
                        }
                        
                        .items-table td {
                            padding: 10px 8px;
                            border-bottom: 1px solid #eee;
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
                            
                            .invoice-items {
                                margin-bottom: 15px !important;
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

const getTotalRevenue = () => {
    return props.orders.data
        .reduce(
            (total, order) => total + (parseFloat(order.total_amount) || 0),
            0
        )
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
        cod: "CASH ON DELIVERY",
        COD: "CASH ON DELIVERY",
    };
    return statusMap[status] || status.toUpperCase();
};

const statusClasses = {
    cod: {
        container:
            "bg-gradient-to-r from-orange-50 to-amber-50 border-2 border-orange-200 shadow-sm hover:shadow-md hover:border-orange-300",
        iconBg: "bg-gradient-to-r from-orange-500 to-amber-500",
        icon: "text-white",
        text: "text-orange-800",
        gradient: "from-orange-500 to-amber-500",
        description: "Cash on Delivery order",
    },
    COD: {
        container:
            "bg-gradient-to-r from-orange-50 to-amber-50 border-2 border-orange-200 shadow-sm hover:shadow-md hover:border-orange-300",
        iconBg: "bg-gradient-to-r from-orange-500 to-amber-500",
        icon: "text-white",
        text: "text-orange-800",
        gradient: "from-orange-500 to-amber-500",
        description: "Cash on Delivery order",
    },
    pending: {
        container:
            "bg-gradient-to-r from-yellow-50 to-amber-50 border-2 border-yellow-200 shadow-sm hover:shadow-md hover:border-yellow-300",
        iconBg: "bg-gradient-to-r from-yellow-500 to-amber-500",
        icon: "text-white",
        text: "text-yellow-800",
        gradient: "from-yellow-500 to-amber-500",
        description: "Order placed, awaiting payment",
    },
    payment_submitted: {
        container:
            "bg-gradient-to-r from-blue-50 to-cyan-50 border-2 border-blue-200 shadow-sm hover:shadow-md hover:border-blue-300",
        iconBg: "bg-gradient-to-r from-blue-500 to-cyan-500",
        icon: "text-white",
        text: "text-blue-800",
        gradient: "from-blue-500 to-cyan-500",
        description: "Payment submitted, waiting confirmation",
    },
    payment_verification: {
        container:
            "bg-gradient-to-r from-indigo-50 to-purple-50 border-2 border-indigo-200 shadow-sm hover:shadow-md hover:border-indigo-300",
        iconBg: "bg-gradient-to-r from-indigo-500 to-purple-500",
        icon: "text-white",
        text: "text-indigo-800",
        gradient: "from-indigo-500 to-purple-500",
        description: "Payment under verification",
    },
    paid: {
        container:
            "bg-gradient-to-r from-green-50 to-emerald-50 border-2 border-green-200 shadow-sm hover:shadow-md hover:border-green-300",
        iconBg: "bg-gradient-to-r from-green-500 to-emerald-500",
        icon: "text-white",
        text: "text-green-800",
        gradient: "from-green-500 to-emerald-500",
        description: "Payment successful, preparing order",
    },
    processing: {
        container:
            "bg-gradient-to-r from-cyan-50 to-teal-50 border-2 border-cyan-200 shadow-sm hover:shadow-md hover:border-cyan-300",
        iconBg: "bg-gradient-to-r from-cyan-500 to-teal-500",
        icon: "text-white",
        text: "text-cyan-800",
        gradient: "from-cyan-500 to-teal-500",
        description: "Order is being processed",
    },
    shipped: {
        container:
            "bg-gradient-to-r from-violet-50 to-fuchsia-50 border-2 border-violet-200 shadow-sm hover:shadow-md hover:border-violet-300",
        iconBg: "bg-gradient-to-r from-violet-500 to-fuchsia-500",
        icon: "text-white",
        text: "text-violet-800",
        gradient: "from-violet-500 to-fuchsia-500",
        description: "Order shipped, on the way",
    },
    ready_for_pickup: {
        container:
            "bg-gradient-to-r from-orange-50 to-amber-50 border-2 border-orange-200 shadow-sm hover:shadow-md hover:border-orange-300",
        iconBg: "bg-gradient-to-r from-orange-500 to-amber-500",
        icon: "text-white",
        text: "text-orange-800",
        gradient: "from-orange-500 to-amber-500",
        description: "Ready for pickup at store",
    },
    completed: {
        container:
            "bg-gradient-to-r from-emerald-50 to-green-50 border-2 border-emerald-200 shadow-sm hover:shadow-md hover:border-emerald-300",
        iconBg: "bg-gradient-to-r from-emerald-500 to-green-500",
        icon: "text-white",
        text: "text-emerald-800",
        gradient: "from-emerald-500 to-green-500",
        description: "Order completed successfully",
    },
    cancelled: {
        container:
            "bg-gradient-to-r from-red-50 to-rose-50 border-2 border-red-200 shadow-sm hover:shadow-md hover:border-red-300",
        iconBg: "bg-gradient-to-r from-red-500 to-rose-500",
        icon: "text-white",
        text: "text-red-800",
        gradient: "from-red-500 to-rose-500",
        description: "Order cancelled",
    },
    payment_failed: {
        container:
            "bg-gradient-to-r from-pink-50 to-rose-50 border-2 border-pink-200 shadow-sm hover:shadow-md hover:border-pink-300",
        iconBg: "bg-gradient-to-r from-pink-500 to-rose-500",
        icon: "text-white",
        text: "text-pink-800",
        gradient: "from-pink-500 to-rose-500",
        description: "Payment failed, please retry",
    },
};

const formatDate = (dateString) => {
    return new Date(dateString).toLocaleDateString("en-US", {
        year: "numeric",
        month: "short",
        day: "numeric",
        hour: "2-digit",
        minute: "2-digit",
    });
};

const handleImageError = (event) => {
    event.target.src = "/images/book-placeholder.png";
};

// Add these helper functions
const getStatusBackground = (status) => {
    const statusMap = {
        pending: "linear-gradient(135deg, #fef3c7, #fde68a)",
        payment_submitted: "linear-gradient(135deg, #dbeafe, #93c5fd)",
        payment_verification: "linear-gradient(135deg, #e0e7ff, #a5b4fc)",
        paid: "linear-gradient(135deg, #dcfce7, #86efac)",
        processing: "linear-gradient(135deg, #f3e8ff, #d8b4fe)",
        shipped: "linear-gradient(135deg, #cffafe, #67e8f9)",
        ready_for_pickup: "linear-gradient(135deg, #ffedd5, #fdba74)",
        completed: "linear-gradient(135deg, #bbf7d0, #4ade80)",
        cancelled: "linear-gradient(135deg, #fee2e2, #fca5a5)",
        payment_failed: "linear-gradient(135deg, #fef3c7, #fbbf24)",
        cod: "linear-gradient(135deg, #fed7aa, #fb923c)",
        COD: "linear-gradient(135deg, #fed7aa, #fb923c)",
    };
    return statusMap[status] || "linear-gradient(135deg, #f3f4f6, #d1d5db)";
};

const getStatusColor = (status) => {
    const statusMap = {
        pending: "#92400e",
        payment_submitted: "#1e40af",
        payment_verification: "#3730a3",
        paid: "#166534",
        processing: "#6b21a8",
        shipped: "#155e75",
        ready_for_pickup: "#9a3412",
        completed: "#166534",
        cancelled: "#991b1b",
        payment_failed: "#92400e",
        cod: "#9a3412",
        COD: "#9a3412",
    };
    return statusMap[status] || "#374151";
};
</script>

<style scoped>
/* Custom scrollbar for modal */
::-webkit-scrollbar {
    width: 8px;
}

::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-radius: 4px;
}

::-webkit-scrollbar-thumb {
    background: #888;
    border-radius: 4px;
}

::-webkit-scrollbar-thumb:hover {
    background: #555;
}

/* Line clamp for book titles */
.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

/* Smooth transitions */
.transition-all {
    transition-property: all;
    transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
    transition-duration: 300ms;
}

/* Glass effect for modal */
.backdrop-blur {
    backdrop-filter: blur(4px);
}
</style>
