<template>
    <AdminLayout>
        <!-- Header Section -->
        <div class="mb-8">
            <div class="flex justify-between items-center">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">
                        Books Management
                    </h1>
                    <p class="mt-2 text-gray-600">
                        Manage your book inventory and catalog
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
                    <span>Add New Book</span>
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
                        books?.from || 0
                    }}</span>
                    to
                    <span class="font-semibold text-gray-900">{{
                        books?.to || 0
                    }}</span>
                    of
                    <span class="font-semibold text-gray-900">{{
                        books?.total || 0
                    }}</span>
                    books
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
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div
                class="bg-gradient-to-br from-blue-50 to-white p-6 rounded-2xl shadow-lg border border-blue-100"
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
                                d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"
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
                            Total Stock
                        </p>
                        <p class="text-2xl font-bold text-gray-900 mt-1">
                            {{ total_stock }}
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
                            Categories
                        </p>
                        <p class="text-2xl font-bold text-gray-900 mt-1">
                            {{ total_categories_count }}
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
                                d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"
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
                        <p class="text-sm font-medium text-gray-600">Authors</p>
                        <p class="text-2xl font-bold text-gray-900 mt-1">
                            {{ total_authors_count }}
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

        <!-- Books Table -->
        <div
            class="bg-white shadow-xl rounded-2xl overflow-hidden border border-gray-100"
        >
            <!-- Fixed Header with Search -->
            <div
                class="px-6 py-5 bg-gradient-to-r from-gray-50 to-white border-b border-gray-200"
            >
                <div
                    class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4"
                >
                    <h3 class="text-xl font-bold text-gray-900">
                        Book Catalog
                    </h3>
                    <div class="text-sm text-gray-700">
                        Page {{ books.current_page }} of {{ books.last_page }}
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
                                Book Details
                            </th>
                            <th
                                class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider"
                            >
                                Author
                            </th>
                            <th
                                class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider"
                            >
                                Category
                            </th>
                            <th
                                class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider"
                            >
                                Price
                            </th>
                            <th
                                class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider"
                            >
                                Stock
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
                            v-for="book in books.data"
                            :key="book.id"
                            class="hover:bg-gray-50 transition-colors duration-200"
                        >
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <img
                                        :src="book.image_url"
                                        :alt="book.title"
                                        class="h-12 w-12 object-cover rounded-xl shadow-sm"
                                    />
                                    <div class="ml-4">
                                        <div
                                            class="text-sm font-semibold text-gray-900"
                                        >
                                            {{ book.title }}
                                        </div>
                                        <div
                                            class="text-sm text-gray-500 line-clamp-1"
                                        >
                                            {{
                                                book.description?.substring(
                                                    0,
                                                    50
                                                )
                                            }}...
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span
                                    class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800"
                                >
                                    {{ book.author?.name || "Unknown Author" }}
                                </span>
                            </td>
                            <td
                                class="px-6 py-4 whitespace-nowrap text-sm text-gray-600"
                            >
                                {{ book.category?.name || "Uncategorized" }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span
                                    class="text-sm font-semibold text-gray-900"
                                >
                                    ${{ book.price }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <span
                                        class="text-sm font-medium px-2 py-1 rounded-full"
                                        :class="
                                            book.stock > 10
                                                ? 'bg-green-100 text-green-800'
                                                : book.stock > 0
                                                ? 'bg-yellow-100 text-yellow-800'
                                                : 'bg-red-100 text-red-800'
                                        "
                                    >
                                        {{ book.stock }}
                                    </span>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center space-x-2">
                                    <button
                                        @click="editBook(book)"
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
                                        @click="deleteBook(book)"
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
                Page {{ books.current_page }} of {{ books.last_page }}
            </div>
            <Pagination :links="books.links" />
        </div>

        <!-- Add/Edit Book Modal -->
        <div
            v-if="showAddModal || showEditModal"
            class="fixed inset-0 bg-black bg-opacity-50 overflow-y-auto h-full w-full z-50 transition-opacity duration-300"
        >
            <div class="relative top-10 mx-auto p-5 w-full max-w-2xl">
                <div
                    class="bg-white rounded-2xl shadow-2xl border border-gray-200 transform transition-all duration-300 scale-100"
                >
                    <div
                        class="px-6 py-4 bg-gradient-to-r from-gray-50 to-white border-b border-gray-200 rounded-t-2xl"
                    >
                        <h3 class="text-xl font-bold text-gray-900">
                            {{ showAddModal ? "Add New Book" : "Edit Book" }}
                        </h3>
                    </div>

                    <div class="p-6 max-h-[70vh] overflow-y-auto">
                        <form @submit.prevent="submitForm" class="space-y-4">
                            <!-- Current Book Cover (Only in Edit Mode) -->
                            <div
                                v-if="showEditModal && editingBook?.image_url"
                                class="text-center mb-4"
                            >
                                <div>
                                    <p
                                        class="text-sm font-medium text-gray-700 mb-2"
                                    >
                                        Current Book Cover
                                    </p>
                                    <div class="inline-block relative">
                                        <img
                                            :src="editingBook.image_url"
                                            :alt="editingBook.title"
                                            class="h-32 w-24 object-cover rounded-xl shadow-lg border-2 border-blue-100 mx-auto"
                                        />
                                        <div
                                            class="absolute -bottom-2 -right-2 bg-blue-100 text-blue-700 text-xs font-medium px-2 py-1 rounded-full"
                                        >
                                            Current
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- In the form section of the modal, add this field -->

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label
                                        class="block text-sm font-medium text-gray-700 mb-2"
                                        >Title</label
                                    >
                                    <input
                                        v-model="form.title"
                                        type="text"
                                        class="w-full border border-gray-300 rounded-xl shadow-sm p-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all"
                                        required
                                        placeholder="Enter book title"
                                    />
                                </div>

                                <div>
                                    <label
                                        class="block text-sm font-medium text-gray-700 mb-2"
                                        >Author</label
                                    >
                                    <select
                                        v-model="form.author_id"
                                        class="w-full border border-gray-300 rounded-xl shadow-sm p-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all"
                                        required
                                    >
                                        <option value="">Select Author</option>
                                        <option
                                            v-for="author in authors"
                                            :key="author.id"
                                            :value="author.id"
                                        >
                                            {{ author.name }}
                                        </option>
                                    </select>
                                </div>
                            </div>

                            <!-- Add this new grid row for publisher -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label
                                        class="block text-sm font-medium text-gray-700 mb-2"
                                        >Publisher</label
                                    >
                                    <input
                                        v-model="form.publisher"
                                        type="text"
                                        class="w-full border border-gray-300 rounded-xl shadow-sm p-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all"
                                        placeholder="Enter publisher name"
                                    />
                                </div>
                            </div>

                            <div>
                                <label
                                    class="block text-sm font-medium text-gray-700 mb-2"
                                    >Description</label
                                >
                                <textarea
                                    v-model="form.description"
                                    rows="3"
                                    class="w-full border border-gray-300 rounded-xl shadow-sm p-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all"
                                    placeholder="Enter book description"
                                ></textarea>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div>
                                    <label
                                        class="block text-sm font-medium text-gray-700 mb-2"
                                        >Price ($)</label
                                    >
                                    <input
                                        v-model="form.price"
                                        type="number"
                                        step="0.01"
                                        class="w-full border border-gray-300 rounded-xl shadow-sm p-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all"
                                        required
                                        placeholder="0.00"
                                    />
                                </div>

                                <div>
                                    <label
                                        class="block text-sm font-medium text-gray-700 mb-2"
                                        >Stock</label
                                    >
                                    <input
                                        v-model="form.stock"
                                        type="number"
                                        class="w-full border border-gray-300 rounded-xl shadow-sm p-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all"
                                        required
                                        placeholder="0"
                                    />
                                </div>

                                <div>
                                    <label
                                        class="block text-sm font-medium text-gray-700 mb-2"
                                        >Category</label
                                    >
                                    <select
                                        v-model="form.category_id"
                                        class="w-full border border-gray-300 rounded-xl shadow-sm p-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all"
                                        required
                                    >
                                        <option value="">
                                            Select Category
                                        </option>
                                        <option
                                            v-for="category in categories"
                                            :key="category.id"
                                            :value="category.id"
                                        >
                                            {{ category.name }}
                                        </option>
                                    </select>
                                </div>
                            </div>

                            <div>
                                <label
                                    class="block text-sm font-medium text-gray-700 mb-2"
                                >
                                    {{
                                        showEditModal
                                            ? "Update Book Cover"
                                            : "Book Cover"
                                    }}
                                    <span
                                        class="text-gray-500 text-sm font-normal"
                                        >(optional)</span
                                    >
                                </label>

                                <!-- Image Upload Area -->
                                <div
                                    class="border-2 border-dashed border-gray-300 rounded-xl p-6 text-center hover:border-blue-400 transition-colors cursor-pointer relative"
                                    @click="triggerFileInput"
                                >
                                    <input
                                        type="file"
                                        @change="handleImageUpload"
                                        class="hidden"
                                        id="book-image"
                                        accept="image/*"
                                        ref="fileInput"
                                    />

                                    <!-- Show preview if new image selected -->
                                    <div v-if="imagePreview" class="mb-4">
                                        <p
                                            class="text-sm font-medium text-gray-700 mb-2"
                                        >
                                            New Cover Preview:
                                        </p>
                                        <img
                                            :src="imagePreview"
                                            alt="Preview"
                                            class="h-32 w-24 object-cover rounded-xl shadow-md mx-auto border border-gray-200"
                                        />
                                    </div>

                                    <!-- Default upload UI -->
                                    <div v-else>
                                        <svg
                                            class="w-10 h-10 text-gray-400 mx-auto mb-3"
                                            fill="none"
                                            stroke="currentColor"
                                            viewBox="0 0 24 24"
                                        >
                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                stroke-width="2"
                                                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"
                                            />
                                        </svg>
                                        <span
                                            class="text-sm text-gray-600 block"
                                        >
                                            {{
                                                showEditModal
                                                    ? "Click to update book cover"
                                                    : "Click to upload book cover"
                                            }}
                                        </span>
                                        <p class="text-xs text-gray-500 mt-1">
                                            Optional, max 2MB
                                        </p>
                                        <p
                                            v-if="
                                                showEditModal &&
                                                editingBook?.image_url
                                            "
                                            class="text-xs text-blue-600 mt-2"
                                        >
                                            Leave empty to keep current cover
                                        </p>
                                    </div>

                                    <!-- Clear selection button -->
                                    <button
                                        v-if="imagePreview || form.image"
                                        type="button"
                                        @click.stop="clearImageSelection"
                                        class="absolute top-2 right-2 text-gray-400 hover:text-red-500 bg-white rounded-full p-1"
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
                                                d="M6 18L18 6M6 6l12 12"
                                            />
                                        </svg>
                                    </button>
                                </div>

                                <!-- Show current image filename in edit mode -->
                                <div
                                    v-if="
                                        showEditModal &&
                                        editingBook?.image_url &&
                                        !form.image &&
                                        !imagePreview
                                    "
                                    class="mt-2 text-center"
                                >
                                    <p class="text-xs text-gray-500">
                                        Current file:
                                        {{ getFileName(editingBook.image_url) }}
                                    </p>
                                </div>
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
                                            ? "Add Book"
                                            : "Update Book"
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
import { ref, computed } from "vue"; // Add computed to imports
import { router, useForm } from "@inertiajs/vue3";
import AdminLayout from "@/Layouts/AdminLayout.vue";
import Pagination from "@/Components/Pagination.vue";

const props = defineProps({
    books: Object,
    categories: Array,
    authors: Array,
    per_page: {
        type: Number,
        default: 10,
    },
    total_books_count: Number,
    total_stock: Number,
    total_categories_count: Number,
    total_authors_count: Number,
    total_value: [Number, String],
    average_price: [Number, String],
});

const showAddModal = ref(false);
const showEditModal = ref(false);
const editingBook = ref(null);
const perPage = ref(props.per_page);
const imagePreview = ref(null);
const fileInput = ref(null);

// Add computed properties for formatted values
const formattedTotalValue = computed(() => {
    return parseFloat(props.total_value || 0).toFixed(2);
});

const formattedAveragePrice = computed(() => {
    return parseFloat(props.average_price || 0).toFixed(2);
});

const form = useForm({
    title: "",
    author_id: "",
    description: "",
    publisher: "",
    price: "",
    stock: "",
    category_id: "",
    image: null,
});

const getFileName = (url) => {
    if (!url) return "No file";
    const parts = url.split("/");
    return parts[parts.length - 1];
};

const triggerFileInput = () => {
    fileInput.value.click();
};

const handleImageUpload = (event) => {
    const file = event.target.files[0];
    if (file) {
        form.image = file;

        // Create preview
        const reader = new FileReader();
        reader.onload = (e) => {
            imagePreview.value = e.target.result;
        };
        reader.readAsDataURL(file);
    }
};

const clearImageSelection = () => {
    form.image = null;
    imagePreview.value = null;
    if (fileInput.value) {
        fileInput.value.value = "";
    }
};

const updatePerPage = () => {
    if (perPage.value < 1) perPage.value = 1;
    if (perPage.value > 100) perPage.value = 100;

    router.get(
        route("admin.books.index"),
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

// const getTotalStock = () => {
//     return props.books.data.reduce(
//         (total, book) => total + (book.stock || 0),
//         0
//     );
// };

const submitForm = () => {
    if (showAddModal.value) {
        form.post(route("admin.books.store"), {
            onSuccess: () => {
                closeModal();
                form.reset();
                imagePreview.value = null;
            },
        });
    } else {
        const formData = new FormData();
        formData.append("_method", "PUT");
        formData.append("title", form.title);
        formData.append("author_id", form.author_id);
        formData.append("publisher", form.publisher || "");
        formData.append("description", form.description || "");
        formData.append("price", form.price);
        formData.append("stock", form.stock);
        formData.append("category_id", form.category_id);

        if (form.image) {
            formData.append("image", form.image);
        }

        router.post(
            route("admin.books.update", editingBook.value.id),
            formData,
            {
                onSuccess: () => {
                    closeModal();
                    form.reset();
                    imagePreview.value = null;
                },
            }
        );
    }
};

const editBook = (book) => {
    editingBook.value = book;
    form.title = book.title;
    form.author_id = book.author_id;
    form.description = book.description;
    form.publisher = book.publisher || "";
    form.price = book.price;
    form.stock = book.stock;
    form.category_id = book.category_id;
    form.image = null;
    imagePreview.value = null;
    showEditModal.value = true;
};

const deleteBook = (book) => {
    if (confirm("Are you sure you want to delete this book?")) {
        router.delete(route("admin.books.destroy", book.id), {
            preserveScroll: true,
            preserveState: true,
        });
    }
};

const closeModal = () => {
    showAddModal.value = false;
    showEditModal.value = false;
    editingBook.value = null;
    form.reset();
    form.clearErrors();
    imagePreview.value = null;
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
