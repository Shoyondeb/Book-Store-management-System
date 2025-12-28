// resources/js/bootstrap.js
import axios from 'axios';

// Create axios instance with ALL required settings
const axiosInstance = axios.create({
    baseURL: '/',
    withCredentials: true, // CRITICAL: Send cookies
    headers: {
        'X-Requested-With': 'XMLHttpRequest',
        'Accept': 'application/json',
        'Content-Type': 'application/json'
    }
});

// Function to get CSRF token safely
function getCsrfToken() {
    // First try meta tag
    const metaToken = document.querySelector('meta[name="csrf-token"]');
    if (metaToken && metaToken.content) {
        return metaToken.content;
    }
    
    // Fallback to cookie
    const cookieMatch = document.cookie.match(/XSRF-TOKEN=([^;]+)/);
    if (cookieMatch) {
        return decodeURIComponent(cookieMatch[1]);
    }
    
    console.error('CSRF token not found!');
    return null;
}

// Set CSRF token for all requests
axiosInstance.interceptors.request.use(config => {
    const token = getCsrfToken();
    if (token) {
        config.headers['X-CSRF-TOKEN'] = token;
        config.headers['X-XSRF-TOKEN'] = token;
    }
    return config;
});

// Make it globally available
window.axios = axiosInstance;

// Also export for imports
export default axiosInstance;