<template>
    <div class="flex items-center space-x-1">
        <button
            v-for="star in 5"
            :key="star"
            type="button"
            @click="setRating(star)"
            @mouseover="hoverRating = star"
            @mouseleave="hoverRating = 0"
            :class="[
                'text-2xl transition-colors duration-200 focus:outline-none',
                star <= (hoverRating || currentRating)
                    ? 'text-yellow-400'
                    : 'text-gray-300',
                disabled ? 'cursor-not-allowed' : 'cursor-pointer',
            ]"
            :disabled="disabled"
        >
            ★
        </button>
        <span v-if="showScore" class="ml-2 text-sm text-gray-600">
            {{ currentRating }}/5
        </span>
    </div>
</template>

<script setup>
import { ref, watch } from "vue";

const props = defineProps({
    rating: { type: Number, default: 0 },
    disabled: { type: Boolean, default: false },
    showScore: { type: Boolean, default: true },
});

const emit = defineEmits(["update:rating"]);

const currentRating = ref(props.rating);
const hoverRating = ref(0);

watch(
    () => props.rating,
    (newRating) => {
        currentRating.value = newRating;
    }
);

const setRating = (star) => {
    if (!props.disabled) {
        currentRating.value = star;
        emit("update:rating", star);
    }
};
</script>

<style scoped>
button:focus {
    outline: none;
}
</style>
