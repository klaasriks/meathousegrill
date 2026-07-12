import { computed, onBeforeUnmount, onMounted, ref } from 'vue';

export type RestaurantCartItem = {
    cartKey: string;
    id: number | string;
    name: string;
    option: string;
    price: number;
    quantity: number;
};

const CART_STORAGE_KEY = 'restaurant_cart';
const CART_EVENT_NAME = 'restaurant-cart-updated';

const cart = ref<RestaurantCartItem[]>([]);

const safeParseCart = (value: string | null): RestaurantCartItem[] => {
    if (!value) return [];

    try {
        const parsedCart = JSON.parse(value);
        return Array.isArray(parsedCart) ? parsedCart : [];
    } catch (error) {
        return [];
    }
};

const dispatchCartEvent = () => {
    if (typeof window === 'undefined') return;

    window.dispatchEvent(
        new CustomEvent(CART_EVENT_NAME, {
            detail: cart.value,
        })
    );
};

export const loadCart = () => {
    if (typeof window === 'undefined') return;

    cart.value = safeParseCart(localStorage.getItem(CART_STORAGE_KEY));
};

export const persistCart = () => {
    if (typeof window === 'undefined') return;

    localStorage.setItem(CART_STORAGE_KEY, JSON.stringify(cart.value));
    dispatchCartEvent();
};

export const clearCart = () => {
    cart.value = [];

    if (typeof window !== 'undefined') {
        localStorage.removeItem(CART_STORAGE_KEY);
    }

    dispatchCartEvent();
};

export const toNumber = (value: any): number => {
    if (value === null || value === undefined) return 0;

    return Number(
        String(value)
            .replace('R', '')
            .replace(',', '')
            .trim()
    ) || 0;
};

export const formatCurrency = (value: number): string => {
    return `R${Number(value || 0).toFixed(2)}`;
};

export const addToCart = (menuItem: any, option = 'Standard', priceOverride: any = null) => {
    const price = priceOverride !== null
        ? toNumber(priceOverride)
        : toNumber(menuItem.price);

    const cartKey = `${menuItem.id}-${option}`;
    const existingItem = cart.value.find(item => item.cartKey === cartKey);

    if (existingItem) {
        existingItem.quantity += 1;
        persistCart();
        return;
    }

    cart.value.push({
        cartKey,
        id: menuItem.id,
        name: menuItem.name,
        option,
        price,
        quantity: 1,
    });

    persistCart();
};

export const increaseQuantity = (cartKey: string) => {
    const item = cart.value.find(item => item.cartKey === cartKey);

    if (!item) return;

    item.quantity += 1;
    persistCart();
};

export const decreaseQuantity = (cartKey: string) => {
    const item = cart.value.find(item => item.cartKey === cartKey);

    if (!item) return;

    if (item.quantity > 1) {
        item.quantity -= 1;
    } else {
        removeFromCart(cartKey);
        return;
    }

    persistCart();
};

export const removeFromCart = (cartKey: string) => {
    cart.value = cart.value.filter(item => item.cartKey !== cartKey);
    persistCart();
};

export const useRestaurantCart = () => {
    const cartCount = computed(() => {
        return cart.value.reduce((total, item) => total + Number(item.quantity || 0), 0);
    });

    const subtotal = computed(() => {
        return cart.value.reduce((total, item) => total + Number(item.price || 0) * Number(item.quantity || 0), 0);
    });

    const onStorageChange = () => {
        loadCart();
    };

    const onCartUpdated = () => {
        loadCart();
    };

    onMounted(() => {
        loadCart();

        if (typeof window === 'undefined') return;

        window.addEventListener('storage', onStorageChange);
        window.addEventListener(CART_EVENT_NAME, onCartUpdated);
    });

    onBeforeUnmount(() => {
        if (typeof window === 'undefined') return;

        window.removeEventListener('storage', onStorageChange);
        window.removeEventListener(CART_EVENT_NAME, onCartUpdated);
    });

    return {
        cart,
        cartCount,
        subtotal,
        loadCart,
        persistCart,
        clearCart,
        addToCart,
        increaseQuantity,
        decreaseQuantity,
        removeFromCart,
        toNumber,
        formatCurrency,
    };
};
