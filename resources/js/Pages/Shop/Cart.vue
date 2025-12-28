<template>
    <AppLayout>
        <div class="max-w-7xl mx-auto px-4 py-10">
            <!-- Header -->
            <h1 class="text-4xl font-bold text-gray-900 mb-10 tracking-tight">
                🛒 Shopping Cart
            </h1>

            <!-- Empty Cart -->
            <div
                v-if="cartItems.length === 0"
                class="text-center py-20 bg-white shadow rounded-2xl"
            >
                <svg
                    class="mx-auto h-16 w-16 text-gray-400"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-2.5 5.5M7 13l2.5 5.5m0 0L17 21m-7.5-2.5h9"
                    />
                </svg>

                <h3 class="mt-4 text-xl font-semibold text-gray-800">
                    Your cart is empty
                </h3>
                <p class="mt-1 text-gray-500">
                    Start shopping to add items to your cart.
                </p>

                <div class="mt-6">
                    <Link
                        :href="route('shop.home')"
                        class="inline-flex items-center px-6 py-2.5 rounded-xl shadow bg-blue-600 text-white font-semibold hover:bg-blue-700 transition"
                    >
                        Continue Shopping
                    </Link>
                </div>
            </div>

            <!-- Cart Content -->
            <div v-else class="lg:grid lg:grid-cols-12 lg:gap-10">
                <!-- Cart Items & Address -->
                <div class="lg:col-span-7">
                    <!-- Cart Items -->
                    <div class="bg-white rounded-2xl shadow mb-6">
                        <ul class="divide-y divide-gray-200">
                            <li
                                v-for="item in cartItems"
                                :key="item.id"
                                class="p-6 hover:bg-gray-50 transition"
                            >
                                <div class="flex items-center">
                                    <img
                                        :src="item.image"
                                        :alt="item.title"
                                        class="w-24 h-24 object-cover rounded-xl shadow-sm"
                                        @error="handleImageError"
                                    />

                                    <div class="ml-6 flex-1">
                                        <div
                                            class="flex justify-between items-start"
                                        >
                                            <div>
                                                <h3
                                                    class="text-lg font-semibold text-gray-900"
                                                >
                                                    {{ item.title }}
                                                </h3>
                                                <div
                                                    class="mt-1 inline-flex items-center"
                                                >
                                                    <span
                                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium"
                                                        :class="
                                                            getStockBadgeClass(
                                                                item
                                                            )
                                                        "
                                                    >
                                                        <svg
                                                            class="w-3 h-3 mr-1"
                                                            fill="currentColor"
                                                            viewBox="0 0 20 20"
                                                        >
                                                            <path
                                                                d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"
                                                            />
                                                            <path
                                                                fill-rule="evenodd"
                                                                d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3zm-3 4a1 1 0 100 2h.01a1 1 0 100-2H7zm3 0a1 1 0 100 2h3a1 1 0 100-2h-3z"
                                                                clip-rule="evenodd"
                                                            />
                                                        </svg>
                                                        Stock:
                                                        {{ item.stock }} books
                                                    </span>
                                                    <span
                                                        v-if="
                                                            item.stock <= 5 &&
                                                            item.stock > 0
                                                        "
                                                        class="ml-2 inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800"
                                                    >
                                                        ⚡ Low stock
                                                    </span>
                                                </div>
                                            </div>
                                            <p
                                                class="text-lg font-bold text-blue-600"
                                            >
                                                ${{ item.subtotal.toFixed(2) }}
                                            </p>
                                        </div>

                                        <p class="mt-2 text-sm text-gray-500">
                                            by
                                            {{
                                                item.author?.name ||
                                                "Unknown Author"
                                            }}
                                        </p>

                                        <div class="mt-3">
                                            <div
                                                class="flex items-center justify-between text-xs text-gray-600 mb-1"
                                            >
                                                <span>Available stock</span>
                                                <span
                                                    >{{ item.quantity }} of
                                                    {{ item.stock }} in
                                                    cart</span
                                                >
                                            </div>
                                            <div
                                                class="w-full bg-gray-200 rounded-full h-2"
                                            >
                                                <div
                                                    class="h-2 rounded-full"
                                                    :class="
                                                        getStockProgressColor(
                                                            item
                                                        )
                                                    "
                                                    :style="{
                                                        width: `${Math.min(
                                                            (item.quantity /
                                                                item.stock) *
                                                                100,
                                                            100
                                                        )}%`,
                                                    }"
                                                ></div>
                                            </div>
                                            <div
                                                class="mt-1 text-xs text-gray-500"
                                            >
                                                <span
                                                    v-if="
                                                        item.stock -
                                                            item.quantity >
                                                        0
                                                    "
                                                >
                                                    {{
                                                        item.stock -
                                                        item.quantity
                                                    }}
                                                    more available
                                                </span>
                                                <span
                                                    v-else
                                                    class="text-red-600 font-medium"
                                                >
                                                    No more available
                                                </span>
                                            </div>
                                        </div>

                                        <div
                                            class="mt-4 flex items-center justify-between"
                                        >
                                            <div class="flex flex-col">
                                                <div
                                                    class="flex items-center border rounded-xl shadow-sm bg-white"
                                                >
                                                    <button
                                                        @click="
                                                            updateQuantity(
                                                                item,
                                                                item.quantity -
                                                                    1
                                                            )
                                                        "
                                                        class="px-3 py-1.5 text-gray-600 hover:bg-gray-200 rounded-l-xl transition disabled:opacity-50"
                                                        :disabled="
                                                            item.quantity <=
                                                                1 ||
                                                            processingItem ===
                                                                item.id
                                                        "
                                                    >
                                                        -
                                                    </button>
                                                    <span
                                                        class="px-4 py-1 text-gray-800 font-semibold min-w-[40px] text-center"
                                                    >
                                                        {{ item.quantity }}
                                                    </span>
                                                    <button
                                                        @click="
                                                            updateQuantity(
                                                                item,
                                                                item.quantity +
                                                                    1
                                                            )
                                                        "
                                                        class="px-3 py-1.5 text-gray-600 hover:bg-gray-200 rounded-r-xl transition disabled:opacity-50"
                                                        :disabled="
                                                            item.quantity >=
                                                                item.stock ||
                                                            processingItem ===
                                                                item.id
                                                        "
                                                    >
                                                        +
                                                    </button>
                                                </div>
                                                <p
                                                    class="mt-1 text-xs text-gray-500"
                                                >
                                                    <span
                                                        v-if="
                                                            item.quantity === 1
                                                        "
                                                        >1 book</span
                                                    >
                                                    <span v-else
                                                        >{{
                                                            item.quantity
                                                        }}
                                                        books</span
                                                    >
                                                    in cart
                                                </p>
                                            </div>

                                            <button
                                                @click="removeItem(item)"
                                                class="text-red-600 hover:text-red-700 font-medium transition disabled:opacity-50"
                                                :disabled="
                                                    processingItem === item.id
                                                "
                                            >
                                                {{
                                                    processingItem === item.id
                                                        ? "Removing..."
                                                        : "Remove"
                                                }}
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>

                    <!-- Shipping Address Section -->
                    <div class="bg-white rounded-2xl shadow p-6">
                        <div class="flex justify-between items-center mb-6">
                            <h2 class="text-xl font-bold text-gray-900">
                                <i
                                    class="fas fa-map-marker-alt mr-2 text-blue-600"
                                ></i>
                                Shipping Address
                            </h2>
                            <button
                                @click="openAddressForm()"
                                class="text-blue-600 hover:text-blue-800 font-medium text-sm flex items-center"
                            >
                                <i class="fas fa-plus mr-1"></i> Add New Address
                            </button>
                        </div>

                        <!-- Selected Address Display -->
                        <div v-if="selectedAddress" class="mb-6">
                            <div
                                class="border-2 border-blue-500 rounded-xl p-4 bg-blue-50"
                            >
                                <div class="flex justify-between items-start">
                                    <div>
                                        <div class="flex items-center mb-2">
                                            <span
                                                class="font-semibold text-gray-900"
                                                >{{
                                                    selectedAddress.full_name
                                                }}</span
                                            >
                                            <span
                                                v-if="
                                                    selectedAddress.is_default
                                                "
                                                class="ml-2 px-2 py-0.5 bg-green-100 text-green-800 text-xs font-medium rounded-full"
                                            >
                                                Default
                                            </span>
                                        </div>
                                        <p class="text-sm text-gray-600">
                                            {{ selectedAddress.phone }}
                                        </p>
                                        <p class="mt-2 text-sm text-gray-700">
                                            {{ selectedAddress.address_line1 }}
                                            <span
                                                v-if="
                                                    selectedAddress.address_line2
                                                "
                                                >,
                                                {{
                                                    selectedAddress.address_line2
                                                }}</span
                                            >
                                        </p>
                                        <p class="text-sm text-gray-700">
                                            {{ selectedAddress.city }},
                                            {{ selectedAddress.state }} -
                                            {{ selectedAddress.zip_code }}
                                        </p>
                                        <p class="text-sm text-gray-700">
                                            {{ selectedAddress.country }}
                                        </p>
                                    </div>
                                    <div class="flex space-x-2">
                                        <button
                                            @click="
                                                openAddressForm(selectedAddress)
                                            "
                                            class="text-blue-600 hover:text-blue-800"
                                            title="Edit"
                                        >
                                            <i class="fas fa-edit">Edit</i>
                                        </button>
                                        <button
                                            v-if="!selectedAddress.is_default"
                                            @click="
                                                deleteAddress(selectedAddress)
                                            "
                                            class="text-red-600 hover:text-red-800"
                                            title="Delete"
                                        >
                                            <i class="fas fa-trash">Delete</i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Address List for Selection -->
                        <div
                            v-if="addresses.length > 0"
                            class="grid md:grid-cols-2 gap-4"
                        >
                            <div
                                v-for="address in addresses"
                                :key="address.id"
                                @click="selectAddress(address)"
                                :class="[
                                    'border-2 rounded-xl p-4 cursor-pointer transition-all hover:shadow-md',
                                    selectedAddress?.id === address.id
                                        ? 'border-blue-500 bg-blue-50'
                                        : 'border-gray-200 hover:border-blue-300',
                                ]"
                            >
                                <div class="flex justify-between items-start">
                                    <div>
                                        <div class="flex items-center mb-2">
                                            <span
                                                class="font-semibold text-gray-900"
                                                >{{ address.full_name }}</span
                                            >
                                            <span
                                                v-if="address.is_default"
                                                class="ml-2 px-2 py-0.5 bg-green-100 text-green-800 text-xs font-medium rounded-full"
                                            >
                                                Default
                                            </span>
                                        </div>
                                        <p class="text-sm text-gray-600">
                                            {{ address.phone }}
                                        </p>
                                        <p class="mt-2 text-sm text-gray-700">
                                            {{ address.address_line1 }}
                                            <span v-if="address.address_line2"
                                                >,
                                                {{
                                                    address.address_line2
                                                }}</span
                                            >
                                        </p>
                                        <p class="text-sm text-gray-700">
                                            {{ address.city }},
                                            {{ address.state }} -
                                            {{ address.zip_code }}
                                        </p>
                                        <p class="text-sm text-gray-700">
                                            {{ address.country }}
                                        </p>
                                    </div>
                                    <div class="flex space-x-2">
                                        <button
                                            @click.stop="
                                                openAddressForm(address)
                                            "
                                            class="text-blue-600 hover:text-blue-800"
                                            title="Edit"
                                        >
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button
                                            v-if="!address.is_default"
                                            @click.stop="deleteAddress(address)"
                                            class="text-red-600 hover:text-red-800"
                                            title="Delete"
                                        >
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </div>

                                <div class="mt-3 pt-3 border-t border-gray-100">
                                    <button
                                        v-if="!address.is_default"
                                        @click.stop="setDefaultAddress(address)"
                                        class="text-sm text-blue-600 hover:text-blue-800"
                                    >
                                        Set as Default
                                    </button>
                                    <span
                                        v-else
                                        class="text-sm text-green-600 font-medium"
                                    >
                                        ✓ Default Shipping Address
                                    </span>
                                </div>
                            </div>
                        </div>

                        <!-- No Addresses Message -->
                        <div
                            v-if="addresses.length === 0"
                            class="text-center py-8"
                        >
                            <i
                                class="fas fa-map-marker-alt text-gray-400 text-4xl mb-4"
                            ></i>
                            <h3 class="text-lg font-semibold text-gray-700">
                                No Shipping Address Added
                            </h3>
                            <p class="text-gray-500 mt-1">
                                Please add a shipping address to continue
                            </p>
                            <button
                                @click="openAddressForm()"
                                class="mt-4 px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 font-medium"
                            >
                                <i class="fas fa-plus mr-2"></i> Add Your First
                                Address
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Summary -->
                <div class="mt-12 lg:mt-0 lg:col-span-5">
                    <div
                        class="bg-white rounded-2xl shadow-lg px-6 py-8 border border-gray-100"
                    >
                        <h2 class="text-xl font-bold text-gray-900">
                            Order Summary
                        </h2>

                        <div
                            class="mt-4 p-4 bg-blue-50 rounded-xl border border-blue-200"
                        >
                            <h3 class="font-semibold text-blue-900 mb-2">
                                📚 Stock Summary
                            </h3>
                            <div class="space-y-2 text-sm">
                                <div
                                    v-for="item in cartItems"
                                    :key="item.id"
                                    class="flex justify-between"
                                >
                                    <span
                                        class="text-gray-700 truncate max-w-[60%]"
                                        >{{ item.title }}</span
                                    >
                                    <span
                                        :class="
                                            item.quantity > item.stock
                                                ? 'text-red-600 font-semibold'
                                                : 'text-green-600'
                                        "
                                    >
                                        {{ item.quantity }}/{{ item.stock }}
                                    </span>
                                </div>
                            </div>
                            <div
                                class="mt-3 pt-3 border-t border-blue-200 text-xs text-blue-700"
                            >
                                <p v-if="!hasExceededStock">
                                    ✅ All items are within stock limits
                                </p>
                                <p v-else class="text-red-600 font-semibold">
                                    ⚠️ Some items exceed available stock
                                </p>
                            </div>
                        </div>

                        <div
                            v-if="hasExceededStock"
                            class="mt-4 p-3 bg-red-100 border border-red-300 rounded-xl text-red-700 font-medium"
                        >
                            ⚠️ {{ exceededStockCount }} item(s) exceed available
                            stock. Please adjust quantities before checkout.
                        </div>

                        <div
                            v-if="!selectedAddress && addresses.length > 0"
                            class="mt-4 p-3 bg-yellow-100 border border-yellow-300 rounded-xl text-yellow-700 font-medium"
                        >
                            ⚠️ Please select a shipping address to continue
                        </div>

                        <div class="mt-6 space-y-4">
                            <div class="flex justify-between text-gray-700">
                                <dt>Items ({{ totalItems }})</dt>
                                <dd class="font-semibold">
                                    {{ totalBooksText }}
                                </dd>
                            </div>
                            <div class="flex justify-between text-gray-700">
                                <dt>Subtotal</dt>
                                <dd class="font-semibold">
                                    ${{ total.toFixed(2) }}
                                </dd>
                            </div>
                            <div class="flex justify-between text-gray-700">
                                <dt>Shipping</dt>
                                <dd class="text-green-600 font-semibold">
                                    FREE
                                </dd>
                            </div>
                            <div
                                class="border-t pt-4 flex justify-between text-gray-900 text-lg font-bold"
                            >
                                <dt>Total</dt>
                                <dd>${{ total.toFixed(2) }}</dd>
                            </div>
                        </div>

                        <!-- Checkout Button -->
                        <div class="mt-8">
                            <button
                                @click="proceedToCheckout"
                                :disabled="
                                    hasExceededStock ||
                                    totalItems === 0 ||
                                    !selectedAddress
                                "
                                :class="[
                                    'block w-full text-center py-3 rounded-xl text-white font-semibold shadow transition',
                                    hasExceededStock ||
                                    totalItems === 0 ||
                                    !selectedAddress
                                        ? 'bg-gray-400 cursor-not-allowed'
                                        : 'bg-blue-600 hover:bg-blue-700',
                                ]"
                            >
                                {{
                                    !selectedAddress && addresses.length > 0
                                        ? "Select Shipping Address"
                                        : !selectedAddress
                                        ? "Add Shipping Address"
                                        : hasExceededStock
                                        ? "Cannot Checkout - Stock Issue"
                                        : totalItems === 0
                                        ? "Cart is Empty"
                                        : `Proceed to Checkout (${totalItems} items)`
                                }}
                            </button>
                        </div>

                        <p class="mt-6 text-center">
                            <Link
                                :href="route('shop.home')"
                                class="text-blue-600 hover:text-blue-500 font-medium"
                            >
                                ← Continue Shopping
                            </Link>
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Address Form Modal -->
        <div
            v-if="showAddressForm"
            class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4"
        >
            <div
                class="bg-white rounded-2xl max-w-md w-full max-h-[90vh] overflow-y-auto"
            >
                <div class="p-6">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-xl font-bold text-gray-900">
                            {{
                                editingAddress
                                    ? "Edit Address"
                                    : "Add New Address"
                            }}
                        </h2>
                        <button
                            @click="closeAddressForm"
                            class="text-gray-500 hover:text-gray-700"
                        >
                            <i class="fas fa-times"></i>
                        </button>
                    </div>

                    <form @submit.prevent="saveAddress">
                        <div class="space-y-4">
                            <div>
                                <label
                                    class="block text-sm font-medium text-gray-700 mb-1"
                                    >Full Name *</label
                                >
                                <input
                                    type="text"
                                    v-model="addressForm.full_name"
                                    required
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                    placeholder="Enter full name"
                                />
                            </div>

                            <div>
                                <label
                                    class="block text-sm font-medium text-gray-700 mb-1"
                                    >Phone Number *</label
                                >
                                <input
                                    type="tel"
                                    v-model="addressForm.phone"
                                    required
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                    placeholder="Enter phone number"
                                />
                            </div>

                            <div>
                                <label
                                    class="block text-sm font-medium text-gray-700 mb-1"
                                    >Country *</label
                                >
                                <select
                                    v-model="addressForm.country"
                                    required
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                >
                                    <option value="">Select Country</option>
                                    <option value="Bangladesh">
                                        Bangladesh
                                    </option>
                                    <option value="USA">United States</option>
                                    <option value="UK">United Kingdom</option>
                                </select>
                            </div>

                            <div>
                                <label
                                    class="block text-sm font-medium text-gray-700 mb-1"
                                    >Address Line 1 *</label
                                >
                                <input
                                    type="text"
                                    v-model="addressForm.address_line1"
                                    required
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                    placeholder="House no, Building, Street"
                                />
                            </div>

                            <div>
                                <label
                                    class="block text-sm font-medium text-gray-700 mb-1"
                                    >Address Line 2 (Optional)</label
                                >
                                <input
                                    type="text"
                                    v-model="addressForm.address_line2"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                    placeholder="Apartment, Suite, Unit"
                                />
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label
                                        class="block text-sm font-medium text-gray-700 mb-1"
                                        >City *</label
                                    >
                                    <input
                                        type="text"
                                        v-model="addressForm.city"
                                        required
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                        placeholder="City"
                                    />
                                </div>
                                <div>
                                    <label
                                        class="block text-sm font-medium text-gray-700 mb-1"
                                        >State/Province *</label
                                    >
                                    <input
                                        type="text"
                                        v-model="addressForm.state"
                                        required
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                        placeholder="State"
                                    />
                                </div>
                            </div>

                            <div>
                                <label
                                    class="block text-sm font-medium text-gray-700 mb-1"
                                    >ZIP/Postal Code *</label
                                >
                                <input
                                    type="text"
                                    v-model="addressForm.zip_code"
                                    required
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                    placeholder="ZIP/Postal Code"
                                />
                            </div>

                            <div class="flex items-center mt-4">
                                <input
                                    type="checkbox"
                                    id="set_default"
                                    v-model="addressForm.set_as_default"
                                    class="h-4 w-4 text-blue-600 rounded focus:ring-blue-500 border-gray-300"
                                />
                                <label
                                    for="set_default"
                                    class="ml-2 text-sm text-gray-700"
                                >
                                    Set as default shipping address
                                </label>
                            </div>
                        </div>

                        <div class="mt-8 flex space-x-3">
                            <button
                                type="button"
                                @click="closeAddressForm"
                                class="flex-1 px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 font-medium"
                            >
                                Cancel
                            </button>
                            <button
                                type="submit"
                                :disabled="savingAddress"
                                class="flex-1 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 font-medium disabled:opacity-50"
                            >
                                {{
                                    savingAddress ? "Saving..." : "Save Address"
                                }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<script setup>
import { ref, computed, reactive, onMounted, watch } from "vue";
import { Link, router } from "@inertiajs/vue3";
import AppLayout from "@/Layouts/AppLayout.vue";

const props = defineProps({
    cartItems: Array,
    total: Number,
    addresses: Array,
    defaultAddress: Object,
});

// Cart state
const cartState = reactive({
    items: [...props.cartItems],
    processingItem: null,
    updating: false,
});

// Address state
const showAddressForm = ref(false);
const editingAddress = ref(null);
const savingAddress = ref(false);
const selectedAddress = ref(props.defaultAddress || null);
const addresses = ref([...props.addresses]);

// Address form
const addressForm = reactive({
    full_name: "",
    phone: "",
    address_line1: "",
    address_line2: "",
    city: "",
    state: "",
    zip_code: "",
    country: "Bangladesh",
    set_as_default: false,
});

// Watch for props changes
watch(
    () => props.addresses,
    (newAddresses) => {
        addresses.value = [...newAddresses];
    },
    { immediate: true }
);

// Stock helper functions
const getStockBadgeClass = (item) => {
    if (item.stock === 0) return "bg-red-100 text-red-800";
    if (item.stock <= 5) return "bg-yellow-100 text-yellow-800";
    if (item.stock <= 10) return "bg-blue-100 text-blue-800";
    return "bg-green-100 text-green-800";
};

const getStockProgressColor = (item) => {
    const percentage = (item.quantity / item.stock) * 100;
    if (percentage > 100) return "bg-red-500";
    if (percentage > 80) return "bg-yellow-500";
    return "bg-green-500";
};

// Computed properties
const hasExceededStock = computed(() => {
    return cartState.items.some((item) => item.quantity > item.stock);
});

const exceededStockCount = computed(() => {
    return cartState.items.filter((item) => item.quantity > item.stock).length;
});

const totalItems = computed(() => {
    return cartState.items.length;
});

const totalBooks = computed(() => {
    return cartState.items.reduce((sum, item) => sum + item.quantity, 0);
});

const totalBooksText = computed(() => {
    return totalBooks.value === 1 ? "1 book" : `${totalBooks.value} books`;
});

const total = computed(() => {
    return cartState.items.reduce((sum, item) => sum + item.subtotal, 0);
});

// Cart functions
const updateQuantity = async (item, newQuantity) => {
    if (newQuantity < 1) return;
    if (newQuantity === item.quantity) return;

    const originalQuantity = item.quantity;
    item.quantity = newQuantity;
    item.subtotal = item.price * newQuantity;

    cartState.processingItem = item.id;
    cartState.updating = true;

    try {
        await router.put(
            route("cart.update", item.id),
            { quantity: newQuantity },
            {
                preserveScroll: true,
                preserveState: false,
                onError: (errors) => {
                    item.quantity = originalQuantity;
                    item.subtotal = item.price * originalQuantity;
                    alert(
                        errors.message ||
                            "Failed to update quantity. Please try again."
                    );
                },
            }
        );
    } catch (error) {
        item.quantity = originalQuantity;
        item.subtotal = item.price * originalQuantity;
        alert("Network error. Please try again.");
    } finally {
        setTimeout(() => {
            cartState.processingItem = null;
            cartState.updating = false;
        }, 300);
    }
};

const removeItem = async (item) => {
    if (!confirm("Are you sure you want to remove this item from your cart?"))
        return;

    cartState.processingItem = item.id;
    const itemIndex = cartState.items.findIndex((i) => i.id === item.id);

    if (itemIndex > -1) {
        cartState.items.splice(itemIndex, 1);
    }

    try {
        await router.delete(route("cart.remove", item.id), {
            preserveScroll: true,
            preserveState: false,
            onError: (errors) => {
                cartState.items.splice(itemIndex, 0, item);
                alert(
                    errors.message || "Failed to remove item. Please try again."
                );
            },
        });
    } catch (error) {
        cartState.items.splice(itemIndex, 0, item);
        alert("Failed to remove item. Please try again.");
    } finally {
        cartState.processingItem = null;
    }
};

// Address functions - FIXED VERSION
const selectAddress = (address) => {
    selectedAddress.value = address;
};

const openAddressForm = (address = null) => {
    editingAddress.value = address;
    if (address) {
        addressForm.full_name = address.full_name;
        addressForm.phone = address.phone;
        addressForm.address_line1 = address.address_line1;
        addressForm.address_line2 = address.address_line2 || "";
        addressForm.city = address.city;
        addressForm.state = address.state;
        addressForm.zip_code = address.zip_code;
        addressForm.country = address.country;
        addressForm.set_as_default = address.is_default;
    } else {
        Object.keys(addressForm).forEach((key) => {
            if (key !== "country") addressForm[key] = "";
        });
        addressForm.country = "Bangladesh";
        addressForm.set_as_default = false;
    }
    showAddressForm.value = true;
};

const closeAddressForm = () => {
    showAddressForm.value = false;
    editingAddress.value = null;
};

// FIXED: Save address function - uses proper route names
const saveAddress = async () => {
    savingAddress.value = true;

    try {
        if (editingAddress.value) {
            // UPDATE existing address - using proper route name
            await router.put(
                route("cart.address.update", {
                    address: editingAddress.value.id,
                }),
                addressForm,
                {
                    preserveScroll: true,
                    onSuccess: () => {
                        closeAddressForm();
                        router.reload({
                            only: [
                                "addresses",
                                "defaultAddress",
                                "cartItems",
                                "total",
                            ],
                        });
                    },
                    onError: (errors) => {
                        alert(errors.message || "Failed to update address");
                    },
                }
            );
        } else {
            // CREATE new address - using proper route name
            await router.post(route("cart.address.save"), addressForm, {
                preserveScroll: true,
                onSuccess: () => {
                    closeAddressForm();
                    router.reload({
                        only: [
                            "addresses",
                            "defaultAddress",
                            "cartItems",
                            "total",
                        ],
                    });
                },
                onError: (errors) => {
                    alert(errors.message || "Failed to save address");
                },
            });
        }
    } catch (error) {
        alert("Failed to save address. Please try again.");
    } finally {
        savingAddress.value = false;
    }
};

// FIXED: Delete address function - uses proper route name
const deleteAddress = async (address) => {
    if (!confirm("Are you sure you want to delete this address?")) return;

    try {
        await router.delete(
            route("cart.address.delete", { address: address.id }),
            {
                preserveScroll: true,
                onSuccess: () => {
                    if (selectedAddress.value?.id === address.id) {
                        selectedAddress.value = null;
                    }
                    router.reload({
                        only: [
                            "addresses",
                            "defaultAddress",
                            "cartItems",
                            "total",
                        ],
                    });
                },
                onError: (errors) => {
                    alert(errors.message || "Failed to delete address");
                },
            }
        );
    } catch (error) {
        alert("Failed to delete address");
    }
};

// FIXED: Set default address function - uses proper route name
const setDefaultAddress = async (address) => {
    try {
        await router.post(
            route("cart.address.set-default", { address: address.id }),
            {},
            {
                preserveScroll: true,
                onSuccess: () => {
                    selectedAddress.value = address;
                    router.reload({
                        only: [
                            "addresses",
                            "defaultAddress",
                            "cartItems",
                            "total",
                        ],
                    });
                },
                onError: (errors) => {
                    alert(errors.message || "Failed to set default address");
                },
            }
        );
    } catch (error) {
        alert("Failed to set default address");
    }
};

const proceedToCheckout = () => {
    if (!selectedAddress.value) {
        alert("Please select a shipping address");
        return;
    }

    router.post(
        route("cart.checkout"),
        {
            shipping_address_id: selectedAddress.value.id,
        },
        {
            onError: (errors) => {
                alert(
                    errors.message || "Failed to checkout. Please try again."
                );
            },
        }
    );
};

const handleImageError = (event) => {
    event.target.src = "/images/book-placeholder.png";
};

onMounted(() => {
    if (props.defaultAddress) {
        selectedAddress.value = props.defaultAddress;
    } else if (addresses.value && addresses.value.length > 0) {
        selectedAddress.value =
            addresses.value.find((addr) => addr.is_default) ||
            addresses.value[0];
    }
});
</script>

<style scoped>
.pointer-events-none {
    pointer-events: none;
}
</style>
