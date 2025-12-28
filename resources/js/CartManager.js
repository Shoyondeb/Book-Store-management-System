// resources/js/CartManager.js
class CartManager {
    constructor() {
        this.cart = {};
        this.cartCount = 0;
        this.listeners = [];
        
        // Load initial state from localStorage
        this.loadFromStorage();
        
        // Listen for storage events (cross-tab sync)
        window.addEventListener('storage', (e) => {
            if (e.key === 'cart') {
                this.loadFromStorage();
                this.notifyListeners();
            }
        });
        
        // Listen for custom events
        window.addEventListener('cart-updated', (e) => {
            this.handleCartUpdate(e.detail);
        });
    }
    
    loadFromStorage() {
        const savedCart = localStorage.getItem('cart');
        const savedCount = localStorage.getItem('cart_count');
        
        if (savedCart) {
            this.cart = JSON.parse(savedCart);
        }
        
        if (savedCount) {
            this.cartCount = parseInt(savedCount, 10);
        }
    }
    
    saveToStorage() {
        localStorage.setItem('cart', JSON.stringify(this.cart));
        localStorage.setItem('cart_count', this.cartCount.toString());
    }
    
    handleCartUpdate(detail) {
        if (detail.action === 'add') {
            this.addToCart(detail.bookId, detail.bookData);
        } else if (detail.action === 'remove') {
            this.removeFromCart(detail.bookId);
        } else if (detail.action === 'update') {
            this.updateCart(detail.bookId, detail.quantity);
        }
        
        this.cartCount = detail.cartCount || Object.keys(this.cart).length;
        this.saveToStorage();
        this.notifyListeners();
    }
    
    addToCart(bookId, bookData) {
        if (this.cart[bookId]) {
            this.cart[bookId].quantity += 1;
        } else {
            this.cart[bookId] = {
                ...bookData,
                quantity: 1
            };
        }
        this.cartCount++;
        this.saveToStorage();
        this.notifyListeners();
    }
    
    removeFromCart(bookId) {
        if (this.cart[bookId]) {
            this.cartCount -= this.cart[bookId].quantity;
            delete this.cart[bookId];
            this.saveToStorage();
            this.notifyListeners();
        }
    }
    
    updateCart(bookId, quantity) {
        if (this.cart[bookId]) {
            const oldQuantity = this.cart[bookId].quantity;
            this.cart[bookId].quantity = quantity;
            this.cartCount += (quantity - oldQuantity);
            this.saveToStorage();
            this.notifyListeners();
        }
    }
    
    subscribe(listener) {
        this.listeners.push(listener);
        return () => {
            this.listeners = this.listeners.filter(l => l !== listener);
        };
    }
    
    notifyListeners() {
        this.listeners.forEach(listener => {
            listener({
                cart: this.cart,
                cartCount: this.cartCount
            });
        });
        
        // Dispatch global event
        window.dispatchEvent(new CustomEvent('cart-state-changed', {
            detail: {
                cart: this.cart,
                cartCount: this.cartCount
            }
        }));
    }
    
    getCart() {
        return this.cart;
    }
    
    getCartCount() {
        return this.cartCount;
    }
    
    clearCart() {
        this.cart = {};
        this.cartCount = 0;
        this.saveToStorage();
        this.notifyListeners();
    }
}

// Create global instance
const cartManager = new CartManager();

export default cartManager;