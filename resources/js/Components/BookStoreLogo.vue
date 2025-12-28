<template>
    <svg
        viewBox="0 0 200 200"
        xmlns="http://www.w3.org/2000/svg"
        class="text-blue-600"
    >
        <!-- Open Book -->
        <path
            d="M40 60 L80 40 L80 140 L40 160 Z"
            fill="currentColor"
            opacity="0.3"
            stroke="currentColor"
            stroke-width="2"
        />
        <path
            d="M160 60 L120 40 L120 140 L160 160 Z"
            fill="currentColor"
            opacity="0.3"
            stroke="currentColor"
            stroke-width="2"
        />

        <!-- Book Pages -->
        <path
            d="M45 65 L75 50 L75 135 L45 155 Z"
            fill="white"
            stroke="currentColor"
            stroke-width="1"
        />
        <path
            d="M155 65 L125 50 L125 135 L155 155 Z"
            fill="white"
            stroke="currentColor"
            stroke-width="1"
        />

        <!-- Text Lines -->
        <g stroke="currentColor" stroke-width="1" opacity="0.6">
            <path d="M50 75 L70 65" />
            <path d="M50 85 L70 75" />
            <path d="M50 95 L65 87" />
            <path d="M50 105 L70 95" />
            <path d="M50 115 L68 107" />
        </g>

        <g stroke="currentColor" stroke-width="1" opacity="0.6">
            <path d="M150 75 L130 65" />
            <path d="M150 85 L130 75" />
            <path d="M150 95 L135 87" />
            <path d="M150 105 L130 95" />
            <path d="M150 115 L132 107" />
        </g>

        <!-- Pen -->
        <g transform="translate(90, 35) rotate(30)">
            <path d="M0 0 L20 0 L20 100 L0 100 Z" fill="#8b5cf6" />
            <path d="M20 0 L30 5 L20 10 Z" fill="#7c3aed" />
            <path d="M0 0 L-5 10 L0 20 Z" fill="#a78bfa" />
        </g>

        <!-- Sparkles -->
        <circle cx="60" cy="45" r="2" fill="#fbbf24" />
        <circle cx="140" cy="45" r="2" fill="#fbbf24" />
        <circle cx="100" cy="150" r="3" fill="#10b981" />
    </svg>
</template>

<script setup>
// Component logic
</script>
