<script setup lang="ts">
import AppLayout from '@/layouts/restaurantly/AppLayout.vue';
import { computed, ref } from 'vue';
import { usePage } from '@inertiajs/vue3';
import { useRestaurantCart } from '@/composables/useRestaurantCart';

defineOptions({
    layout: AppLayout,
});

type AuthUser = {
    name?: string;
    email?: string;
    phone_number?: string;
};

type CustomerDetails = {
    firstName: string;
    lastName: string;
    phone_number: string;
    email: string;
    orderType: 'collection' | 'delivery';
    address: string;
    paymentMethod: 'cash' | 'card';
    notes: string;
};

const page = usePage();

const authUser = computed<AuthUser | null>(() => {
    return ((page.props as any)?.auth?.user ?? null) as AuthUser | null;
});

const splitName = (name = '') => {
    const parts = name.trim().split(' ').filter(Boolean);

    return {
        firstName: parts[0] ?? '',
        lastName: parts.slice(1).join(' '),
    };
};

const userName = splitName(authUser.value?.name ?? '');

const {
    cart,
    cartCount,
    subtotal,
    increaseQuantity,
    decreaseQuantity,
    removeFromCart,
    clearCart,
    formatCurrency,
} = useRestaurantCart();

const isSubmitting = ref(false);
const showSuccess = ref(false);
const errors = ref<Record<string, string>>({});

const customer = ref<CustomerDetails>({
    firstName: userName.firstName,
    lastName: userName.lastName,
    phone_number: authUser.value?.phone_number ?? '',
    email: authUser.value?.email ?? '',
    orderType: 'collection',
    address: '',
    paymentMethod: 'cash',
    notes: '',
});

const deliveryFee = computed(() => {
    return customer.value.orderType === 'delivery' ? 35 : 0;
});

const total = computed(() => {
    return subtotal.value + deliveryFee.value;
});

const removeItem = (cartKey: string) => {
    removeFromCart(cartKey);
};

const validateForm = () => {
    errors.value = {};

    if (!customer.value.firstName.trim()) {
        errors.value.firstName = 'First name is required.';
    }

    if (!customer.value.lastName.trim()) {
        errors.value.lastName = 'Last name is required.';
    }

    if (!customer.value.phone_number.trim()) {
        errors.value.phone_number = 'Phone number is required.';
    }

    if (customer.value.email && !/^\S+@\S+\.\S+$/.test(customer.value.email)) {
        errors.value.email = 'Please enter a valid email address.';
    }

    if (customer.value.orderType === 'delivery' && !customer.value.address.trim()) {
        errors.value.address = 'Delivery address is required.';
    }

    if (cart.value.length === 0) {
        errors.value.cart = 'Your cart is empty.';
    }

    return Object.keys(errors.value).length === 0;
};

const placeOrder = async () => {
    if (!validateForm()) return;

    isSubmitting.value = true;

    const orderPayload = {
        customer: customer.value,
        items: cart.value,
        subtotal: subtotal.value,
        deliveryFee: deliveryFee.value,
        total: total.value,
        itemCount: cartCount.value,
    };

    console.log('Order payload:', orderPayload);

    await new Promise(resolve => setTimeout(resolve, 700));

    showSuccess.value = true;
    isSubmitting.value = false;
    clearCart();
};
</script>

<template>
    <div class="container checkout-page">
        <div class="checkout-title">
            <span>Secure Checkout</span>
            <h1>Complete Your Order</h1>
            <p>Review your meal, provide your details, and confirm your order.</p>
        </div>

        <div class="success-alert" v-if="showSuccess">
            <div class="success-icon">&check;</div>
            <div>
                <h4>Order received successfully</h4>
                <p>Your order has been captured. The restaurant team will contact you if anything else is required.</p>
            </div>
        </div>

        <div class="row g-4">
            <div class="col-lg-7">
                <div class="checkout-card step-card-one">
                    <div class="card-heading">
                        <span>Step 1</span>
                        <h2>Your Details</h2>
                    </div>

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label>First Name</label>
                            <input
                                type="text"
                                v-model="customer.firstName"
                                :class="{ invalid: errors.firstName }"
                                placeholder="Enter first name"
                            />
                            <small v-if="errors.firstName">{{ errors.firstName }}</small>
                        </div>

                        <div class="col-md-6">
                            <label>Last Name</label>
                            <input
                                type="text"
                                v-model="customer.lastName"
                                :class="{ invalid: errors.lastName }"
                                placeholder="Enter last name"
                            />
                            <small v-if="errors.lastName">{{ errors.lastName }}</small>
                        </div>

                        <div class="col-md-6">
                            <label>Phone Number</label>
                            <input
                                type="tel"
                                v-model="customer.phone_number"
                                :class="{ invalid: errors.phone_number }"
                                placeholder="e.g. 071 000 0000"
                            />
                            <small v-if="errors.phone_number">{{ errors.phone_number }}</small>
                        </div>

                        <div class="col-md-6">
                            <label>Email Address</label>
                            <input
                                type="email"
                                v-model="customer.email"
                                :class="{ invalid: errors.email }"
                                placeholder="Optional"
                            />
                            <small v-if="errors.email">{{ errors.email }}</small>
                        </div>
                    </div>
                </div>

                <div class="checkout-card step-card-two">
                    <div class="card-heading">
                        <span>Step 2</span>
                        <h2>Collection or Delivery</h2>
                    </div>

                    <div class="fulfilment-options">
                        <label class="option-card" :class="{ active: customer.orderType === 'collection' }">
                            <input type="radio" value="collection" v-model="customer.orderType" />
                            <div>
                                <strong>Collection</strong>
                                <p>Collect your order at the restaurant.</p>
                                <span>FREE</span>
                            </div>
                        </label>

                        <label class="option-card" :class="{ active: customer.orderType === 'delivery' }">
                            <input type="radio" value="delivery" v-model="customer.orderType" />
                            <div>
                                <strong>Delivery</strong>
                                <p>Delivery to your provided address.</p>
                                <span>R35.00</span>
                            </div>
                        </label>
                    </div>

                    <div class="delivery-address" v-if="customer.orderType === 'delivery'">
                        <label>Delivery Address</label>
                        <textarea
                            v-model="customer.address"
                            :class="{ invalid: errors.address }"
                            placeholder="Enter delivery address"
                        ></textarea>
                        <small v-if="errors.address">{{ errors.address }}</small>
                    </div>
                </div>

                <div class="checkout-card step-card-three">
                    <div class="card-heading">
                        <span>Step 3</span>
                        <h2>Payment Method</h2>
                    </div>

                    <div class="payment-options">
                        <label class="payment-card" :class="{ active: customer.paymentMethod === 'cash' }">
                            <input type="radio" value="cash" v-model="customer.paymentMethod" />
                            <strong>Cash on Collection/Delivery</strong>
                        </label>

                        <label class="payment-card" :class="{ active: customer.paymentMethod === 'card' }">
                            <input type="radio" value="card" v-model="customer.paymentMethod" />
                            <strong>Card Payment</strong>
                        </label>
                    </div>

                    <div class="order-notes">
                        <label>Order Notes</label>
                        <textarea
                            v-model="customer.notes"
                            placeholder="Optional: special instructions, sauces, collection time, etc."
                        ></textarea>
                    </div>
                </div>
            </div>

            <div class="col-lg-5">
                <div class="summary-card">
                    <div class="summary-header">
                        <div>
                            <span>Order Summary</span>
                            <h2>Your Meal</h2>
                        </div>
                        <strong>{{ cartCount }} {{ cartCount === 1 ? 'Item' : 'Items' }}</strong>
                    </div>

                    <div class="cart-error" v-if="errors.cart">{{ errors.cart }}</div>

                    <div class="summary-empty" v-if="cart.length === 0">
                        <i class="bi bi-bag-x"></i>
                        <h5>No items found</h5>
                        <p>Please go back to the menu and add items to your order.</p>
                    </div>

                    <div class="summary-items" v-else>
                        <div class="summary-item" v-for="item in cart" :key="item.cartKey">
                            <div class="item-left">
                                <h6>{{ item.name }}</h6>
                                <small>{{ item.option }} - {{ formatCurrency(item.price) }}</small>

                                <div class="quantity-control">
                                    <button @click="decreaseQuantity(item.cartKey)">-</button>
                                    <span>{{ item.quantity }}</span>
                                    <button @click="increaseQuantity(item.cartKey)">+</button>
                                </div>
                            </div>

                            <div class="item-right">
                                <button @click="removeItem(item.cartKey)">x</button>
                                <strong>{{ formatCurrency(item.price * item.quantity) }}</strong>
                            </div>
                        </div>
                    </div>

                    <div class="summary-totals">
                        <div>
                            <span>Subtotal</span>
                            <strong>{{ formatCurrency(subtotal) }}</strong>
                        </div>

                        <div>
                            <span>{{ customer.orderType === 'delivery' ? 'Delivery' : 'Collection' }}</span>
                            <strong>{{ customer.orderType === 'delivery' ? formatCurrency(deliveryFee) : 'FREE' }}</strong>
                        </div>

                        <div class="grand-total">
                            <span>Total</span>
                            <strong>{{ formatCurrency(total) }}</strong>
                        </div>
                    </div>

                    <button
                        class="place-order-btn"
                        :disabled="isSubmitting || cart.length === 0"
                        @click="placeOrder"
                    >
                        {{ isSubmitting ? 'Placing Order...' : 'Place Order' }}
                    </button>

                    <p class="checkout-note">
                        By placing this order, customer details and order items will be submitted to the restaurant for processing.
                    </p>
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>
/* ==========================================
   PROFESSIONAL MEATHOUSE CHECKOUT THEME
   Matches Order page: white, compact, mature
========================================== */
.checkout-page {
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
    --danger: #b42318;
    --danger-soft: #fff5f3;
    --shadow: 0 6px 18px rgba(31, 31, 31, .04);
    --shadow-hover: 0 12px 26px rgba(31, 31, 31, .075);

    position: relative;
    padding: 165px 0 80px;
    color: var(--text);
    background: #ffffff;
}

.checkout-page::before {
    content: "";
    position: fixed;
    inset: 0;
    pointer-events: none;
    background: #ffffff;
    z-index: -1;
}

.checkout-title {
    margin-bottom: 30px;
}

.checkout-title span,
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

.checkout-title span::before,
.card-heading span::before,
.summary-header span::before {
    content: "";
    width: 24px;
    height: 3px;
    border-radius: 999px;
    background: var(--gold);
}

.checkout-title h1 {
    color: var(--text);
    font-size: 36px;
    font-weight: 850;
    letter-spacing: -.6px;
    margin: 8px 0 5px;
}

.checkout-title p {
    color: var(--muted);
    margin: 0;
    font-size: 15px;
}

.checkout-card,
.summary-card,
.success-alert {
    position: relative;
    overflow: hidden;
    background: #ffffff;
    border: 1px solid var(--border);
    border-radius: 14px;
    padding: 24px;
    box-shadow: var(--shadow);
}

.checkout-card {
    margin-bottom: 20px;
}

.checkout-card:hover,
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

.logged-in-notice {
    display: grid;
    gap: 4px;
    margin-bottom: 18px;
    padding: 13px 15px;
    border-radius: 11px;
    background: #f4f8ef;
    border: 1px solid rgba(71, 99, 47, .24);
}

.logged-in-notice strong {
    color: var(--text);
    font-weight: 850;
}

.logged-in-notice span {
    color: var(--muted);
    font-size: 13px;
    line-height: 1.5;
}

label {
    display: block;
    color: var(--text);
    font-size: 13px;
    font-weight: 800;
    margin-bottom: 7px;
}

input,
textarea {
    width: 100%;
    border: 1px solid var(--border);
    background: #ffffff;
    color: var(--text);
    border-radius: 10px;
    padding: 12px 13px;
    transition: all .2s ease;
    outline: none;
}

textarea {
    min-height: 100px;
    resize: vertical;
}

input:focus,
textarea:focus {
    border-color: var(--primary);
    box-shadow: 0 0 0 3px rgba(182, 35, 35, .08);
}

input::placeholder,
textarea::placeholder {
    color: var(--muted-soft);
}

.invalid {
    border-color: var(--danger) !important;
    box-shadow: 0 0 0 3px rgba(180, 35, 24, .10) !important;
}

small {
    display: block;
    color: var(--danger);
    font-size: 12px;
    font-weight: 750;
    margin-top: 6px;
}

.fulfilment-options,
.payment-options {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 12px;
}

.option-card,
.payment-card {
    display: flex;
    gap: 11px;
    align-items: flex-start;
    border: 1px solid var(--border);
    background: #ffffff;
    border-radius: 12px;
    padding: 15px;
    cursor: pointer;
    transition: all .2s ease;
    margin: 0;
    box-shadow: none;
}

.option-card:hover,
.payment-card:hover,
.option-card.active,
.payment-card.active {
    border-color: var(--primary);
    background: var(--primary-soft);
    transform: translateY(-1px);
}

.option-card input,
.payment-card input {
    width: auto;
    margin-top: 3px;
    accent-color: var(--primary);
}

.option-card strong,
.payment-card strong {
    color: var(--text);
    font-size: 14px;
    font-weight: 850;
}

.option-card p {
    color: var(--muted);
    margin: 4px 0 9px;
    font-size: 13px;
    line-height: 1.45;
}

.option-card span {
    color: var(--green);
    font-weight: 850;
}

.delivery-address,
.order-notes {
    margin-top: 18px;
}

.summary-card {
    position: sticky;
    top: 120px;
}

.summary-empty {
    text-align: center;
    padding: 46px 15px;
    color: var(--muted);
}

.summary-empty i {
    display: block;
    color: var(--primary);
    font-size: 48px;
    margin-bottom: 16px;
}

.summary-empty h5 {
    color: var(--text);
    font-size: 20px;
    font-weight: 850;
    margin-bottom: 8px;
}

.summary-empty p {
    color: var(--muted);
    margin: 0;
    font-size: 14px;
}

.summary-items {
    max-height: 400px;
    overflow-y: auto;
    padding-right: 5px;
}

.summary-item {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    gap: 15px;
    padding: 15px 0;
    border-bottom: 1px solid var(--border);
}

.item-left h6 {
    color: var(--text);
    font-size: 15px;
    font-weight: 800;
    margin: 0 0 5px;
    line-height: 1.35;
}

.item-left small {
    color: var(--muted-soft);
    margin: 0 0 11px;
}

.item-right {
    display: flex;
    flex-direction: column;
    align-items: flex-end;
    gap: 14px;
}

.item-right button {
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

.item-right button:hover {
    background: var(--primary);
    border-color: var(--primary);
    color: #ffffff;
}

.item-right strong {
    color: var(--primary);
    white-space: nowrap;
    font-weight: 850;
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

.summary-totals {
    margin-top: 20px;
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

.place-order-btn {
    width: 100%;
    margin-top: 20px;
    height: 50px;
    border: none;
    border-radius: 10px;
    background: var(--primary);
    color: #ffffff;
    font-weight: 850;
    letter-spacing: .2px;
    box-shadow: 0 10px 22px rgba(182, 35, 35, .18);
    transition: all .2s ease;
}

.place-order-btn:hover:not(:disabled) {
    background: var(--primary-hover);
    transform: translateY(-1px);
}

.place-order-btn:disabled {
    background: #dadada;
    color: rgba(37, 37, 37, .45);
    box-shadow: none;
    cursor: not-allowed;
}

.checkout-note {
    color: var(--muted-soft);
    font-size: 12px;
    line-height: 1.6;
    margin: 13px 0 0;
    text-align: center;
}

.cart-error {
    background: var(--danger-soft);
    border: 1px solid rgba(180, 35, 24, .28);
    color: var(--danger);
    border-radius: 10px;
    padding: 11px 13px;
    font-weight: 800;
    margin-bottom: 15px;
}

.success-alert {
    display: flex;
    align-items: flex-start;
    gap: 15px;
    margin-bottom: 22px;
    border-color: rgba(71, 99, 47, .24);
    background: #f4f8ef;
}

.success-icon {
    width: 38px;
    height: 38px;
    display: grid;
    place-items: center;
    border-radius: 50%;
    background: var(--green);
    color: #ffffff;
    font-weight: 850;
    font-size: 20px;
    flex: 0 0 auto;
}

.success-alert h4 {
    color: var(--text);
    margin: 0 0 5px;
    font-weight: 850;
}

.success-alert p {
    color: var(--muted);
    margin: 0;
}

.summary-items::-webkit-scrollbar,
::-webkit-scrollbar {
    width: 8px;
}

.summary-items::-webkit-scrollbar-track,
::-webkit-scrollbar-track {
    background: #f6f1ea;
    border-radius: 999px;
}

.summary-items::-webkit-scrollbar-thumb,
::-webkit-scrollbar-thumb {
    background: #d7c9b7;
    border-radius: 999px;
}

.summary-items::-webkit-scrollbar-thumb:hover,
::-webkit-scrollbar-thumb:hover {
    background: var(--primary);
}

html {
    scrollbar-color: #d7c9b7 #f6f1ea;
    scrollbar-width: thin;
}

@media (max-width: 991px) {
    .checkout-page {
        padding-top: 145px;
    }

    .summary-card {
        position: relative;
        top: 0;
    }
}

@media (max-width: 768px) {
    .checkout-title h1 {
        font-size: 32px;
    }

    .fulfilment-options,
    .payment-options {
        grid-template-columns: 1fr;
    }

    .checkout-card,
    .summary-card,
    .success-alert {
        padding: 20px;
    }

    .card-heading,
    .summary-header {
        flex-direction: column;
    }
}
</style>
