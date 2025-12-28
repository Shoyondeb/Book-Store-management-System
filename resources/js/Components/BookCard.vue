<script setup>
import { ref, computed, onMounted } from "vue";
import { Link, usePage } from "@inertiajs/vue3";

const props = defineProps({
    book: Object,
});

// State management
const isAddingToCart = ref(false);
const isInCart = ref(false);
const page = usePage();

// Initialize cart status
onMounted(() => {
    updateCartStatus();
});

// Function to check if book is in cart
const updateCartStatus = () => {
    const cart = page.props.cart || {};
    isInCart.value = Object.keys(cart).includes(props.book.id.toString());
};

// AJAX add to cart function - FIXED CSRF
const addToCart = async () => {
    if (isInCart.value || props.book.stock === 0 || isAddingToCart.value)
        return;

    isAddingToCart.value = true;

    try {
        // OPTION 1: Use axios with explicit headers (MOST RELIABLE)
        const response = await window.axios.post(
            route("cart.add", props.book.id),
            {
                quantity: 1,
            }
        );

        if (response.data.success) {
            isInCart.value = true;

            // Show notification
            showNotification("✓ Added to cart successfully!", "success");

            // Update cart count via event
            window.dispatchEvent(
                new CustomEvent("cart-count-updated", {
                    detail: { count: response.data.cartCount },
                })
            );
        }
    } catch (error) {
        console.error("Cart error:", error);
        console.log("Error status:", error.response?.status);
        console.log("Error data:", error.response?.data);

        if (error.response?.status === 419) {
            // CSRF token mismatch - refresh page to get new token
            showNotification("Please refresh the page and try again.", "error");
            setTimeout(() => {
                window.location.reload();
            }, 2000);
        } else {
            const message =
                error.response?.data?.message || "Failed to add to cart.";
            showNotification(message, "error");
        }
    } finally {
        isAddingToCart.value = false;
    }
};

// Update global cart count
const updateGlobalCartCount = (count) => {
    // Update localStorage
    localStorage.setItem("cart_count", count);

    // Dispatch event for navbar
    window.dispatchEvent(
        new CustomEvent("cart-count-updated", {
            detail: { count },
        })
    );
};

// Button classes
const getButtonClasses = () => {
    if (props.book.stock === 0) {
        return "bg-gray-300 text-gray-700 cursor-not-allowed";
    } else if (isInCart.value) {
        return "bg-green-100 text-green-700 border-2 border-green-200 hover:bg-green-200 cursor-default";
    } else if (isAddingToCart.value) {
        return "bg-blue-400 text-white cursor-wait";
    } else {
        return "bg-gradient-to-r from-blue-500 to-blue-600 text-white hover:from-blue-600 hover:to-blue-700 hover:shadow-md";
    }
};

// Button text
const buttonText = computed(() => {
    if (isAddingToCart.value) return "Adding...";
    if (isInCart.value) return "✓ Added to Cart";
    if (props.book.stock === 0) return "Out of Stock";
    return "Add to Cart";
});

// Notification function
const showNotification = (message, type = "success") => {
    // Create notification element
    const notification = document.createElement("div");
    notification.className = `fixed top-4 right-4 px-4 py-3 rounded-lg shadow-lg z-50 transform transition-all duration-300 ${
        type === "success"
            ? "bg-green-500"
            : type === "error"
            ? "bg-red-500"
            : "bg-blue-500"
    } text-white`;
    notification.textContent = message;
    notification.style.transform = "translateX(100%)";

    document.body.appendChild(notification);

    // Animate in
    setTimeout(() => (notification.style.transform = "translateX(0)"), 10);

    // Remove after 3 seconds
    setTimeout(() => {
        notification.style.transform = "translateX(100%)";
        setTimeout(() => document.body.removeChild(notification), 300);
    }, 3000);
};

// Listen for cart updates from other components
window.addEventListener("cart-updated", (event) => {
    if (event.detail.bookId === props.book.id) {
        isInCart.value = event.detail.action === "add";
    }
});

// Rest of your existing functions...
const getRating = () => {
    const rating = parseFloat(props.book.average_rating);
    return isNaN(rating) ? 0 : rating;
};

const formatRating = () => {
    const rating = getRating();
    return rating === 0 ? "No ratings" : rating.toFixed(1);
};

const hasDiscount = () => {
    return (
        props.book.original_price &&
        parseFloat(props.book.original_price) > parseFloat(props.book.price)
    );
};

const calculateDiscount = () => {
    if (!hasDiscount()) return 0;
    const original = parseFloat(props.book.original_price);
    const current = parseFloat(props.book.price);
    return Math.round(((original - current) / original) * 100);
};

const getStockBadgeClasses = () => {
    if (props.book.stock === 0) {
        return "bg-red-500 text-white";
    } else if (props.book.stock < 10) {
        return "bg-amber-500 text-white";
    } else {
        return "bg-green-500 text-white";
    }
};

const handleImageError = (event) => {
    event.target.src = "/images/default-book.jpg";
};
</script>

<template>
    <div
        class="group bg-white rounded-xl sm:rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 overflow-hidden border border-gray-100"
    >
        <!-- Book Image with Badges -->
        <div class="relative overflow-hidden bg-gray-100">
            <Link
                :href="route('shop.books.show', book.id)"
                class="block aspect-[3/4]"
            >
                <img
                    :src="book.image_url || '/images/default-book.jpg'"
                    :alt="book.title"
                    class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105"
                    @error="handleImageError"
                />

                <!-- Image Overlay -->
                <div
                    class="absolute inset-0 bg-gradient-to-t from-black/20 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"
                ></div>
            </Link>

            <!-- Stock Badge -->
            <div class="absolute top-2 left-2">
                <span
                    class="inline-flex items-center px-2 py-1 rounded-full text-[10px] sm:text-xs font-semibold shadow-md"
                    :class="getStockBadgeClasses()"
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
                            d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"
                        />
                    </svg>
                    {{ book.stock > 0 ? book.stock : "0" }}
                </span>
            </div>

            <!-- Discount Badge -->
            <div v-if="hasDiscount()" class="absolute top-2 right-2">
                <span
                    class="inline-flex items-center px-2 py-1 rounded-lg text-xs font-bold bg-red-500 text-white shadow-md"
                >
                    -{{ calculateDiscount() }}%
                </span>
            </div>

            <!-- Quick View Button -->
            <button
                @click="$inertia.visit(route('shop.books.show', book.id))"
                class="absolute bottom-2 right-2 p-2 bg-white/90 backdrop-blur-sm rounded-full shadow-md hover:bg-white hover:scale-110 transition-all duration-300 opacity-0 group-hover:opacity-100 hidden sm:flex items-center justify-center"
            >
                <svg
                    class="w-4 h-4 text-gray-700"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"
                    />
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"
                    />
                </svg>
            </button>
        </div>

        <!-- Book Content -->
        <div class="p-3 sm:p-4">
            <!-- Category -->
            <div class="mb-2">
                <span
                    class="inline-block px-2 py-1 bg-gray-100 rounded-md text-xs text-gray-600 font-medium"
                >
                    {{ book.category?.name || "Uncategorized" }}
                </span>
            </div>

            <!-- Title -->
            <Link :href="route('shop.books.show', book.id)" class="block mb-2">
                <h3
                    class="font-bold text-gray-900 hover:text-blue-600 transition-colors duration-200 leading-tight text-sm sm:text-base"
                >
                    {{
                        book.title.length > 30
                            ? book.title.substring(0, 30) + "..."
                            : book.title
                    }}
                </h3>
            </Link>

            <!-- Author -->
            <div class="mb-3">
                <p class="text-xs sm:text-sm text-gray-600 truncate">
                    by
                    <Link
                        v-if="book.author"
                        :href="route('authors.show', book.author.id)"
                        class="text-blue-600 hover:text-blue-800 hover:underline"
                    >
                        {{ book.author.name }}
                    </Link>
                    <span v-else class="text-gray-500">Unknown Author</span>
                </p>
            </div>

            <!-- Rating -->
            <div class="flex items-center mb-3">
                <div class="flex items-center">
                    <div class="flex mr-2">
                        <svg
                            v-for="i in 5"
                            :key="i"
                            class="w-3 h-3 sm:w-4 sm:h-4"
                            :class="
                                i <= Math.floor(getRating())
                                    ? 'text-yellow-400'
                                    : 'text-gray-300'
                            "
                            fill="currentColor"
                            viewBox="0 0 20 20"
                        >
                            <path
                                d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"
                            />
                        </svg>
                    </div>
                    <span class="text-xs sm:text-sm font-medium text-gray-900">
                        {{ formatRating() }}
                    </span>
                </div>
                <span class="mx-2 text-gray-300">•</span>
                <span class="text-xs text-gray-500">
                    {{ book.rating_count || 0 }} review{{
                        book.rating_count !== 1 ? "s" : ""
                    }}
                </span>
            </div>

            <!-- Price -->
            <div class="mb-4">
                <div class="flex items-center gap-2">
                    <span class="text-lg sm:text-xl font-bold text-blue-600">
                        ৳{{ book.price }}
                    </span>
                    <span
                        v-if="hasDiscount()"
                        class="text-sm text-gray-500 line-through"
                    >
                        ৳{{ book.original_price }}
                    </span>
                </div>
            </div>

            <!-- Add to Cart Button -->
            <button
                @click="addToCart"
                :disabled="book.stock === 0 || isInCart || isAddingToCart"
                class="w-full flex items-center justify-center gap-2 px-4 py-2.5 rounded-lg sm:rounded-xl transition-all duration-300 font-semibold shadow-sm hover:shadow-md disabled:cursor-not-allowed disabled:opacity-60"
                :class="getButtonClasses()"
            >
                <span v-if="isAddingToCart" class="flex items-center gap-2">
                    <svg
                        class="w-4 h-4 sm:w-5 sm:h-5 animate-spin"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                    >
                        <circle
                            class="opacity-25"
                            cx="12"
                            cy="12"
                            r="10"
                            stroke="currentColor"
                            stroke-width="4"
                        ></circle>
                        <path
                            class="opacity-75"
                            fill="currentColor"
                            d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"
                        ></path>
                    </svg>
                    Adding...
                </span>
                <span v-else-if="isInCart" class="flex items-center gap-2">
                    <svg
                        class="w-4 h-4 sm:w-5 sm:h-5"
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
                    ✓ Added to Cart
                </span>
                <span
                    v-else-if="book.stock === 0"
                    class="flex items-center gap-2"
                >
                    <svg
                        class="w-4 h-4 sm:w-5 sm:h-5"
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
                    Out of Stock
                </span>
                <span v-else class="flex items-center gap-2">
                    <svg
                        class="w-4 h-4 sm:w-5 sm:h-5"
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
                    Add to Cart
                </span>
            </button>

            <!-- Wishlist Button -->
            <button
                @click="$inertia.post(route('wishlist.add', book.id))"
                class="mt-3 w-full flex items-center justify-center gap-2 px-4 py-2 border border-gray-300 rounded-lg sm:hidden text-sm font-medium text-gray-700 hover:bg-gray-50 transition-colors"
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
                        d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"
                    />
                </svg>
                Add to Wishlist
            </button>
        </div>
    </div>
</template>

<style scoped>
.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.aspect-\[3\/4\] {
    aspect-ratio: 3/4;
}

.animate-spin {
    animation: spin 1s linear infinite;
}

@keyframes spin {
    from {
        transform: rotate(0deg);
    }
    to {
        transform: rotate(360deg);
    }
}
</style>
