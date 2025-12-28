<template>
    <div class="admin-layout">
        <AdminNavbar />
        <div class="admin-content">
            <AdminSidebar />
            <div class="main-content-area">
                <main class="content-wrapper">
                    <slot />
                </main>
                <AdminFooter />
            </div>
        </div>
        <FlashMessage />
    </div>
</template>

<script setup>
import AdminNavbar from "@/Components/AdminNavbar.vue";
import AdminSidebar from "@/Components/AdminSidebar.vue";
import FlashMessage from "@/Components/FlashMessage.vue";
import AdminFooter from "@/Components/AdminFooter.vue";
</script>

<style scoped>
.admin-layout {
    min-height: 100vh;
    background: #f9fafb;
}

.admin-content {
    display: flex;
    min-height: 100vh;
    padding-top: 4rem; /* Space for fixed navbar */
}

/* Sidebar fixed positioning */
.admin-sidebar {
    position: fixed;
    left: 0;
    top: 4rem; /* Start below navbar */
    bottom: 0; /* Stretch to bottom */
    width: 280px;
    z-index: 900;
    overflow-y: auto;
    background: linear-gradient(135deg, #1f2937 0%, #111827 100%);
}

/* Main content area */
.main-content-area {
    flex: 1;
    margin-left: 280px; /* Account for sidebar */
    min-height: calc(100vh - 4rem);
    display: flex;
    flex-direction: column;
}

/* Content wrapper */
.content-wrapper {
    flex: 1;
    padding: 1.5rem 2rem;
    background: #f9fafb;
}

/* Footer stays at bottom */
.admin-footer {
    margin-top: auto;
    background: white;
    border-top: 1px solid #e5e7eb;
}

/* Responsive design */
@media (max-width: 1024px) {
    .admin-sidebar {
        transform: translateX(-100%);
        transition: transform 0.3s ease;
    }

    .admin-sidebar.mobile-open {
        transform: translateX(0);
    }

    .main-content-area {
        margin-left: 0;
        width: 100%;
    }
}

@media (max-width: 768px) {
    .content-wrapper {
        padding: 1rem;
    }
}
</style>
