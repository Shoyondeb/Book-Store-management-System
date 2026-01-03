<template>
    <footer class="bg-gray-900 text-white mt-auto shadow-lg">
        <div
            class="max-w-7xl mx-auto px-4 py-10 flex flex-col md:flex-row items-center justify-between gap-6"
        >
            <!-- Logo / Brand -->
            <div class="flex items-center gap-3">
                <svg
                    class="w-10 h-10 text-white animate-bounce"
                    fill="currentColor"
                    viewBox="0 0 24 24"
                >
                    <path
                        d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"
                    />
                </svg>
                <span class="text-2xl font-extrabold tracking-wide"
                    >PUSTOK.com</span
                >
            </div>
            <!-- Social Media -->
            <div class="flex gap-4">
                <!-- Facebook -->
                <a
                    href="#"
                    target="_blank"
                    class="text-gray-400 hover:text-blue-500 transition"
                >
                    <svg
                        class="w-5 h-5"
                        fill="currentColor"
                        viewBox="0 0 24 24"
                    >
                        <path
                            d="M22 12a10 10 0 1 0-11.5 9.9v-7h-2v-3h2V9.5c0-2 1.2-3.1 3-3.1.9 0 1.8.1 1.8.1v2h-1c-1 0-1.3.6-1.3 1.2V11h2.3l-.4 3h-1.9v7A10 10 0 0 0 22 12z"
                        />
                    </svg>
                </a>

                <!-- Twitter / X -->
                <a
                    href="#"
                    target="_blank"
                    class="text-gray-400 hover:text-sky-400 transition"
                >
                    <svg
                        class="w-5 h-5"
                        fill="currentColor"
                        viewBox="0 0 24 24"
                    >
                        <path
                            d="M22 5.9c-.8.4-1.6.6-2.5.8a4.3 4.3 0 0 0 1.9-2.4c-.8.5-1.8.9-2.8 1.1A4.2 4.2 0 0 0 11.5 9a12 12 0 0 1-8.7-4.4 4.2 4.2 0 0 0 1.3 5.6c-.7 0-1.4-.2-2-.5v.1c0 2 1.4 3.7 3.3 4.1-.3.1-.7.1-1.1.1-.3 0-.5 0-.8-.1a4.2 4.2 0 0 0 3.9 2.9A8.5 8.5 0 0 1 2 18.4 12 12 0 0 0 8.5 20c7.8 0 12-6.4 12-12v-.5c.8-.6 1.5-1.3 2-2.1z"
                        />
                    </svg>
                </a>

                <!-- LinkedIn -->
                <a
                    href="#"
                    target="_blank"
                    class="text-gray-400 hover:text-blue-600 transition"
                >
                    <svg
                        class="w-5 h-5"
                        fill="currentColor"
                        viewBox="0 0 24 24"
                    >
                        <path
                            d="M4.98 3.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM3 8.98h4v12H3zM9 8.98h3.8v1.6h.1c.5-.9 1.8-1.8 3.6-1.8 3.9 0 4.6 2.5 4.6 5.8v6.4h-4v-5.7c0-1.4 0-3.2-2-3.2s-2.3 1.5-2.3 3.1v5.8H9z"
                        />
                    </svg>
                </a>
            </div>

            <!-- In your Footer.vue -->
            <div class="flex flex-wrap justify-center gap-6">
                <Link
                    :href="route('about')"
                    class="text-gray-600 hover:text-blue-600 transition"
                >
                    About
                </Link>
                <Link
                    :href="route('contact')"
                    class="text-gray-600 hover:text-blue-600 transition"
                >
                    Contact
                </Link>
                <Link
                    :href="route('privacy')"
                    class="text-gray-600 hover:text-blue-600 transition"
                >
                    Privacy
                </Link>
                <Link
                    :href="route('terms')"
                    class="text-gray-600 hover:text-blue-600 transition"
                >
                    Terms
                </Link>
            </div>

            <!-- Copyright -->
            <div
                class="text-white text-sm text-center md:text-right mt-4 md:mt-0"
            >
                &copy; 2026 <span class="font-semibold">BookStore</span>. All
                rights reserved.
            </div>
        </div>
    </footer>
</template>

<script setup>
import { Link } from "@inertiajs/vue3";
</script>

<style scoped>
footer svg {
    transition: transform 0.3s ease-in-out;
}
footer svg:hover {
    transform: rotate(20deg) scale(1.1);
}
</style>
