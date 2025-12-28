<template>
    <AppLayout>
        <div class="max-w-7xl mx-auto px-4 py-10">
            <!-- Book Card -->
            <div
                class="bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden hover:shadow-2xl transition-all duration-300"
            >
                <div class="md:flex">
                    <!-- IMAGE -->
                    <div class="md:w-1/3">
                        <img
                            :src="book.image_url"
                            :alt="book.title"
                            class="w-full h-96 md:h-full object-cover hover:scale-105 transition-transform duration-500"
                        />
                    </div>

                    <!-- DETAILS -->
                    <div class="md:w-2/3 p-10 space-y-6">
                        <span
                            class="px-3 py-1 text-sm rounded-full bg-gradient-to-r from-blue-500 to-indigo-500 text-white shadow"
                        >
                            {{ book.category?.name || "Uncategorized" }}
                        </span>

                        <h1
                            class="text-4xl font-extrabold text-gray-900 leading-tight"
                        >
                            {{ book.title }}
                        </h1>

                        <p class="text-xl text-gray-700 -mt-2">
                            ✍️ {{ book.author?.name || "Unknown Author" }}
                        </p>

                        <p class="text-gray-600 leading-relaxed text-lg">
                            {{ book.description }}
                        </p>

                        <!-- PRICE + STOCK + BUY -->
                        <div class="flex items-center justify-between pt-4">
                            <div>
                                <p
                                    class="text-4xl font-bold bg-gradient-to-r from-blue-600 to-indigo-600 text-transparent bg-clip-text"
                                >
                                    ৳{{ book.price }}
                                </p>

                                <p
                                    class="text-sm mt-1"
                                    :class="
                                        book.stock < 10
                                            ? 'text-red-500 font-semibold'
                                            : 'text-gray-500'
                                    "
                                >
                                    {{ book.stock }} in stock
                                </p>
                            </div>

                            <div class="flex items-center gap-4">
                                <!-- QUANTITY -->
                                <div
                                    class="flex items-center border border-gray-300 rounded-xl shadow-sm overflow-hidden"
                                >
                                    <button
                                        @click="decreaseQuantity"
                                        class="px-4 py-2 text-gray-600 hover:bg-gray-100 transition disabled:opacity-40"
                                        :disabled="quantity <= 1 || isInCart"
                                    >
                                        -
                                    </button>

                                    <span class="px-5 py-2 font-semibold">{{
                                        quantity
                                    }}</span>

                                    <button
                                        @click="increaseQuantity"
                                        class="px-4 py-2 text-gray-600 hover:bg-gray-100 transition disabled:opacity-40"
                                        :disabled="
                                            quantity >= book.stock || isInCart
                                        "
                                    >
                                        +
                                    </button>
                                </div>

                                <!-- ADD TO CART / VIEW CART BUTTON -->
                                <button
                                    @click="isInCart ? goToCart() : addToCart()"
                                    :disabled="book.stock === 0 || addingToCart"
                                    class="px-6 py-3 rounded-xl text-white font-semibold shadow-lg transition active:scale-95 disabled:bg-gray-400 disabled:cursor-not-allowed"
                                    :class="
                                        isInCart
                                            ? 'bg-gradient-to-r from-green-500 to-emerald-600 hover:opacity-90'
                                            : 'bg-gradient-to-r from-blue-500 to-indigo-600 hover:opacity-90'
                                    "
                                >
                                    {{ buttonText }}
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- REVIEWS -->
            <div class="mt-14">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-3xl font-bold text-gray-900">
                        Customer Reviews
                    </h2>

                    <div class="flex items-center">
                        <StarRating :rating="averageRating" :disabled="true" />
                        <span class="ml-2 text-gray-600 text-sm">
                            {{ formattedAverageRating }} ({{ ratingCount }}
                            reviews)
                        </span>
                    </div>
                </div>

                <!-- Flash Messages -->
                <div
                    v-if="flashSuccess"
                    class="p-3 mb-4 rounded-lg bg-green-100 text-green-700 border border-green-300 shadow-sm"
                >
                    {{ flashSuccess }}
                </div>

                <div
                    v-if="flashError"
                    class="p-3 mb-4 rounded-lg bg-red-100 text-red-700 border border-red-300 shadow-sm"
                >
                    {{ flashError }}
                </div>

                <!-- Review Form -->
                <ReviewForm v-if="canReview" :book-id="book.id" class="mb-6" />

                <!-- Reviews List -->
                <div
                    v-if="book.reviews && book.reviews.length > 0"
                    class="space-y-6"
                >
                    <div
                        v-for="review in book.reviews"
                        :key="review.id"
                        class="bg-white p-6 rounded-xl shadow hover:shadow-md transition"
                    >
                        <div class="flex justify-between items-start">
                            <div>
                                <h4 class="font-bold text-lg">
                                    {{ review.user?.name || "Anonymous" }}
                                </h4>
                                <StarRating
                                    :rating="review.rating"
                                    :disabled="true"
                                />
                                <p class="text-sm text-gray-500 mt-1">
                                    {{ formatDate(review.created_at) }}
                                </p>
                            </div>

                            <button
                                v-if="canDeleteReview(review)"
                                @click="deleteReview(review)"
                                class="text-red-500 hover:text-red-700 text-sm transition"
                            >
                                Delete
                            </button>
                        </div>

                        <p class="mt-3 text-gray-700">{{ review.comment }}</p>
                    </div>
                </div>

                <p v-else class="text-center py-10 text-gray-500 text-lg">
                    No reviews yet — be the first to review!
                </p>
            </div>

            <!-- RELATED BOOKS -->
            <div v-if="relatedBooks && relatedBooks.length > 0" class="mt-14">
                <h2 class="text-3xl font-bold text-gray-900 mb-6">
                    Related Books
                </h2>

                <div
                    class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6"
                >
                    <BookCard
                        v-for="relatedBook in relatedBooks"
                        :key="relatedBook.id"
                        :book="relatedBook"
                    />
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<script setup>
import { ref, computed } from "vue";
import { router, useForm, usePage } from "@inertiajs/vue3";
import AppLayout from "@/Layouts/AppLayout.vue";
import BookCard from "@/Components/BookCard.vue";
import StarRating from "@/Components/StarRating.vue";
import ReviewForm from "@/Components/ReviewForm.vue";

const page = usePage();
const props = defineProps({
    book: Object,
    relatedBooks: Array,
    canReview: Boolean,
});
// Check if book is already in cart
const isInCart = computed(() => {
    const cart = page.props.cart || {};
    return cart.hasOwnProperty(props.book.id);
});

const buttonText = computed(() => {
    if (props.book.stock === 0) return "Out of Stock";
    if (addingToCart.value) return "Adding...";
    if (isInCart.value) return "View in Cart";
    return "Add to Cart";
});

const increaseQuantity = () => {
    if (quantity.value < props.book.stock && !isInCart.value) {
        quantity.value++;
    }
};
const decreaseQuantity = () => {
    if (quantity.value > 1 && !isInCart.value) {
        quantity.value--;
    }
};
const goToCart = () => {
    router.visit(route("cart.index"));
};

const addToCart = async () => {
    if (props.book.stock === 0 || isInCart.value) return;

    addingToCart.value = true;

    try {
        await router.post(
            route("cart.add", props.book.id),
            { quantity: quantity.value },
            {
                preserveState: true,
                preserveScroll: true,
                only: [], // This updates navbar cart count
            }
        );
    } catch (error) {
        console.error("Failed to add to cart:", error);
    } finally {
        addingToCart.value = false;
    }
};

const quantity = ref(1);
const addingToCart = ref(false);

// Safe flash message handling
const flashSuccess = computed(() => {
    return page.props.flash?.success || null;
});

const flashError = computed(() => {
    return page.props.flash?.error || null;
});

// Safe computed properties for average rating
const averageRating = computed(() => {
    // First try to use the provided average_rating
    if (
        props.book.average_rating !== undefined &&
        props.book.average_rating !== null
    ) {
        const rating = parseFloat(props.book.average_rating);
        return isNaN(rating) ? 0 : rating;
    }

    // Fallback: calculate from reviews
    if (props.book.reviews && props.book.reviews.length > 0) {
        const validReviews = props.book.reviews.filter(
            (review) => review.rating && !isNaN(review.rating)
        );

        if (validReviews.length > 0) {
            const sum = validReviews.reduce(
                (total, review) => total + review.rating,
                0
            );
            return sum / validReviews.length;
        }
    }

    return 0;
});

const formattedAverageRating = computed(() => {
    return averageRating.value.toFixed(1);
});

const ratingCount = computed(() => {
    if (
        props.book.rating_count !== undefined &&
        props.book.rating_count !== null
    ) {
        return props.book.rating_count;
    }

    // Fallback: count from reviews array
    return props.book.reviews ? props.book.reviews.length : 0;
});

const formatDate = (dateString) => {
    if (!dateString) return "Unknown date";

    try {
        return new Date(dateString).toLocaleDateString("en-US", {
            year: "numeric",
            month: "long",
            day: "numeric",
        });
    } catch (error) {
        return "Invalid date";
    }
};

const canDeleteReview = (review) => {
    const user = page.props?.auth?.user;
    if (!user) return false;

    return user.role === "admin" || user.id === review.user_id;
};

const deleteReview = (review) => {
    if (confirm("Are you sure you want to delete this review?")) {
        router.delete(route("reviews.destroy", review.id), {
            preserveScroll: true,
            onSuccess: () => {
                // Optional: Show success message or refresh data
            },
            onError: (errors) => {
                alert("Failed to delete review. Please try again.");
            },
        });
    }
};
</script>
