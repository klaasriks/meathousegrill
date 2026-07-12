<script setup lang="ts">
import AppLayout from '@/layouts/restaurantly/AppLayout.vue';
import { computed, onMounted, ref } from 'vue';
import { useRestaurantCart } from '@/composables/useRestaurantCart';

defineOptions({
    layout: AppLayout,
});

const props = defineProps({
    menu: {
        type: Object,
        required: true,
    },
});

const selectedCategory = ref(props.menu.menu_category?.[0]?.id ?? null);

const {
    cart,
    cartCount,
    subtotal,
    addToCart,
    increaseQuantity,
    decreaseQuantity,
    removeFromCart,
    clearCart,
    toNumber,
    formatCurrency,
    persistCart,
} = useRestaurantCart();

onMounted(() => {
    if (props.menu.menu_category?.length > 0) {
        selectedCategory.value = props.menu.menu_category[0].id;
    }
});

const total = computed(() => {
    return subtotal.value;
});

const proceedToCheckout = () => {
    if (!cart.value.length) return;

    persistCart();
    window.location.href = '/checkout';
};
</script>

<template>
    <div class="container order-page">
        <div class="row g-4">
            <div class="col-lg-8">

                <div class="row">
                    <div class="col-12">
                        <div class="section-heading">
                            <span>Order Online</span>
                            <h2>Choose Your Meal</h2>
                            <p>Select your favourite items and build your order.</p>
                        </div>

                        <div class="order-menu">
                            <button
                                class="cta-btn"
                                v-for="menu_category in menu.menu_category"
                                :key="menu_category.id"
                                :class="{ active: selectedCategory === menu_category.id }"
                                @click="selectedCategory = menu_category.id"
                            >
                                {{ menu_category.name }}
                            </button>
                        </div>
                    </div>
                </div>

                <div class="row g-4">
                    <template
                        v-for="menu_category in menu.menu_category"
                        :key="menu_category.id"
                    >
                        <div
                            v-for="menu_item in menu_category.menu_items"
                            class="col-md-6 col-sm-12"
                            :class="menu_category.slug"
                            :key="menu_item.id"
                            v-show="selectedCategory === menu_category.id"
                        >
                            <div class="menu-card">
                                <div class="item-top">
                                    <div class="item-info">
                                        <h3>{{ menu_item.name }}</h3>
                                        <p class="desc">{{ menu_item.description }}</p>
                                    </div>

                                    <div class="price">
                                        {{ formatCurrency(toNumber(menu_item.price)) }}
                                    </div>
                                </div>

                                <div class="actions">
                                    <button
                                        class="btn primary"
                                        @click="addToCart(menu_item)"
                                    >
                                        + Add
                                    </button>

                                    <button
                                        class="btn alt"
                                        v-if="menu_item.chips_price"
                                        @click="addToCart(menu_item, 'Chips', menu_item.chips_price)"
                                    >
                                        Chips {{ formatCurrency(toNumber(menu_item.chips_price)) }}
                                    </button>

                                    <button
                                        class="btn alt"
                                        v-if="menu_item.drink_price"
                                        @click="addToCart(menu_item, 'Drink', menu_item.drink_price)"
                                    >
                                        Drink {{ formatCurrency(toNumber(menu_item.drink_price)) }}
                                    </button>
                                </div>
                            </div>
                        </div>
                    </template>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="cart-card">

                    <div class="cart-header">
                        <div>
                            <span class="cart-label">Current Order</span>
                            <h3>Your Order</h3>
                        </div>

                        <span class="cart-count">
                            {{ cartCount }} {{ cartCount === 1 ? 'Item' : 'Items' }}
                        </span>
                    </div>

                    <div class="cart-items">
                        <div
                            class="cart-empty"
                            v-if="cart.length === 0"
                        >
                            <i class="bi bi-cart3"></i>
                            <h5>Your cart is empty</h5>
                            <p>Add something delicious from the menu.</p>
                        </div>

                        <div
                            class="cart-item"
                            v-for="item in cart"
                            :key="item.cartKey"
                        >
                            <div class="cart-item-main">
                                <div class="cart-item-info">
                                    <h6>{{ item.name }}</h6>
                                    <small>{{ item.option }}</small>
                                </div>

                                <button
                                    class="remove-btn"
                                    @click="removeFromCart(item.cartKey)"
                                    title="Remove item"
                                >
                                    x
                                </button>
                            </div>

                            <div class="cart-item-bottom">
                                <div class="quantity-control">
                                    <button @click="decreaseQuantity(item.cartKey)">-</button>
                                    <span>{{ item.quantity }}</span>
                                    <button @click="increaseQuantity(item.cartKey)">+</button>
                                </div>

                                <div class="cart-item-price">
                                    {{ formatCurrency(item.price * item.quantity) }}
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="cart-summary">
                        <div>
                            <span>Subtotal</span>
                            <strong>{{ formatCurrency(subtotal) }}</strong>
                        </div>

                        <div>
                            <span>Collection</span>
                            <strong class="free-text">FREE</strong>
                        </div>

                        <div class="cart-total">
                            <span>Total</span>
                            <strong>{{ formatCurrency(total) }}</strong>
                        </div>
                    </div>

                    <button
                        class="checkout-btn"
                        :disabled="cart.length === 0"
                        @click="proceedToCheckout"
                    >
                        Proceed to Checkout
                    </button>

                    <button
                        class="clear-cart-btn"
                        v-if="cart.length > 0"
                        @click="clearCart"
                    >
                        Clear Order
                    </button>

                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>
/* ==========================================
   MODERN CREATIVE GRILL THEME VARIABLES
========================================== */
.order-page {
    --page-bg: #fff7ee;
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
    --cream: #fff9f2;
    --border: #f0dfcc;
    --shadow: 0 12px 30px rgba(83, 45, 23, .08);
    --shadow-hover: 0 20px 45px rgba(83, 45, 23, .14);

    position: relative;
    padding: 170px 0 80px;
    color: var(--text);
}

.order-page::before {
    content: "";
    position: fixed;
    inset: 0;
    pointer-events: none;
    background:
        radial-gradient(circle at 12% 12%, rgba(255, 207, 77, .24), transparent 28%),
        radial-gradient(circle at 88% 20%, rgba(240, 74, 42, .16), transparent 26%),
        linear-gradient(180deg, #fff9f2 0%, #fff3e6 100%);
    z-index: -1;
}

/* ==========================================
   SECTION HEADING
========================================== */
.section-heading {
    position: relative;
    margin-bottom: 20px;
    padding: 8px 0 2px;
}

.section-heading span {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    color: var(--primary);
    font-size: 13px;
    font-weight: 900;
    letter-spacing: 1.5px;
    text-transform: uppercase;
    margin-bottom: 8px;
}

.section-heading span::before {
    content: "";
    width: 28px;
    height: 4px;
    border-radius: 999px;
    background: linear-gradient(90deg, var(--primary), var(--orange));
}

.section-heading h2 {
    color: var(--text);
    font-size: 38px;
    font-weight: 950;
    letter-spacing: -.8px;
    margin: 0 0 6px;
}

.section-heading p {
    color: var(--muted);
    margin: 0;
    font-size: 15px;
}

/* ==========================================
   CATEGORY MENU
========================================== */
.order-menu {
    width: 100%;
    display: flex;
    flex-wrap: wrap;
    gap: 12px;
    padding: 15px 0 35px;
}

.order-menu .cta-btn {
    color: var(--muted);
    border: 1px solid var(--border);
    background: rgba(255, 255, 255, .84);
    backdrop-filter: blur(14px);
    font-weight: 900;
    font-size: 13px;
    text-transform: uppercase;
    letter-spacing: 1px;
    display: inline-block;
    padding: 12px 24px;
    border-radius: 999px;
    transition: all .25s ease;
    box-shadow: 0 8px 20px rgba(83, 45, 23, .05);
}

.order-menu .cta-btn:hover {
    border-color: rgba(240, 74, 42, .42);
    color: var(--primary);
    background: var(--primary-soft);
    transform: translateY(-2px);
}

.order-menu .cta-btn.active {
    background: linear-gradient(135deg, var(--primary), var(--orange));
    border-color: transparent;
    color: #ffffff;
    box-shadow: 0 14px 30px rgba(240, 74, 42, .24);
}

/* ==========================================
   MENU CARD
========================================== */
.menu-card {
    position: relative;
    overflow: hidden;
    background: var(--surface);
    backdrop-filter: blur(18px);
    border: 1px solid rgba(240, 223, 204, .95);
    border-radius: 26px;
    padding: 26px;
    height: 100%;
    transition: all .25s ease;
    box-shadow: var(--shadow);
}

.menu-card::before {
    content: "";
    position: absolute;
    inset: 0 0 auto 0;
    height: 5px;
    background: linear-gradient(90deg, var(--primary), var(--orange), var(--yellow));
    opacity: .85;
}

.menu-card:hover {
    transform: translateY(-5px);
    border-color: rgba(240, 74, 42, .34);
    box-shadow: var(--shadow-hover);
}

.item-top {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    gap: 18px;
    margin-bottom: 24px;
}

.item-info {
    min-width: 0;
}

.item-top h3 {
    margin: 0 0 10px;
    color: var(--text);
    font-size: 23px;
    font-weight: 950;
    letter-spacing: -.3px;
    line-height: 1.25;
}

.desc {
    margin: 0;
    color: var(--muted);
    font-size: 15px;
    line-height: 1.65;
}

.price {
    color: var(--primary);
    font-size: 30px;
    font-weight: 950;
    white-space: nowrap;
    line-height: 1;
    padding: 8px 10px;
    border-radius: 14px;
    background: var(--primary-soft);
}

/* ==========================================
   ACTION BUTTONS
========================================== */
.actions {
    display: flex;
    gap: 12px;
    margin-top: 24px;
}

.actions .btn {
    flex: 1;
    border-radius: 15px;
    padding: 13px 16px;
    font-size: 14px;
    font-weight: 950;
    transition: all .25s ease;
    border: none;
}

.actions .btn.primary {
    background: linear-gradient(135deg, var(--primary), var(--orange));
    border: 1px solid transparent;
    color: #ffffff;
    box-shadow: 0 12px 24px rgba(240, 74, 42, .22);
}

.actions .btn.primary:hover {
    background: linear-gradient(135deg, var(--primary-hover), var(--primary));
    transform: translateY(-2px);
}

.actions .btn.alt {
    background: #ffffff;
    border: 1px solid rgba(127, 161, 75, .5);
    color: var(--green);
}

.actions .btn.alt:hover {
    background: var(--green);
    border-color: var(--green);
    color: #ffffff;
    transform: translateY(-2px);
}

/* ==========================================
   CART
========================================== */
.cart-card {
    position: sticky;
    top: 120px;
    overflow: hidden;
    background: rgba(255, 255, 255, .94);
    backdrop-filter: blur(18px);
    border: 1px solid var(--border);
    border-radius: 28px;
    padding: 28px;
    box-shadow: 0 18px 45px rgba(83, 45, 23, .11);
}

.cart-card::before {
    content: "";
    position: absolute;
    inset: 0 0 auto 0;
    height: 6px;
    background: linear-gradient(90deg, var(--primary), var(--orange), var(--yellow));
}

.cart-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    gap: 15px;
    margin-bottom: 24px;
    border-bottom: 1px solid var(--border);
    padding-bottom: 18px;
}

.cart-label {
    display: block;
    color: var(--primary);
    font-size: 12px;
    font-weight: 950;
    text-transform: uppercase;
    letter-spacing: 1px;
    margin-bottom: 5px;
}

.cart-header h3 {
    color: var(--text);
    margin: 0;
    font-size: 28px;
    font-weight: 950;
}

.cart-count {
    background: linear-gradient(135deg, var(--primary), var(--orange));
    color: #ffffff;
    padding: 8px 14px;
    border-radius: 999px;
    font-size: 12px;
    font-weight: 950;
    white-space: nowrap;
}

.cart-items {
    min-height: 290px;
    max-height: 420px;
    overflow-y: auto;
    padding-right: 4px;
}

.cart-empty {
    text-align: center;
    padding: 55px 15px;
    color: var(--muted);
}

.cart-empty i {
    font-size: 58px;
    color: var(--primary);
    display: block;
    margin-bottom: 22px;
}

.cart-empty h5 {
    color: var(--text);
    margin-bottom: 10px;
    font-size: 22px;
    font-weight: 950;
}

.cart-empty p {
    margin: 0;
    font-size: 15px;
}

.cart-item {
    padding: 16px 0;
    border-bottom: 1px solid var(--border);
}

.cart-item-main {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    gap: 15px;
    margin-bottom: 12px;
}

.cart-item-info h6 {
    color: var(--text);
    margin: 0 0 5px;
    font-size: 15px;
    font-weight: 950;
    line-height: 1.35;
}

.cart-item-info small {
    color: var(--muted-soft);
    font-size: 13px;
}

.remove-btn {
    width: 26px;
    height: 26px;
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

.cart-item-bottom {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 15px;
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
    width: 32px;
    height: 30px;
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
    min-width: 34px;
    text-align: center;
    color: var(--text);
    font-weight: 950;
    font-size: 14px;
}

.cart-item-price {
    color: var(--primary);
    font-weight: 950;
    font-size: 15px;
    white-space: nowrap;
}

.cart-summary {
    margin-top: 22px;
    border-top: 1px solid var(--border);
    padding-top: 20px;
}

.cart-summary > div {
    display: flex;
    justify-content: space-between;
    margin-bottom: 13px;
    color: var(--muted);
    font-size: 15px;
}

.cart-summary strong {
    color: var(--text);
}

.free-text {
    color: var(--green) !important;
}

.cart-total {
    margin-top: 16px;
    padding-top: 16px;
    border-top: 1px solid var(--border);
    font-size: 20px !important;
    font-weight: 950;
}

.cart-total strong {
    color: var(--primary);
    font-size: 27px;
}

.checkout-btn {
    width: 100%;
    margin-top: 22px;
    height: 54px;
    border: none;
    border-radius: 16px;
    background: linear-gradient(135deg, var(--primary), var(--orange));
    color: #ffffff;
    font-weight: 950;
    letter-spacing: .3px;
    transition: all .25s ease;
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

.clear-cart-btn {
    width: 100%;
    margin-top: 12px;
    height: 44px;
    border-radius: 14px;
    background: transparent;
    border: 1px solid var(--border);
    color: var(--muted);
    font-weight: 900;
    transition: all .25s ease;
}

.clear-cart-btn:hover {
    border-color: var(--primary);
    color: var(--primary);
    background: var(--primary-soft);
}

/* ==========================================
   SCROLLBAR
========================================== */
.cart-items::-webkit-scrollbar,
::-webkit-scrollbar {
    width: 8px;
}

.cart-items::-webkit-scrollbar-track,
::-webkit-scrollbar-track {
    background: #fff1e5;
    border-radius: 999px;
}

.cart-items::-webkit-scrollbar-thumb,
::-webkit-scrollbar-thumb {
    background: #e0c7b0;
    border-radius: 999px;
}

.cart-items::-webkit-scrollbar-thumb:hover,
::-webkit-scrollbar-thumb:hover {
    background: var(--primary);
}

html {
    scrollbar-color: #e0c7b0 #fff1e5;
    scrollbar-width: thin;
}

/* ==========================================
   RESPONSIVE
========================================== */
@media (max-width: 991px) {
    .order-page {
        padding-top: 145px;
    }

    .cart-card {
        position: relative;
        top: 0;
        margin-top: 20px;
    }
}

@media (max-width: 768px) {
    .section-heading h2 {
        font-size: 30px;
    }

    .item-top {
        flex-direction: column;
        gap: 12px;
    }

    .price {
        font-size: 28px;
    }

    .actions {
        flex-direction: column;
    }

    .actions .btn {
        width: 100%;
    }

    .cart-header h3 {
        font-size: 24px;
    }
}

@media (max-width: 480px) {
    .order-menu .cta-btn {
        width: 100%;
        font-size: 12px;
        padding: 12px 16px;
    }

    .menu-card,
    .cart-card {
        padding: 22px;
    }
}
</style>
