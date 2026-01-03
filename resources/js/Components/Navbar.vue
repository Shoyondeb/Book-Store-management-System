<template>
    <nav
        class="bg-white/80 backdrop-blur-md shadow-md fixed w-full top-0 z-50 border-b border-gray-200"
    >
        <div class="max-w-7xl mx-auto px-4 sm:px-4 lg:px-5">
            <div class="flex justify-between p-4 items-center">
                <!-- Logo -->
                <div class="flex items-center space-x-3">
                    <Link
                        :href="route('shop.home')"
                        class="flex items-center space-x-2 hover:opacity-90 transition"
                    >
                        <!-- Logo Image -->
                        <img
                            src="/images/logo2.png"
                            alt="Pustok Logo"
                            class="h-16 w-16 md:h-18 md:w-18 object-cover rounded-full bord border-gray-300"
                        />

                        <!-- Pustok Text -->
                        <div class="flex flex-col">
                            <span
                                class="text-2xl font-bold text-blue-600 leading-tight"
                            >
                                PUSTOK.com
                            </span>
                            <span
                                class="text-xs text-gray-500 font-medium -mt-1"
                            >
                                Online Bookstore
                            </span>
                        </div>
                    </Link>
                </div>

                <!-- Rest of your existing code remains the same -->
                <!-- Middle Nav -->
                <div class="hidden md:flex items-center space-x-6">
                    <Link
                        :href="route('shop.home')"
                        class="text-gray-700 hover:text-blue-600 font-medium transition hover:underline"
                    >
                        Shop
                    </Link>

                    <!-- Authors Dropdown -->
                    <div class="relative">
                        <button
                            @click="showAuthorsDropdown = !showAuthorsDropdown"
                            class="text-gray-700 hover:text-blue-600 font-medium transition flex items-center focus:outline-none"
                        >
                            Authors
                            <svg
                                class="ml-1 w-4 h-4"
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
                        </button>

                        <!-- Dropdown Menu -->
                        <div
                            v-show="showAuthorsDropdown"
                            class="absolute top-full left-0 mt-2 w-64 bg-white rounded-lg shadow-xl border border-gray-100 py-2 max-h-80 overflow-y-auto z-50 transition-transform transform scale-95 opacity-0 animate-fade-in scale-100 opacity-100"
                        >
                            <div
                                v-for="author in authors"
                                :key="author.id"
                                class="block px-4 py-2 text-sm text-gray-700 hover:bg-blue-50 cursor-pointer transition-colors"
                                @click="goToAuthor(author.id)"
                            >
                                {{ author.name }}
                            </div>

                            <div
                                v-if="authors.length === 0"
                                class="px-4 py-2 text-sm text-gray-500"
                            >
                                No authors available
                            </div>
                        </div>
                    </div>

                    <Link
                        :href="route('orders.history')"
                        class="text-gray-700 hover:text-blue-600 font-medium transition hover:underline"
                    >
                        Order History
                    </Link>
                </div>

                <!-- Right Nav (Cart & User) -->
                <div class="flex items-center space-x-4">
                    <!-- Cart -->
                    <Link
                        :href="route('cart.index')"
                        class="relative text-gray-700 hover:text-blue-600 transition transform hover:scale-110"
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
                                d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-2.5 5.5M7 13l2.5 5.5m0 0L17 21m-7.5-2.5h9"
                            />
                        </svg>
                        <span
                            v-if="cartCount > 0"
                            class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full w-5 h-5 text-xs flex items-center justify-center animate-pulse"
                        >
                            {{ cartCount }}
                        </span>
                    </Link>

                    <!-- Authenticated User -->
                    <div v-if="$page.props.auth.user" class="relative">
                        <button
                            @click="showUserMenu = !showUserMenu"
                            class="flex items-center text-gray-700 hover:text-blue-600 font-medium focus:outline-none transition hover:underline"
                        >
                            <!-- User Avatar with Initials -->
                            <div
                                class="w-8 h-8 bg-blue-600 text-white rounded-full flex items-center justify-center text-sm font-semibold mr-2"
                            >
                                {{
                                    getUserInitials($page.props.auth.user.name)
                                }}
                            </div>
                            <span class="hidden md:inline">{{
                                $page.props.auth.user.name
                            }}</span>
                            <svg
                                class="ml-1 w-4 h-4"
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
                        </button>

                        <!-- User Dropdown Menu -->
                        <div
                            v-show="showUserMenu"
                            class="absolute right-0 mt-2 w-64 bg-white rounded-lg shadow-xl border border-gray-100 py-2 animate-fade-in z-50"
                        >
                            <!-- User Info Section -->
                            <div class="px-4 py-3 border-b border-gray-100">
                                <div class="flex items-center space-x-3">
                                    <div
                                        class="w-10 h-10 bg-blue-600 text-white rounded-full flex items-center justify-center text-lg font-bold"
                                    >
                                        {{
                                            getUserInitials(
                                                $page.props.auth.user.name
                                            )
                                        }}
                                    </div>
                                    <div>
                                        <p class="font-semibold text-gray-900">
                                            {{ $page.props.auth.user.name }}
                                        </p>
                                        <p
                                            class="text-xs text-gray-500 truncate"
                                        >
                                            {{ $page.props.auth.user.email }}
                                        </p>
                                        <div class="mt-1">
                                            <span
                                                class="inline-block px-2 py-1 bg-blue-100 text-blue-800 text-xs font-medium rounded-full"
                                            >
                                                {{ $page.props.auth.user.role }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Menu Items -->
                            <div class="py-1">
                                <!-- Profile Link -->
                                <Link
                                    :href="route('profile.edit')"
                                    class="flex items-center px-4 py-3 text-sm text-gray-700 hover:bg-blue-50 transition-colors"
                                    @click="showUserMenu = false"
                                >
                                    <svg
                                        class="w-5 h-5 mr-3 text-blue-600"
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
                                    <div>
                                        <p class="font-medium">Edit Profile</p>
                                        <p class="text-xs text-gray-500">
                                            Update your personal information
                                        </p>
                                    </div>
                                </Link>

                                <!-- Divider -->
                                <div
                                    class="border-t border-gray-100 my-1"
                                ></div>

                                <!-- Admin Dashboard -->
                                <Link
                                    v-if="
                                        $page.props.auth.user.role === 'admin'
                                    "
                                    :href="route('admin.dashboard')"
                                    class="flex items-center px-4 py-3 text-sm text-gray-700 hover:bg-blue-50 transition-colors"
                                    @click="showUserMenu = false"
                                >
                                    <svg
                                        class="w-5 h-5 mr-3 text-blue-600"
                                        fill="none"
                                        stroke="currentColor"
                                        viewBox="0 0 24 24"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"
                                        />
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"
                                        />
                                    </svg>
                                    <div>
                                        <p class="font-medium">
                                            Admin Dashboard
                                        </p>
                                        <p class="text-xs text-gray-500">
                                            Manage the store
                                        </p>
                                    </div>
                                </Link>

                                <!-- Logout -->
                                <Link
                                    :href="route('logout')"
                                    method="post"
                                    as="button"
                                    class="flex items-center px-4 py-3 text-sm text-red-600 hover:bg-red-50 transition-colors w-full text-left"
                                    @click="showUserMenu = false"
                                >
                                    <svg
                                        class="w-5 h-5 mr-3"
                                        fill="none"
                                        stroke="currentColor"
                                        viewBox="0 0 24 24"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"
                                        />
                                    </svg>
                                    <div>
                                        <p class="font-medium">Log Out</p>
                                        <p class="text-xs text-red-500">
                                            Sign out of your account
                                        </p>
                                    </div>
                                </Link>
                            </div>

                            <!-- Footer -->
                            <div
                                class="px-4 py-2 bg-gray-50 border-t border-gray-100 rounded-b-lg"
                            >
                                <p class="text-xs text-gray-500">
                                    Member since
                                    {{
                                        formatJoinDate(
                                            $page.props.auth.user.created_at
                                        )
                                    }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Guest Links -->
                    <div v-else class="flex items-center space-x-3">
                        <Link
                            :href="route('login')"
                            class="text-gray-700 hover:text-blue-600 font-medium transition hover:underline"
                        >
                            Log in
                        </Link>
                        <Link
                            :href="route('register')"
                            class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition transform hover:scale-105"
                        >
                            Register
                        </Link>
                    </div>
                </div>
            </div>
        </div>
    </nav>
</template>

<script setup>
import { ref, computed, onMounted, onUnmounted, watch } from "vue";
import { Link, usePage, router } from "@inertiajs/vue3";

const showUserMenu = ref(false);
const showAuthorsDropdown = ref(false);

// REACTIVE cart count (for real-time updates)
const cartCount = ref(0);

// Computed cart count (for initial load from page props)
const initialCartCount = computed(() => {
    const cart = usePage().props.cart || {};
    return Object.values(cart).reduce((total, item) => {
        return total + (item.quantity || 0);
    }, 0);
});

const authors = computed(() => usePage().props.authors || []);

onMounted(() => {
    // Initialize cart count from page props
    cartCount.value = initialCartCount.value;

    // Listen for cart count updates from BookCard
    window.addEventListener("cart-count-updated", (event) => {
        cartCount.value = event.detail.count;
    });

    // Close dropdowns when clicking outside
    document.addEventListener("click", closeDropdowns);
});

onUnmounted(() => {
    window.removeEventListener("cart-count-updated", () => {});
    document.removeEventListener("click", closeDropdowns);
});

// Watch for page props changes (if page reloads or filters change)
watch(initialCartCount, (newCount) => {
    // Update cart count if page props change
    cartCount.value = newCount;
});

const closeDropdowns = (event) => {
    if (!event.target.closest(".relative")) {
        showAuthorsDropdown.value = false;
        showUserMenu.value = false;
    }
};

const goToAuthor = (authorId) => {
    showAuthorsDropdown.value = false;
    router.visit(route("authors.show", authorId));
};

// Helper functions
const getUserInitials = (name) => {
    if (!name) return "U";
    return name
        .split(" ")
        .map((n) => n[0])
        .join("")
        .toUpperCase()
        .slice(0, 2);
};

const formatJoinDate = (dateString) => {
    if (!dateString) return "Recently";
    const date = new Date(dateString);
    return date.toLocaleDateString("en-US", {
        month: "short",
        year: "numeric",
    });
};
</script>

<style scoped>
@keyframes fade-in {
    from {
        opacity: 0;
        transform: translateY(-4px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}
.animate-fade-in {
    animation: fade-in 0.2s ease-out forwards;
}

/* Custom scrollbar for dropdown */
.max-h-80::-webkit-scrollbar {
    width: 4px;
}
.max-h-80::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-radius: 4px;
}
.max-h-80::-webkit-scrollbar-thumb {
    background: #888;
    border-radius: 4px;
}
.max-h-80::-webkit-scrollbar-thumb:hover {
    background: #555;
}
</style>
