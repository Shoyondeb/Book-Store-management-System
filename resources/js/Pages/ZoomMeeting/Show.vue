<!-- resources/js/Pages/ZoomMeeting/Show.vue -->
<template>
    <div class="container mx-auto px-4 py-8">
        <div class="max-w-4xl mx-auto">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-3xl font-bold">Meeting Details</h1>
                <Link
                    :href="route('meetings.join', meeting.id)"
                    class="px-6 py-2 bg-green-600 text-white rounded-md hover:bg-green-700"
                >
                    Join Meeting
                </Link>
            </div>

            <div class="bg-white rounded-lg shadow overflow-hidden">
                <div class="p-6">
                    <h2 class="text-2xl font-semibold mb-4">
                        {{ meeting.topic || "Meeting" }}
                    </h2>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <h3 class="text-sm font-medium text-gray-500 mb-2">
                                Date & Time
                            </h3>
                            <p class="text-lg">
                                {{ formatDateTime(meeting.start_time) }}
                            </p>
                            <p class="text-gray-600">
                                Timezone: {{ meeting.timezone || "UTC" }}
                            </p>
                        </div>

                        <div>
                            <h3 class="text-sm font-medium text-gray-500 mb-2">
                                Duration
                            </h3>
                            <p class="text-lg">
                                {{ meeting.duration || 30 }} minutes
                            </p>
                        </div>

                        <div>
                            <h3 class="text-sm font-medium text-gray-500 mb-2">
                                Meeting ID
                            </h3>
                            <p class="text-lg font-mono">
                                {{ meeting.zoom_meeting_id || "N/A" }}
                            </p>
                        </div>

                        <div>
                            <h3 class="text-sm font-medium text-gray-500 mb-2">
                                Password
                            </h3>
                            <p class="text-lg font-mono">
                                {{ meeting.password || "N/A" }}
                            </p>
                        </div>

                        <div>
                            <h3 class="text-sm font-medium text-gray-500 mb-2">
                                Scheduled With
                            </h3>
                            <p class="text-lg">
                                {{ meeting.admin?.name || "N/A" }}
                            </p>
                            <p class="text-gray-600">
                                {{ meeting.admin?.email || "N/A" }}
                            </p>
                        </div>

                        <div>
                            <h3 class="text-sm font-medium text-gray-500 mb-2">
                                Status
                            </h3>
                            <span
                                :class="statusClasses(meeting.status)"
                                class="px-3 py-1 rounded-full text-sm font-medium"
                            >
                                {{ meeting.status || "scheduled" }}
                            </span>
                        </div>
                    </div>

                    <div v-if="meeting.agenda" class="mb-6">
                        <h3 class="text-sm font-medium text-gray-500 mb-2">
                            Agenda
                        </h3>
                        <p class="text-gray-700 whitespace-pre-line">
                            {{ meeting.agenda }}
                        </p>
                    </div>

                    <div class="border-t pt-6">
                        <h3 class="text-lg font-medium mb-4">Meeting Links</h3>
                        <div class="space-y-3">
                            <div>
                                <p
                                    class="text-sm font-medium text-gray-500 mb-1"
                                >
                                    Join URL (for participants):
                                </p>
                                <div class="flex items-center">
                                    <input
                                        type="text"
                                        :value="meeting.join_url || 'N/A'"
                                        readonly
                                        class="flex-1 px-3 py-2 border border-gray-300 rounded-l-md bg-gray-50"
                                    />
                                    <button
                                        @click="
                                            copyToClipboard(meeting.join_url)
                                        "
                                        class="px-4 py-2 bg-gray-200 border border-l-0 border-gray-300 rounded-r-md hover:bg-gray-300"
                                        :disabled="!meeting.join_url"
                                    >
                                        Copy
                                    </button>
                                </div>
                            </div>

                            <div
                                v-if="
                                    meeting.start_url &&
                                    $page.props.auth?.user?.id ===
                                        meeting.admin_id
                                "
                            >
                                <p
                                    class="text-sm font-medium text-gray-500 mb-1"
                                >
                                    Start URL (host only):
                                </p>
                                <div class="flex items-center">
                                    <input
                                        type="text"
                                        :value="meeting.start_url"
                                        readonly
                                        class="flex-1 px-3 py-2 border border-gray-300 rounded-l-md bg-gray-50"
                                    />
                                    <button
                                        @click="
                                            copyToClipboard(meeting.start_url)
                                        "
                                        class="px-4 py-2 bg-gray-200 border border-l-0 border-gray-300 rounded-r-md hover:bg-gray-300"
                                    >
                                        Copy
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-gray-50 px-6 py-4 flex justify-between">
                    <Link
                        :href="route('meetings.index')"
                        class="px-4 py-2 text-gray-600 hover:text-gray-800"
                    >
                        Back to Meetings
                    </Link>

                    <button
                        v-if="
                            $page.props.auth?.user?.id === meeting.user_id &&
                            meeting.status === 'scheduled'
                        "
                        @click="cancelMeeting"
                        class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700"
                    >
                        Cancel Meeting
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { Link, router } from "@inertiajs/vue3";

const props = defineProps({
    meeting: Object,
});

const formatDateTime = (dateString) => {
    if (!dateString) return "Not scheduled";
    try {
        const date = new Date(dateString);
        return date.toLocaleString("en-US", {
            weekday: "long",
            year: "numeric",
            month: "long",
            day: "numeric",
            hour: "2-digit",
            minute: "2-digit",
            timeZoneName: "short",
        });
    } catch (e) {
        return dateString || "Invalid date";
    }
};

const statusClasses = (status) => {
    const classes = {
        scheduled: "bg-yellow-100 text-yellow-800",
        started: "bg-blue-100 text-blue-800",
        ended: "bg-gray-100 text-gray-800",
        cancelled: "bg-red-100 text-red-800",
    };
    return classes[status] || "bg-gray-100 text-gray-800";
};

const copyToClipboard = (text) => {
    if (!text) {
        alert("No text to copy");
        return;
    }
    navigator.clipboard
        .writeText(text)
        .then(() => alert("Copied to clipboard!"))
        .catch((err) => {
            console.error("Failed to copy:", err);
            alert("Failed to copy to clipboard");
        });
};

const cancelMeeting = () => {
    if (confirm("Are you sure you want to cancel this meeting?")) {
        router.delete(route("meetings.destroy", props.meeting.id));
    }
};
</script>
