<template>
    <Head title="Profile" />

    <AppLayout>
        <Navbar />
        <template #header>
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-2xl font-bold text-gray-900">
                        Profile Settings
                    </h2>
                    <p class="mt-1 text-sm text-gray-600">
                        Manage your account and security preferences
                    </p>
                </div>
                <div class="flex items-center space-x-2">
                    <span
                        class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800"
                    >
                        {{ $page.props.auth?.user?.role || "User" }}
                    </span>
                </div>
            </div>
        </template>

        <div class="py-8">
            <!-- Success Message -->
            <div
                v-if="$page.props.flash?.success"
                class="mb-6 mx-auto max-w-7xl"
            >
                <div
                    class="p-4 bg-green-50 border border-green-200 rounded-xl shadow-sm"
                >
                    <div class="flex items-center">
                        <svg
                            class="w-5 h-5 text-green-500 mr-3"
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
                        <span class="text-green-700 font-medium">{{
                            $page.props.flash.success
                        }}</span>
                    </div>
                </div>
            </div>

            <!-- Error Message -->
            <div v-if="$page.props.flash?.error" class="mb-6 mx-auto max-w-7xl">
                <div
                    class="p-4 bg-red-50 border border-red-200 rounded-xl shadow-sm"
                >
                    <div class="flex items-center">
                        <svg
                            class="w-5 h-5 text-red-500 mr-3"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.698-.833-2.464 0L4.197 16.5c-.77.833.192 2.5 1.732 2.5z"
                            />
                        </svg>
                        <span class="text-red-700 font-medium">{{
                            $page.props.flash.error
                        }}</span>
                    </div>
                </div>
            </div>

            <div class="mx-auto max-w-7xl">
                <!-- User Profile Header -->
                <div
                    class="mb-8 bg-gradient-to-r from-blue-600 to-indigo-600 rounded-2xl shadow-xl overflow-hidden"
                >
                    <div class="p-8">
                        <div
                            class="flex flex-col md:flex-row items-center md:items-start space-y-6 md:space-y-0 md:space-x-8"
                        >
                            <!-- User Avatar -->
                            <div class="relative">
                                <div
                                    class="w-20 h-20 bg-white/20 backdrop-blur-sm rounded-full flex items-center justify-center text-white text-2xl font-bold border-4 border-white/30 shadow-xl"
                                >
                                    {{
                                        getUserInitials(
                                            $page.props.auth?.user?.name
                                        )
                                    }}
                                </div>
                                <div
                                    class="absolute -bottom-2 -right-2 w-8 h-8 bg-white rounded-full flex items-center justify-center shadow-lg"
                                >
                                    <svg
                                        class="w-4 h-4 text-blue-600"
                                        fill="none"
                                        stroke="currentColor"
                                        viewBox="0 0 24 24"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"
                                        />
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"
                                        />
                                    </svg>
                                </div>
                            </div>

                            <!-- User Info -->
                            <div class="text-center md:text-left">
                                <h2 class="text-2xl font-bold text-white mb-2">
                                    {{ $page.props.auth?.user?.name || "User" }}
                                </h2>
                                <p class="text-blue-100 mb-3">
                                    {{
                                        $page.props.auth?.user?.email ||
                                        "No email provided"
                                    }}
                                </p>
                                <div
                                    class="flex flex-wrap gap-2 justify-center md:justify-start"
                                >
                                    <span
                                        class="inline-block px-3 py-1 bg-white/20 text-white text-sm font-medium rounded-full backdrop-blur-sm"
                                    >
                                        Member since
                                        {{
                                            formatJoinDate(
                                                $page.props.auth?.user
                                                    ?.created_at
                                            )
                                        }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Profile Sections Grid -->
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    <!-- Left Column: Profile Info -->
                    <div class="lg:col-span-2 space-y-8">
                        <!-- Update Profile Information Card -->
                        <div
                            class="bg-white rounded-2xl shadow-lg overflow-hidden"
                        >
                            <div class="p-6 border-b border-gray-100">
                                <div class="flex items-center mb-4">
                                    <div
                                        class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center mr-4"
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
                                    </div>
                                    <div>
                                        <h3
                                            class="text-lg font-bold text-gray-900"
                                        >
                                            Profile Information
                                        </h3>
                                        <p class="text-gray-600 text-sm">
                                            Update your name and email address
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="p-6">
                                <UpdateProfileInformationForm
                                    :must-verify-email="mustVerifyEmail"
                                    :status="status"
                                    class="max-w-2xl"
                                />
                            </div>
                        </div>

                        <!-- Update Password Card -->
                        <div
                            class="bg-white rounded-2xl shadow-lg overflow-hidden"
                        >
                            <div class="p-6 border-b border-gray-100">
                                <div class="flex items-center mb-4">
                                    <div
                                        class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center mr-4"
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
                                                d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"
                                            />
                                        </svg>
                                    </div>
                                    <div>
                                        <h3
                                            class="text-lg font-bold text-gray-900"
                                        >
                                            Update Password
                                        </h3>
                                        <p class="text-gray-600 text-sm">
                                            Ensure your account is using a
                                            secure password
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="p-6">
                                <UpdatePasswordForm class="max-w-2xl" />
                            </div>
                        </div>
                    </div>

                    <!-- Right Column: Delete Account & Stats -->
                    <div class="space-y-8">
                        <!-- Account Statistics -->
                        <div class="bg-white rounded-2xl shadow-lg p-6">
                            <h3 class="text-lg font-bold text-gray-900 mb-6">
                                Account Overview
                            </h3>
                            <div class="space-y-4">
                                <div
                                    class="flex items-center justify-between p-3 bg-gray-50 rounded-lg"
                                >
                                    <div class="flex items-center">
                                        <div
                                            class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center mr-3"
                                        >
                                            <svg
                                                class="w-4 h-4 text-blue-600"
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
                                        <span
                                            class="text-sm font-medium text-gray-700"
                                            >Member Since</span
                                        >
                                    </div>
                                    <span class="text-sm text-gray-600">{{
                                        formatJoinDate(
                                            $page.props.auth?.user?.created_at
                                        )
                                    }}</span>
                                </div>

                                <div
                                    class="flex items-center justify-between p-3 bg-gray-50 rounded-lg"
                                >
                                    <div class="flex items-center">
                                        <div
                                            class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center mr-3"
                                        >
                                            <svg
                                                class="w-4 h-4 text-green-600"
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
                                            class="text-sm font-medium text-gray-700"
                                            >Account Status</span
                                        >
                                    </div>
                                    <span
                                        class="text-sm font-medium text-green-600"
                                        >Active</span
                                    >
                                </div>

                                <div
                                    class="flex items-center justify-between p-3 bg-gray-50 rounded-lg"
                                >
                                    <div class="flex items-center">
                                        <div
                                            class="w-8 h-8 bg-purple-100 rounded-full flex items-center justify-center mr-3"
                                        >
                                            <svg
                                                class="w-4 h-4 text-purple-600"
                                                fill="none"
                                                stroke="currentColor"
                                                viewBox="0 0 24 24"
                                            >
                                                <path
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    stroke-width="2"
                                                    d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"
                                                />
                                            </svg>
                                        </div>
                                        <span
                                            class="text-sm font-medium text-gray-700"
                                            >Last Updated</span
                                        >
                                    </div>
                                    <span class="text-sm text-gray-600">{{
                                        formatLastUpdate(
                                            $page.props.auth?.user?.updated_at
                                        )
                                    }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Delete Account Card -->
                        <div
                            class="bg-white rounded-2xl shadow-lg overflow-hidden"
                        >
                            <div class="p-6 border-b border-gray-100">
                                <div class="flex items-center mb-4">
                                    <div
                                        class="w-10 h-10 bg-red-100 rounded-full flex items-center justify-center mr-4"
                                    >
                                        <svg
                                            class="w-5 h-5 text-red-600"
                                            fill="none"
                                            stroke="currentColor"
                                            viewBox="0 0 24 24"
                                        >
                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                stroke-width="2"
                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"
                                            />
                                        </svg>
                                    </div>
                                    <div>
                                        <h3
                                            class="text-lg font-bold text-gray-900"
                                        >
                                            Delete Account
                                        </h3>
                                        <p class="text-gray-600 text-sm">
                                            Permanently delete your account
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="p-6">
                                <DeleteUserForm />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import DeleteUserForm from "./Partials/DeleteUserForm.vue";
import UpdatePasswordForm from "./Partials/UpdatePasswordForm.vue";
import UpdateProfileInformationForm from "./Partials/UpdateProfileInformationForm.vue";
import { Head } from "@inertiajs/vue3";
import AppLayout from "@/Layouts/AppLayout.vue";

defineProps({
    mustVerifyEmail: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});

// Helper functions with safe access
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
    try {
        const date = new Date(dateString);
        return date.toLocaleDateString("en-US", {
            year: "numeric",
            month: "long",
            day: "numeric",
        });
    } catch {
        return "Recently";
    }
};

const formatLastUpdate = (dateString) => {
    if (!dateString) return "Never";
    try {
        const date = new Date(dateString);
        const now = new Date();
        const diffTime = Math.abs(now - date);
        const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));

        if (diffDays === 0) return "Today";
        if (diffDays === 1) return "Yesterday";
        if (diffDays < 7) return `${diffDays} days ago`;
        if (diffDays < 30) return `${Math.floor(diffDays / 7)} weeks ago`;
        return date.toLocaleDateString("en-US", {
            month: "short",
            day: "numeric",
        });
    } catch {
        return "Never";
    }
};
</script>
