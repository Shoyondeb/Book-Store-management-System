<template>
    <AdminLayout>
        <!-- Header Section -->
        <div class="mb-8">
            <div class="flex justify-between items-center">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">
                        Users Management
                    </h1>
                    <p class="mt-2 text-gray-600">
                        View and manage system users and their roles
                    </p>
                </div>
                <div class="text-sm text-gray-700">
                    Total: {{ totalUsers }} users
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
                        users?.from || 0
                    }}</span>
                    to
                    <span class="font-semibold text-gray-900">{{
                        users?.to || 0
                    }}</span>
                    of
                    <span class="font-semibold text-gray-900">{{
                        users?.total || 0
                    }}</span>
                    users
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
                            v-model="perPage"
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
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div
                class="bg-gradient-to-br from-blue-50 to-white p-6 rounded-2xl shadow-lg border border-blue-100"
            >
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">
                            Total Users
                        </p>
                        <p class="text-2xl font-bold text-gray-900 mt-1">
                            {{ totalUsers }}
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
                                d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5 1.195a4 4 0 01-2.83 1.195 4 4 0 01-2.83-1.195m0 0A4 4 0 0118 14.5a4 4 0 012.83 1.197M18 14.5a4 4 0 00-4-4 4 4 0 00-4 4"
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
                            Admin Users
                        </p>
                        <p class="text-2xl font-bold text-gray-900 mt-1">
                            {{ totalAdminCount }}
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
                                d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"
                            />
                        </svg>
                    </div>
                </div>
            </div>

            <div
                class="bg-gradient-to-br from-orange-50 to-white p-6 rounded-2xl shadow-lg border border-orange-100"
            >
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">
                            Customer Users
                        </p>
                        <p class="text-2xl font-bold text-gray-900 mt-1">
                            {{ totalCustomerCount }}
                        </p>
                    </div>
                    <div class="p-3 bg-orange-100 rounded-xl">
                        <svg
                            class="w-6 h-6 text-orange-600"
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
                </div>
            </div>
        </div>

        <!-- Users Table -->
        <div
            class="bg-white shadow-xl rounded-2xl overflow-hidden border border-gray-100"
        >
            <!-- Fixed Header -->
            <div
                class="px-6 py-5 bg-gradient-to-r from-gray-50 to-white border-b border-gray-200"
            >
                <div
                    class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4"
                >
                    <h3 class="text-xl font-bold text-gray-900">User List</h3>
                    <div class="text-sm text-gray-700">
                        Page {{ users.current_page }} of {{ users.last_page }}
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
                                User Details
                            </th>
                            <th
                                class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider"
                            >
                                Contact Information
                            </th>
                            <th
                                class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider"
                            >
                                Role
                            </th>
                            <th
                                class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider"
                            >
                                Status
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-100">
                        <tr
                            v-for="user in users.data"
                            :key="user.id"
                            class="hover:bg-gray-50 transition-colors duration-200"
                        >
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div
                                        class="h-12 w-12 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl shadow-sm flex items-center justify-center"
                                    >
                                        <span
                                            class="text-white font-bold text-sm"
                                        >
                                            {{ getUserInitials(user.name) }}
                                        </span>
                                    </div>
                                    <div class="ml-4">
                                        <div
                                            class="text-sm font-semibold text-gray-900"
                                        >
                                            {{ user.name }}
                                        </div>
                                        <div class="text-xs text-gray-500">
                                            ID: #{{ user.id }}
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td
                                class="px-6 py-4 whitespace-nowrap text-sm text-gray-600"
                            >
                                <div class="font-medium text-gray-900">
                                    {{ user.email }}
                                </div>
                            </td>
                            <td
                                v-if="user.email !== auth?.user?.email"
                                class="px-6 py-4 whitespace-nowrap"
                            >
                                <select
                                    v-model="user.role"
                                    @change="updateRole(user.id, user.role)"
                                    class="text-sm border rounded-lg px-3 py-1.5 font-medium focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors min-w-[140px]"
                                    :class="
                                        user.role === 'admin'
                                            ? 'bg-gradient-to-r from-purple-50 to-purple-100 border-purple-300 text-purple-700 hover:from-purple-100 hover:to-purple-50'
                                            : 'bg-gradient-to-r from-blue-50 to-blue-100 border-blue-300 text-blue-700 hover:from-blue-100 hover:to-blue-50'
                                    "
                                >
                                    <option value="customer" class="bg-white">
                                        👤 Customer
                                    </option>
                                    <option value="admin" class="bg-white">
                                        👑 Admin
                                    </option>
                                </select>
                            </td>
                            <td v-else class="px-6 py-4 whitespace-nowrap">
                                <span
                                    class="inline-flex items-center px-3 py-1.5 rounded-full text-sm font-medium bg-gradient-to-r from-purple-50 to-purple-100 border border-purple-300 text-purple-700"
                                    v-if="user.role == 'admin'"
                                >
                                    👑 Admin
                                </span>
                                <span class="bg-white" v-else>
                                    👤 Customer
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-600">
                                    <div class="font-medium">Member Since</div>
                                    <div class="text-gray-500">
                                        {{ formatDate(user.created_at) }}
                                    </div>
                                    <div class="mt-1">
                                        <span
                                            class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium"
                                            :class="
                                                getDaysSince(user.created_at) <
                                                30
                                                    ? 'bg-green-100 text-green-800'
                                                    : 'bg-gray-100 text-gray-800'
                                            "
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
                                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"
                                                />
                                            </svg>
                                            {{
                                                getDaysSince(user.created_at) <
                                                30
                                                    ? "New User"
                                                    : getDaysSince(
                                                          user.created_at
                                                      ) + " days"
                                            }}
                                        </span>
                                    </div>
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
                Page {{ users.current_page }} of {{ users.last_page }}
            </div>
            <Pagination :links="users.links" />
        </div>
    </AdminLayout>
</template>

<script setup>
import { ref } from "vue";
import { router } from "@inertiajs/vue3";
import AdminLayout from "@/Layouts/AdminLayout.vue";
import Pagination from "@/Components/Pagination.vue";

const props = defineProps({
    users: Object,
    auth: Object,
    per_page: {
        type: Number,
        default: 10,
    },
    totalUsers: Number,
    totalAdminCount: Number,
    totalCustomerCount: Number,
    search: String,
});

const perPage = ref(props.per_page);

const updatePerPage = () => {
    if (perPage.value < 1) perPage.value = 1;
    if (perPage.value > 100) perPage.value = 100;

    router.get(
        route("admin.users.list"),
        {
            per_page: perPage.value,
            search: props.search,
        },
        {
            preserveState: true,
            preserveScroll: true,
            replace: true,
        }
    );
};

const updateRole = (userId, newRole) => {
    router.patch(
        route("admin.users.updateRole", userId),
        {
            role: newRole,
        },
        {
            preserveScroll: true,
        }
    );
};

const formatDate = (date) => {
    return new Date(date).toLocaleDateString("en-US", {
        year: "numeric",
        month: "short",
        day: "numeric",
    });
};

const getDaysSince = (date) => {
    const created = new Date(date);
    const now = new Date();
    const diffTime = Math.abs(now - created);
    return Math.floor(diffTime / (1000 * 60 * 60 * 24));
};

const getUserInitials = (name) => {
    return name
        .split(" ")
        .map((part) => part.charAt(0))
        .join("")
        .toUpperCase()
        .slice(0, 2);
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
</style>
