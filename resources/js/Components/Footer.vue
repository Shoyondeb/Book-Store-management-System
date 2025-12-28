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
                    >PUSTOK</span
                >
            </div>

            <!-- Navigation Links -->
            <div class="flex gap-6 text-white text-sm font-medium">
                <a
                    href="#"
                    class="hover:text-yellow-400 transition-all duration-300"
                    >About</a
                >
                <a
                    href="#"
                    class="hover:text-yellow-400 transition-all duration-300"
                    >Contact</a
                >
                <a
                    href="#"
                    class="hover:text-yellow-400 transition-all duration-300"
                    >Privacy</a
                >
                <a
                    href="#"
                    class="hover:text-yellow-400 transition-all duration-300"
                    >Terms</a
                >
            </div>

            <!-- Social Icons -->
            <div class="flex gap-4">
                <a href="#" class="hover:text-blue-400 transition-colors"
                    ><i class="fab fa-facebook-f"></i
                ></a>
                <a href="#" class="hover:text-pink-400 transition-colors"
                    ><i class="fab fa-instagram"></i
                ></a>
                <a href="#" class="hover:text-sky-400 transition-colors"
                    ><i class="fab fa-twitter"></i
                ></a>
                <a href="#" class="hover:text-red-500 transition-colors"
                    ><i class="fab fa-youtube"></i
                ></a>
            </div>

            <!-- Copyright -->
            <div
                class="text-white text-sm text-center md:text-right mt-4 md:mt-0"
            >
                &copy; 2025 <span class="font-semibold">BookStore</span>. All
                rights reserved.
            </div>
        </div>
    </footer>
</template>

<script setup></script>

<style scoped>
footer svg {
    transition: transform 0.3s ease-in-out;
}
footer svg:hover {
    transform: rotate(20deg) scale(1.1);
}
</style>
