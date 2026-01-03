<template>
    <AppLayout>
        <!-- Mobile Filter Button -->
        <div class="fixed bottom-6 right-6 z-40 md:hidden">
            <button
                @click="openMobileFilters()"
                class="flex items-center justify-center w-14 h-14 rounded-full bg-gradient-to-r from-blue-600 to-indigo-600 text-white shadow-lg hover:shadow-xl transition-all transform hover:scale-105 active:scale-95"
            >
                <svg
                    class="w-7 h-7"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"
                    />
                </svg>
                <span
                    v-if="activeFilterCount > 0"
                    class="absolute -top-1 -right-1 w-6 h-6 bg-red-500 text-xs font-bold rounded-full flex items-center justify-center border-2 border-white"
                >
                    {{ activeFilterCount }}
                </span>
            </button>
        </div>

        <!-- Mobile Filter Overlay -->
        <div
            v-if="showMobileFilters"
            class="fixed inset-0 bg-black bg-opacity-50 z-30 md:hidden"
            @click="showMobileFilters = false"
        ></div>

        <!-- Mobile Filter Panel -->
        <div
            v-if="showMobileFilters"
            class="fixed inset-x-0 bottom-0 z-40 bg-white rounded-t-3xl shadow-2xl md:hidden"
            style="max-height: 85vh"
        >
            <div class="p-6 overflow-y-auto h-full">
                <!-- Drag Handle -->
                <div class="flex justify-center mb-4">
                    <div class="w-12 h-1.5 bg-gray-300 rounded-full"></div>
                </div>

                <!-- Mobile Filter Header -->
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-bold text-gray-900">Filters</h2>
                    <button
                        @click="showMobileFilters = false"
                        class="p-2 hover:bg-gray-100 rounded-full"
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

                <!-- Mobile Search Input -->
                <div class="mb-6">
                    <label class="text-sm font-medium text-gray-700 mb-2 block"
                        >Search</label
                    >
                    <div class="relative">
                        <input
                            v-model="mobileForm.search"
                            type="text"
                            placeholder="Search books..."
                            class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-xl focus:border-blue-500 focus:ring-2 focus:ring-blue-200"
                        />
                        <svg
                            class="absolute left-3 top-1/2 transform -translate-y-1/2 w-5 h-5 text-gray-400"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"
                            />
                        </svg>
                    </div>
                </div>

                <!-- Mobile Category Filter -->
                <div class="mb-6">
                    <label class="text-sm font-medium text-gray-700 mb-2 block"
                        >Category</label
                    >
                    <select
                        v-model="mobileForm.category"
                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:border-blue-500 focus:ring-2 focus:ring-blue-200"
                    >
                        <option value="">All Categories</option>
                        <option
                            v-for="category in categories"
                            :key="category.id"
                            :value="category.id"
                        >
                            {{ category.name }}
                        </option>
                    </select>
                </div>

                <!-- Mobile Author Filter -->
                <div class="mb-6">
                    <label class="text-sm font-medium text-gray-700 mb-2 block"
                        >Author</label
                    >
                    <select
                        v-model="mobileForm.author"
                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:border-blue-500 focus:ring-2 focus:ring-blue-200"
                    >
                        <option value="">All Authors</option>
                        <option
                            v-for="author in authors"
                            :key="author.id"
                            :value="author.id"
                        >
                            {{ author.name }}
                        </option>
                    </select>
                </div>

                <!-- Mobile Price Range -->
                <div class="mb-6">
                    <label class="text-sm font-medium text-gray-700 mb-2 block"
                        >Price Range</label
                    >
                    <div class="grid grid-cols-2 gap-3">
                        <input
                            v-model="mobileForm.min_price"
                            type="number"
                            min="0"
                            placeholder="Min"
                            class="px-4 py-3 border border-gray-300 rounded-xl focus:border-blue-500 focus:ring-2 focus:ring-blue-200"
                        />
                        <input
                            v-model="mobileForm.max_price"
                            type="number"
                            min="0"
                            placeholder="Max"
                            class="px-4 py-3 border border-gray-300 rounded-xl focus:border-blue-500 focus:ring-2 focus:ring-blue-200"
                        />
                    </div>
                </div>

                <!-- Mobile Action Buttons -->
                <div class="pt-6 border-t border-gray-200 space-y-3">
                    <button
                        @click="applyMobileFilters()"
                        class="w-full py-3.5 bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-semibold rounded-xl hover:from-blue-700 hover:to-indigo-700"
                    >
                        Apply Filters
                    </button>
                    <button
                        @click="resetMobileFilters()"
                        class="w-full py-3.5 border-2 border-gray-300 text-gray-700 font-medium rounded-xl hover:bg-gray-50"
                    >
                        Reset All
                    </button>
                </div>
            </div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 sm:py-10">
            <!-- Page Header -->
            <div class="mb-8 sm:mb-12">
                <div class="text-center mb-10">
                    <h1
                        class="text-3xl sm:text-4xl lg:text-5xl font-extrabold text-gray-900 mb-4 tracking-tight"
                    >
                        Explore Books
                    </h1>
                    <p class="text-gray-600 text-lg">
                        Discover your next favorite read
                    </p>
                </div>

                <!-- Desktop Search and Filter Toggle -->
                <div class="hidden md:flex flex-col items-center gap-6 mb-10">
                    <!-- Search Bar with Button -->
                    <div class="w-full max-w-2xl">
                        <div class="relative">
                            <input
                                v-model="form.search"
                                type="text"
                                placeholder="Search books, authors, titles..."
                                class="w-full pl-14 pr-32 py-4 border-2 border-gray-300 rounded-2xl shadow-lg hover:shadow-xl focus:shadow-2xl focus:border-blue-500 focus:ring-4 focus:ring-blue-200 focus:ring-opacity-50 text-lg transition-all duration-200"
                                @input="onDesktopSearchInput"
                            />
                            <svg
                                class="absolute left-5 top-1/2 transform -translate-y-1/2 w-6 h-6 text-gray-400"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"
                                />
                            </svg>
                            <div
                                class="absolute right-2 top-1/2 transform -translate-y-1/2 flex items-center gap-2"
                            >
                                <button
                                    v-if="form.search"
                                    @click="clearSearch"
                                    class="p-2 text-gray-400 hover:text-gray-600 transition"
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
                                            d="M6 18L18 6M6 6l12 12"
                                        />
                                    </svg>
                                </button>
                                <div class="h-6 w-px bg-gray-300"></div>
                                <button
                                    @click="applyFilters"
                                    class="px-6 py-2 bg-blue-600 text-white font-semibold rounded-xl hover:bg-blue-700 transition shadow-md hover:shadow-lg"
                                >
                                    Search
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Filter Toggle Button -->
                    <div class="flex items-center gap-4">
                        <button
                            @click="showDesktopFilters = !showDesktopFilters"
                            class="flex items-center gap-3 px-6 py-3 rounded-xl bg-gradient-to-r from-blue-600 to-indigo-600 text-white shadow-lg hover:shadow-xl transition-all hover:-translate-y-0.5 active:translate-y-0 font-semibold"
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
                                    d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"
                                />
                            </svg>
                            {{
                                showDesktopFilters
                                    ? "Hide Filters"
                                    : "Show Filters"
                            }}
                            <span
                                v-if="activeFilterCount > 0"
                                class="ml-2 px-2 py-1 text-xs bg-white text-blue-600 rounded-full"
                            >
                                {{ activeFilterCount }}
                            </span>
                        </button>
                    </div>
                </div>

                <!-- Mobile Search (Hidden on desktop) -->
                <div class="md:hidden mb-6">
                    <div class="relative">
                        <input
                            v-model="form.search"
                            type="text"
                            placeholder="🔍 Search books..."
                            class="w-full pl-12 pr-4 py-3 border-2 border-gray-300 rounded-xl shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-200"
                            @input="onMobileSearchInput"
                        />
                        <svg
                            class="absolute left-4 top-1/2 transform -translate-y-1/2 w-5 h-5 text-gray-400"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"
                            />
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Desktop Filters -->
            <div
                v-if="showDesktopFilters"
                class="hidden md:block bg-white p-8 rounded-3xl shadow-2xl border border-gray-200 mb-10 transition-all duration-300"
            >
                <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
                    <!-- Category -->
                    <div>
                        <label
                            class="text-lg font-semibold text-gray-900 mb-3 flex items-center gap-3"
                        >
                            <div class="p-2 bg-blue-100 rounded-lg">
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
                            Category
                        </label>
                        <select
                            v-model="form.category"
                            class="w-full px-5 py-3.5 border-2 border-gray-300 rounded-xl shadow-sm focus:border-blue-500 focus:ring-4 focus:ring-blue-200 focus:ring-opacity-30 text-lg transition"
                        >
                            <option value="">All Categories</option>
                            <option
                                v-for="category in categories"
                                :key="category.id"
                                :value="category.id"
                            >
                                {{ category.name }}
                            </option>
                        </select>
                    </div>

                    <!-- Author -->
                    <div>
                        <label
                            class="text-lg font-semibold text-gray-900 mb-3 flex items-center gap-3"
                        >
                            <div class="p-2 bg-blue-100 rounded-lg">
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
                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"
                                    />
                                </svg>
                            </div>
                            Author
                        </label>
                        <select
                            v-model="form.author"
                            class="w-full px-5 py-3.5 border-2 border-gray-300 rounded-xl shadow-sm focus:border-blue-500 focus:ring-4 focus:ring-blue-200 focus:ring-opacity-30 text-lg transition"
                        >
                            <option value="">All Authors</option>
                            <option
                                v-for="author in authors"
                                :key="author.id"
                                :value="author.id"
                            >
                                {{ author.name }}
                            </option>
                        </select>
                    </div>

                    <!-- Min Price -->
                    <div>
                        <label
                            class="text-lg font-semibold text-gray-900 mb-3 flex items-center gap-3"
                        >
                            <div class="p-2 bg-blue-100 rounded-lg">
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
                                        d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"
                                    />
                                </svg>
                            </div>
                            Min Price
                        </label>
                        <div class="relative">
                            <span
                                class="absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-500 text-lg"
                                >$</span
                            >
                            <input
                                v-model="form.min_price"
                                type="number"
                                min="0"
                                placeholder="0"
                                class="w-full pl-10 pr-5 py-3.5 border-2 border-gray-300 rounded-xl shadow-sm focus:border-blue-500 focus:ring-4 focus:ring-blue-200 focus:ring-opacity-30 text-lg transition"
                            />
                        </div>
                    </div>

                    <!-- Max Price -->
                    <div>
                        <label
                            class="text-lg font-semibold text-gray-900 mb-3 flex items-center gap-3"
                        >
                            <div class="p-2 bg-blue-100 rounded-lg">
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
                                        d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"
                                    />
                                </svg>
                            </div>
                            Max Price
                        </label>
                        <div class="relative">
                            <span
                                class="absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-500 text-lg"
                                >$</span
                            >
                            <input
                                v-model="form.max_price"
                                type="number"
                                min="0"
                                placeholder="100"
                                class="w-full pl-10 pr-5 py-3.5 border-2 border-gray-300 rounded-xl shadow-sm focus:border-blue-500 focus:ring-4 focus:ring-blue-200 focus:ring-opacity-30 text-lg transition"
                            />
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div
                    class="mt-10 pt-8 border-t border-gray-200 flex justify-between items-center"
                >
                    <div class="flex items-center text-gray-700 text-lg">
                        <svg
                            class="w-6 h-6 mr-3 text-blue-600"
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
                        <span class="font-medium">{{ activeFilterCount }}</span>
                        <span class="ml-1">active filter(s)</span>
                    </div>
                    <div class="flex gap-4">
                        <button
                            @click="resetFilters"
                            class="px-8 py-3.5 rounded-xl border-3 border-gray-300 text-gray-800 font-semibold hover:bg-gray-50 active:bg-gray-100 transition flex items-center gap-3 text-lg"
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
                                    d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"
                                />
                            </svg>
                            Reset All
                        </button>
                        <button
                            @click="applyFilters"
                            class="px-10 py-3.5 rounded-xl bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-semibold hover:from-blue-700 hover:to-indigo-700 shadow-lg hover:shadow-xl transition flex items-center gap-3 text-lg"
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
                                    d="M5 13l4 4L19 7"
                                />
                            </svg>
                            Apply Filters
                        </button>
                    </div>
                </div>
            </div>

            <!-- Active Filters Bar -->
            <div
                v-if="activeFilterCount > 0"
                class="mb-8 p-5 bg-gradient-to-r from-blue-50 to-indigo-50 rounded-2xl border-2 border-blue-200 shadow-lg"
            >
                <div class="flex flex-wrap items-center gap-4">
                    <div class="flex items-center gap-3">
                        <svg
                            class="w-6 h-6 text-blue-700"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"
                            />
                        </svg>
                        <span class="text-lg font-bold text-blue-900"
                            >Active filters:</span
                        >
                    </div>

                    <template v-if="form.search">
                        <FilterPill @remove="removeFilter('search')">
                            🔍 Search: "{{ form.search }}"
                        </FilterPill>
                    </template>

                    <template v-if="form.category">
                        <FilterPill @remove="removeFilter('category')">
                            📚 {{ getCategoryName(form.category) }}
                        </FilterPill>
                    </template>

                    <template v-if="form.author">
                        <FilterPill @remove="removeFilter('author')">
                            👤 {{ getAuthorName(form.author) }}
                        </FilterPill>
                    </template>

                    <template v-if="form.min_price">
                        <FilterPill @remove="removeFilter('min_price')">
                            💰 Min: ${{ form.min_price }}
                        </FilterPill>
                    </template>

                    <template v-if="form.max_price">
                        <FilterPill @remove="removeFilter('max_price')">
                            💵 Max: ${{ form.max_price }}
                        </FilterPill>
                    </template>

                    <button
                        @click="resetFilters"
                        class="ml-auto px-5 py-2.5 rounded-xl bg-white border-2 border-blue-300 text-blue-700 hover:bg-blue-50 font-semibold flex items-center gap-2 transition"
                    >
                        Clear all
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
                                d="M6 18L18 6M6 6l12 12"
                            />
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Content Area -->
            <div>
                <!-- When No Filters -->
                <div v-if="!activeFilterCount" class="space-y-16">
                    <div
                        v-for="category in categoriesWithBooks"
                        :key="category.id"
                        class="relative group"
                    >
                        <!-- Category Header -->
                        <div
                            class="flex justify-between items-center mb-8 pb-4 border-b-2 border-gray-100"
                        >
                            <div>
                                <h2
                                    class="text-3xl font-bold text-gray-900 mb-2"
                                >
                                    {{ category.name }}
                                </h2>
                                <div class="flex items-center gap-4">
                                    <span
                                        class="px-4 py-1.5 rounded-full bg-gradient-to-r from-blue-100 to-indigo-100 text-blue-700 font-semibold"
                                    >
                                        {{ category.books.length }} books
                                    </span>
                                    <span class="text-gray-500">
                                        Browse our collection
                                    </span>
                                </div>
                            </div>
                            <button
                                @click="viewAllCategory(category)"
                                class="group-hover:translate-x-2 transition-transform px-6 py-2.5 rounded-xl bg-gradient-to-r from-blue-600 to-indigo-600 text-white hover:from-blue-700 hover:to-indigo-700 shadow-lg hover:shadow-xl font-semibold flex items-center gap-2"
                            >
                                View all
                                <svg
                                    class="w-5 h-5 group-hover:translate-x-1 transition-transform"
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

                        <!-- Books Grid -->
                        <div
                            class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8"
                        >
                            <BookCard
                                v-for="book in category.books.slice(0, 8)"
                                :key="book.id"
                                :book="book"
                            />
                        </div>
                    </div>
                </div>

                <!-- Filtered Results -->
                <div v-else>
                    <!-- Results Header -->
                    <div class="mb-12">
                        <h2 class="text-3xl font-bold text-gray-900 mb-3">
                            {{ getResultsTitle() }}
                        </h2>
                        <div class="flex items-center gap-6">
                            <p class="text-xl text-gray-700">
                                Found
                                <span class="font-bold text-gray-900">{{
                                    books.total
                                }}</span>
                                book{{ books.total !== 1 ? "s" : "" }}
                            </p>
                            <div class="flex items-center gap-2 text-gray-500">
                                <span>•</span>
                                <span>
                                    Page {{ books.current_page }} of
                                    {{ books.last_page }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Books Grid -->
                    <div
                        v-if="books.data.length > 0"
                        class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8"
                    >
                        <BookCard
                            v-for="book in books.data"
                            :key="book.id"
                            :book="book"
                        />
                    </div>

                    <!-- No Results -->
                    <div v-else class="text-center py-20">
                        <div class="w-32 h-32 mx-auto mb-8 text-gray-300">
                            <svg
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="1.5"
                                    d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"
                                />
                            </svg>
                        </div>
                        <h3 class="text-3xl font-bold text-gray-900 mb-4">
                            No books found
                        </h3>
                        <p class="text-gray-600 text-lg mb-8 max-w-md mx-auto">
                            Try adjusting your filters or search term to find
                            what you're looking for.
                        </p>
                        <button
                            @click="resetFilters"
                            class="px-8 py-3.5 rounded-xl bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-semibold hover:from-blue-700 hover:to-indigo-700 shadow-lg hover:shadow-xl transition text-lg"
                        >
                            Reset all filters
                        </button>
                    </div>

                    <!-- Pagination -->
                    <div v-if="books.data.length > 0" class="mt-16">
                        <Pagination :links="books.links" />
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<script setup>
import { ref, computed, watch, onMounted } from "vue";
import { router } from "@inertiajs/vue3";
import AppLayout from "@/Layouts/AppLayout.vue";
import BookCard from "@/Components/BookCard.vue";
import Pagination from "@/Components/Pagination.vue";
import FilterPill from "@/Components/FilterPill.vue";

const props = defineProps({
    books: Object,
    allBooks: Array, // Add this
    categories: Array,
    authors: Array,
    filters: Object,
});

// State
const showDesktopFilters = ref(false);
const showMobileFilters = ref(false);

// Forms - Main form for current active filters
const form = ref({
    search: props.filters.search || "",
    category: props.filters.category || "",
    author: props.filters.author || "",
    min_price: props.filters.min_price || "",
    max_price: props.filters.max_price || "",
});

// Mobile form for temporary changes in mobile panel
const mobileForm = ref({
    search: props.filters.search || "",
    category: props.filters.category || "",
    author: props.filters.author || "",
    min_price: props.filters.min_price || "",
    max_price: props.filters.max_price || "",
});

// Computed
const activeFilterCount = computed(() => {
    return Object.values(form.value).filter(
        (value) => value !== "" && value !== null
    ).length;
});

const categoriesWithBooks = computed(() => {
    return props.categories
        .map((category) => {
            const categoryBooks = props.allBooks.filter(
                // ✅ Use allBooks instead of books.data
                (book) => book.category_id === category.id
            );
            return {
                ...category,
                books: categoryBooks,
            };
        })
        .filter((category) => category.books.length > 0);
});

// Methods
const applyFilters = () => {
    router.get(route("shop.home"), form.value, {
        preserveState: true,
        replace: true,
    });
};

// Mobile Methods
const openMobileFilters = () => {
    // Sync mobile form with current filters
    mobileForm.value = { ...form.value };
    showMobileFilters.value = true;
};

const applyMobileFilters = () => {
    // Apply mobile form to main form
    form.value = { ...mobileForm.value };
    showMobileFilters.value = false;
    applyFilters();
};

const resetMobileFilters = () => {
    // Reset mobile form
    mobileForm.value = {
        search: "",
        category: "",
        author: "",
        min_price: "",
        max_price: "",
    };
};

const resetFilters = () => {
    form.value = {
        search: "",
        category: "",
        author: "",
        min_price: "",
        max_price: "",
    };
    mobileForm.value = {
        search: "",
        category: "",
        author: "",
        min_price: "",
        max_price: "",
    };
    applyFilters();
};

const removeFilter = (filterKey) => {
    form.value[filterKey] = "";
    applyFilters();
};

const viewAllCategory = (category) => {
    form.value.category = category.id;
    applyFilters();
};

const getResultsTitle = () => {
    if (form.value.search) return `Search results for "${form.value.search}"`;
    if (form.value.category) {
        const category = props.categories.find(
            (c) => c.id == form.value.category
        );
        return category ? `Books in "${category.name}"` : "Books by Category";
    }
    if (form.value.author) {
        const author = props.authors.find((a) => a.id == form.value.author);
        return author ? `Books by "${author.name}"` : "Books by Author";
    }
    return "Filtered Books";
};

const getCategoryName = (id) => {
    const category = props.categories.find((c) => c.id == id);
    return category ? category.name : "";
};

const getAuthorName = (id) => {
    const author = props.authors.find((a) => a.id == id);
    return author ? author.name : "";
};

const clearSearch = () => {
    form.value.search = "";
    applyFilters();
};

// Desktop search with debounce
let searchTimeout = null;
const onDesktopSearchInput = () => {
    clearTimeout(searchTimeout);
    searchTimeout = setTimeout(() => {
        applyFilters();
    }, 500);
};

// Mobile search (auto-applies like desktop)
const onMobileSearchInput = () => {
    clearTimeout(searchTimeout);
    searchTimeout = setTimeout(() => {
        applyFilters();
    }, 500);
};

// Watch desktop filters (auto-apply)
watch(
    [
        () => form.value.category,
        () => form.value.author,
        () => form.value.min_price,
        () => form.value.max_price,
    ],
    () => {
        // Only auto-apply if search is not the trigger
        if (!searchTimeout) {
            applyFilters();
        }
    }
);

// Lifecycle
onMounted(() => {
    // Initialize mobile form with current filters
    mobileForm.value = { ...form.value };
});
</script>
