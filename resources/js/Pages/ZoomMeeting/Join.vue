<!-- resources/js/Pages/ZoomMeeting/Join.vue -->
<template>
    <div class="min-h-screen bg-gradient-to-br from-gray-50 to-blue-50">
        <!-- Main Container -->
        <div class="container mx-auto px-4 py-8">
            <div class="max-w-6xl mx-auto">
                <!-- Header Section -->
                <div class="mb-10">
                    <div class="text-center">
                        <!-- Status Badge -->
                        <div
                            class="inline-flex items-center mb-4 px-4 py-2 rounded-full bg-white shadow-sm border"
                        >
                            <div
                                :class="`w-2 h-2 rounded-full mr-2 ${statusDotColor}`"
                            ></div>
                            <span class="text-sm font-medium text-gray-700">{{
                                meetingStatus
                            }}</span>
                        </div>

                        <!-- Meeting Title -->
                        <h1 class="text-4xl font-bold text-gray-900 mb-3">
                            {{ meeting.topic || "Zoom Meeting" }}
                        </h1>

                        <!-- Meeting Time -->
                        <div
                            class="flex items-center justify-center text-gray-600 mb-6"
                        >
                            <svg
                                class="w-5 h-5 mr-2 text-blue-500"
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
                            <span class="text-lg">{{
                                formatDateTime(meeting.start_time)
                            }}</span>
                        </div>

                        <!-- Status Message -->
                        <div
                            v-if="statusMessage"
                            class="max-w-2xl mx-auto bg-blue-50 border border-blue-200 rounded-xl px-6 py-4"
                        >
                            <div class="flex items-center">
                                <svg
                                    class="w-5 h-5 text-blue-500 mr-3 flex-shrink-0"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"
                                    />
                                </svg>
                                <p class="text-blue-800">{{ statusMessage }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Main Card -->
                <div
                    class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-200"
                >
                    <!-- Tabs Navigation -->
                    <div class="border-b border-gray-200">
                        <nav class="flex">
                            <button
                                @click="activeTab = 'join'"
                                :class="`flex-1 px-6 py-4 text-lg font-medium transition-colors ${
                                    activeTab === 'join'
                                        ? 'bg-blue-50 text-blue-600 border-b-2 border-blue-600'
                                        : 'text-gray-500 hover:text-gray-700'
                                }`"
                            >
                                <svg
                                    class="w-5 h-5 inline-block mr-2"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"
                                    />
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"
                                    />
                                </svg>
                                Join Meeting
                            </button>
                            <button
                                @click="activeTab = 'details'"
                                :class="`flex-1 px-6 py-4 text-lg font-medium transition-colors ${
                                    activeTab === 'details'
                                        ? 'bg-blue-50 text-blue-600 border-b-2 border-blue-600'
                                        : 'text-gray-500 hover:text-gray-700'
                                }`"
                            >
                                <svg
                                    class="w-5 h-5 inline-block mr-2"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"
                                    />
                                </svg>
                                Meeting Details
                            </button>
                            <button
                                @click="activeTab = 'help'"
                                :class="`flex-1 px-6 py-4 text-lg font-medium transition-colors ${
                                    activeTab === 'help'
                                        ? 'bg-blue-50 text-blue-600 border-b-2 border-blue-600'
                                        : 'text-gray-500 hover:text-gray-700'
                                }`"
                            >
                                <svg
                                    class="w-5 h-5 inline-block mr-2"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"
                                    />
                                </svg>
                                Help & Support
                            </button>
                        </nav>
                    </div>

                    <!-- Tab Content -->
                    <div class="p-8">
                        <!-- Join Tab -->
                        <div v-if="activeTab === 'join'" class="space-y-8">
                            <!-- Browser Warning -->
                            <div
                                v-if="showBrowserWarning"
                                class="bg-yellow-50 border border-yellow-200 rounded-xl p-6"
                            >
                                <div class="flex">
                                    <svg
                                        class="w-6 h-6 text-yellow-500 mr-4 flex-shrink-0"
                                        fill="none"
                                        stroke="currentColor"
                                        viewBox="0 0 24 24"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.732-.833-2.464 0L4.288 16.5c-.77.833.192 2.5 1.732 2.5z"
                                        />
                                    </svg>
                                    <div>
                                        <h3
                                            class="font-semibold text-yellow-800 mb-1"
                                        >
                                            For Best Experience
                                        </h3>
                                        <p class="text-yellow-700 text-sm">
                                            Use Google Chrome or Firefox for
                                            optimal audio/video performance.
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <!-- Join Methods -->
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                <!-- Video & Audio -->
                                <div
                                    class="bg-gradient-to-br from-blue-50 to-blue-100 border-2 border-blue-200 rounded-2xl p-8 text-center hover:border-blue-300 hover:shadow-lg transition-all duration-300"
                                >
                                    <div
                                        class="w-16 h-16 bg-blue-500 rounded-full flex items-center justify-center mx-auto mb-6"
                                    >
                                        <svg
                                            class="w-8 h-8 text-white"
                                            fill="none"
                                            stroke="currentColor"
                                            viewBox="0 0 24 24"
                                        >
                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                stroke-width="2"
                                                d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"
                                            />
                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                stroke-width="2"
                                                d="M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 01-3-3V5a3 3 0 116 0v6a3 3 0 01-3 3z"
                                            />
                                        </svg>
                                    </div>
                                    <h3
                                        class="text-xl font-bold text-gray-900 mb-3"
                                    >
                                        Join with Video & Audio
                                    </h3>
                                    <p class="text-gray-600 mb-6">
                                        Full meeting experience with camera and
                                        microphone
                                    </p>
                                    <button
                                        @click="joinWithVideoAudio"
                                        class="w-full py-3 bg-blue-600 text-white font-semibold rounded-xl hover:bg-blue-700 transition-colors shadow-md hover:shadow-lg"
                                    >
                                        Join Now
                                    </button>
                                </div>

                                <!-- Audio Only -->
                                <div
                                    class="bg-gradient-to-br from-green-50 to-green-100 border-2 border-green-200 rounded-2xl p-8 text-center hover:border-green-300 hover:shadow-lg transition-all duration-300"
                                >
                                    <div
                                        class="w-16 h-16 bg-green-500 rounded-full flex items-center justify-center mx-auto mb-6"
                                    >
                                        <svg
                                            class="w-8 h-8 text-white"
                                            fill="none"
                                            stroke="currentColor"
                                            viewBox="0 0 24 24"
                                        >
                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                stroke-width="2"
                                                d="M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 01-3-3V5a3 3 0 116 0v6a3 3 0 01-3 3z"
                                            />
                                        </svg>
                                    </div>
                                    <h3
                                        class="text-xl font-bold text-gray-900 mb-3"
                                    >
                                        Audio Only
                                    </h3>
                                    <p class="text-gray-600 mb-6">
                                        Join with microphone only (no camera)
                                    </p>
                                    <button
                                        @click="joinWithAudioOnly"
                                        class="w-full py-3 bg-green-600 text-white font-semibold rounded-xl hover:bg-green-700 transition-colors shadow-md hover:shadow-lg"
                                    >
                                        Join with Audio
                                    </button>
                                </div>

                                <!-- Listen Only -->
                                <div
                                    class="bg-gradient-to-br from-gray-50 to-gray-100 border-2 border-gray-200 rounded-2xl p-8 text-center hover:border-gray-300 hover:shadow-lg transition-all duration-300"
                                >
                                    <div
                                        class="w-16 h-16 bg-gray-500 rounded-full flex items-center justify-center mx-auto mb-6"
                                    >
                                        <svg
                                            class="w-8 h-8 text-white"
                                            fill="none"
                                            stroke="currentColor"
                                            viewBox="0 0 24 24"
                                        >
                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                stroke-width="2"
                                                d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L6.59 6.59m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"
                                            />
                                        </svg>
                                    </div>
                                    <h3
                                        class="text-xl font-bold text-gray-900 mb-3"
                                    >
                                        Listen Only
                                    </h3>
                                    <p class="text-gray-600 mb-6">
                                        Join without camera or microphone
                                    </p>
                                    <button
                                        @click="joinWithoutMedia"
                                        class="w-full py-3 bg-gray-600 text-white font-semibold rounded-xl hover:bg-gray-700 transition-colors shadow-md hover:shadow-lg"
                                    >
                                        Join to Listen
                                    </button>
                                </div>
                            </div>

                            <!-- Embedded Meeting (When joined) -->
                            <div v-if="isJoined" class="mt-8">
                                <div
                                    class="bg-gray-900 rounded-xl overflow-hidden border border-gray-800"
                                >
                                    <!-- Meeting Header -->
                                    <div
                                        class="bg-gray-800 px-6 py-4 flex items-center justify-between"
                                    >
                                        <div class="flex items-center">
                                            <div
                                                class="w-3 h-3 bg-red-500 rounded-full mr-3 animate-pulse"
                                            ></div>
                                            <span class="text-white font-medium"
                                                >Meeting in Progress</span
                                            >
                                        </div>
                                        <div
                                            class="flex items-center space-x-2"
                                        >
                                            <button
                                                @click="toggleAudio"
                                                class="p-2 bg-gray-700 text-white rounded-lg hover:bg-gray-600 transition-colors"
                                                title="Toggle Audio"
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
                                                        d="M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 01-3-3V5a3 3 0 116 0v6a3 3 0 01-3 3z"
                                                    />
                                                </svg>
                                            </button>
                                            <button
                                                @click="toggleVideo"
                                                class="p-2 bg-gray-700 text-white rounded-lg hover:bg-gray-600 transition-colors"
                                                title="Toggle Video"
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
                                                        d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"
                                                    />
                                                </svg>
                                            </button>
                                            <button
                                                @click="toggleFullscreen"
                                                class="p-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors"
                                                title="Fullscreen"
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
                                                        d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5v-4m0 4h-4m4 0l-5-5"
                                                    />
                                                </svg>
                                            </button>
                                            <button
                                                @click="leaveMeeting"
                                                class="p-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors"
                                                title="Leave Meeting"
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
                                                        d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"
                                                    />
                                                </svg>
                                            </button>
                                        </div>
                                    </div>

                                    <!-- Zoom Iframe -->
                                    <div class="relative">
                                        <iframe
                                            ref="zoomIframe"
                                            :src="finalZoomUrl"
                                            class="w-full h-[500px] border-0"
                                            allow="microphone; camera; autoplay; display-capture; fullscreen"
                                            allowfullscreen
                                            @load="onIframeLoad"
                                            @error="onIframeError"
                                        ></iframe>

                                        <!-- Loading Overlay -->
                                        <div
                                            v-if="loading"
                                            class="absolute inset-0 bg-gray-900 flex items-center justify-center"
                                        >
                                            <div class="text-center">
                                                <div
                                                    class="animate-spin rounded-full h-12 w-12 border-4 border-blue-500 border-t-transparent mb-4 mx-auto"
                                                ></div>
                                                <p
                                                    class="text-white font-medium"
                                                >
                                                    Connecting to meeting...
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Status Indicators -->
                                <div class="flex justify-center space-x-6 mt-4">
                                    <div class="flex items-center">
                                        <div
                                            class="w-3 h-3 rounded-full mr-2"
                                            :class="
                                                audioEnabled
                                                    ? 'bg-green-500 animate-pulse'
                                                    : 'bg-red-500'
                                            "
                                        ></div>
                                        <span class="text-sm text-gray-600">{{
                                            audioEnabled
                                                ? "Audio On"
                                                : "Audio Off"
                                        }}</span>
                                    </div>
                                    <div class="flex items-center">
                                        <div
                                            class="w-3 h-3 rounded-full mr-2"
                                            :class="
                                                videoEnabled
                                                    ? 'bg-green-500 animate-pulse'
                                                    : 'bg-red-500'
                                            "
                                        ></div>
                                        <span class="text-sm text-gray-600">{{
                                            videoEnabled
                                                ? "Video On"
                                                : "Video Off"
                                        }}</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Alternative Options -->
                            <div
                                v-if="!isJoined"
                                class="bg-gray-50 rounded-xl p-6 border border-gray-200"
                            >
                                <h3
                                    class="font-bold text-gray-900 mb-4 flex items-center"
                                >
                                    <svg
                                        class="w-5 h-5 mr-2 text-gray-500"
                                        fill="none"
                                        stroke="currentColor"
                                        viewBox="0 0 24 24"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M13 10V3L4 14h7v7l9-11h-7z"
                                        />
                                    </svg>
                                    Alternative Ways to Join
                                </h3>
                                <div
                                    class="grid grid-cols-1 md:grid-cols-2 gap-4"
                                >
                                    <a
                                        :href="zoomDesktopUrl"
                                        class="p-4 bg-white border border-blue-200 rounded-xl hover:border-blue-300 hover:shadow-md transition-all duration-300 flex items-center"
                                    >
                                        <div
                                            class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center mr-4"
                                        >
                                            <svg
                                                class="w-6 h-6 text-blue-600"
                                                fill="none"
                                                stroke="currentColor"
                                                viewBox="0 0 24 24"
                                            >
                                                <path
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    stroke-width="2"
                                                    d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"
                                                />
                                            </svg>
                                        </div>
                                        <div class="flex-1">
                                            <p
                                                class="font-semibold text-gray-900"
                                            >
                                                Zoom Desktop App
                                            </p>
                                            <p class="text-sm text-gray-600">
                                                Best audio/video quality
                                            </p>
                                        </div>
                                        <svg
                                            class="w-5 h-5 text-gray-400"
                                            fill="none"
                                            stroke="currentColor"
                                            viewBox="0 0 24 24"
                                        >
                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                stroke-width="2"
                                                d="M9 5l7 7-7 7"
                                            />
                                        </svg>
                                    </a>
                                    <a
                                        :href="meeting.join_url"
                                        target="_blank"
                                        class="p-4 bg-white border border-green-200 rounded-xl hover:border-green-300 hover:shadow-md transition-all duration-300 flex items-center"
                                    >
                                        <div
                                            class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center mr-4"
                                        >
                                            <svg
                                                class="w-6 h-6 text-green-600"
                                                fill="none"
                                                stroke="currentColor"
                                                viewBox="0 0 24 24"
                                            >
                                                <path
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    stroke-width="2"
                                                    d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m12 0a9 9 0 01-9 9m9-9a9 9 0 00-9-9"
                                                />
                                            </svg>
                                        </div>
                                        <div class="flex-1">
                                            <p
                                                class="font-semibold text-gray-900"
                                            >
                                                Zoom Web Client
                                            </p>
                                            <p class="text-sm text-gray-600">
                                                Open in browser tab
                                            </p>
                                        </div>
                                        <svg
                                            class="w-5 h-5 text-gray-400"
                                            fill="none"
                                            stroke="currentColor"
                                            viewBox="0 0 24 24"
                                        >
                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                stroke-width="2"
                                                d="M9 5l7 7-7 7"
                                            />
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </div>

                        <!-- Details Tab -->
                        <div v-if="activeTab === 'details'" class="space-y-8">
                            <!-- Meeting Info Cards -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Meeting ID -->
                                <div
                                    class="bg-blue-50 border border-blue-200 rounded-xl p-6"
                                >
                                    <div class="flex items-center mb-4">
                                        <div
                                            class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center mr-3"
                                        >
                                            <svg
                                                class="w-5 h-5 text-blue-600"
                                                fill="none"
                                                stroke="currentColor"
                                                viewBox="0 0 24 24"
                                            >
                                                <path
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    stroke-width="2"
                                                    d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"
                                                />
                                            </svg>
                                        </div>
                                        <div>
                                            <h3 class="font-bold text-gray-900">
                                                Meeting ID
                                            </h3>
                                        </div>
                                    </div>
                                    <div
                                        class="flex items-center justify-between"
                                    >
                                        <p
                                            class="font-mono text-2xl font-bold text-gray-900"
                                        >
                                            {{ meeting.zoom_meeting_id }}
                                        </p>
                                        <button
                                            @click="
                                                copyToClipboard(
                                                    meeting.zoom_meeting_id,
                                                    'Meeting ID'
                                                )
                                            "
                                            class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors text-sm font-medium"
                                        >
                                            Copy
                                        </button>
                                    </div>
                                </div>

                                <!-- Password -->
                                <div
                                    class="bg-green-50 border border-green-200 rounded-xl p-6"
                                >
                                    <div class="flex items-center mb-4">
                                        <div
                                            class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center mr-3"
                                        >
                                            <svg
                                                class="w-5 h-5 text-green-600"
                                                fill="none"
                                                stroke="currentColor"
                                                viewBox="0 0 24 24"
                                            >
                                                <path
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    stroke-width="2"
                                                    d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"
                                                />
                                            </svg>
                                        </div>
                                        <div>
                                            <h3 class="font-bold text-gray-900">
                                                Password
                                            </h3>
                                        </div>
                                    </div>
                                    <div
                                        class="flex items-center justify-between"
                                    >
                                        <p
                                            class="font-mono text-2xl font-bold text-gray-900"
                                        >
                                            {{ meeting.password }}
                                        </p>
                                        <button
                                            @click="
                                                copyToClipboard(
                                                    meeting.password,
                                                    'Password'
                                                )
                                            "
                                            class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors text-sm font-medium"
                                        >
                                            Copy
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <!-- Host Info -->
                            <div
                                v-if="meeting.admin"
                                class="bg-gradient-to-r from-blue-50 to-indigo-50 border border-blue-200 rounded-xl p-6"
                            >
                                <div class="flex items-center mb-4">
                                    <div
                                        class="w-12 h-12 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-full flex items-center justify-center mr-4"
                                    >
                                        <svg
                                            class="w-6 h-6 text-white"
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
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-600">
                                            Meeting Host
                                        </p>
                                        <h3
                                            class="text-xl font-bold text-gray-900"
                                        >
                                            {{ meeting.admin.name }}
                                        </h3>
                                    </div>
                                </div>
                                <p class="text-gray-700">
                                    This meeting is hosted by
                                    <span class="font-semibold">{{
                                        meeting.admin.name
                                    }}</span
                                    >. They will start the meeting and manage
                                    participants.
                                </p>
                            </div>

                            <!-- Meeting Details -->
                            <div
                                class="bg-white border border-gray-200 rounded-xl p-6"
                            >
                                <h3
                                    class="font-bold text-gray-900 text-lg mb-4"
                                >
                                    Meeting Information
                                </h3>
                                <div
                                    class="grid grid-cols-1 md:grid-cols-2 gap-6"
                                >
                                    <div>
                                        <h4
                                            class="font-semibold text-gray-900 mb-2"
                                        >
                                            Time & Duration
                                        </h4>
                                        <ul class="space-y-2 text-gray-600">
                                            <li class="flex items-center">
                                                <svg
                                                    class="w-4 h-4 mr-2 text-blue-500"
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
                                                {{
                                                    formatDateTime(
                                                        meeting.start_time
                                                    )
                                                }}
                                            </li>
                                            <li class="flex items-center">
                                                <svg
                                                    class="w-4 h-4 mr-2 text-blue-500"
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
                                                duration
                                            </li>
                                            <li class="flex items-center">
                                                <svg
                                                    class="w-4 h-4 mr-2 text-blue-500"
                                                    fill="none"
                                                    stroke="currentColor"
                                                    viewBox="0 0 24 24"
                                                >
                                                    <path
                                                        stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"
                                                    />
                                                </svg>
                                                Timezone:
                                                {{ meeting.timezone || "UTC" }}
                                            </li>
                                        </ul>
                                    </div>
                                    <div>
                                        <h4
                                            class="font-semibold text-gray-900 mb-2"
                                        >
                                            Quick Links
                                        </h4>
                                        <div class="space-y-3">
                                            <button
                                                @click="
                                                    copyToClipboard(
                                                        meeting.join_url,
                                                        'Meeting Link'
                                                    )
                                                "
                                                class="w-full flex items-center justify-between p-3 bg-gray-50 hover:bg-gray-100 rounded-lg transition-colors"
                                            >
                                                <span
                                                    class="font-medium text-gray-700"
                                                    >Copy Meeting Link</span
                                                >
                                                <svg
                                                    class="w-5 h-5 text-gray-500"
                                                    fill="none"
                                                    stroke="currentColor"
                                                    viewBox="0 0 24 24"
                                                >
                                                    <path
                                                        stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"
                                                    />
                                                </svg>
                                            </button>
                                            <a
                                                :href="meeting.join_url"
                                                target="_blank"
                                                class="w-full flex items-center justify-between p-3 bg-blue-50 hover:bg-blue-100 rounded-lg transition-colors"
                                            >
                                                <span
                                                    class="font-medium text-blue-700"
                                                    >Open in New Tab</span
                                                >
                                                <svg
                                                    class="w-5 h-5 text-blue-500"
                                                    fill="none"
                                                    stroke="currentColor"
                                                    viewBox="0 0 24 24"
                                                >
                                                    <path
                                                        stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"
                                                    />
                                                </svg>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Help Tab -->
                        <div v-if="activeTab === 'help'" class="space-y-8">
                            <!-- Common Issues -->
                            <div
                                class="bg-white border border-gray-200 rounded-xl p-6"
                            >
                                <h3
                                    class="font-bold text-gray-900 text-lg mb-4"
                                >
                                    Common Issues & Solutions
                                </h3>
                                <div class="space-y-4">
                                    <div
                                        class="p-4 bg-red-50 border border-red-200 rounded-lg"
                                    >
                                        <div class="flex items-center mb-2">
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
                                                    d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.732-.833-2.464 0L4.288 16.5c-.77.833.192 2.5 1.732 2.5z"
                                                />
                                            </svg>
                                            <h4
                                                class="font-semibold text-red-800"
                                            >
                                                Audio/Video Not Working?
                                            </h4>
                                        </div>
                                        <ul
                                            class="text-red-700 text-sm space-y-1 ml-7"
                                        >
                                            <li>
                                                • Click the lock icon 🔒 in your
                                                browser address bar
                                            </li>
                                            <li>
                                                • Allow camera and microphone
                                                permissions
                                            </li>
                                            <li>
                                                • Use Google Chrome for best
                                                compatibility
                                            </li>
                                            <li>
                                                • Ensure no other app is using
                                                your camera/mic
                                            </li>
                                        </ul>
                                    </div>

                                    <div
                                        class="p-4 bg-blue-50 border border-blue-200 rounded-lg"
                                    >
                                        <div class="flex items-center mb-2">
                                            <svg
                                                class="w-5 h-5 text-blue-500 mr-2"
                                                fill="none"
                                                stroke="currentColor"
                                                viewBox="0 0 24 24"
                                            >
                                                <path
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    stroke-width="2"
                                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"
                                                />
                                            </svg>
                                            <h4
                                                class="font-semibold text-blue-800"
                                            >
                                                Can't Join Meeting?
                                            </h4>
                                        </div>
                                        <ul
                                            class="text-blue-700 text-sm space-y-1 ml-7"
                                        >
                                            <li>
                                                • Ensure meeting has started
                                                (host must be present)
                                            </li>
                                            <li>
                                                • Verify meeting ID and password
                                                are correct
                                            </li>
                                            <li>
                                                • Try alternative join methods
                                                below
                                            </li>
                                            <li>
                                                • Contact host if issues persist
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <!-- Contact Support -->
                            <div
                                class="bg-gradient-to-r from-blue-500 to-indigo-600 rounded-xl p-6 text-white"
                            >
                                <div class="flex items-center mb-4">
                                    <svg
                                        class="w-8 h-8 mr-3"
                                        fill="none"
                                        stroke="currentColor"
                                        viewBox="0 0 24 24"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"
                                        />
                                    </svg>
                                    <div>
                                        <h3 class="text-xl font-bold">
                                            Need More Help?
                                        </h3>
                                        <p class="text-blue-100">
                                            Contact meeting host or technical
                                            support
                                        </p>
                                    </div>
                                </div>
                                <div
                                    class="grid grid-cols-1 md:grid-cols-2 gap-4"
                                >
                                    <div
                                        class="bg-white/20 backdrop-blur-sm rounded-lg p-4"
                                    >
                                        <p class="font-semibold">
                                            Meeting Host
                                        </p>
                                        <p class="text-sm opacity-90">
                                            {{
                                                meeting.admin?.name ||
                                                "Not specified"
                                            }}
                                        </p>
                                    </div>
                                    <div
                                        class="bg-white/20 backdrop-blur-sm rounded-lg p-4"
                                    >
                                        <p class="font-semibold">Meeting ID</p>
                                        <p class="font-mono text-sm">
                                            {{ meeting.zoom_meeting_id }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Back Button -->
                <div class="mt-8 text-center">
                    <Link
                        :href="'/meetings/' + meeting.id"
                        class="inline-flex items-center px-6 py-3 bg-white border border-gray-300 text-gray-700 rounded-xl hover:bg-gray-50 hover:border-gray-400 transition-all duration-300 font-medium shadow-sm"
                    >
                        <svg
                            class="w-5 h-5 mr-2"
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
                        Back to Meetings List
                    </Link>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, computed, onMounted } from "vue";
import { Link } from "@inertiajs/vue3";

const props = defineProps({
    meeting: Object,
});

// ========== STATE ==========
const activeTab = ref("join");
const loading = ref(false);
const isJoined = ref(false);
const isFullscreen = ref(false);
const showBrowserWarning = ref(false);
const audioEnabled = ref(true);
const videoEnabled = ref(true);
const zoomIframe = ref(null);

// ========== COMPUTED PROPERTIES ==========
const meetingStatus = computed(() => {
    if (!props.meeting.start_time) return "Scheduled";

    const meetingTime = new Date(props.meeting.start_time);
    const now = new Date();
    const timeDiff = meetingTime - now;

    if (timeDiff <= 0) return "Live Now";
    if (timeDiff < 15 * 60 * 1000) return "Starting Soon";
    return "Scheduled";
});

const statusDotColor = computed(() => {
    switch (meetingStatus.value) {
        case "Live Now":
            return "bg-green-500";
        case "Starting Soon":
            return "bg-yellow-500";
        case "Scheduled":
            return "bg-blue-500";
        default:
            return "bg-gray-500";
    }
});

const statusMessage = computed(() => {
    if (!props.meeting.start_time) return "";

    const meetingTime = new Date(props.meeting.start_time);
    const now = new Date();
    const timeDiff = meetingTime - now;

    if (timeDiff <= 0) return "Meeting is in progress. You can join now.";
    if (timeDiff < 15 * 60 * 1000) {
        const minutes = Math.floor(timeDiff / (60 * 1000));
        return `Meeting starts in ${minutes} minute${minutes !== 1 ? "s" : ""}`;
    }
    return `Meeting starts at ${formatDateTime(props.meeting.start_time)}`;
});

const zoomDesktopUrl = computed(() => {
    return `zoommtg://zoom.us/join?confno=${props.meeting.zoom_meeting_id}&pwd=${props.meeting.password}`;
});

const finalZoomUrl = computed(() => {
    if (!props.meeting.zoom_meeting_id || !props.meeting.password) return "#";

    const params = new URLSearchParams({
        pwd: props.meeting.password,
        wpk: props.meeting.password,
        uname: "Guest",
        audio: audioEnabled.value ? "on" : "off",
        video: videoEnabled.value ? "on" : "off",
        zm: "1",
    });

    return `https://zoom.us/wc/${
        props.meeting.zoom_meeting_id
    }/join?${params.toString()}`;
});

// ========== METHODS ==========
const formatDateTime = (dateString) => {
    if (!dateString) return "Date not specified";
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

const checkBrowserCompatibility = () => {
    const isChrome = /chrome|chromium|crios/i.test(navigator.userAgent);
    const isFirefox = /firefox|fxios/i.test(navigator.userAgent);
    const isEdge = /edg/i.test(navigator.userAgent);

    if (!isChrome && !isFirefox && !isEdge) {
        showBrowserWarning.value = true;
    }
};

const joinWithVideoAudio = async () => {
    try {
        const stream = await navigator.mediaDevices.getUserMedia({
            audio: true,
            video: true,
        });

        stream.getTracks().forEach((track) => track.stop());

        audioEnabled.value = true;
        videoEnabled.value = true;
        joinMeeting();
    } catch (error) {
        console.error("Failed to get media permissions:", error);
        showToast(
            "Please allow camera and microphone access to join with video."
        );
    }
};

const joinWithAudioOnly = async () => {
    try {
        const stream = await navigator.mediaDevices.getUserMedia({
            audio: true,
            video: false,
        });
        stream.getTracks().forEach((track) => track.stop());

        audioEnabled.value = true;
        videoEnabled.value = false;
        joinMeeting();
    } catch (error) {
        console.error("Failed to get audio permission:", error);
        showToast("Please allow microphone access to join with audio.");
    }
};

const joinWithoutMedia = () => {
    audioEnabled.value = false;
    videoEnabled.value = false;
    joinMeeting();
};

const joinMeeting = () => {
    isJoined.value = true;
    loading.value = true;
    activeTab.value = "join";
};

const onIframeLoad = () => {
    console.log("Zoom iframe loaded successfully");
    loading.value = false;

    // Wait for Zoom to initialize
    setTimeout(() => {
        if (zoomIframe.value && zoomIframe.value.contentWindow) {
            zoomIframe.value.contentWindow.postMessage(
                {
                    type: "zoom-controls",
                    audio: audioEnabled.value,
                    video: videoEnabled.value,
                },
                "*"
            );
        }
    }, 3000);
};

const onIframeError = () => {
    console.error("Failed to load Zoom iframe");
    loading.value = false;
    showToast("Failed to load meeting. Please try an alternative method.");
};

const toggleAudio = () => {
    audioEnabled.value = !audioEnabled.value;

    if (zoomIframe.value && zoomIframe.value.contentWindow) {
        zoomIframe.value.contentWindow.postMessage(
            {
                type: "toggle-audio",
                enabled: audioEnabled.value,
            },
            "*"
        );
    }

    showToast(audioEnabled.value ? "Audio enabled" : "Audio muted");
};

const toggleVideo = () => {
    videoEnabled.value = !videoEnabled.value;

    if (zoomIframe.value && zoomIframe.value.contentWindow) {
        zoomIframe.value.contentWindow.postMessage(
            {
                type: "toggle-video",
                enabled: videoEnabled.value,
            },
            "*"
        );
    }

    showToast(videoEnabled.value ? "Video enabled" : "Video disabled");
};

const leaveMeeting = () => {
    isJoined.value = false;
    audioEnabled.value = true;
    videoEnabled.value = true;
    loading.value = false;
};

const toggleFullscreen = () => {
    const container = document.querySelector(".relative");
    if (!container) return;

    if (!isFullscreen.value) {
        if (container.requestFullscreen) {
            container.requestFullscreen();
        } else if (container.webkitRequestFullscreen) {
            container.webkitRequestFullscreen();
        }
        isFullscreen.value = true;
    } else {
        if (document.exitFullscreen) {
            document.exitFullscreen();
        } else if (document.webkitExitFullscreen) {
            document.webkitExitFullscreen();
        }
        isFullscreen.value = false;
    }
};

const copyToClipboard = async (text, label) => {
    try {
        await navigator.clipboard.writeText(text);
        showToast(`${label} copied to clipboard!`);
    } catch (err) {
        // Fallback
        const textArea = document.createElement("textarea");
        textArea.value = text;
        document.body.appendChild(textArea);
        textArea.select();
        document.execCommand("copy");
        document.body.removeChild(textArea);
        showToast(`${label} copied to clipboard!`);
    }
};

const showToast = (message) => {
    const toast = document.createElement("div");
    toast.className =
        "fixed bottom-4 right-4 bg-gray-900 text-white px-6 py-3 rounded-lg shadow-xl z-50 animate-fade-in";
    toast.textContent = message;
    document.body.appendChild(toast);

    setTimeout(() => {
        toast.classList.add("animate-fade-out");
        setTimeout(() => {
            if (toast.parentNode) toast.parentNode.removeChild(toast);
        }, 300);
    }, 3000);
};

// ========== LIFECYCLE ==========
onMounted(() => {
    checkBrowserCompatibility();

    // Add styles for animations
    const style = document.createElement("style");
    style.textContent = `
        .animate-fade-in {
            animation: fadeIn 0.3s ease-out;
        }
        .animate-fade-out {
            animation: fadeOut 0.3s ease-out;
        }
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        @keyframes fadeOut {
            from {
                opacity: 1;
                transform: translateY(0);
            }
            to {
                opacity: 0;
                transform: translateY(10px);
            }
        }
        .animate-pulse {
            animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
        }
        @keyframes pulse {
            0%, 100% {
                opacity: 1;
            }
            50% {
                opacity: 0.5;
            }
        }
        .animate-spin {
            animation: spin 1s linear infinite;
        }
        @keyframes spin {
            from {
                transform: rotate(0deg);
            }
            to {
                transform: rotate(360deg);
            }
        }
    `;
    document.head.appendChild(style);
});
</script>
