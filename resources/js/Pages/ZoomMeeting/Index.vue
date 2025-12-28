<!-- resources/js/Pages/ZoomMeeting/Index.vue -->
<template>
    <div class="p-8">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold">My Meetings</h1>
            <Link
                :href="route('meetings.create')"
                class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700"
            >
                Schedule New Meeting
            </Link>
        </div>

        <!-- Success/Error Messages -->
        <div
            v-if="$page.props.flash?.success"
            class="mb-4 p-4 bg-green-100 text-green-700 rounded"
        >
            {{ $page.props.flash.success }}
        </div>
        <div
            v-if="$page.props.flash?.error"
            class="mb-4 p-4 bg-red-100 text-red-700 rounded"
        >
            {{ $page.props.flash.error }}
        </div>

        <!-- Meetings List -->
        <div v-if="meetings.data.length > 0">
            <div class="grid gap-4">
                <div
                    v-for="meeting in meetings.data"
                    :key="meeting.id"
                    class="bg-white border rounded-lg shadow-sm p-6"
                >
                    <div class="flex justify-between items-start">
                        <div>
                            <h2 class="text-xl font-semibold mb-2">
                                {{ meeting.topic }}
                            </h2>
                            <div class="space-y-1 text-gray-600">
                                <p class="flex items-center">
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
                                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"
                                        />
                                    </svg>
                                    {{ formatDateTime(meeting.start_time) }}
                                </p>
                                <p class="flex items-center">
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
                                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"
                                        />
                                    </svg>
                                    {{ meeting.duration }} minutes
                                </p>
                                <p class="flex items-center">
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
                                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"
                                        />
                                    </svg>
                                    With: {{ meeting.admin?.name || "N/A" }}
                                </p>
                            </div>
                        </div>

                        <div class="flex flex-col space-y-2">
                            <span
                                :class="statusBadgeClass(meeting.status)"
                                class="px-3 py-1 rounded-full text-sm font-medium"
                            >
                                {{ meeting.status }}
                            </span>
                            <div class="flex space-x-2">
                                <Link
                                    :href="route('meetings.show', meeting.id)"
                                    class="px-3 py-1 text-blue-600 hover:text-blue-800"
                                >
                                    Details
                                </Link>
                                <Link
                                    :href="route('meetings.join', meeting.id)"
                                    class="px-3 py-1 bg-green-600 text-white rounded hover:bg-green-700"
                                >
                                    Join
                                </Link>
                            </div>
                        </div>
                    </div>

                    <div v-if="meeting.agenda" class="mt-4 pt-4 border-t">
                        <p class="text-gray-700">{{ meeting.agenda }}</p>
                    </div>
                </div>
            </div>

            <!-- Pagination -->
            <div
                v-if="meetings.links && meetings.links.length > 1"
                class="mt-6"
            >
                <template v-for="(link, index) in meetings.links" :key="index">
                    <Link
                        v-if="link.url"
                        :href="link.url"
                        v-html="link.label"
                        class="px-3 py-1 border rounded mx-1"
                        :class="{
                            'bg-blue-600 text-white': link.active,
                            'text-gray-700 hover:bg-gray-50': !link.active,
                        }"
                    />
                    <span
                        v-else
                        v-html="link.label"
                        class="px-3 py-1 border rounded mx-1 text-gray-400"
                    />
                </template>
            </div>
        </div>

        <!-- Empty State -->
        <div v-else class="text-center py-12">
            <svg
                class="w-16 h-16 text-gray-400 mx-auto mb-4"
                fill="none"
                stroke="currentColor"
                viewBox="0 0 24 24"
            >
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"
                />
            </svg>
            <h3 class="text-lg font-medium text-gray-900 mb-2">
                No meetings scheduled
            </h3>
            <p class="text-gray-500 mb-4">
                Schedule your first meeting to get started.
            </p>
            <Link
                :href="route('meetings.create')"
                class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700"
            >
                Schedule Meeting
            </Link>
        </div>
    </div>
</template>

<script setup>
import { Link } from "@inertiajs/vue3";

defineProps({
    meetings: Object,
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
        });
    } catch (e) {
        return dateString;
    }
};

const statusBadgeClass = (status) => {
    const classes = {
        scheduled: "bg-yellow-100 text-yellow-800",
        started: "bg-blue-100 text-blue-800",
        ended: "bg-gray-100 text-gray-800",
        cancelled: "bg-red-100 text-red-800",
    };
    return classes[status] || "bg-gray-100 text-gray-800";
};
</script>
