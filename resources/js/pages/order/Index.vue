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

const selectedMenuItems = computed(() => {
    const categories = props.menu.menu_category ?? [];
    const category = categories.find((menuCategory: any) => String(menuCategory.id) === String(selectedCategory.value));

    return category?.menu_items ?? [];
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
                                :class="{ active: String(selectedCategory) === String(menu_category.id) }"
                                @click="selectedCategory = menu_category.id"
                            >
                                {{ menu_category.name }}
                            </button>
                        </div>
                    </div>
                </div>

                <div class="row g-3" :key="selectedCategory">
                    <div
                        v-for="menu_item in selectedMenuItems"
                        class="col-md-6 col-sm-12 d-flex"
                        :key="`${selectedCategory}-${menu_item.id}`"
                    >
                        <div class="menu-card">
                            <div class="menu-thumb" v-if="menu_item.image">
                                <img
                                    :src="menu_item.image"
                                    :alt="menu_item.name"
                                    class="menu-img"
                                />
                            </div>

                            <div class="menu-details">
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
                                        Add
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
                    </div>
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
   PROFESSIONAL MEATHOUSE ORDERING THEME
   Compact professional cards + stable cart behavior
========================================== */
.order-page {
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

.order-page::before {
    content: "";
    position: fixed;
    inset: 0;
    pointer-events: none;
    background: #ffffff;
    z-index: -1;
}

.section-heading {
    position: relative;
    margin-bottom: 14px;
    padding: 6px 0 2px;
}

.section-heading span {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    color: var(--green);
    font-size: 12px;
    font-weight: 800;
    letter-spacing: 1.1px;
    text-transform: uppercase;
    margin-bottom: 7px;
}

.section-heading span::before {
    content: "";
    width: 24px;
    height: 3px;
    border-radius: 999px;
    background: var(--gold);
}

.section-heading h2 {
    color: var(--text);
    font-size: 34px;
    font-weight: 850;
    letter-spacing: -.6px;
    margin: 0 0 5px;
}

.section-heading p {
    color: var(--muted);
    margin: 0;
    font-size: 15px;
}

.order-menu {
    width: 100%;
    display: flex;
    flex-wrap: wrap;
    gap: 9px;
    padding: 12px 0 24px;
}

.order-menu .cta-btn {
    color: var(--text);
    border: 1px solid var(--border);
    background: #ffffff;
    font-weight: 750;
    font-size: 13px;
    text-transform: none;
    letter-spacing: .2px;
    display: inline-block;
    padding: 10px 16px;
    border-radius: 9px;
    transition: all .2s ease;
    box-shadow: none;
}

.order-menu .cta-btn:hover {
    border-color: var(--border-strong);
    color: var(--primary);
    background: #ffffff;
    transform: translateY(-1px);
}

.order-menu .cta-btn.active {
    background: var(--primary);
    border-color: var(--primary);
    color: #ffffff;
    box-shadow: 0 8px 18px rgba(182, 35, 35, .16);
}

.menu-card {
    width: 100%;
    height: 148px;
    display: grid;
    grid-template-columns: 96px minmax(0, 1fr);
    overflow: hidden;
    background: #ffffff;
    border: 1px solid var(--border);
    border-radius: 11px;
    transition: all .2s ease;
    box-shadow: var(--shadow);
}

.menu-card:hover {
    transform: translateY(-2px);
    border-color: var(--border-strong);
    box-shadow: var(--shadow-hover);
}

.menu-card:not(:has(.menu-thumb)) {
    grid-template-columns: 1fr;
}

.menu-thumb {
    position: relative;
    height: 148px;
    overflow: hidden;
    background: #f6f1ea;
    border-right: 1px solid var(--border);
}

.menu-img {
    width: 100%;
    height: 148px;
    display: block;
    object-fit: cover;
    transition: transform .3s ease;
}

.menu-card:hover .menu-img {
    transform: scale(1.03);
}

.menu-details {
    display: flex;
    flex-direction: column;
    min-width: 0;
    padding: 12px;
}

.item-top {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    gap: 10px;
    margin-bottom: 8px;
    flex: 1;
    min-width: 0;
}

.item-info {
    min-width: 0;
}

.item-top h3 {
    margin: 0 0 5px;
    color: var(--text);
    font-size: 15px;
    font-weight: 800;
    letter-spacing: -.1px;
    line-height: 1.22;
}

.desc {
    margin: 0;
    color: var(--muted);
    font-size: 12px;
    line-height: 1.35;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.price {
    color: var(--primary);
    font-size: 15px;
    font-weight: 850;
    white-space: nowrap;
    line-height: 1.2;
    padding: 0;
    background: transparent;
}

.actions {
    display: flex;
    gap: 6px;
    margin-top: auto;
}

.actions .btn {
    flex: 1;
    border-radius: 7px;
    padding: 7px 7px;
    font-size: 11px;
    font-weight: 800;
    line-height: 1.1;
    transition: all .2s ease;
    border: 1px solid transparent;
}

.actions .btn.primary {
    background: var(--primary);
    border-color: var(--primary);
    color: #ffffff;
    box-shadow: 0 7px 16px rgba(182, 35, 35, .12);
}

.actions .btn.primary:hover {
    background: var(--primary-hover);
    border-color: var(--primary-hover);
    transform: translateY(-1px);
}

.actions .btn.alt {
    background: var(--surface-soft);
    border-color: var(--border);
    color: var(--green);
}

.actions .btn.alt:hover {
    background: var(--green);
    border-color: var(--green);
    color: #ffffff;
    transform: translateY(-1px);
}

.cart-card {
    position: sticky;
    top: 120px;
    overflow: hidden;
    background: #ffffff;
    border: 1px solid var(--border);
    border-radius: 14px;
    padding: 24px;
    box-shadow: 0 10px 28px rgba(31, 31, 31, .07);
}

.cart-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    gap: 15px;
    margin-bottom: 22px;
    border-bottom: 1px solid var(--border);
    padding-bottom: 16px;
}

.cart-label {
    display: block;
    color: var(--green);
    font-size: 11px;
    font-weight: 850;
    text-transform: uppercase;
    letter-spacing: 1px;
    margin-bottom: 5px;
}

.cart-header h3 {
    color: var(--text);
    margin: 0;
    font-size: 24px;
    font-weight: 850;
}

.cart-count {
    background: #f6f1ea;
    color: var(--text);
    padding: 7px 12px;
    border: 1px solid var(--border);
    border-radius: 999px;
    font-size: 12px;
    font-weight: 800;
    white-space: nowrap;
}

.cart-items {
    min-height: 280px;
    max-height: 420px;
    overflow-y: auto;
    padding-right: 4px;
}

.cart-empty {
    text-align: center;
    padding: 50px 15px;
    color: var(--muted);
}

.cart-empty i {
    font-size: 48px;
    color: var(--primary);
    display: block;
    margin-bottom: 18px;
}

.cart-empty h5 {
    color: var(--text);
    margin-bottom: 8px;
    font-size: 20px;
    font-weight: 850;
}

.cart-empty p {
    margin: 0;
    font-size: 14px;
}

.cart-item {
    padding: 15px 0;
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
    font-weight: 800;
    line-height: 1.35;
}

.cart-item-info small {
    color: var(--muted-soft);
    font-size: 13px;
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

.cart-item-price {
    color: var(--primary);
    font-weight: 850;
    font-size: 15px;
    white-space: nowrap;
}

.cart-summary {
    margin-top: 20px;
    border-top: 1px solid var(--border);
    padding-top: 18px;
}

.cart-summary > div {
    display: flex;
    justify-content: space-between;
    margin-bottom: 12px;
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
    margin-top: 14px;
    padding-top: 14px;
    border-top: 1px solid var(--border);
    font-size: 18px !important;
    font-weight: 850;
}

.cart-total strong {
    color: var(--primary);
    font-size: 24px;
}

.checkout-btn {
    width: 100%;
    margin-top: 20px;
    height: 50px;
    border: none;
    border-radius: 10px;
    background: var(--primary);
    color: #ffffff;
    font-weight: 850;
    letter-spacing: .2px;
    transition: all .2s ease;
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

.clear-cart-btn {
    width: 100%;
    margin-top: 12px;
    height: 42px;
    border-radius: 10px;
    background: transparent;
    border: 1px solid var(--border);
    color: var(--muted);
    font-weight: 800;
    transition: all .2s ease;
}

.clear-cart-btn:hover {
    border-color: var(--primary);
    color: var(--primary);
    background: var(--primary-soft);
}

.cart-items::-webkit-scrollbar,
::-webkit-scrollbar {
    width: 8px;
}

.cart-items::-webkit-scrollbar-track,
::-webkit-scrollbar-track {
    background: #f6f1ea;
    border-radius: 999px;
}

.cart-items::-webkit-scrollbar-thumb,
::-webkit-scrollbar-thumb {
    background: #d7c9b7;
    border-radius: 999px;
}

.cart-items::-webkit-scrollbar-thumb:hover,
::-webkit-scrollbar-thumb:hover {
    background: var(--primary);
}

html {
    scrollbar-color: #d7c9b7 #f6f1ea;
    scrollbar-width: thin;
}

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

    .menu-card {
        height: auto;
        grid-template-columns: 1fr;
    }

    .menu-thumb {
        height: 170px;
        border-right: 0;
        border-bottom: 1px solid var(--border);
    }

    .menu-img {
        height: 170px;
    }

    .item-top {
        flex-direction: column;
        gap: 10px;
    }

    .price {
        font-size: 18px;
    }

    .actions {
        flex-direction: column;
    }

    .actions .btn {
        width: 100%;
    }

    .cart-header h3 {
        font-size: 22px;
    }
}

@media (max-width: 480px) {
    .order-menu .cta-btn {
        width: 100%;
        font-size: 12px;
        padding: 12px 16px;
    }

    .menu-details,
    .cart-card {
        padding: 18px;
    }
}
</style>
