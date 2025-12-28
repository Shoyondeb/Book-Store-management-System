<!-- resources/js/Pages/ZoomMeeting/Create.vue -->
<template>
    <div class="container mx-auto px-4 py-8">
        <div class="max-w-2xl mx-auto">
            <div class="mb-6">
                <Link
                    :href="route('meetings.index')"
                    class="inline-flex items-center text-blue-600 hover:text-blue-800 mb-4"
                >
                    <svg
                        class="w-4 h-4 mr-2"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18"
                        />
                    </svg>
                    Back to Meetings
                </Link>
                <h1 class="text-3xl font-bold">Schedule a New Meeting</h1>
            </div>

            <form
                @submit.prevent="submit"
                class="bg-white rounded-lg shadow-md p-6"
            >
                <!-- Admin Selection -->
                <div class="mb-6">
                    <label
                        for="admin_id"
                        class="block text-sm font-medium text-gray-700 mb-2"
                    >
                        Select Admin *
                    </label>
                    <select
                        v-model="form.admin_id"
                        id="admin_id"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                        required
                    >
                        <option value="">Select an admin</option>
                        <option
                            v-for="admin in admins"
                            :key="admin.id"
                            :value="admin.id"
                        >
                            {{ admin.name }} ({{ admin.email }})
                        </option>
                    </select>
                    <div
                        v-if="form.errors.admin_id"
                        class="text-red-500 text-sm mt-1"
                    >
                        {{ form.errors.admin_id }}
                    </div>
                </div>

                <!-- Topic -->
                <div class="mb-6">
                    <label
                        for="topic"
                        class="block text-sm font-medium text-gray-700 mb-2"
                    >
                        Meeting Topic *
                    </label>
                    <input
                        v-model="form.topic"
                        type="text"
                        id="topic"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="Enter meeting topic"
                        required
                    />
                    <div
                        v-if="form.errors.topic"
                        class="text-red-500 text-sm mt-1"
                    >
                        {{ form.errors.topic }}
                    </div>
                </div>

                <!-- Agenda -->
                <div class="mb-6">
                    <label
                        for="agenda"
                        class="block text-sm font-medium text-gray-700 mb-2"
                    >
                        Agenda (Optional)
                    </label>
                    <textarea
                        v-model="form.agenda"
                        id="agenda"
                        rows="3"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="What will be discussed in the meeting?"
                    ></textarea>
                </div>

                <!-- Date & Time -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label
                            for="start_time"
                            class="block text-sm font-medium text-gray-700 mb-2"
                        >
                            Start Date & Time *
                        </label>
                        <input
                            v-model="form.start_time"
                            type="datetime-local"
                            id="start_time"
                            :min="minDateTime"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                            required
                        />
                        <div
                            v-if="form.errors.start_time"
                            class="text-red-500 text-sm mt-1"
                        >
                            {{ form.errors.start_time }}
                        </div>
                    </div>

                    <div>
                        <label
                            for="duration"
                            class="block text-sm font-medium text-gray-700 mb-2"
                        >
                            Duration (minutes) *
                        </label>
                        <input
                            v-model="form.duration"
                            type="number"
                            id="duration"
                            min="15"
                            max="240"
                            step="15"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                            required
                        />
                        <div
                            v-if="form.errors.duration"
                            class="text-red-500 text-sm mt-1"
                        >
                            {{ form.errors.duration }}
                        </div>
                    </div>
                </div>

                <!-- Timezone -->
                <div class="mb-8">
                    <label
                        for="timezone"
                        class="block text-sm font-medium text-gray-700 mb-2"
                    >
                        Timezone *
                    </label>
                    <select
                        v-model="form.timezone"
                        id="timezone"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                        required
                    >
                        <option value="UTC">UTC</option>
                        <option value="America/New_York">
                            Eastern Time (ET)
                        </option>
                        <option value="America/Chicago">
                            Central Time (CT)
                        </option>
                        <option value="America/Denver">
                            Mountain Time (MT)
                        </option>
                        <option value="America/Los_Angeles">
                            Pacific Time (PT)
                        </option>
                    </select>
                </div>

                <!-- Submit Button -->
                <div class="flex justify-end">
                    <button
                        type="submit"
                        :disabled="form.processing"
                        class="px-6 py-3 bg-blue-600 text-white font-medium rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 disabled:opacity-50 disabled:cursor-not-allowed transition-colors"
                    >
                        {{
                            form.processing
                                ? "Scheduling..."
                                : "Schedule Meeting"
                        }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</template>

<script setup>
import { useForm, Link } from "@inertiajs/vue3";
import { computed } from "vue";

const props = defineProps({
    admins: Array,
});

const form = useForm({
    admin_id: "",
    topic: "",
    agenda: "",
    start_time: "",
    duration: 60,
    timezone: "UTC",
});

// Get minimum datetime (current time + 30 minutes)
const minDateTime = computed(() => {
    const now = new Date();
    now.setMinutes(now.getMinutes() + 30);
    return now.toISOString().slice(0, 16);
});

const submit = () => {
    form.post(route("meetings.store"), {
        // ✅ FIXED: 'meetings.store' not 'store'
        preserveScroll: true,
        onSuccess: () => {
            form.reset();
        },
        onError: (errors) => {
            console.log("Form errors:", errors);
        },
    });
};
</script>
