<template>
    <aside class="admin-sidebar">
        <!-- Sidebar Content -->
        <div class="sidebar-content">
            <!-- Header -->
            <div class="sidebar-header">
                <div class="logo">
                    <!-- Logo Image -->
                    <img
                        src="/images/logo.png"
                        alt="PUSTOK Logo"
                        class="rounded-full border-2 border-gray-300"
                        style="width: 75px; height: 75px; object-fit: cover"
                    />

                    <div class="logo-text">
                        <h2>PUSTOK.com</h2>
                        <p>Admin Panel</p>
                    </div>
                </div>
            </div>

            <!-- Navigation -->
            <nav class="sidebar-nav">
                <div class="nav-section">
                    <p class="section-label">Management</p>
                    <div class="nav-links">
                        <Link
                            :href="route('admin.dashboard')"
                            class="nav-link"
                            :class="{
                                active: $page.url.startsWith(
                                    '/admin/dashboard'
                                ),
                            }"
                        >
                            <i class="fas fa-chart-pie"></i>
                            <span>Dashboard</span>
                            <div class="active-indicator"></div>
                        </Link>

                        <Link
                            :href="route('admin.books.index')"
                            class="nav-link"
                            :class="{
                                active: $page.url.startsWith('/admin/books'),
                            }"
                        >
                            <i class="fas fa-book"></i>
                            <span>Books</span>
                            <div class="active-indicator"></div>
                        </Link>

                        <Link
                            :href="route('admin.categories.index')"
                            class="nav-link"
                            :class="{
                                active: $page.url.startsWith(
                                    '/admin/categories'
                                ),
                            }"
                        >
                            <i class="fas fa-tags"></i>
                            <span>Categories</span>
                            <div class="active-indicator"></div>
                        </Link>

                        <Link
                            :href="route('admin.authors.index')"
                            class="nav-link"
                            :class="{
                                active: $page.url.startsWith('/admin/authors'),
                            }"
                        >
                            <i class="fas fa-user-edit"></i>
                            <span>Authors</span>
                            <div class="active-indicator"></div>
                        </Link>

                        <Link
                            :href="route('admin.orders.index')"
                            class="nav-link"
                            :class="{
                                active: $page.url.startsWith('/admin/orders'),
                            }"
                        >
                            <i class="fas fa-shopping-bag"></i>
                            <span>Orders</span>
                            <div class="active-indicator"></div>
                        </Link>

                        <Link
                            :href="route('admin.users.list')"
                            class="nav-link"
                            :class="{
                                active: $page.url.startsWith('/admin/users'),
                            }"
                        >
                            <i class="fas fa-users"></i>
                            <span>Users</span>
                            <div class="active-indicator"></div>
                        </Link>
                    </div>
                </div>

                <!-- Back to Shop -->
                <div class="nav-section">
                    <div class="nav-links">
                        <Link
                            :href="route('shop.home')"
                            class="nav-link back-link"
                        >
                            <i class="fas fa-store"></i>
                            <span>Back to Shop</span>
                            <div class="link-arrow">
                                <i class="fas fa-arrow-right"></i>
                            </div>
                        </Link>
                    </div>
                </div>
            </nav>

            <!-- User Profile -->
            <div class="sidebar-footer">
                <div class="user-profile">
                    <div class="user-avatar">
                        <i class="fas fa-user-circle"></i>
                    </div>
                    <div class="user-info">
                        <p class="user-name">Administrator</p>
                        <p class="user-role">Admin</p>
                    </div>
                </div>
            </div>
        </div>
    </aside>
</template>

<script setup>
import { Link } from "@inertiajs/vue3";
</script>

<style scoped>
/* Main sidebar container */
.admin-sidebar {
    width: 280px;
    background: linear-gradient(135deg, #1f2937 0%, #111827 100%);
    color: white;
}

/* Sidebar content wrapper */
.sidebar-content {
    display: flex;
    flex-direction: column;
    height: 100%;
}

/* Header */
.sidebar-header {
    padding: 1rem 1.5rem;
    border-bottom: 1px solid #374151;
}

.logo {
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.logo-icon {
    width: 40px;
    height: 40px;
    background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%);
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.25rem;
}

.logo-text h2 {
    font-size: 1.25rem;
    font-weight: 700;
    margin: 0;
}

.logo-text p {
    font-size: 0.75rem;
    color: #9ca3af;
    margin: 0;
}

/* Navigation */
.sidebar-nav {
    flex: 1;
    padding: 1.5rem;
    display: flex;
    flex-direction: column;
    gap: 2rem;
    overflow-y: auto;
}

.section-label {
    font-size: 0.75rem;
    font-weight: 600;
    color: #9ca3af;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    margin-bottom: 0.75rem;
    padding-left: 0.5rem;
}

.nav-links {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
}

.nav-link {
    position: relative;
    display: flex;
    align-items: center;
    gap: 0.75rem;
    padding: 0.875rem 1rem;
    color: #d1d5db;
    text-decoration: none;
    border-radius: 8px;
    transition: all 0.2s ease;
    overflow: hidden;
}

.nav-link:hover {
    background: rgba(255, 255, 255, 0.05);
    color: white;
    transform: translateX(4px);
}

.nav-link.active {
    background: linear-gradient(
        135deg,
        rgba(99, 102, 241, 0.15) 0%,
        rgba(139, 92, 246, 0.15) 100%
    );
    color: white;
    border-left: 3px solid #6366f1;
}

.nav-link.active .active-indicator {
    opacity: 1;
}

.nav-link i {
    width: 20px;
    text-align: center;
    font-size: 1.125rem;
}

.nav-link span {
    font-weight: 500;
    flex: 1;
}

.active-indicator {
    position: absolute;
    right: 1rem;
    width: 6px;
    height: 6px;
    background: #10b981;
    border-radius: 50%;
    opacity: 0;
    transition: opacity 0.2s ease;
}

.back-link {
    background: rgba(255, 255, 255, 0.03);
    border: 1px solid #374151;
    margin-top: 1rem;
}

.back-link:hover {
    background: rgba(255, 255, 255, 0.08);
    border-color: #4b5563;
}

.link-arrow {
    opacity: 0;
    transform: translateX(-4px);
    transition: all 0.2s ease;
}

.back-link:hover .link-arrow {
    opacity: 1;
    transform: translateX(0);
}

/* Footer */
.sidebar-footer {
    padding: 1.5rem;
    border-top: 1px solid #374151;
}

.user-profile {
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.user-avatar {
    font-size: 2.5rem;
    color: #6366f1;
}

.user-info {
    flex: 1;
}

.user-name {
    font-weight: 600;
    margin: 0;
    font-size: 0.9rem;
}

.user-role {
    color: #9ca3af;
    margin: 0;
    font-size: 0.75rem;
}
</style>
