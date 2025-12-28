<template>
    <div
        class="inline-flex items-center gap-3 px-4 py-2.5 bg-gradient-to-r from-white to-blue-50 text-blue-800 rounded-xl border-2 border-blue-200 shadow-sm hover:shadow-md transition-shadow font-medium text-base"
    >
        <slot />
        <button
            @click="$emit('remove')"
            class="text-blue-600 hover:text-blue-800 p-1 rounded-full hover:bg-blue-100 transition"
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
    </div>
</template>

<script setup>
defineEmits(["remove"]);
</script>
