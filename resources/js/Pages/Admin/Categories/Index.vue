<template>
    <AdminLayout>
        <!-- Header Section -->
        <div class="mb-8">
            <div class="flex justify-between items-center">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">
                        Categories Management
                    </h1>
                    <p class="mt-2 text-gray-600">
                        Manage your book categories and organization
                    </p>
                </div>
                <button
                    @click="showAddModal = true"
                    class="bg-gradient-to-r from-blue-500 to-blue-600 text-white px-6 py-3 rounded-xl hover:from-blue-600 hover:to-blue-700 shadow-lg hover:shadow-xl transition-all duration-300 flex items-center space-x-2"
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
                            d="M12 6v6m0 0v6m0-6h6m-6 0H6"
                        />
                    </svg>
                    <span>Add New Category</span>
                </button>
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
                        categories.from
                    }}</span>
                    to
                    <span class="font-semibold text-gray-900">{{
                        categories.to
                    }}</span>
                    of
                    <span class="font-semibold text-gray-900">{{
                        categories.total
                    }}</span>
                    categories
                </div>

                <!-- Items Per Page Select -->
                <div class="flex items-center space-x-4">
                    <label
                        for="perPage"
                        class="text-sm font-medium text-gray-700"
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
                            Total Categories
                        </p>
                        <p class="text-2xl font-bold text-gray-900 mt-1">
                            {{ total_categories_count }}
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
                                d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"
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
                            Active Categories
                        </p>
                        <p class="text-2xl font-bold text-gray-900 mt-1">
                            {{ active_categories_count }}
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
                            Total Books
                        </p>
                        <p class="text-2xl font-bold text-gray-900 mt-1">
                            {{ total_books_count }}
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
                                d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"
                            />
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Categories Table -->
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
                    <h3 class="text-xl font-bold text-gray-900">
                        Category List
                    </h3>
                    <div class="text-sm text-gray-700">
                        Page {{ categories.current_page }} of
                        {{ categories.last_page }}
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
                                Category Details
                            </th>
                            <th
                                class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider"
                            >
                                Books Count
                            </th>
                            <th
                                class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider"
                            >
                                Created
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
                            v-for="category in categories.data"
                            :key="category.id"
                            class="hover:bg-gray-50 transition-colors duration-200"
                        >
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div
                                        class="h-12 w-12 flex items-center justify-center bg-gradient-to-br from-purple-100 to-purple-50 rounded-xl shadow-sm"
                                    >
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
                                                d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"
                                            />
                                        </svg>
                                    </div>
                                    <div class="ml-4">
                                        <div
                                            class="text-sm font-semibold text-gray-900"
                                        >
                                            {{ category.name }}
                                        </div>
                                        <div class="text-sm text-gray-500">
                                            {{ category.slug }}
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span
                                    class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium"
                                    :class="
                                        category.books_count > 20
                                            ? 'bg-green-100 text-green-800'
                                            : category.books_count > 5
                                            ? 'bg-blue-100 text-blue-800'
                                            : 'bg-gray-100 text-gray-800'
                                    "
                                >
                                    {{ category.books_count }} books
                                </span>
                            </td>
                            <td
                                class="px-6 py-4 whitespace-nowrap text-sm text-gray-600"
                            >
                                {{ formatDate(category.created_at) }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center space-x-2">
                                    <button
                                        @click="editCategory(category)"
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
                                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"
                                            />
                                        </svg>
                                        Edit
                                    </button>
                                    <button
                                        @click="deleteCategory(category)"
                                        class="inline-flex items-center px-3 py-1.5 border border-red-300 text-sm font-medium rounded-lg text-red-700 bg-red-50 hover:bg-red-100 hover:border-red-400 transition-all duration-200"
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
                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"
                                            />
                                        </svg>
                                        Delete
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
                Page {{ categories.current_page }} of {{ categories.last_page }}
            </div>
            <Pagination :links="categories.links" />
        </div>

        <!-- Add/Edit Category Modal -->
        <div
            v-if="showAddModal || showEditModal"
            class="fixed inset-0 bg-black bg-opacity-50 overflow-y-auto h-full w-full z-50 transition-opacity duration-300"
        >
            <div class="relative top-10 mx-auto p-5 w-full max-w-md">
                <div
                    class="bg-white rounded-2xl shadow-2xl border border-gray-200 transform transition-all duration-300 scale-100"
                >
                    <div
                        class="px-6 py-4 bg-gradient-to-r from-gray-50 to-white border-b border-gray-200 rounded-t-2xl"
                    >
                        <h3 class="text-xl font-bold text-gray-900">
                            {{
                                showAddModal
                                    ? "Add New Category"
                                    : "Edit Category"
                            }}
                        </h3>
                    </div>

                    <div class="p-6">
                        <form @submit.prevent="submitForm" class="space-y-6">
                            <div>
                                <label
                                    class="block text-sm font-medium text-gray-700 mb-2"
                                    >Category Name</label
                                >
                                <input
                                    v-model="form.name"
                                    type="text"
                                    class="w-full border border-gray-300 rounded-xl shadow-sm p-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all"
                                    required
                                    placeholder="Enter category name"
                                />
                                <p class="mt-2 text-sm text-gray-500">
                                    Slug will be generated automatically
                                </p>
                            </div>

                            <div class="flex justify-end space-x-3 pt-4">
                                <button
                                    type="button"
                                    @click="closeModal"
                                    class="px-6 py-3 border border-gray-300 text-gray-700 rounded-xl hover:bg-gray-50 transition-all duration-200 font-medium"
                                >
                                    Cancel
                                </button>
                                <button
                                    type="submit"
                                    class="px-6 py-3 bg-gradient-to-r from-blue-500 to-blue-600 text-white rounded-xl hover:from-blue-600 hover:to-blue-700 shadow-lg transition-all duration-200 font-medium"
                                    :disabled="form.processing"
                                >
                                    {{
                                        form.processing
                                            ? "Processing..."
                                            : showAddModal
                                            ? "Add Category"
                                            : "Update Category"
                                    }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>

<script setup>
import { ref } from "vue";
import { router, useForm } from "@inertiajs/vue3";
import AdminLayout from "@/Layouts/AdminLayout.vue";
import Pagination from "@/Components/Pagination.vue";

const props = defineProps({
    categories: Object,
    per_page: {
        type: Number,
        default: 10,
    },
    total_categories_count: Number,
    active_categories_count: Number,
    total_books_count: Number,
});

const showAddModal = ref(false);
const showEditModal = ref(false);
const editingCategory = ref(null);
const perPage = ref(props.per_page);

const form = useForm({
    name: "",
});

// Remove these functions since we're getting the data from props
// const getActiveCategories = () => {
//     return props.categories.data.filter((cat) => cat.books_count > 0).length;
// };

// const getTotalBooks = () => {
//     return props.categories.data.reduce(
//         (total, category) => total + (category.books_count || 0),
//         0
//     );
// };

const updatePerPage = () => {
    if (perPage.value < 1) perPage.value = 1;
    if (perPage.value > 100) perPage.value = 100;

    router.get(
        route("admin.categories.index"),
        {
            per_page: perPage.value,
        },
        {
            preserveState: true,
            preserveScroll: true,
            replace: true,
        }
    );
};

const formatDate = (dateString) => {
    const date = new Date(dateString);
    return date.toLocaleDateString("en-US", {
        year: "numeric",
        month: "short",
        day: "numeric",
    });
};

const submitForm = () => {
    if (showAddModal.value) {
        form.post(route("admin.categories.store"), {
            onSuccess: () => {
                closeModal();
                form.reset();
            },
        });
    } else {
        form.put(route("admin.categories.update", editingCategory.value.id), {
            onSuccess: () => {
                closeModal();
                form.reset();
            },
        });
    }
};

const editCategory = (category) => {
    editingCategory.value = category;
    form.name = category.name;
    showEditModal.value = true;
};

const deleteCategory = (category) => {
    if (confirm("Are you sure you want to delete this category?")) {
        router.delete(route("admin.categories.destroy", category.id), {
            preserveScroll: true,
            preserveState: true,
        });
    }
};

const closeModal = () => {
    showAddModal.value = false;
    showEditModal.value = false;
    editingCategory.value = null;
    form.reset();
    form.clearErrors();
};
</script>
