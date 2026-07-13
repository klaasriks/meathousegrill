<script setup lang="ts">
import { computed, onBeforeUnmount, onMounted, ref } from 'vue';
import { router, usePage } from '@inertiajs/vue3';

const page = usePage();
const currentPath = ref('');
const cartCount = ref(0);

const user = computed(() => {
    return (page.props as any)?.auth?.user ?? null;
});

const isLoggedIn = computed(() => {
    return !!user.value;
});

const normalisePath = (path: string) => {
    return path.replace(/\/$/, '') || '/';
};

const showOrderButton = computed(() => {
    const path = normalisePath(currentPath.value);
    return !['/order', '/checkout', '/cart'].includes(path);
});

const updateCurrentPath = () => {
    if (typeof window === 'undefined') return;
    currentPath.value = window.location.pathname;
};

const updateCartCount = () => {
    if (typeof window === 'undefined') return;

    const storedCart = localStorage.getItem('restaurant_cart');

    if (!storedCart) {
        cartCount.value = 0;
        return;
    }

    try {
        const cart = JSON.parse(storedCart);

        if (!Array.isArray(cart)) {
            cartCount.value = 0;
            return;
        }

        cartCount.value = cart.reduce((total: number, item: any) => {
            return total + Number(item.quantity || 0);
        }, 0);
    } catch (error) {
        cartCount.value = 0;
    }
};

const handleStorageChange = () => {
    updateCartCount();
};

const logout = () => {
    router.post('/logout');
};

onMounted(() => {
    updateCurrentPath();
    updateCartCount();

    window.addEventListener('storage', handleStorageChange);
    window.addEventListener('popstate', updateCurrentPath);
});

onBeforeUnmount(() => {
    if (typeof window === 'undefined') return;

    window.removeEventListener('storage', handleStorageChange);
    window.removeEventListener('popstate', updateCurrentPath);
});
</script>

<template>
    <header id="header" class="header fixed-top">

        <!-- Top Bar -->
        <div class="topbar d-flex align-items-center">
            <div class="container d-flex justify-content-center justify-content-md-between">

                <div class="contact-info d-flex align-items-center">
                    <i class="bi bi-envelope d-flex align-items-center">
                        <a href="mailto:info@meathousegrill.co.za">
                            info@meathousegrill.co.za
                        </a>
                    </i>

                    <i class="bi bi-phone d-flex align-items-center ms-4">
                        <span>+27 10 011 3806</span>
                    </i>
                </div>

                <div class="languages d-none d-md-flex align-items-center">
                    <ul>
                        <li>
                            <a href="/#contact">
                                Shop 13, Kingfisher Square, 69 Kingfisher Ave, Elspark, Germiston, 1418
                            </a>
                        </li>
                    </ul>
                </div>

            </div>
        </div>

        <!-- Branding / Main Header -->
        <div class="branding d-flex align-items-center">
            <div class="container position-relative d-flex align-items-center">

                <!-- Logo -->
                <a href="/" class="logo d-flex align-items-center me-auto me-xl-0">
                    <img
                        src="/themes/restaurantly/assets/img/logo_v1.png"
                        alt="Meathouse Grill Logo"
                        class="logo-img"
                    />

                    <div class="logo-text d-flex flex-column">
                        <h1 class="sitename m-0">MEATHOUSE GRILL</h1>
                        <p class="tagline m-0">YOUR LIP SMACKING TASTE</p>
                    </div>
                </a>

                <!-- Main Navigation -->
                <nav id="navmenu" class="navmenu">
                    <ul class="nav-left">
                        <li>
                            <a href="/#" :class="{ active: normalisePath(currentPath) === '/' }">
                                Home
                            </a>
                        </li>

                        <li>
                            <a href="/#menu">
                                Our Menu
                            </a>
                        </li>

                        <li>
                            <a href="/#specials">
                                Featured Favourites
                            </a>
                        </li>

                        <li>
                            <a href="/#contact">
                                Find Us
                            </a>
                        </li>

                        <!-- Mobile Only Account Links -->
                        <template v-if="isLoggedIn">
                            <li class="mobile-only">
                                <a href="/profile">
                                    My Profile
                                </a>
                            </li>

                            <li class="mobile-only">
                                <a href="/cart">
                                    My Cart
                                    <span v-if="cartCount > 0" class="mobile-cart-count">
                                        {{ cartCount }}
                                    </span>
                                </a>
                            </li>

                            <li class="mobile-only">
                                <button type="button" class="mobile-logout-link" @click="logout">
                                    Logout
                                </button>
                            </li>
                        </template>

                        <template v-else>
                            <li class="mobile-only">
                                <a href="/login">
                                    Sign In
                                </a>
                            </li>
                        </template>
                    </ul>
                </nav>

                <!-- Right Navigation -->
                <div class="nav-right-group">

                    <!-- Cart -->
                    <a href="/cart" class="cart-btn" aria-label="View cart">
                        <i class="bi bi-cart3"></i>

                        <span v-if="cartCount > 0" class="cart-badge">
                            {{ cartCount }}
                        </span>
                    </a>

                    <!-- Account - Desktop Only -->
                    <nav id="navmenu-account" class="navmenu account-menu d-none d-xl-flex">
                        <ul class="nav-right">
                            <template v-if="isLoggedIn">
                                <li class="dropdown">
                                    <a href="#" @click.prevent>
                                        <span>Account</span>
                                        <i class="bi bi-chevron-down toggle-dropdown"></i>
                                    </a>

                                    <ul>
                                        <li>
                                            <a href="/profile">Profile</a>
                                        </li>

                                        <li>
                                            <a href="/cart">Cart</a>
                                        </li>

                                        <li>
                                            <button type="button" class="logout-dropdown-btn" @click="logout">
                                                Log Out
                                            </button>
                                        </li>
                                    </ul>
                                </li>
                            </template>

                            <template v-else>
                                <li>
                                    <a href="/login" class="signin-link">
                                        Sign In
                                    </a>
                                </li>
                            </template>
                        </ul>
                    </nav>

                    <!-- Order Button - Hidden on Order, Cart and Checkout pages -->
                    <a
                        v-if="showOrderButton"
                        class="pulsating-order-now-btn"
                        href="/order"
                    >
                        Order Now
                    </a>

                    <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>

                </div>

            </div>
        </div>

    </header>
</template>

<style scoped>
.mobile-only {
    display: none;
}

.nav-right-group {
    margin-left: auto;
    display: flex;
    align-items: center;
    gap: 14px;
}

/* Cart button - fixed to stay visible on the new light header */
.cart-btn {
    position: relative;
    width: 46px;
    height: 46px;
    border-radius: 14px;
    background: rgba(255, 255, 255, .88);
    backdrop-filter: blur(12px);
    border: 1px solid rgba(240, 74, 42, .22);
    color: #f04a2a !important;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all .3s ease;
    text-decoration: none;
    box-shadow: 0 8px 20px rgba(83, 45, 23, .06);
}

.cart-btn i,
.cart-btn i::before,
.cart-btn .bi,
.cart-btn .bi::before {
    color: #f04a2a !important;
    font-size: 22px;
    line-height: 1;
}

.cart-btn:hover {
    background: #f04a2a;
    border-color: #f04a2a;
    color: #ffffff !important;
    transform: translateY(-1px);
    box-shadow: 0 12px 26px rgba(240, 74, 42, .24);
}

.cart-btn:hover i,
.cart-btn:hover i::before,
.cart-btn:hover .bi,
.cart-btn:hover .bi::before {
    color: #ffffff !important;
}

.cart-badge {
    position: absolute;
    top: -6px;
    right: -6px;
    min-width: 22px;
    height: 22px;
    padding: 0 6px;
    border-radius: 999px;
    background: linear-gradient(135deg, #f04a2a, #ff8a2a);
    color: #ffffff;
    font-size: 11px;
    font-weight: 900;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 8px 16px rgba(240, 74, 42, .28);
}

.mobile-cart-count {
    margin-left: 8px;
    background: linear-gradient(135deg, #f04a2a, #ff8a2a);
    color: #ffffff;
    font-size: 12px;
    font-weight: 900;
    padding: 2px 8px;
    border-radius: 999px;
}

.signin-link {
    color: #f04a2a !important;
    font-weight: 800 !important;
}

.logout-dropdown-btn,
.mobile-logout-link {
    width: 100%;
    border: 0;
    background: transparent;
    color: inherit;
    font: inherit;
    text-align: left;
    cursor: pointer;
    transition: .3s;
}

.logout-dropdown-btn {
    padding: 10px 20px;
    color: var(--nav-dropdown-color);
}

.logout-dropdown-btn:hover {
    color: var(--nav-dropdown-hover-color);
}

.mobile-logout-link {
    padding: 10px 20px;
    color: var(--nav-dropdown-color);
    font-family: var(--nav-font);
    font-size: 17px;
    font-weight: 500;
}

.mobile-logout-link:hover {
    color: var(--nav-dropdown-hover-color);
}

@media (max-width: 1199px) {
    .mobile-only {
        display: block;
    }

    .topbar {
        display: none !important;
    }

    .branding {
        padding: 10px 0;
    }

    .logo-img {
        height: 50px;
    }

    .sitename {
        font-size: 20px !important;
    }

    .tagline {
        display: none;
    }

    .pulsating-order-now-btn {
        display: none;
    }

    .nav-right-group {
        margin-left: auto;
        gap: 10px;
    }

    .cart-btn {
        width: 42px;
        height: 42px;
    }

    .cart-btn i,
    .cart-btn i::before,
    .cart-btn .bi,
    .cart-btn .bi::before {
        font-size: 20px;
    }

    .mobile-nav-toggle {
        font-size: 32px;
        margin-right: 0;
        color: #f04a2a !important;
    }
}

@media (max-width: 768px) {
    .logo-text {
        max-width: 150px;
    }

    .sitename {
        font-size: 16px !important;
        white-space: nowrap;
    }

    .cart-btn {
        width: 38px;
        height: 38px;
        border-radius: 12px;
    }

    .cart-btn i,
    .cart-btn i::before,
    .cart-btn .bi,
    .cart-btn .bi::before {
        font-size: 18px;
    }
}

@media (max-width: 420px) {
    .logo-img {
        height: 38px;
    }

    .sitename {
        font-size: 14px !important;
    }

    .cart-btn {
        width: 36px;
        height: 36px;
    }

    .mobile-nav-toggle {
        font-size: 28px;
    }
}
</style>
