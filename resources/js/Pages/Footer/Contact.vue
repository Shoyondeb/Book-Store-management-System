<template>
    <AppLayout>
        <div class="min-h-screen bg-gray-50">
            <div class="bg-white py-12 shadow-sm">
                <div class="max-w-4xl mx-auto px-4">
                    <h1 class="text-3xl font-bold text-gray-900 mb-4">
                        Contact Us
                    </h1>
                    <p class="text-gray-600">We'd love to hear from you</p>
                </div>
            </div>

            <div class="max-w-4xl mx-auto px-4 py-12">
                <!-- Success Message using flash (if available) -->
                <div
                    v-if="flashMessage && flashMessage.type === 'success'"
                    class="mb-6 p-4 bg-green-50 border border-green-200 rounded-lg"
                >
                    <div class="flex items-center">
                        <svg
                            class="w-5 h-5 text-green-500 mr-2"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M5 13l4 4L19 7"
                            ></path>
                        </svg>
                        <p class="text-green-700 font-medium">
                            {{ flashMessage.message }}
                        </p>
                    </div>
                </div>

                <!-- Error Message using flash (if available) -->
                <div
                    v-if="flashMessage && flashMessage.type === 'error'"
                    class="mb-6 p-4 bg-red-50 border border-red-200 rounded-lg"
                >
                    <div class="flex items-center">
                        <svg
                            class="w-5 h-5 text-red-500 mr-2"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"
                            ></path>
                        </svg>
                        <p class="text-red-700 font-medium">
                            {{ flashMessage.message }}
                        </p>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow p-6">
                    <div class="grid md:grid-cols-2 gap-8">
                        <!-- Contact Info -->
                        <div>
                            <h2
                                class="text-xl font-semibold text-gray-900 mb-4"
                            >
                                Contact Information
                            </h2>
                            <div class="space-y-4">
                                <div>
                                    <h3 class="font-medium text-gray-900">
                                        Email
                                    </h3>
                                    <p class="text-gray-600">
                                        shoyondeb18246@gmail.com
                                    </p>
                                </div>
                                <div>
                                    <h3 class="font-medium text-gray-900">
                                        Phone
                                    </h3>
                                    <p class="text-gray-600">+880 1795547756</p>
                                </div>
                                <div>
                                    <h3 class="font-medium text-gray-900">
                                        Address
                                    </h3>
                                    <p class="text-gray-600">
                                        123 Book Street<br />
                                        Sylhet, Bangladesh
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Contact Form -->
                        <div>
                            <h2
                                class="text-xl font-semibold text-gray-900 mb-4"
                            >
                                Send Message
                            </h2>
                            <form
                                @submit.prevent="submitContact"
                                class="space-y-4"
                            >
                                <div>
                                    <label
                                        class="block text-sm font-medium text-gray-700 mb-1"
                                        >Full Name *</label
                                    >
                                    <input
                                        type="text"
                                        v-model="form.name"
                                        class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500"
                                        required
                                        placeholder="Your name"
                                    />
                                </div>
                                <div>
                                    <label
                                        class="block text-sm font-medium text-gray-700 mb-1"
                                        >Email Address *</label
                                    >
                                    <input
                                        type="email"
                                        v-model="form.email"
                                        class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500"
                                        required
                                        placeholder="you@example.com"
                                    />
                                </div>
                                <div>
                                    <label
                                        class="block text-sm font-medium text-gray-700 mb-1"
                                        >Subject</label
                                    >
                                    <input
                                        type="text"
                                        v-model="form.subject"
                                        class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500"
                                        placeholder="What is this regarding?"
                                    />
                                </div>
                                <div>
                                    <label
                                        class="block text-sm font-medium text-gray-700 mb-1"
                                        >Message *</label
                                    >
                                    <textarea
                                        v-model="form.message"
                                        rows="4"
                                        class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500"
                                        required
                                        placeholder="Your message here..."
                                    ></textarea>
                                </div>

                                <!-- Send Message Button -->
                                <button
                                    type="submit"
                                    :disabled="form.processing"
                                    class="w-full bg-blue-600 text-white py-2 px-4 rounded hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 disabled:opacity-50 disabled:cursor-not-allowed transition duration-200"
                                >
                                    <span
                                        v-if="form.processing"
                                        class="flex items-center justify-center"
                                    >
                                        <svg
                                            class="animate-spin h-4 w-4 mr-2 text-white"
                                            fill="none"
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
                                        Sending...
                                    </span>
                                    <span v-else>Send Message</span>
                                </button>

                                <!-- Local Success Message (appears right below button) -->
                                <div
                                    v-if="showLocalSuccess"
                                    class="mt-4 p-4 bg-green-50 border border-green-200 rounded-lg"
                                >
                                    <div class="flex items-center">
                                        <svg
                                            class="w-5 h-5 text-green-500 mr-2"
                                            fill="none"
                                            stroke="currentColor"
                                            viewBox="0 0 24 24"
                                        >
                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                stroke-width="2"
                                                d="M5 13l4 4L19 7"
                                            ></path>
                                        </svg>
                                        <p class="text-green-700 font-medium">
                                            {{ localSuccessMessage }}
                                        </p>
                                    </div>
                                </div>

                                <!-- Local Error Message (appears right below button) -->
                                <div
                                    v-if="showLocalError"
                                    class="mt-4 p-4 bg-red-50 border border-red-200 rounded-lg"
                                >
                                    <div class="flex items-center">
                                        <svg
                                            class="w-5 h-5 text-red-500 mr-2"
                                            fill="none"
                                            stroke="currentColor"
                                            viewBox="0 0 24 24"
                                        >
                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                stroke-width="2"
                                                d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"
                                            ></path>
                                        </svg>
                                        <p class="text-red-700 font-medium">
                                            {{ localErrorMessage }}
                                        </p>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<script setup>
import { reactive, ref, computed } from "vue";
import { router } from "@inertiajs/vue3";
import AppLayout from "@/Layouts/AppLayout.vue";

const props = defineProps({
    flash: Object, // Make sure flash is passed as prop
});

const form = reactive({
    name: "",
    email: "",
    subject: "",
    message: "",
    processing: false,
});

const showLocalSuccess = ref(false);
const showLocalError = ref(false);
const localSuccessMessage = ref("");
const localErrorMessage = ref("");

// Safely check flash messages
const flashMessage = computed(() => {
    if (!props.flash) return null;

    if (props.flash.success) {
        return { type: "success", message: props.flash.success };
    }
    if (props.flash.error) {
        return { type: "error", message: props.flash.error };
    }
    return null;
});

const submitContact = async () => {
    form.processing = true;
    showLocalSuccess.value = false;
    showLocalError.value = false;

    try {
        // Use Inertia's POST method
        await router.post("/contact/send", form, {
            preserveScroll: true,
            onSuccess: () => {
                // Reset form
                form.name = "";
                form.email = "";
                form.subject = "";
                form.message = "";
                form.processing = false;

                // Show local success message
                showLocalSuccess.value = true;
                localSuccessMessage.value = "Message sent successfully!";

                // Hide message after 5 seconds
                setTimeout(() => {
                    showLocalSuccess.value = false;
                }, 5000);
            },
            onError: (errors) => {
                form.processing = false;
                showLocalError.value = true;
                localErrorMessage.value =
                    errors.message ||
                    "Failed to send message. Please try again.";

                // Hide error after 5 seconds
                setTimeout(() => {
                    showLocalError.value = false;
                }, 5000);
            },
        });
    } catch (error) {
        form.processing = false;
        showLocalError.value = true;
        localErrorMessage.value =
            "Network error. Please check your connection and try again.";

        // Hide error after 5 seconds
        setTimeout(() => {
            showLocalError.value = false;
        }, 5000);
    }
};
</script>
