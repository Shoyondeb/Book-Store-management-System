<template>
    <AppLayout>
        <div
            class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-100 py-8"
        >
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <!-- Animated Header -->
                <div class="text-center mb-12">
                    <div
                        class="inline-flex items-center justify-center w-20 h-20 bg-gradient-to-r from-blue-500 to-purple-600 rounded-2xl shadow-xl mb-6 transform hover:scale-105 transition-transform duration-300"
                    >
                        <svg
                            class="w-10 h-10 text-white"
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
                    <h1
                        class="text-5xl font-bold bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent mb-4"
                    >
                        Secure Checkout
                    </h1>
                    <p
                        class="text-xl text-gray-600 max-w-2xl mx-auto leading-relaxed"
                    >
                        Complete your purchase with confidence using our secure
                        payment system
                    </p>
                </div>

                <!-- Progress Steps -->
                <div class="max-w-4xl mx-auto mb-12">
                    <div class="flex items-center justify-center space-x-4">
                        <div class="flex items-center">
                            <div
                                class="w-10 h-10 bg-green-500 rounded-full flex items-center justify-center shadow-lg"
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
                                        d="M5 13l4 4L19 7"
                                    ></path>
                                </svg>
                            </div>
                            <span
                                class="ml-3 text-sm font-semibold text-gray-900"
                                >Cart</span
                            >
                        </div>
                        <div class="flex-1 h-1 bg-green-500 rounded-full"></div>
                        <div class="flex items-center">
                            <div
                                class="w-10 h-10 bg-blue-500 rounded-full flex items-center justify-center shadow-lg"
                            >
                                <span class="text-white font-semibold">2</span>
                            </div>
                            <span
                                class="ml-3 text-sm font-semibold text-gray-900"
                                >Payment</span
                            >
                        </div>
                        <div class="flex-1 h-1 bg-gray-300 rounded-full"></div>
                        <div class="flex items-center">
                            <div
                                class="w-10 h-10 bg-gray-300 rounded-full flex items-center justify-center"
                            >
                                <span class="text-gray-600 font-semibold"
                                    >3</span
                                >
                            </div>
                            <span
                                class="ml-3 text-sm font-semibold text-gray-500"
                                >Complete</span
                            >
                        </div>
                    </div>
                </div>

                <!-- Flash Messages -->
                <div
                    v-if="$page.props.flash?.error"
                    class="max-w-4xl mx-auto mb-8"
                >
                    <div
                        class="bg-red-50 border-l-4 border-red-500 rounded-2xl p-6 shadow-lg transform hover:scale-[1.02] transition-transform duration-200"
                    >
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <svg
                                    class="h-8 w-8 text-red-400"
                                    fill="currentColor"
                                    viewBox="0 0 20 20"
                                >
                                    <path
                                        fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                        clip-rule="evenodd"
                                    />
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-lg font-medium text-red-800">
                                    {{ $page.props.flash.error }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <div
                    v-if="$page.props.flash?.success"
                    class="max-w-4xl mx-auto mb-8"
                >
                    <div
                        class="bg-green-50 border-l-4 border-green-500 rounded-2xl p-6 shadow-lg transform hover:scale-[1.02] transition-transform duration-200"
                    >
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <svg
                                    class="h-8 w-8 text-green-400"
                                    fill="currentColor"
                                    viewBox="0 0 20 20"
                                >
                                    <path
                                        fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                        clip-rule="evenodd"
                                    />
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-lg font-medium text-green-800">
                                    {{ $page.props.flash.success }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <div
                    class="grid grid-cols-1 xl:grid-cols-2 gap-8 max-w-7xl mx-auto"
                >
                    <!-- Order Summary - Glass Morphism -->
                    <div
                        class="bg-white/80 backdrop-blur-lg rounded-3xl shadow-2xl border border-white/20 overflow-hidden"
                    >
                        <div
                            class="bg-gradient-to-r from-blue-600 via-purple-600 to-indigo-700 px-8 py-6"
                        >
                            <h2
                                class="text-2xl font-bold text-white flex items-center"
                            >
                                <svg
                                    class="w-7 h-7 mr-3"
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
                                Order Summary
                            </h2>
                        </div>
                        <div class="p-8">
                            <div class="space-y-6">
                                <div
                                    v-for="item in order.order_items"
                                    :key="item.id"
                                    class="flex items-center space-x-5 p-5 bg-white rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1"
                                >
                                    <img
                                        :src="
                                            item.book.image_url ||
                                            '/images/default-book.jpg'
                                        "
                                        :alt="item.book.title"
                                        class="h-20 w-16 object-cover rounded-xl shadow-md"
                                    />
                                    <div class="flex-1 min-w-0">
                                        <h3
                                            class="text-lg font-semibold text-gray-900 truncate"
                                        >
                                            {{ item.book.title }}
                                        </h3>
                                        <p class="text-sm text-gray-600 mt-1">
                                            Quantity: {{ item.quantity }}
                                        </p>
                                        <p
                                            class="text-sm text-blue-600 font-medium mt-1"
                                        >
                                            ৳{{ item.price }} each
                                        </p>
                                    </div>
                                    <div class="text-right">
                                        <p
                                            class="text-xl font-bold text-gray-900"
                                        >
                                            ৳{{
                                                (
                                                    item.price * item.quantity
                                                ).toFixed(2)
                                            }}
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <!-- Order Total -->
                            <div
                                class="mt-8 pt-8 border-t border-gray-200 space-y-4"
                            >
                                <div
                                    class="flex justify-between items-center text-lg text-gray-700"
                                >
                                    <span class="font-medium">Subtotal</span>
                                    <span class="font-semibold"
                                        >৳{{ order.total_amount }}</span
                                    >
                                </div>
                                <div
                                    class="flex justify-between items-center text-lg text-gray-700"
                                >
                                    <span class="font-medium">Shipping</span>
                                    <span class="text-green-600 font-bold"
                                        >FREE</span
                                    >
                                </div>
                                <div
                                    class="flex justify-between items-center text-2xl font-bold text-gray-900 pt-4 border-t border-gray-300"
                                >
                                    <span>Total Amount</span>
                                    <span
                                        class="bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent"
                                    >
                                        ৳{{ order.total_amount }}
                                    </span>
                                </div>
                            </div>

                            <!-- Security Badges -->
                            <div
                                class="mt-8 flex items-center justify-center space-x-6 pt-6 border-t border-gray-200"
                            >
                                <div
                                    class="flex items-center space-x-2 text-sm text-gray-600"
                                >
                                    <svg
                                        class="w-5 h-5 text-green-500"
                                        fill="currentColor"
                                        viewBox="0 0 20 20"
                                    >
                                        <path
                                            fill-rule="evenodd"
                                            d="M2.166 4.999A11.954 11.954 0 0010 1.944 11.954 11.954 0 0017.834 5c.11.65.166 1.32.166 2.001 0 5.225-3.34 9.67-8 11.317C5.34 16.67 2 12.225 2 7c0-.682.057-1.35.166-2.001zm11.541 3.708a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                            clip-rule="evenodd"
                                        />
                                    </svg>
                                    <span>SSL Secure</span>
                                </div>
                                <div
                                    class="flex items-center space-x-2 text-sm text-gray-600"
                                >
                                    <svg
                                        class="w-5 h-5 text-blue-500"
                                        fill="currentColor"
                                        viewBox="0 0 20 20"
                                    >
                                        <path
                                            fill-rule="evenodd"
                                            d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z"
                                            clip-rule="evenodd"
                                        />
                                    </svg>
                                    <span>Encrypted</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Payment Section -->
                    <div class="space-y-8">
                        <!-- Payment Method Selection -->
                        <div
                            class="bg-white/80 backdrop-blur-lg rounded-3xl shadow-2xl border border-white/20 overflow-hidden"
                        >
                            <div
                                class="bg-gradient-to-r from-green-500 to-teal-600 px-8 py-6"
                            >
                                <h2
                                    class="text-2xl font-bold text-white flex items-center"
                                >
                                    <svg
                                        class="w-7 h-7 mr-3"
                                        fill="none"
                                        stroke="currentColor"
                                        viewBox="0 0 24 24"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"
                                        ></path>
                                    </svg>
                                    Choose Payment Method
                                </h2>
                            </div>
                            <div class="p-8">
                                <!-- Payment Error -->
                                <div
                                    v-if="paymentError"
                                    class="mb-8 bg-red-50 border-l-4 border-red-500 rounded-2xl p-6 transform hover:scale-[1.02] transition-transform duration-200"
                                >
                                    <div class="flex items-center">
                                        <svg
                                            class="w-8 h-8 text-red-400 mr-4"
                                            fill="currentColor"
                                            viewBox="0 0 20 20"
                                        >
                                            <path
                                                fill-rule="evenodd"
                                                d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                                clip-rule="evenodd"
                                            />
                                        </svg>
                                        <p
                                            class="text-lg font-medium text-red-800"
                                        >
                                            {{ paymentError }}
                                        </p>
                                    </div>
                                </div>

                                <!-- Payment Methods Grid -->
                                <div
                                    class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-8"
                                >
                                    <!-- Stripe Card -->
                                    <div class="relative">
                                        <input
                                            type="radio"
                                            id="stripe"
                                            v-model="selectedMethod"
                                            value="stripe"
                                            class="sr-only"
                                        />
                                        <label
                                            for="stripe"
                                            :class="[
                                                'flex flex-col p-6 border-3 rounded-2xl cursor-pointer transition-all duration-300 transform hover:scale-105',
                                                selectedMethod === 'stripe'
                                                    ? 'border-blue-500 bg-blue-50 shadow-xl'
                                                    : 'border-gray-200 bg-white hover:border-gray-300 hover:shadow-lg',
                                            ]"
                                        >
                                            <div
                                                class="flex items-center justify-between"
                                            >
                                                <div
                                                    class="flex items-center space-x-4"
                                                >
                                                    <div
                                                        class="w-12 h-8 bg-gradient-to-r from-blue-500 to-purple-600 rounded-lg flex items-center justify-center shadow-md"
                                                    >
                                                        <span
                                                            class="text-xs font-bold text-white"
                                                            >CARD</span
                                                        >
                                                    </div>
                                                    <div>
                                                        <span
                                                            class="font-bold text-gray-900 text-lg"
                                                            >Credit Card</span
                                                        >
                                                        <p
                                                            class="text-sm text-gray-600 mt-1"
                                                        >
                                                            Visa, Mastercard,
                                                            Amex
                                                        </p>
                                                    </div>
                                                </div>
                                                <div
                                                    :class="[
                                                        'w-6 h-6 rounded-full border-3 flex items-center justify-center',
                                                        selectedMethod ===
                                                        'stripe'
                                                            ? 'border-blue-500 bg-blue-500'
                                                            : 'border-gray-300',
                                                    ]"
                                                >
                                                    <svg
                                                        v-if="
                                                            selectedMethod ===
                                                            'stripe'
                                                        "
                                                        class="w-3 h-3 text-white"
                                                        fill="currentColor"
                                                        viewBox="0 0 20 20"
                                                    >
                                                        <path
                                                            fill-rule="evenodd"
                                                            d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                                            clip-rule="evenodd"
                                                        />
                                                    </svg>
                                                </div>
                                            </div>
                                        </label>
                                    </div>

                                    <!-- bKash Card -->
                                    <div class="relative">
                                        <input
                                            type="radio"
                                            id="bkash"
                                            v-model="selectedMethod"
                                            value="bkash"
                                            class="sr-only"
                                        />
                                        <label
                                            for="bkash"
                                            :class="[
                                                'flex flex-col p-6 border-3 rounded-2xl cursor-pointer transition-all duration-300 transform hover:scale-105',
                                                selectedMethod === 'bkash'
                                                    ? 'border-green-500 bg-green-50 shadow-xl'
                                                    : 'border-gray-200 bg-white hover:border-gray-300 hover:shadow-lg',
                                            ]"
                                        >
                                            <div
                                                class="flex items-center justify-between"
                                            >
                                                <div
                                                    class="flex items-center space-x-4"
                                                >
                                                    <div
                                                        class="w-12 h-8 bg-gradient-to-r from-green-500 to-emerald-600 rounded-lg flex items-center justify-center shadow-md"
                                                    >
                                                        <span
                                                            class="text-xs font-bold text-white"
                                                            >bKash</span
                                                        >
                                                    </div>
                                                    <div>
                                                        <span
                                                            class="font-bold text-gray-900 text-lg"
                                                            >bKash</span
                                                        >
                                                        <p
                                                            class="text-sm text-gray-600 mt-1"
                                                        >
                                                            Mobile Payment
                                                        </p>
                                                    </div>
                                                </div>
                                                <div
                                                    :class="[
                                                        'w-6 h-6 rounded-full border-3 flex items-center justify-center',
                                                        selectedMethod ===
                                                        'bkash'
                                                            ? 'border-green-500 bg-green-500'
                                                            : 'border-gray-300',
                                                    ]"
                                                >
                                                    <svg
                                                        v-if="
                                                            selectedMethod ===
                                                            'bkash'
                                                        "
                                                        class="w-3 h-3 text-white"
                                                        fill="currentColor"
                                                        viewBox="0 0 20 20"
                                                    >
                                                        <path
                                                            fill-rule="evenodd"
                                                            d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                                            clip-rule="evenodd"
                                                        />
                                                    </svg>
                                                </div>
                                            </div>
                                        </label>
                                    </div>

                                    <!-- Nagad Card -->
                                    <div class="relative">
                                        <input
                                            type="radio"
                                            id="nagad"
                                            v-model="selectedMethod"
                                            value="nagad"
                                            class="sr-only"
                                        />
                                        <label
                                            for="nagad"
                                            :class="[
                                                'flex flex-col p-6 border-3 rounded-2xl cursor-pointer transition-all duration-300 transform hover:scale-105',
                                                selectedMethod === 'nagad'
                                                    ? 'border-purple-500 bg-purple-50 shadow-xl'
                                                    : 'border-gray-200 bg-white hover:border-gray-300 hover:shadow-lg',
                                            ]"
                                        >
                                            <div
                                                class="flex items-center justify-between"
                                            >
                                                <div
                                                    class="flex items-center space-x-4"
                                                >
                                                    <div
                                                        class="w-12 h-8 bg-gradient-to-r from-purple-500 to-indigo-600 rounded-lg flex items-center justify-center shadow-md"
                                                    >
                                                        <span
                                                            class="text-xs font-bold text-white"
                                                            >Nagad</span
                                                        >
                                                    </div>
                                                    <div>
                                                        <span
                                                            class="font-bold text-gray-900 text-lg"
                                                            >Nagad</span
                                                        >
                                                        <p
                                                            class="text-sm text-gray-600 mt-1"
                                                        >
                                                            Mobile Payment
                                                        </p>
                                                    </div>
                                                </div>
                                                <div
                                                    :class="[
                                                        'w-6 h-6 rounded-full border-3 flex items-center justify-center',
                                                        selectedMethod ===
                                                        'nagad'
                                                            ? 'border-purple-500 bg-purple-500'
                                                            : 'border-gray-300',
                                                    ]"
                                                >
                                                    <svg
                                                        v-if="
                                                            selectedMethod ===
                                                            'nagad'
                                                        "
                                                        class="w-3 h-3 text-white"
                                                        fill="currentColor"
                                                        viewBox="0 0 20 20"
                                                    >
                                                        <path
                                                            fill-rule="evenodd"
                                                            d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                                            clip-rule="evenodd"
                                                        />
                                                    </svg>
                                                </div>
                                            </div>
                                        </label>
                                    </div>

                                    <!-- Mobile Banking Card -->
                                    <div class="relative">
                                        <input
                                            type="radio"
                                            id="mobile"
                                            v-model="selectedMethod"
                                            value="mobile"
                                            class="sr-only"
                                        />
                                        <label
                                            for="mobile"
                                            :class="[
                                                'flex flex-col p-6 border-3 rounded-2xl cursor-pointer transition-all duration-300 transform hover:scale-105',
                                                selectedMethod === 'mobile'
                                                    ? 'border-orange-500 bg-orange-50 shadow-xl'
                                                    : 'border-gray-200 bg-white hover:border-gray-300 hover:shadow-lg',
                                            ]"
                                        >
                                            <div
                                                class="flex items-center justify-between"
                                            >
                                                <div
                                                    class="flex items-center space-x-4"
                                                >
                                                    <div
                                                        class="w-12 h-8 bg-gradient-to-r from-orange-500 to-red-500 rounded-lg flex items-center justify-center shadow-md"
                                                    >
                                                        <span
                                                            class="text-xs font-bold text-white"
                                                            >MB</span
                                                        >
                                                    </div>
                                                    <div>
                                                        <span
                                                            class="font-bold text-gray-900 text-lg"
                                                            >Mobile
                                                            Banking</span
                                                        >
                                                        <p
                                                            class="text-sm text-gray-600 mt-1"
                                                        >
                                                            Rocket, MCash, Upay
                                                        </p>
                                                    </div>
                                                </div>
                                                <div
                                                    :class="[
                                                        'w-6 h-6 rounded-full border-3 flex items-center justify-center',
                                                        selectedMethod ===
                                                        'mobile'
                                                            ? 'border-orange-500 bg-orange-500'
                                                            : 'border-gray-300',
                                                    ]"
                                                >
                                                    <svg
                                                        v-if="
                                                            selectedMethod ===
                                                            'mobile'
                                                        "
                                                        class="w-3 h-3 text-white"
                                                        fill="currentColor"
                                                        viewBox="0 0 20 20"
                                                    >
                                                        <path
                                                            fill-rule="evenodd"
                                                            d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                                            clip-rule="evenodd"
                                                        />
                                                    </svg>
                                                </div>
                                            </div>
                                        </label>
                                    </div>
                                </div>

                                <!-- Dynamic Payment Forms -->
                                <div class="space-y-8">
                                    <!-- Stripe Card Form -->
                                    <div
                                        v-if="selectedMethod === 'stripe'"
                                        class="bg-gradient-to-br from-blue-50 to-indigo-100 rounded-2xl p-8 border border-blue-200 shadow-lg"
                                    >
                                        <h4
                                            class="font-bold text-2xl text-gray-900 mb-6 flex items-center"
                                        >
                                            <div
                                                class="w-12 h-12 bg-blue-500 rounded-xl flex items-center justify-center mr-4 shadow-lg"
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
                                                        d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"
                                                    ></path>
                                                </svg>
                                            </div>
                                            Card Details
                                        </h4>
                                        <div class="space-y-6">
                                            <div>
                                                <label
                                                    class="block text-lg font-semibold text-gray-700 mb-3"
                                                >
                                                    Cardholder Name
                                                </label>
                                                <input
                                                    v-model="
                                                        stripeData.cardName
                                                    "
                                                    type="text"
                                                    placeholder="John Doe"
                                                    class="w-full px-6 py-4 border-2 border-gray-300 rounded-2xl focus:ring-4 focus:ring-blue-200 focus:border-blue-500 transition-all duration-200 text-lg"
                                                    :disabled="processing"
                                                />
                                            </div>
                                            <div>
                                                <label
                                                    class="block text-lg font-semibold text-gray-700 mb-3"
                                                >
                                                    Card Details
                                                </label>
                                                <div
                                                    id="card-element"
                                                    class="p-4 border-2 border-gray-300 rounded-2xl bg-white focus-within:ring-4 focus-within:ring-blue-200 focus-within:border-blue-500 transition-all duration-200"
                                                ></div>
                                                <div
                                                    id="card-errors"
                                                    class="text-red-600 text-lg mt-3 font-medium"
                                                    role="alert"
                                                >
                                                    {{ stripeErrors }}
                                                </div>
                                            </div>
                                            <!-- Test Card Info -->
                                            <div
                                                class="bg-gradient-to-r from-green-100 to-emerald-200 border-2 border-green-300 rounded-2xl p-6"
                                            >
                                                <p
                                                    class="text-lg font-bold text-green-800 mb-3 flex items-center"
                                                >
                                                    <svg
                                                        class="w-5 h-5 mr-2"
                                                        fill="currentColor"
                                                        viewBox="0 0 20 20"
                                                    >
                                                        <path
                                                            fill-rule="evenodd"
                                                            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                                            clip-rule="evenodd"
                                                        />
                                                    </svg>
                                                    Test Card Information
                                                </p>
                                                <div
                                                    class="grid grid-cols-1 md:grid-cols-2 gap-3 text-sm text-green-700"
                                                >
                                                    <div>
                                                        <span
                                                            class="font-semibold"
                                                            >Card Number:</span
                                                        >
                                                        4242 4242 4242 4242
                                                    </div>
                                                    <div>
                                                        <span
                                                            class="font-semibold"
                                                            >Expiry:</span
                                                        >
                                                        12/34
                                                    </div>
                                                    <div>
                                                        <span
                                                            class="font-semibold"
                                                            >CVC:</span
                                                        >
                                                        123
                                                    </div>
                                                    <div>
                                                        <span
                                                            class="font-semibold"
                                                            >ZIP:</span
                                                        >
                                                        12345
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- bKash Form -->
                                    <div
                                        v-if="selectedMethod === 'bkash'"
                                        class="bg-gradient-to-br from-green-50 to-emerald-100 rounded-2xl p-8 border border-green-200 shadow-lg"
                                    >
                                        <h4
                                            class="font-bold text-2xl text-gray-900 mb-6 flex items-center"
                                        >
                                            <div
                                                class="w-12 h-12 bg-green-500 rounded-xl flex items-center justify-center mr-4 shadow-lg"
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
                                                        d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"
                                                    ></path>
                                                </svg>
                                            </div>
                                            bKash Payment
                                        </h4>
                                        <div class="space-y-6">
                                            <div>
                                                <label
                                                    class="block text-lg font-semibold text-gray-700 mb-3"
                                                >
                                                    bKash Mobile Number
                                                </label>
                                                <input
                                                    v-model="
                                                        bkashData.mobileNumber
                                                    "
                                                    type="text"
                                                    placeholder="01XXXXXXXXX"
                                                    class="w-full px-6 py-4 border-2 border-gray-300 rounded-2xl focus:ring-4 focus:ring-green-200 focus:border-green-500 transition-all duration-200 text-lg"
                                                    :disabled="processing"
                                                />
                                            </div>
                                            <div>
                                                <label
                                                    class="block text-lg font-semibold text-gray-700 mb-3"
                                                >
                                                    Transaction ID
                                                </label>
                                                <input
                                                    v-model="
                                                        bkashData.transactionId
                                                    "
                                                    type="text"
                                                    placeholder="Enter transaction ID"
                                                    class="w-full px-6 py-4 border-2 border-gray-300 rounded-2xl focus:ring-4 focus:ring-green-200 focus:border-green-500 transition-all duration-200 text-lg"
                                                    :disabled="processing"
                                                />
                                            </div>
                                            <div
                                                class="bg-gradient-to-r from-yellow-100 to-amber-200 border-2 border-yellow-300 rounded-2xl p-6"
                                            >
                                                <p
                                                    class="text-lg font-bold text-yellow-800 mb-3 flex items-center"
                                                >
                                                    <svg
                                                        class="w-5 h-5 mr-2"
                                                        fill="currentColor"
                                                        viewBox="0 0 20 20"
                                                    >
                                                        <path
                                                            fill-rule="evenodd"
                                                            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                                            clip-rule="evenodd"
                                                        />
                                                    </svg>
                                                    Payment Instructions
                                                </p>
                                                <ol
                                                    class="text-sm text-yellow-800 space-y-2"
                                                >
                                                    <li
                                                        class="flex items-center"
                                                    >
                                                        <span
                                                            class="w-6 h-6 bg-yellow-500 text-white rounded-full flex items-center justify-center mr-3 text-sm"
                                                            >1</span
                                                        >
                                                        Go to your bKash app
                                                    </li>
                                                    <li
                                                        class="flex items-center"
                                                    >
                                                        <span
                                                            class="w-6 h-6 bg-yellow-500 text-white rounded-full flex items-center justify-center mr-3 text-sm"
                                                            >2</span
                                                        >
                                                        Send ৳{{
                                                            order.total_amount
                                                        }}
                                                        to 01795547756
                                                    </li>
                                                    <li
                                                        class="flex items-center"
                                                    >
                                                        <span
                                                            class="w-6 h-6 bg-yellow-500 text-white rounded-full flex items-center justify-center mr-3 text-sm"
                                                            >3</span
                                                        >
                                                        Enter the transaction ID
                                                        above
                                                    </li>
                                                </ol>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Nagad Form -->
                                    <div
                                        v-if="selectedMethod === 'nagad'"
                                        class="bg-gradient-to-br from-purple-50 to-indigo-100 rounded-2xl p-8 border border-purple-200 shadow-lg"
                                    >
                                        <h4
                                            class="font-bold text-2xl text-gray-900 mb-6 flex items-center"
                                        >
                                            <div
                                                class="w-12 h-12 bg-purple-500 rounded-xl flex items-center justify-center mr-4 shadow-lg"
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
                                                        d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"
                                                    ></path>
                                                </svg>
                                            </div>
                                            Nagad Payment
                                        </h4>
                                        <div class="space-y-6">
                                            <div>
                                                <label
                                                    class="block text-lg font-semibold text-gray-700 mb-3"
                                                >
                                                    Nagad Mobile Number
                                                </label>
                                                <input
                                                    v-model="
                                                        nagadData.mobileNumber
                                                    "
                                                    type="text"
                                                    placeholder="01XXXXXXXXX"
                                                    class="w-full px-6 py-4 border-2 border-gray-300 rounded-2xl focus:ring-4 focus:ring-purple-200 focus:border-purple-500 transition-all duration-200 text-lg"
                                                    :disabled="processing"
                                                />
                                            </div>
                                            <div>
                                                <label
                                                    class="block text-lg font-semibold text-gray-700 mb-3"
                                                >
                                                    Transaction ID
                                                </label>
                                                <input
                                                    v-model="
                                                        nagadData.transactionId
                                                    "
                                                    type="text"
                                                    placeholder="Enter transaction ID"
                                                    class="w-full px-6 py-4 border-2 border-gray-300 rounded-2xl focus:ring-4 focus:ring-purple-200 focus:border-purple-500 transition-all duration-200 text-lg"
                                                    :disabled="processing"
                                                />
                                            </div>
                                            <div
                                                class="bg-gradient-to-r from-yellow-100 to-amber-200 border-2 border-yellow-300 rounded-2xl p-6"
                                            >
                                                <p
                                                    class="text-lg font-bold text-yellow-800 mb-3 flex items-center"
                                                >
                                                    <svg
                                                        class="w-5 h-5 mr-2"
                                                        fill="currentColor"
                                                        viewBox="0 0 20 20"
                                                    >
                                                        <path
                                                            fill-rule="evenodd"
                                                            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                                            clip-rule="evenodd"
                                                        />
                                                    </svg>
                                                    Payment Instructions
                                                </p>
                                                <ol
                                                    class="text-sm text-yellow-800 space-y-2"
                                                >
                                                    <li
                                                        class="flex items-center"
                                                    >
                                                        <span
                                                            class="w-6 h-6 bg-yellow-500 text-white rounded-full flex items-center justify-center mr-3 text-sm"
                                                            >1</span
                                                        >
                                                        Go to your Nagad app
                                                    </li>
                                                    <li
                                                        class="flex items-center"
                                                    >
                                                        <span
                                                            class="w-6 h-6 bg-yellow-500 text-white rounded-full flex items-center justify-center mr-3 text-sm"
                                                            >2</span
                                                        >
                                                        Send ৳{{
                                                            order.total_amount
                                                        }}
                                                        to 01795547756
                                                    </li>
                                                    <li
                                                        class="flex items-center"
                                                    >
                                                        <span
                                                            class="w-6 h-6 bg-yellow-500 text-white rounded-full flex items-center justify-center mr-3 text-sm"
                                                            >3</span
                                                        >
                                                        Enter the transaction ID
                                                        above
                                                    </li>
                                                </ol>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Mobile Banking Form -->
                                    <div
                                        v-if="selectedMethod === 'mobile'"
                                        class="bg-gradient-to-br from-orange-50 to-red-100 rounded-2xl p-8 border border-orange-200 shadow-lg"
                                    >
                                        <h4
                                            class="font-bold text-2xl text-gray-900 mb-6 flex items-center"
                                        >
                                            <div
                                                class="w-12 h-12 bg-orange-500 rounded-xl flex items-center justify-center mr-4 shadow-lg"
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
                                                        d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z"
                                                    ></path>
                                                </svg>
                                            </div>
                                            Mobile Banking
                                        </h4>
                                        <div class="space-y-6">
                                            <div>
                                                <label
                                                    class="block text-lg font-semibold text-gray-700 mb-3"
                                                >
                                                    Select Bank
                                                </label>
                                                <select
                                                    v-model="
                                                        mobileBankingData.bank
                                                    "
                                                    class="w-full px-6 py-4 border-2 border-gray-300 rounded-2xl focus:ring-4 focus:ring-orange-200 focus:border-orange-500 transition-all duration-200 text-lg"
                                                    :disabled="processing"
                                                >
                                                    <option value="">
                                                        Select your bank
                                                    </option>
                                                    <option value="rocket">
                                                        DBBL Rocket
                                                    </option>
                                                    <option value="mcash">
                                                        MCash
                                                    </option>
                                                    <option value="upay">
                                                        Upay
                                                    </option>
                                                    <option value="tap">
                                                        Tap
                                                    </option>
                                                </select>
                                            </div>
                                            <div>
                                                <label
                                                    class="block text-lg font-semibold text-gray-700 mb-3"
                                                >
                                                    Mobile Number
                                                </label>
                                                <input
                                                    v-model="
                                                        mobileBankingData.mobileNumber
                                                    "
                                                    type="text"
                                                    placeholder="01XXXXXXXXX"
                                                    class="w-full px-6 py-4 border-2 border-gray-300 rounded-2xl focus:ring-4 focus:ring-orange-200 focus:border-orange-500 transition-all duration-200 text-lg"
                                                    :disabled="processing"
                                                />
                                            </div>
                                            <div>
                                                <label
                                                    class="block text-lg font-semibold text-gray-700 mb-3"
                                                >
                                                    Transaction ID
                                                </label>
                                                <input
                                                    v-model="
                                                        mobileBankingData.transactionId
                                                    "
                                                    type="text"
                                                    placeholder="Enter transaction ID"
                                                    class="w-full px-6 py-4 border-2 border-gray-300 rounded-2xl focus:ring-4 focus:ring-orange-200 focus:border-orange-500 transition-all duration-200 text-lg"
                                                    :disabled="processing"
                                                />
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Mega Pay Button -->
                                <div
                                    class="mt-12 pt-8 border-t border-gray-200"
                                >
                                    <div class="text-center mb-6">
                                        <p
                                            class="text-2xl font-bold text-gray-900 mb-2"
                                        >
                                            Total to Pay
                                        </p>
                                        <p
                                            class="text-5xl font-extrabold bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent"
                                        >
                                            ৳{{ order.total_amount }}
                                        </p>
                                    </div>

                                    <button
                                        @click="proceedToPayment"
                                        :disabled="
                                            !selectedMethod || processing
                                        "
                                        class="w-full bg-blue-600 text-white py-3 px-6 rounded-lg hover:bg-blue-700 disabled:bg-gray-400 disabled:cursor-not-allowed transition-colors duration-200 font-medium text-base"
                                    >
                                        <div
                                            class="flex items-center justify-center"
                                        >
                                            <span v-if="processing">
                                                Processing Payment...
                                            </span>
                                            <span v-else>
                                                Complete Payment - ৳{{
                                                    order.total_amount
                                                }}
                                            </span>
                                        </div>
                                    </button>

                                    <p
                                        class="text-center text-gray-600 mt-4 text-lg flex items-center justify-center"
                                    >
                                        <svg
                                            class="w-5 h-5 mr-2 text-green-500"
                                            fill="currentColor"
                                            viewBox="0 0 20 20"
                                        >
                                            <path
                                                fill-rule="evenodd"
                                                d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z"
                                                clip-rule="evenodd"
                                            />
                                        </svg>
                                        Your payment is secure and encrypted
                                    </p>
                                </div>

                                <!-- Back to Cart -->
                                <div class="mt-8 text-center">
                                    <Link
                                        :href="route('cart.index')"
                                        class="inline-flex items-center text-blue-600 hover:text-blue-800 text-lg font-semibold transition-colors duration-200 group"
                                    >
                                        <svg
                                            class="w-6 h-6 mr-2 transform group-hover:-translate-x-1 transition-transform duration-200"
                                            fill="none"
                                            stroke="currentColor"
                                            viewBox="0 0 24 24"
                                        >
                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                stroke-width="2"
                                                d="M10 19l-7-7m0 0l7-7m-7 7h18"
                                            ></path>
                                        </svg>
                                        Return to Shopping Cart
                                    </Link>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<script setup>
import { ref, computed, onMounted, onUnmounted, watch } from "vue";
import { Link, router } from "@inertiajs/vue3";
import AppLayout from "@/Layouts/AppLayout.vue";

const props = defineProps({
    order: Object,
});

// Reactive variables
const selectedMethod = ref("");
const processing = ref(false);
const paymentError = ref("");
const stripe = ref(null);
const elements = ref(null);
const cardElement = ref(null);
const stripeErrors = ref("");
const cardComplete = ref(false);

// Payment data objects
const stripeData = ref({ cardName: "" });
const bkashData = ref({ mobileNumber: "", transactionId: "" });
const nagadData = ref({ mobileNumber: "", transactionId: "" });
const mobileBankingData = ref({
    bank: "",
    mobileNumber: "",
    transactionId: "",
});

// Form validation
const isFormValid = computed(() => {
    if (!selectedMethod.value) return false;

    switch (selectedMethod.value) {
        case "stripe":
            return stripeData.value.cardName && cardComplete.value;
        case "bkash":
            return (
                bkashData.value.mobileNumber && bkashData.value.transactionId
            );
        case "nagad":
            return (
                nagadData.value.mobileNumber && nagadData.value.transactionId
            );
        case "mobile":
            return (
                mobileBankingData.value.bank &&
                mobileBankingData.value.mobileNumber &&
                mobileBankingData.value.transactionId
            );
        default:
            return false;
    }
});

const getCsrfToken = () => {
    const metaTag = document.querySelector('meta[name="csrf-token"]');
    return metaTag ? metaTag.content : "";
};

// Stripe initialization
const initializeStripe = () => {
    if (window.Stripe) {
        stripe.value = window.Stripe(
            "pk_test_51SUOIWLDw8pO9GdRPSu8SbkBkg7upAahMQIVAdXOEPbA2WW3UslXZv0XHPLqZBSJEkgW6txlw5g4mYhGlAgX9TkC00buhRPNhN"
        );
        initializeCardElement();
        return;
    }

    const script = document.createElement("script");
    script.src = "https://js.stripe.com/v3/";
    script.onload = () => {
        stripe.value = window.Stripe(
            "pk_test_51SUOIWLDw8pO9GdRPSu8SbkBkg7upAahMQIVAdXOEPbA2WW3UslXZv0XHPLqZBSJEkgW6txlw5g4mYhGlAgX9TkC00buhRPNhN"
        );
        initializeCardElement();
    };
    document.head.appendChild(script);
};

const initializeCardElement = () => {
    if (!stripe.value) return;

    elements.value = stripe.value.elements();

    if (cardElement.value) {
        cardElement.value.destroy();
    }

    cardElement.value = elements.value.create("card", {
        style: {
            base: {
                fontSize: "18px",
                color: "#424770",
                "::placeholder": { color: "#aab7c4" },
                padding: "16px 14px",
            },
        },
    });

    cardElement.value.mount("#card-element");

    cardElement.value.on("change", (event) => {
        cardComplete.value = event.complete;
        stripeErrors.value = event.error ? event.error.message : "";
    });
};

// Payment processing
const processStripePayment = () => {
    processing.value = true;
    paymentError.value = "";
    stripeErrors.value = "";

    // Validation
    if (!stripeData.value.cardName) {
        paymentError.value = "Please enter cardholder name";
        processing.value = false;
        return;
    }
    if (!cardComplete.value) {
        paymentError.value = "Please complete card details";
        processing.value = false;
        return;
    }

    const csrfToken = getCsrfToken();
    if (!csrfToken) {
        paymentError.value = "Security token missing. Please refresh the page.";
        processing.value = false;
        return;
    }

    console.log("🔄 Creating payment intent...");

    // Create payment intent
    fetch(route("stripe.create-payment-intent"), {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": csrfToken,
            Accept: "application/json",
        },
        body: JSON.stringify({
            order_id: props.order.id,
            amount: props.order.total_amount,
        }),
    })
        .then((response) => {
            if (!response.ok) {
                return response.text().then((errorText) => {
                    throw new Error(
                        `Server error: ${response.status} - ${errorText}`
                    );
                });
            }
            return response.json();
        })
        .then((data) => {
            console.log("✅ Payment intent created:", data);

            if (!data.client_secret) {
                throw new Error(data.error || "No client secret received");
            }

            console.log("🔄 Confirming card payment...");

            // Confirm payment with Stripe
            return stripe.value.confirmCardPayment(data.client_secret, {
                payment_method: {
                    card: cardElement.value,
                    billing_details: { name: stripeData.value.cardName },
                },
            });
        })
        .then((result) => {
            if (result.error) {
                throw new Error(result.error.message);
            }

            console.log(
                "✅ Payment intent status:",
                result.paymentIntent.status
            );

            if (result.paymentIntent.status === "succeeded") {
                console.log("💰 Payment succeeded! Updating order...");
                return updateOrderStatus(result.paymentIntent.id);
            } else {
                throw new Error(
                    `Payment status: ${result.paymentIntent.status}`
                );
            }
        })
        .then(() => {
            console.log("🎉 Payment successful! Redirecting...");
            processing.value = false;

            window.location.href = route("payment.success");
        })
        .catch((error) => {
            console.error("💥 Stripe payment error:", error);
            paymentError.value = error.message;
            processing.value = false;
        });
};

const updateOrderStatus = (paymentIntentId) => {
    const csrfToken = getCsrfToken();

    return fetch(route("stripe.update-order"), {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": csrfToken,
            Accept: "application/json",
        },
        body: JSON.stringify({
            order_id: props.order.id,
            payment_intent_id: paymentIntentId,
        }),
    })
        .then((response) => {
            if (!response.ok) {
                throw new Error("Failed to update order status");
            }
            console.log("✅ Order updated successfully");
            return response.json();
        })
        .then((data) => {
            console.log("✅ Order updated successfully", data);
            if (data.redirect_url) {
                window.location.href = data.redirect_url;
            } else {
                window.location.href = route("payment.success");
            }
            return data;
        })
        .catch((error) => {
            console.error("Update order error:", error);
            throw error;
        });
};

const proceedToPayment = () => {
    if (!selectedMethod.value) {
        alert("Please select a payment method");
        return;
    }

    if (!isFormValid.value) {
        alert("Please complete the payment form");
        return;
    }

    processing.value = true;
    paymentError.value = "";

    if (selectedMethod.value === "stripe") {
        processStripePayment();
    } else {
        processOtherPayment();
    }
};

const processOtherPayment = () => {
    processing.value = true;

    router.post(
        route("payment.process.other"),
        {
            order_id: props.order.id,
            payment_method: selectedMethod.value,
            mobile_number:
                selectedMethod.value === "bkash"
                    ? bkashData.value.mobileNumber
                    : selectedMethod.value === "nagad"
                    ? nagadData.value.mobileNumber
                    : mobileBankingData.value.mobileNumber,
            transaction_id:
                selectedMethod.value === "bkash"
                    ? bkashData.value.transactionId
                    : selectedMethod.value === "nagad"
                    ? nagadData.value.transactionId
                    : mobileBankingData.value.transactionId,
            ...(selectedMethod.value === "mobile" && {
                bank: mobileBankingData.value.bank,
            }),
        },
        {
            onSuccess: () => {
                processing.value = false;
                window.location.href = route("payment.success");
            },
            onError: (errors) => {
                processing.value = false;
                paymentError.value =
                    errors.message || "Payment failed. Please try again.";
            },
        }
    );
};

// Watchers and lifecycle
watch(selectedMethod, (newMethod) => {
    if (newMethod === "stripe") {
        setTimeout(() => initializeStripe(), 100);
    } else {
        if (cardElement.value) {
            cardElement.value.destroy();
            cardElement.value = null;
        }
        stripeErrors.value = "";
        paymentError.value = "";
    }
});

onMounted(() => {
    console.log("Checkout component mounted");
    initializeStripe();
});

onUnmounted(() => {
    if (cardElement.value) cardElement.value.destroy();
});
</script>

<style scoped>
/* Custom animations */
@keyframes shimmer {
    0% {
        transform: translateX(-100%);
    }
    100% {
        transform: translateX(100%);
    }
}

.animate-shimmer {
    animation: shimmer 2s infinite;
}

/* Glass morphism effect */
.glass {
    background: rgba(255, 255, 255, 0.25);
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.18);
}
</style>
