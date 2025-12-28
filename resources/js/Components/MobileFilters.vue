<template>
    <div class="space-y-6">
        <!-- Search -->
        <div>
            <label class="text-sm font-medium text-gray-700 mb-2 block"
                >Search</label
            >
            <div class="relative">
                <input
                    v-model="localForm.search"
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

        <!-- Category -->
        <div>
            <label class="text-sm font-medium text-gray-700 mb-2 block"
                >Category</label
            >
            <select
                v-model="localForm.category"
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

        <!-- Author -->
        <div>
            <label class="text-sm font-medium text-gray-700 mb-2 block"
                >Author</label
            >
            <select
                v-model="localForm.author"
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

        <!-- Price Range -->
        <div>
            <label class="text-sm font-medium text-gray-700 mb-2 block"
                >Price Range</label
            >
            <div class="grid grid-cols-2 gap-3">
                <input
                    v-model="localForm.min_price"
                    type="number"
                    min="0"
                    placeholder="Min"
                    class="px-4 py-3 border border-gray-300 rounded-xl focus:border-blue-500 focus:ring-2 focus:ring-blue-200"
                />
                <input
                    v-model="localForm.max_price"
                    type="number"
                    min="0"
                    placeholder="Max"
                    class="px-4 py-3 border border-gray-300 rounded-xl focus:border-blue-500 focus:ring-2 focus:ring-blue-200"
                />
            </div>
        </div>

        <!-- Filter Summary -->
        <div v-if="hasActiveFilters" class="p-4 bg-blue-50 rounded-xl">
            <h3 class="text-sm font-medium text-blue-900 mb-2">
                Selected Filters:
            </h3>
            <ul class="space-y-1">
                <li
                    v-if="localForm.search"
                    class="text-sm text-blue-800 flex items-center gap-2"
                >
                    <span class="w-2 h-2 bg-blue-500 rounded-full"></span>
                    Search: "{{ localForm.search }}"
                </li>
                <li
                    v-if="localForm.category"
                    class="text-sm text-blue-800 flex items-center gap-2"
                >
                    <span class="w-2 h-2 bg-blue-500 rounded-full"></span>
                    Category: {{ getCategoryName(localForm.category) }}
                </li>
                <li
                    v-if="localForm.author"
                    class="text-sm text-blue-800 flex items-center gap-2"
                >
                    <span class="w-2 h-2 bg-blue-500 rounded-full"></span>
                    Author: {{ getAuthorName(localForm.author) }}
                </li>
                <li
                    v-if="localForm.min_price"
                    class="text-sm text-blue-800 flex items-center gap-2"
                >
                    <span class="w-2 h-2 bg-blue-500 rounded-full"></span>
                    Min Price: ${{ localForm.min_price }}
                </li>
                <li
                    v-if="localForm.max_price"
                    class="text-sm text-blue-800 flex items-center gap-2"
                >
                    <span class="w-2 h-2 bg-blue-500 rounded-full"></span>
                    Max Price: ${{ localForm.max_price }}
                </li>
            </ul>
        </div>

        <!-- Buttons -->
        <div class="pt-6 border-t border-gray-200 space-y-3">
            <button
                @click="handleApply"
                class="w-full py-3.5 bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-semibold rounded-xl hover:from-blue-700 hover:to-indigo-700 active:scale-[0.98] transition flex items-center justify-center gap-2"
                :disabled="isApplying"
            >
                <svg
                    v-if="isApplying"
                    class="w-5 h-5 animate-spin"
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
                <svg
                    v-else
                    class="w-5 h-5"
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
                {{ isApplying ? "Applying..." : "Apply Filters" }}
            </button>
            <button
                @click="handleReset"
                class="w-full py-3.5 border-2 border-gray-300 text-gray-700 font-medium rounded-xl hover:bg-gray-50 active:scale-[0.98] transition"
            >
                Reset All
            </button>
        </div>
    </div>
</template>

<script setup>
import { ref, computed, watch } from "vue";

const props = defineProps({
    form: Object,
    categories: Array,
    authors: Array,
});

const emit = defineEmits(["apply", "reset"]);

const localForm = ref({ ...props.form });
const isApplying = ref(false);

const hasActiveFilters = computed(() => {
    return Object.values(localForm.value).some(
        (value) => value !== "" && value !== null
    );
});

const getCategoryName = (id) => {
    const category = props.categories.find((c) => c.id == id);
    return category ? category.name : "";
};

const getAuthorName = (id) => {
    const author = props.authors.find((a) => a.id == id);
    return author ? author.name : "";
};

const handleApply = () => {
    isApplying.value = true;
    // Simulate a slight delay for better UX
    setTimeout(() => {
        emit("apply", localForm.value);
        isApplying.value = false;
    }, 300);
};

const handleReset = () => {
    localForm.value = {
        search: "",
        category: "",
        author: "",
        min_price: "",
        max_price: "",
    };
    emit("reset");
};

// Sync when parent form changes
watch(
    () => props.form,
    (newForm) => {
        localForm.value = { ...newForm };
    },
    { deep: true }
);
</script>
