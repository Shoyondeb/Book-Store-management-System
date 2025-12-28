<template>
    <div v-if="hasFlashMessages" class="fixed top-4 right-4 z-50">
        <div
            v-if="flashSuccess"
            class="bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg flex items-center space-x-2"
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
                    d="M5 13l4 4L19 7"
                />
            </svg>
            <span>{{ flashSuccess }}</span>
        </div>

        <div
            v-if="flashError"
            class="bg-red-500 text-white px-6 py-3 rounded-lg shadow-lg flex items-center space-x-2"
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
            <span>{{ flashError }}</span>
        </div>
    </div>
</template>

<script setup>
import { computed } from "vue";
import { usePage } from "@inertiajs/vue3";

const page = usePage();

const flashSuccess = computed(() => {
    return page.props.flash?.success || null;
});

const flashError = computed(() => {
    return page.props.flash?.error || null;
});

const hasFlashMessages = computed(() => {
    return !!(flashSuccess.value || flashError.value);
});
</script>
