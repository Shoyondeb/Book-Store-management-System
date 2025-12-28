<template>
    <div
        class="bg-white p-6 rounded-xl shadow-lg mt-6 border border-gray-200 max-w-xl mx-auto"
    >
        <h3 class="text-xl font-semibold mb-4 text-gray-800">Write a Review</h3>
        <form @submit.prevent="submitReview">
            <!-- Rating -->
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2"
                    >Your Rating</label
                >
                <StarRating
                    v-model:rating="form.rating"
                    :disabled="false"
                    class="cursor-pointer hover:scale-110 transition-transform"
                />
            </div>

            <!-- Review Text -->
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2"
                    >Your Review</label
                >
                <textarea
                    v-model="form.comment"
                    rows="4"
                    placeholder="Share your thoughts about this book..."
                    class="w-full border border-gray-300 rounded-lg shadow-sm p-3 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all resize-none"
                ></textarea>
            </div>

            <!-- Submit Button -->
            <button
                type="submit"
                :disabled="form.processing"
                class="bg-blue-500 text-white px-6 py-2 rounded-lg hover:bg-blue-600 shadow-md hover:shadow-lg disabled:bg-gray-400 disabled:cursor-not-allowed transition-all font-medium"
            >
                Submit Review
            </button>
        </form>
    </div>
</template>

<script setup>
import { useForm } from "@inertiajs/vue3";
import StarRating from "./StarRating.vue";

const props = defineProps({
    bookId: {
        type: Number,
        required: true,
    },
});

const form = useForm({
    rating: 0,
    comment: "",
});

const submitReview = () => {
    form.post(route("reviews.store", props.bookId), {
        preserveScroll: true,
        onSuccess: () => form.reset(),
        onError: (errors) => {
            console.error(errors);
            alert("Error: " + JSON.stringify(errors));
        },
    });
};
</script>

<style scoped>
/* Optional subtle hover effect */
div.bg-white:hover {
    transform: translateY(-2px);
    transition: transform 0.2s;
}
</style>
