<template>
    <footer class="admin-footer">
        <div class="footer-content">
            <div class="footer-section">
                <span class="text-sm text-gray-600"
                    >BookStore Admin v2.1.0</span
                >
            </div>
            <div class="footer-section">
                <div class="flex items-center gap-2">
                    <span class="status-dot active"></span>
                    <span class="text-sm text-gray-600">System Online</span>
                </div>
            </div>
            <div class="footer-section">
                <span class="text-sm text-gray-500"
                    >&copy; {{ currentYear }} BookStore</span
                >
            </div>
        </div>
    </footer>
</template>

<script setup>
import { ref } from "vue";

const currentYear = ref(new Date().getFullYear());
</script>

<style scoped>
.admin-footer {
    background: white;
    border-top: 1px solid #e5e7eb;
    padding: 1rem 2rem;
}

.footer-content {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.footer-section {
    flex: 1;
}

.footer-section:first-child {
    text-align: left;
}

.footer-section:nth-child(2) {
    text-align: center;
}

.footer-section:last-child {
    text-align: right;
}

.status-dot {
    width: 8px;
    height: 8px;
    border-radius: 50%;
    background: #10b981;
    display: inline-block;
    animation: pulse 2s infinite;
}

@keyframes pulse {
    0%,
    100% {
        opacity: 1;
    }
    50% {
        opacity: 0.5;
    }
}

/* Responsive */
@media (max-width: 768px) {
    .footer-content {
        flex-direction: column;
        gap: 0.5rem;
        text-align: center;
    }

    .footer-section {
        text-align: center !important;
    }
}
</style>
