<script setup>
import { Link } from "@inertiajs/vue3";
</script>

<template>
    <div
        class="min-h-screen bg-gradient-to-br from-blue-50 via-white to-indigo-50 flex items-center justify-center p-4 sm:p-6"
    >
        <div class="w-full max-w-md mx-auto">
            <!-- Logo & Brand Section -->
            <div class="text-center mb-10 space-y-4">
                <Link
                    href="/"
                    class="inline-block group focus:outline-none focus:ring-4 focus:ring-indigo-200 rounded-full transition-all duration-300"
                    preserve-scroll
                >
                    <div class="relative">
                        <!-- Compact navbar logo -->
                        <img
                            :src="'/images/logo.png'"
                            alt="Pustok - Book Store Logo"
                            class="h-24 w-24 md:h-12 md:w-12 object-cover rounded-xl shadow-sm border-2 border-white/30 hover:scale-105 hover:rotate-1 hover:shadow-md transition-all duration-200"
                            width="48"
                            height="48"
                            loading="eager"
                        />
                        <!-- Subtle glow effect -->
                        <div
                            class="absolute inset-0 bg-indigo-200/30 rounded-2xl blur-xl -z-10 opacity-0 group-hover:opacity-100 transition-opacity duration-300"
                        ></div>
                    </div>
                </Link>

                <div class="space-y-2">
                    <h1
                        class="text-4xl font-bold bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent"
                    >
                        Pustok.com
                    </h1>
                    <p class="text-gray-600 text-lg font-medium">
                        Your Ultimate Book Management Solution
                    </p>
                    <div class="pt-2">
                        <span
                            class="inline-block h-1 w-16 bg-gradient-to-r from-indigo-400 to-purple-400 rounded-full"
                        ></span>
                    </div>
                </div>
            </div>

            <!-- Form Container -->
            <div
                class="bg-white rounded-2xl shadow-2xl border border-gray-100 overflow-hidden transition-all duration-300 hover:shadow-3xl"
            >
                <div class="p-8 sm:p-10">
                    <slot />
                </div>

                <!-- Optional: Decorative bottom border -->
                <div
                    class="h-1 bg-gradient-to-r from-indigo-500 via-purple-500 to-pink-500"
                ></div>
            </div>

            <!-- Footer -->
            <div class="text-center mt-8 pt-6 border-t border-gray-100">
                <p class="text-sm text-gray-500">
                    &copy; {{ new Date().getFullYear() }} Pustok Book Manager.
                    All rights reserved.
                </p>
                <p class="text-xs text-gray-400 mt-1">
                    Streamlining your literary journey
                </p>
            </div>
        </div>
    </div>
</template>

<style scoped>
/* Smooth shadow transitions */
.hover\:shadow-3xl {
    box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.15);
}
</style>
