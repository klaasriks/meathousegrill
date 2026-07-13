<script setup lang="ts">
import AppLayout from '@/layouts/restaurantly/AppLayout.vue';
import { computed } from 'vue';
import { useRestaurantCart } from '@/composables/useRestaurantCart';

defineOptions({
    layout: AppLayout,
});

const {
    cart,
    cartCount,
    subtotal,
    increaseQuantity,
    decreaseQuantity,
    removeFromCart,
    clearCart,
    formatCurrency,
    persistCart,
} = useRestaurantCart();

const total = computed(() => {
    return subtotal.value;
});

const removeItem = (cartKey: string) => {
    removeFromCart(cartKey);
};

const proceedToCheckout = () => {
    if (!cart.value.length) return;

    persistCart();
    window.location.href = '/checkout';
};

const continueShopping = () => {
    window.location.href = '/order';
};
</script>

<template>
    <div class="container cart-page">
        <div class="cart-title">
            <span>Your Cart</span>
            <h1>Review Your Order</h1>
            <p>Check your meal items, update quantities, and proceed to checkout when ready.</p>
        </div>

        <div class="row g-4">
            <div class="col-lg-8">
                <div class="cart-list-card">
                    <div class="card-heading">
                        <span>Order Items</span>
                        <h2>Selected Meals</h2>
                    </div>

                    <div class="cart-empty" v-if="cart.length === 0">
                        <i class="bi bi-cart-x"></i>
                        <h5>Your cart is empty</h5>
                        <p>Add something delicious from the menu before checking out.</p>
                        <button class="continue-btn empty-btn" @click="continueShopping">
                            Browse Menu
                        </button>
                    </div>

                    <div class="cart-items" v-else>
                        <div class="cart-item" v-for="item in cart" :key="item.cartKey">
                            <div class="cart-item-info">
                                <h6>{{ item.name }}</h6>
                                <small>{{ item.option }} - {{ formatCurrency(item.price) }}</small>
                            </div>

                            <div class="cart-item-actions">
                                <div class="quantity-control">
                                    <button @click="decreaseQuantity(item.cartKey)">-</button>
                                    <span>{{ item.quantity }}</span>
                                    <button @click="increaseQuantity(item.cartKey)">+</button>
                                </div>

                                <strong>{{ formatCurrency(item.price * item.quantity) }}</strong>

                                <button class="remove-btn" @click="removeItem(item.cartKey)" title="Remove item">
                                    x
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="summary-card">
                    <div class="summary-header">
                        <div>
                            <span>Cart Summary</span>
                            <h2>Your Total</h2>
                        </div>

                        <strong>
                            {{ cartCount }} {{ cartCount === 1 ? 'Item' : 'Items' }}
                        </strong>
                    </div>

                    <div class="summary-totals">
                        <div>
                            <span>Subtotal</span>
                            <strong>{{ formatCurrency(subtotal) }}</strong>
                        </div>

                        <div>
                            <span>Collection</span>
                            <strong class="free-text">FREE</strong>
                        </div>

                        <div class="grand-total">
                            <span>Total</span>
                            <strong>{{ formatCurrency(total) }}</strong>
                        </div>
                    </div>

                    <button
                        class="checkout-btn"
                        :disabled="cart.length === 0"
                        @click="proceedToCheckout"
                    >
                        Proceed To Checkout
                    </button>

                    <button class="continue-btn" @click="continueShopping">
                        Continue Shopping
                    </button>

                    <button
                        class="clear-btn"
                        v-if="cart.length > 0"
                        @click="clearCart"
                    >
                        Clear Cart
                    </button>

                    <p class="summary-note">
                        Review quantities carefully before moving to checkout.
                    </p>
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>
/* ==========================================
   PROFESSIONAL MEATHOUSE CART THEME
   Matches final Order + Checkout pages
========================================== */
.cart-page {
    --page-bg: #ffffff;
    --surface: #ffffff;
    --surface-soft: #faf8f5;
    --text: #1f1f1f;
    --muted: #666666;
    --muted-soft: #8a8a8a;
    --primary: #b62323;
    --primary-hover: #971d1d;
    --primary-soft: #fff5f3;
    --green: #47632f;
    --gold: #c79a3b;
    --border: #e7e0d6;
    --border-strong: #d7c9b7;
    --shadow: 0 6px 18px rgba(31, 31, 31, .04);
    --shadow-hover: 0 12px 26px rgba(31, 31, 31, .075);

    position: relative;
    padding: 165px 0 80px;
    color: var(--text);
    background: #ffffff;
}

.cart-page::before {
    content: "";
    position: fixed;
    inset: 0;
    pointer-events: none;
    background: #ffffff;
    z-index: -1;
}

.cart-title {
    margin-bottom: 30px;
}

.cart-title span,
.card-heading span,
.summary-header span {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    color: var(--green);
    font-size: 12px;
    font-weight: 800;
    text-transform: uppercase;
    letter-spacing: 1.1px;
}

.cart-title span::before,
.card-heading span::before,
.summary-header span::before {
    content: "";
    width: 24px;
    height: 3px;
    border-radius: 999px;
    background: var(--gold);
}

.cart-title h1 {
    color: var(--text);
    font-size: 36px;
    font-weight: 850;
    letter-spacing: -.6px;
    margin: 8px 0 5px;
}

.cart-title p {
    color: var(--muted);
    margin: 0;
    font-size: 15px;
}

.cart-list-card,
.summary-card {
    position: relative;
    overflow: hidden;
    background: #ffffff;
    border: 1px solid var(--border);
    border-radius: 14px;
    padding: 24px;
    box-shadow: var(--shadow);
}

.cart-list-card:hover,
.summary-card:hover {
    border-color: var(--border-strong);
    box-shadow: var(--shadow-hover);
}

.card-heading,
.summary-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    gap: 15px;
    margin-bottom: 22px;
    border-bottom: 1px solid var(--border);
    padding-bottom: 16px;
}

.card-heading h2,
.summary-header h2 {
    color: var(--text);
    margin: 4px 0 0;
    font-size: 24px;
    font-weight: 850;
    letter-spacing: -.25px;
}

.summary-header strong {
    background: #f6f1ea;
    color: var(--text);
    padding: 7px 12px;
    border: 1px solid var(--border);
    border-radius: 999px;
    font-size: 12px;
    font-weight: 800;
    white-space: nowrap;
}

.cart-empty {
    text-align: center;
    padding: 48px 15px;
    color: var(--muted);
}

.cart-empty i {
    display: block;
    color: var(--primary);
    font-size: 48px;
    margin-bottom: 16px;
}

.cart-empty h5 {
    color: var(--text);
    font-size: 20px;
    font-weight: 850;
    margin-bottom: 8px;
}

.cart-empty p {
    color: var(--muted);
    margin-bottom: 20px;
    font-size: 14px;
}

.cart-items {
    display: flex;
    flex-direction: column;
}

.cart-item {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 18px;
    padding: 15px 0;
    border-bottom: 1px solid var(--border);
}

.cart-item:last-child {
    border-bottom: none;
}

.cart-item-info {
    min-width: 0;
}

.cart-item-info h6 {
    color: var(--text);
    font-size: 15px;
    font-weight: 800;
    margin: 0 0 5px;
    line-height: 1.35;
}

.cart-item-info small {
    color: var(--muted-soft);
    font-size: 13px;
}

.cart-item-actions {
    display: flex;
    align-items: center;
    gap: 14px;
    flex: 0 0 auto;
}

.cart-item-actions strong {
    color: var(--primary);
    font-weight: 850;
    font-size: 15px;
    white-space: nowrap;
}

.quantity-control {
    display: inline-flex;
    align-items: center;
    border: 1px solid var(--border);
    border-radius: 8px;
    overflow: hidden;
    background: #ffffff;
}

.quantity-control button {
    width: 31px;
    height: 29px;
    border: none;
    background: transparent;
    color: var(--primary);
    font-size: 16px;
    font-weight: 850;
    transition: all .2s ease;
}

.quantity-control button:hover {
    background: var(--primary);
    color: #ffffff;
}

.quantity-control span {
    min-width: 32px;
    text-align: center;
    color: var(--text);
    font-weight: 850;
    font-size: 14px;
}

.remove-btn {
    width: 25px;
    height: 25px;
    border-radius: 50%;
    border: 1px solid var(--border);
    background: #ffffff;
    color: var(--muted-soft);
    line-height: 1;
    font-size: 16px;
    transition: all .2s ease;
}

.remove-btn:hover {
    background: var(--primary);
    border-color: var(--primary);
    color: #ffffff;
}

.summary-card {
    position: sticky;
    top: 120px;
}

.summary-totals {
    margin-top: 4px;
    border-top: 1px solid var(--border);
    padding-top: 18px;
}

.summary-totals > div {
    display: flex;
    justify-content: space-between;
    margin-bottom: 12px;
    color: var(--muted);
    font-size: 15px;
}

.summary-totals strong {
    color: var(--text);
}

.free-text {
    color: var(--green) !important;
}

.grand-total {
    margin-top: 14px;
    padding-top: 14px;
    border-top: 1px solid var(--border);
    font-size: 18px !important;
    font-weight: 850;
}

.grand-total strong {
    color: var(--primary);
    font-size: 24px;
}

.checkout-btn,
.continue-btn,
.clear-btn {
    width: 100%;
    margin-top: 14px;
    height: 50px;
    border-radius: 10px;
    font-weight: 850;
    letter-spacing: .2px;
    transition: all .2s ease;
}

.checkout-btn {
    border: none;
    background: var(--primary);
    color: #ffffff;
    box-shadow: 0 10px 22px rgba(182, 35, 35, .18);
}

.checkout-btn:hover:not(:disabled) {
    background: var(--primary-hover);
    transform: translateY(-1px);
}

.checkout-btn:disabled {
    background: #dadada;
    color: rgba(37, 37, 37, .45);
    box-shadow: none;
    cursor: not-allowed;
}

.continue-btn {
    border: 1px solid var(--border);
    background: #ffffff;
    color: var(--text);
}

.continue-btn:hover {
    border-color: var(--primary);
    background: var(--primary-soft);
    color: var(--primary);
    transform: translateY(-1px);
}

.clear-btn {
    border: 1px solid var(--border);
    background: transparent;
    color: var(--muted);
}

.clear-btn:hover {
    border-color: var(--primary);
    color: var(--primary);
    background: var(--primary-soft);
}

.empty-btn {
    width: auto;
    padding: 0 28px;
}

.summary-note {
    color: var(--muted-soft);
    font-size: 12px;
    line-height: 1.6;
    margin: 13px 0 0;
    text-align: center;
}

@media (max-width: 991px) {
    .cart-page {
        padding-top: 145px;
    }

    .summary-card {
        position: relative;
        top: 0;
    }
}

@media (max-width: 768px) {
    .cart-title h1 {
        font-size: 32px;
    }

    .cart-item {
        flex-direction: column;
        align-items: flex-start;
    }

    .cart-item-actions {
        width: 100%;
        justify-content: space-between;
        gap: 10px;
    }

    .cart-list-card,
    .summary-card {
        padding: 20px;
    }

    .card-heading,
    .summary-header {
        flex-direction: column;
    }
}
</style>
