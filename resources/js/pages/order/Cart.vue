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
.cart-page {
    --surface: rgba(255, 255, 255, .92);
    --surface-solid: #ffffff;
    --surface-soft: #fff0e5;
    --text: #261b16;
    --muted: #6b5b52;
    --muted-soft: #9a8171;
    --primary: #f04a2a;
    --primary-hover: #df3517;
    --primary-soft: #fff0eb;
    --orange: #ff8a2a;
    --yellow: #ffcf4d;
    --green: #7fa14b;
    --border: #f0dfcc;
    --shadow: 0 12px 30px rgba(83, 45, 23, .08);
    --shadow-hover: 0 20px 45px rgba(83, 45, 23, .14);

    position: relative;
    padding: 170px 0 80px;
    color: var(--text);
}

.cart-page::before {
    content: "";
    position: fixed;
    inset: 0;
    pointer-events: none;
    background:
        radial-gradient(circle at 10% 14%, rgba(255, 207, 77, .24), transparent 28%),
        radial-gradient(circle at 88% 24%, rgba(240, 74, 42, .16), transparent 26%),
        linear-gradient(180deg, #fff9f2 0%, #fff3e6 100%);
    z-index: -1;
}

.cart-title {
    margin-bottom: 34px;
}

.cart-title span,
.card-heading span,
.summary-header span {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    color: var(--primary);
    font-size: 12px;
    font-weight: 950;
    text-transform: uppercase;
    letter-spacing: 1.4px;
}

.cart-title span::before,
.card-heading span::before,
.summary-header span::before {
    content: "";
    width: 26px;
    height: 4px;
    border-radius: 999px;
    background: linear-gradient(90deg, var(--primary), var(--orange));
}

.cart-title h1 {
    color: var(--text);
    font-size: 44px;
    font-weight: 950;
    letter-spacing: -.9px;
    margin: 8px 0;
}

.cart-title p {
    color: var(--muted);
    margin: 0;
    font-size: 16px;
}

.cart-list-card,
.summary-card {
    position: relative;
    overflow: hidden;
    background: var(--surface);
    backdrop-filter: blur(18px);
    border: 1px solid rgba(240, 223, 204, .95);
    border-radius: 28px;
    padding: 28px;
    box-shadow: var(--shadow);
}

.cart-list-card::before,
.summary-card::before {
    content: "";
    position: absolute;
    inset: 0 0 auto 0;
    height: 6px;
    background: linear-gradient(90deg, var(--primary), var(--orange), var(--yellow));
}

.cart-list-card:hover,
.summary-card:hover {
    box-shadow: var(--shadow-hover);
}

.card-heading,
.summary-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    gap: 15px;
    margin-bottom: 24px;
    border-bottom: 1px solid var(--border);
    padding-bottom: 18px;
}

.card-heading h2,
.summary-header h2 {
    color: var(--text);
    margin: 4px 0 0;
    font-size: 26px;
    font-weight: 950;
    letter-spacing: -.4px;
}

.summary-header strong {
    background: linear-gradient(135deg, var(--primary), var(--orange));
    color: #ffffff;
    padding: 8px 14px;
    border-radius: 999px;
    font-size: 12px;
    white-space: nowrap;
    box-shadow: 0 12px 24px rgba(240, 74, 42, .22);
}

.cart-empty {
    text-align: center;
    padding: 55px 15px;
    color: var(--muted);
}

.cart-empty i {
    display: block;
    color: var(--primary);
    font-size: 56px;
    margin-bottom: 16px;
}

.cart-empty h5 {
    color: var(--text);
    font-size: 22px;
    font-weight: 950;
    margin-bottom: 8px;
}

.cart-empty p {
    color: var(--muted);
    margin-bottom: 20px;
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
    padding: 18px 0;
    border-bottom: 1px solid var(--border);
}

.cart-item:last-child {
    border-bottom: none;
}

.cart-item-info h6 {
    color: var(--text);
    font-size: 16px;
    font-weight: 950;
    margin: 0 0 5px;
}

.cart-item-info small {
    color: var(--muted-soft);
}

.cart-item-actions {
    display: flex;
    align-items: center;
    gap: 14px;
}

.cart-item-actions strong {
    color: var(--primary);
    font-weight: 950;
    white-space: nowrap;
}

.quantity-control {
    display: inline-flex;
    align-items: center;
    border: 1px solid var(--border);
    border-radius: 999px;
    overflow: hidden;
    background: var(--surface-soft);
}

.quantity-control button {
    width: 34px;
    height: 32px;
    border: none;
    background: transparent;
    color: var(--primary);
    font-size: 18px;
    font-weight: 950;
    transition: all .2s ease;
}

.quantity-control button:hover {
    background: var(--primary);
    color: #ffffff;
}

.quantity-control span {
    min-width: 36px;
    text-align: center;
    color: var(--text);
    font-weight: 950;
    font-size: 14px;
}

.remove-btn {
    width: 28px;
    height: 28px;
    border-radius: 50%;
    border: 1px solid var(--border);
    background: var(--surface-solid);
    color: var(--muted-soft);
    line-height: 1;
    font-size: 18px;
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
    margin-top: 6px;
    border-top: 1px solid var(--border);
    padding-top: 20px;
}

.summary-totals > div {
    display: flex;
    justify-content: space-between;
    margin-bottom: 13px;
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
    margin-top: 16px;
    padding-top: 16px;
    border-top: 1px solid var(--border);
    font-size: 21px !important;
    font-weight: 950;
}

.grand-total strong {
    color: var(--primary);
    font-size: 29px;
}

.checkout-btn,
.continue-btn,
.clear-btn {
    width: 100%;
    margin-top: 14px;
    height: 54px;
    border-radius: 16px;
    font-weight: 950;
    letter-spacing: .3px;
    transition: all .25s ease;
}

.checkout-btn {
    border: none;
    background: linear-gradient(135deg, var(--primary), var(--orange));
    color: #ffffff;
    box-shadow: 0 16px 34px rgba(240, 74, 42, .24);
}

.checkout-btn:hover:not(:disabled) {
    background: linear-gradient(135deg, var(--primary-hover), var(--primary));
    transform: translateY(-2px);
}

.checkout-btn:disabled {
    background: #d7cec6;
    color: rgba(37, 37, 37, .45);
    box-shadow: none;
    cursor: not-allowed;
}

.continue-btn {
    border: 1px solid var(--border);
    background: rgba(255, 255, 255, .72);
    color: var(--text);
}

.continue-btn:hover {
    border-color: rgba(240, 74, 42, .42);
    background: var(--primary-soft);
    color: var(--primary);
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
    margin: 14px 0 0;
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
        font-size: 34px;
    }

    .cart-item {
        flex-direction: column;
        align-items: flex-start;
    }

    .cart-item-actions {
        width: 100%;
        justify-content: space-between;
    }

    .cart-list-card,
    .summary-card {
        padding: 22px;
    }

    .card-heading,
    .summary-header {
        flex-direction: column;
    }
}
</style>
