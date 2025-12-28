<template>
    <AppLayout>
        <div class="max-w-7xl mx-auto px-4 py-8">
            <!-- Author Header -->
            <div class="bg-white rounded-lg shadow-lg overflow-hidden mb-8">
                <div class="md:flex">
                    <!-- Author Image -->
                    <div class="md:w-1/3">
                        <img
                            :src="
                                author.image_url || '/images/default-author.jpg'
                            "
                            :alt="author.name"
                            class="w-full h-64 md:h-full object-cover"
                        />
                    </div>

                    <!-- Author Details -->
                    <div class="md:w-2/3 p-8">
                        <h1 class="text-4xl font-bold text-gray-900 mb-4">
                            {{ author.name }}
                        </h1>

                        <div class="mb-6">
                            <h3
                                class="text-lg font-semibold text-gray-700 mb-2"
                            >
                                About the Author
                            </h3>
                            <p class="text-gray-600 leading-relaxed">
                                {{ author.bio || "No biography available." }}
                            </p>
                        </div>

                        <div
                            class="grid grid-cols-2 md:grid-cols-3 gap-4 text-center"
                        >
                            <div class="bg-blue-50 p-4 rounded-lg">
                                <p class="text-2xl font-bold text-blue-600">
                                    {{
                                        author.books_count || books.data.length
                                    }}
                                </p>
                                <p class="text-sm text-gray-600">
                                    Books Published
                                </p>
                            </div>
                            <div class="bg-green-50 p-4 rounded-lg">
                                <p class="text-2xl font-bold text-green-600">
                                    {{ totalRatings }}
                                </p>
                                <p class="text-sm text-gray-600">
                                    Total Reviews
                                </p>
                            </div>
                            <div
                                v-if="averageAuthorRating < 3"
                                class="bg-yellow-50 p-4 rounded-lg"
                            >
                                <p class="text-2xl font-bold text-red-500">
                                    {{ averageAuthorRating }}
                                </p>
                                <p class="text-sm text-gray-600">Avg Rating</p>
                            </div>
                            <div v-else class="bg-yellow-50 p-4 rounded-lg">
                                <p class="text-2xl font-bold text-green-700">
                                    {{ averageAuthorRating }}
                                </p>
                                <p class="text-sm text-gray-600">Avg Rating</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Author's Books -->
            <div>
                <h2 class="text-3xl font-bold text-gray-900 mb-6">
                    Books by {{ author.name }}
                </h2>

                <div
                    v-if="books.data.length > 0"
                    class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6"
                >
                    <BookCard
                        v-for="book in books.data"
                        :key="book.id"
                        :book="book"
                    />
                </div>

                <div v-else class="text-center py-12">
                    <p class="text-gray-500 text-lg">
                        No books found by this author.
                    </p>
                </div>

                <!-- Pagination -->
                <div class="mt-8 flex justify-center">
                    <Pagination :links="books.links" />
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<script setup>
import { computed } from "vue";
import { usePage } from "@inertiajs/vue3";
import AppLayout from "@/Layouts/AppLayout.vue";
import BookCard from "@/Components/BookCard.vue";
import Pagination from "@/Components/Pagination.vue";

const page = usePage();
const props = defineProps({
    author: Object,
    books: Object,
});

// Calculate author statistics
const totalRatings = computed(() => {
    return props.books.data.reduce(
        (total, book) => total + (book.rating_count || 0),
        0
    );
});

const averageAuthorRating = computed(() => {
    const booksWithRatings = props.books.data.filter(
        (book) => book.average_rating > 0
    );
    if (booksWithRatings.length === 0) return "0.0";

    const totalRating = booksWithRatings.reduce((total, book) => {
        // Convert string to number
        const rating = parseFloat(book.average_rating) || 0;
        return total + rating;
    }, 0);

    return (totalRating / booksWithRatings.length).toFixed(1);
});
</script>
