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
.checkout-page {
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
    --border: #f0dfcc;
    --danger: #ef3f37;
    --danger-soft: #fff0ef;
    --shadow: 0 12px 30px rgba(83, 45, 23, .08);
    --shadow-hover: 0 20px 45px rgba(83, 45, 23, .14);

    position: relative;
    padding: 170px 0 80px;
    color: var(--text);
}

.checkout-page::before {
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

.checkout-title {
    margin-bottom: 34px;
}

.checkout-title span,
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

.checkout-title span::before,
.card-heading span::before,
.summary-header span::before {
    content: "";
    width: 26px;
    height: 4px;
    border-radius: 999px;
    background: linear-gradient(90deg, var(--primary), var(--orange));
}

.checkout-title h1 {
    color: var(--text);
    font-size: 44px;
    font-weight: 950;
    letter-spacing: -.9px;
    margin: 8px 0;
}

.checkout-title p {
    color: var(--muted);
    margin: 0;
    font-size: 16px;
}

.checkout-card,
.summary-card,
.success-alert {
    position: relative;
    overflow: hidden;
    background: var(--surface);
    backdrop-filter: blur(18px);
    border: 1px solid rgba(240, 223, 204, .95);
    border-radius: 28px;
    padding: 28px;
    box-shadow: var(--shadow);
}

.checkout-card::before,
.summary-card::before {
    content: "";
    position: absolute;
    inset: 0 0 auto 0;
    height: 6px;
    background: linear-gradient(90deg, var(--primary), var(--orange), var(--yellow));
}

.checkout-card {
    margin-bottom: 24px;
}

.checkout-card:hover,
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

.logged-in-notice {
    display: grid;
    gap: 4px;
    margin-bottom: 20px;
    padding: 14px 16px;
    border-radius: 16px;
    background: #f7ffee;
    border: 1px solid rgba(127, 161, 75, .45);
}

.logged-in-notice strong {
    color: var(--text);
    font-weight: 950;
}

.logged-in-notice span {
    color: var(--muted);
    font-size: 13px;
    line-height: 1.5;
}

label {
    display: block;
    color: var(--text);
    font-size: 14px;
    font-weight: 900;
    margin-bottom: 8px;
}

input,
textarea {
    width: 100%;
    border: 1px solid var(--border);
    background: var(--surface-solid);
    color: var(--text);
    border-radius: 15px;
    padding: 14px 15px;
    transition: all .25s ease;
    outline: none;
}

textarea {
    min-height: 110px;
    resize: vertical;
}

input:focus,
textarea:focus {
    border-color: rgba(240, 74, 42, .55);
    box-shadow: 0 0 0 4px rgba(240, 74, 42, .10);
}

input::placeholder,
textarea::placeholder {
    color: var(--muted-soft);
}

.invalid {
    border-color: var(--danger) !important;
    box-shadow: 0 0 0 4px rgba(239, 63, 55, .10) !important;
}

small {
    display: block;
    color: var(--danger);
    font-size: 12px;
    font-weight: 800;
    margin-top: 7px;
}

.fulfilment-options,
.payment-options {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 14px;
}

.payment-options {
    grid-template-columns: repeat(2, 1fr);
}

.option-card,
.payment-card {
    display: flex;
    gap: 12px;
    align-items: flex-start;
    border: 1px solid var(--border);
    background: rgba(255, 255, 255, .82);
    border-radius: 20px;
    padding: 18px;
    cursor: pointer;
    transition: all .25s ease;
    margin: 0;
    box-shadow: 0 8px 20px rgba(83, 45, 23, .04);
}

.option-card:hover,
.payment-card:hover,
.option-card.active,
.payment-card.active {
    border-color: rgba(240, 74, 42, .42);
    background: var(--primary-soft);
    transform: translateY(-2px);
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
    font-size: 15px;
    font-weight: 950;
}

.option-card p {
    color: var(--muted);
    margin: 5px 0 10px;
    font-size: 13px;
    line-height: 1.5;
}

.option-card span {
    color: var(--green);
    font-weight: 950;
}

.delivery-address,
.order-notes {
    margin-top: 20px;
}

.summary-card {
    position: sticky;
    top: 120px;
}

.summary-empty {
    text-align: center;
    padding: 45px 15px;
    color: var(--muted);
}

.summary-empty i {
    display: block;
    color: var(--primary);
    font-size: 52px;
    margin-bottom: 16px;
}

.summary-empty h5 {
    color: var(--text);
    font-size: 21px;
    font-weight: 950;
    margin-bottom: 8px;
}

.summary-empty p {
    color: var(--muted);
}

.summary-items {
    max-height: 380px;
    overflow-y: auto;
    padding-right: 5px;
}

.summary-item {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    gap: 16px;
    padding: 17px 0;
    border-bottom: 1px solid var(--border);
}

.item-left h6 {
    color: var(--text);
    font-size: 15px;
    font-weight: 950;
    margin: 0 0 5px;
    line-height: 1.35;
}

.item-left small {
    color: var(--muted-soft);
    margin: 0 0 12px;
}

.item-right {
    display: flex;
    flex-direction: column;
    align-items: flex-end;
    gap: 16px;
}

.item-right button {
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

.item-right button:hover {
    background: var(--primary);
    border-color: var(--primary);
    color: #ffffff;
}

.item-right strong {
    color: var(--primary);
    white-space: nowrap;
    font-weight: 950;
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

.summary-totals {
    margin-top: 22px;
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

.place-order-btn {
    width: 100%;
    margin-top: 22px;
    height: 56px;
    border: none;
    border-radius: 16px;
    background: linear-gradient(135deg, var(--primary), var(--orange));
    color: #ffffff;
    font-weight: 950;
    letter-spacing: .4px;
    box-shadow: 0 16px 34px rgba(240, 74, 42, .24);
    transition: all .25s ease;
}

.place-order-btn:hover:not(:disabled) {
    background: linear-gradient(135deg, var(--primary-hover), var(--primary));
    transform: translateY(-2px);
}

.place-order-btn:disabled {
    background: #d7cec6;
    color: rgba(37, 37, 37, .45);
    box-shadow: none;
    cursor: not-allowed;
}

.checkout-note {
    color: var(--muted-soft);
    font-size: 12px;
    line-height: 1.6;
    margin: 14px 0 0;
    text-align: center;
}

.cart-error {
    background: var(--danger-soft);
    border: 1px solid rgba(239, 63, 55, .34);
    color: var(--danger);
    border-radius: 14px;
    padding: 12px 14px;
    font-weight: 900;
    margin-bottom: 16px;
}

.success-alert {
    display: flex;
    align-items: flex-start;
    gap: 16px;
    margin-bottom: 24px;
    border-color: rgba(127, 161, 75, .45);
    background: #f7ffee;
}

.success-icon {
    width: 42px;
    height: 42px;
    display: grid;
    place-items: center;
    border-radius: 50%;
    background: var(--green);
    color: #ffffff;
    font-weight: 950;
    font-size: 22px;
    flex: 0 0 auto;
}

.success-alert h4 {
    color: var(--text);
    margin: 0 0 5px;
    font-weight: 950;
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
    background: #fff1e5;
    border-radius: 999px;
}

.summary-items::-webkit-scrollbar-thumb,
::-webkit-scrollbar-thumb {
    background: #e0c7b0;
    border-radius: 999px;
}

.summary-items::-webkit-scrollbar-thumb:hover,
::-webkit-scrollbar-thumb:hover {
    background: var(--primary);
}

html {
    scrollbar-color: #e0c7b0 #fff1e5;
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
        font-size: 34px;
    }

    .fulfilment-options,
    .payment-options {
        grid-template-columns: 1fr;
    }

    .checkout-card,
    .summary-card,
    .success-alert {
        padding: 22px;
    }

    .card-heading,
    .summary-header {
        flex-direction: column;
    }
}
</style>
