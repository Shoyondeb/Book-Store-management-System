<template>
    <nav
        class="admin-navbar bg-gradient-to-r from-gray-800 to-gray-900 shadow-xl"
    >
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <!-- Left side: Logo/Brand -->
                <div class="flex items-center">
                    <!-- Logo/Icon -->
                    <div class="flex items-center space-x-3">
                        <div
                            class="w-8 h-8 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-lg flex items-center justify-center shadow-lg"
                        >
                            <svg
                                class="w-4 h-4 text-white"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"
                                />
                            </svg>
                        </div>
                        <div>
                            <h1 class="text-xl font-bold text-white">
                                Admin Panel
                            </h1>
                            <p class="text-xs text-gray-400">
                                Dashboard Management
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Right side: User Menu & Notifications -->
                <div class="flex items-center space-x-4">
                    <!-- User Menu -->
                    <div class="relative">
                        <button
                            @click="showUserMenu = !showUserMenu"
                            class="flex items-center space-x-3 p-1 rounded-lg hover:bg-white/10 transition-all duration-200 group"
                        >
                            <!-- User Avatar -->
                            <div class="relative">
                                <div
                                    class="w-9 h-9 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-full flex items-center justify-center text-white text-sm font-semibold shadow-lg group-hover:scale-105 transition-transform"
                                >
                                    {{
                                        getUserInitials(
                                            $page.props.auth.user.name
                                        )
                                    }}
                                </div>
                                <div
                                    class="absolute -bottom-1 -right-1 w-4 h-4 bg-green-500 border-2 border-gray-900 rounded-full"
                                ></div>
                            </div>

                            <!-- User Info (hidden on mobile) -->
                            <div class="hidden md:block text-left">
                                <p class="text-sm font-medium text-white">
                                    {{ $page.props.auth.user.name }}
                                </p>
                                <p class="text-xs text-gray-400">
                                    {{ $page.props.auth.user.role }}
                                </p>
                            </div>

                            <!-- Dropdown Icon -->
                            <svg
                                class="w-4 h-4 text-gray-400 transition-transform duration-200"
                                :class="{ 'rotate-180': showUserMenu }"
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
                            v-show="showUserMenu"
                            @click="showUserMenu = false"
                            class="fixed inset-0 z-40 md:hidden"
                        ></div>

                        <div
                            v-show="showUserMenu"
                            class="absolute right-0 mt-2 w-72 bg-white rounded-2xl shadow-2xl border border-gray-100 overflow-hidden z-50 animate-dropdown"
                        >
                            <!-- User Info Header with Gradient -->
                            <div class="relative overflow-hidden">
                                <div
                                    class="absolute inset-0 bg-gradient-to-br from-blue-500 via-indigo-500 to-purple-600 opacity-90"
                                ></div>
                                <!-- <div
                                    class="absolute inset-0 bg-gradient-to-br from-blue-500/5 via-indigo-500/5 to-purple-600/5"
                                ></div> -->

                                <div class="relative p-5">
                                    <div class="flex items-center space-x-3">
                                        <!-- User Avatar with Glow Effect -->
                                        <div class="relative">
                                            <div
                                                class="absolute inset-0 bg-gradient-to-r from-blue-400 to-indigo-500 rounded-full blur-md opacity-60"
                                            ></div>
                                            <div
                                                class="relative w-12 h-12 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-full flex items-center justify-center text-white text-lg font-bold shadow-xl border-2 border-white"
                                            >
                                                {{
                                                    getUserInitials(
                                                        $page.props.auth.user
                                                            .name
                                                    )
                                                }}
                                            </div>
                                            <div
                                                class="absolute -bottom-1 -right-1 w-4 h-4 bg-gradient-to-r from-green-400 to-green-500 border-2 border-white rounded-full shadow-md"
                                            ></div>
                                        </div>

                                        <!-- User Info -->
                                        <div class="flex-1 min-w-0">
                                            <p
                                                class="font-bold text-white text-lg truncate"
                                            >
                                                {{ $page.props.auth.user.name }}
                                            </p>
                                            <p
                                                class="text-sm text-blue-100 truncate mt-0.5"
                                            >
                                                {{
                                                    $page.props.auth.user.email
                                                }}
                                            </p>
                                            <div class="mt-2">
                                                <span
                                                    class="inline-flex items-center px-2.5 py-0.5 bg-white/20 backdrop-blur-sm text-white text-xs font-semibold rounded-full border border-white/30"
                                                >
                                                    <svg
                                                        class="w-3 h-3 mr-1"
                                                        fill="currentColor"
                                                        viewBox="0 0 20 20"
                                                    >
                                                        <path
                                                            fill-rule="evenodd"
                                                            d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"
                                                            clip-rule="evenodd"
                                                        />
                                                    </svg>
                                                    {{
                                                        $page.props.auth.user
                                                            .role
                                                    }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Menu Items -->
                            <div class="p-2">
                                <!-- Profile Settings -->
                                <Link
                                    :href="route('profile.edit')"
                                    class="group flex items-center w-full px-4 py-3 text-sm text-gray-700 hover:text-blue-600 rounded-xl hover:bg-gradient-to-r hover:from-blue-50 hover:to-indigo-50 transition-all duration-200 transform hover:translate-x-1"
                                >
                                    <div class="relative">
                                        <div
                                            class="w-9 h-9 bg-gradient-to-br from-blue-100 to-blue-50 rounded-lg flex items-center justify-center group-hover:from-blue-200 group-hover:to-blue-100 transition-all duration-200"
                                        >
                                            <svg
                                                class="w-4 h-4 text-blue-600 group-hover:scale-110 transition-transform"
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
                                        </div>
                                    </div>
                                    <div class="ml-3 flex-1">
                                        <span class="font-medium"
                                            >Profile Settings</span
                                        >
                                        <p
                                            class="text-xs text-gray-500 mt-0.5 group-hover:text-blue-500 transition-colors"
                                        >
                                            Manage your account
                                        </p>
                                    </div>
                                    <svg
                                        class="w-4 h-4 text-gray-300 group-hover:text-blue-500 transform group-hover:translate-x-1 transition-all duration-200"
                                        fill="none"
                                        stroke="currentColor"
                                        viewBox="0 0 24 24"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M9 5l7 7-7 7"
                                        />
                                    </svg>
                                </Link>

                                <!-- Divider -->
                                <div class="relative my-2 px-4">
                                    <div
                                        class="absolute inset-0 flex items-center"
                                    >
                                        <div
                                            class="w-full border-t border-gray-100"
                                        ></div>
                                    </div>
                                    <div class="relative flex justify-center">
                                        <span
                                            class="px-2 bg-white text-xs text-gray-400"
                                            >Account</span
                                        >
                                    </div>
                                </div>

                                <!-- Log Out -->
                                <Link
                                    :href="route('logout')"
                                    method="post"
                                    as="button"
                                    class="group flex items-center w-full px-4 py-3 text-sm text-red-600 hover:text-red-700 rounded-xl hover:bg-gradient-to-r hover:from-red-50 hover:to-pink-50 transition-all duration-200 transform hover:translate-x-1"
                                >
                                    <div class="relative">
                                        <div
                                            class="w-9 h-9 bg-gradient-to-br from-red-100 to-red-50 rounded-lg flex items-center justify-center group-hover:from-red-200 group-hover:to-red-100 transition-all duration-200"
                                        >
                                            <svg
                                                class="w-4 h-4 text-red-600 group-hover:scale-110 transition-transform"
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
                                        </div>
                                    </div>
                                    <div class="ml-3 flex-1">
                                        <span class="font-medium">Log Out</span>
                                        <p
                                            class="text-xs text-red-500/70 mt-0.5 group-hover:text-red-600 transition-colors"
                                        >
                                            Sign out from your account
                                        </p>
                                    </div>
                                    <svg
                                        class="w-4 h-4 text-red-300 group-hover:text-red-500 transform group-hover:translate-x-1 transition-all duration-200"
                                        fill="none"
                                        stroke="currentColor"
                                        viewBox="0 0 24 24"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M9 5l7 7-7 7"
                                        />
                                    </svg>
                                </Link>
                            </div>

                            <!-- Footer with Last Login -->
                            <div
                                class="border-t border-gray-100 bg-gray-50/50 backdrop-blur-sm"
                            >
                                <div class="px-4 py-3">
                                    <div
                                        class="flex items-center justify-between"
                                    >
                                        <div
                                            class="flex items-center space-x-2"
                                        >
                                            <div
                                                class="w-2 h-2 bg-green-400 rounded-full animate-pulse"
                                            ></div>
                                            <span
                                                class="text-xs text-gray-600 font-medium"
                                                >Online</span
                                            >
                                        </div>
                                        <div class="text-right">
                                            <p class="text-xs text-gray-500">
                                                Last login:
                                            </p>
                                            <p
                                                class="text-xs font-medium text-gray-700"
                                            >
                                                {{
                                                    formatLastLogin(
                                                        $page.props.auth.user
                                                            .last_login_at
                                                    )
                                                }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Decorative Corner -->
                            <div
                                class="absolute top-0 right-0 w-16 h-16 overflow-hidden"
                            >
                                <div
                                    class="absolute -top-8 -right-8 w-16 h-16 bg-gradient-to-br from-blue-400/20 to-purple-400/20 rounded-full"
                                ></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>
</template>

<script setup>
import { ref } from "vue";
import { Link } from "@inertiajs/vue3";

const showUserMenu = ref(false);

// Close dropdown when clicking outside
const handleClickOutside = (event) => {
    if (!event.target.closest(".relative")) {
        showUserMenu.value = false;
    }
};

// Add click outside listener
if (typeof window !== "undefined") {
    document.addEventListener("click", handleClickOutside);
}

// Helper functions
const getUserInitials = (name) => {
    if (!name) return "A";
    return name
        .split(" ")
        .map((n) => n[0])
        .join("")
        .toUpperCase()
        .slice(0, 2);
};

const formatLastLogin = (dateString) => {
    if (!dateString) return "Recently";
    const date = new Date(dateString);
    const now = new Date();
    const diffTime = Math.abs(now - date);
    const diffHours = Math.ceil(diffTime / (1000 * 60 * 60));

    if (diffHours < 1) return "Just now";
    if (diffHours === 1) return "1 hour ago";
    if (diffHours < 24) return `${diffHours} hours ago`;
    return date.toLocaleDateString("en-US", { month: "short", day: "numeric" });
};
</script>

<style scoped>
.admin-navbar {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    z-index: 1000;
    height: 4rem;
}

@keyframes fade-in {
    from {
        opacity: 0;
        transform: translateY(-10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.animate-fade-in {
    animation: fade-in 0.2s ease-out forwards;
}

/* Smooth transitions */
.transition-all {
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

/* Glass effect for dropdown */
.bg-white {
    backdrop-filter: blur(10px);
}

/* Custom scrollbar */
::-webkit-scrollbar {
    width: 6px;
}

::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-radius: 3px;
}

::-webkit-scrollbar-thumb {
    background: #888;
    border-radius: 3px;
}

::-webkit-scrollbar-thumb:hover {
    background: #555;
}
@keyframes dropdown {
    from {
        opacity: 0;
        transform: translateY(-10px) scale(0.95);
    }
    to {
        opacity: 1;
        transform: translateY(0) scale(1);
    }
}

.animate-dropdown {
    animation: dropdown 0.2s cubic-bezier(0.4, 0, 0.2, 1) forwards;
}

/* Hover effects for better interaction */
.hover\:translate-x-1:hover {
    transform: translateX(4px);
}

/* Smooth transitions */
.transition-all {
    transition-property: all;
    transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
    transition-duration: 200ms;
}

/* Glass effect */
.backdrop-blur-sm {
    backdrop-filter: blur(8px);
}
</style>
