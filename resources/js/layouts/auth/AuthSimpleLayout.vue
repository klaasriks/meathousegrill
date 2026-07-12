<!-- Meathouse Grill Auth Layout - SM Version -->
<template>
    <div class="auth-layout">
        <div class="auth-shell">
            <div class="auth-brand">
                <div class="brand-content">
                    <span class="brand-eyebrow">Meathouse Grill</span>
                    <h1>Flame Grilled.<br>Bold Flavour.<br>Made To Go.</h1>
                    <p>Order your favourite ribs, chicken, burgers, curries, wraps and sides.</p>

                    <div class="brand-features">
                        <div class="feature-card">
                            <strong>Fast Checkout</strong>
                            <span>Save your details and order quicker.</span>
                        </div>
                        <div class="feature-card">
                            <strong>Collection & Delivery</strong>
                            <span>Choose how you want to receive your order.</span>
                        </div>
                        <div class="feature-card">
                            <strong>Freshly Prepared</strong>
                            <span>Every meal prepared fresh for every order.</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="auth-content">
                <div class="auth-header">
                    <span>Account Access</span>
                    <h2>{{ title }}</h2>
                    <p>{{ description }}</p>
                </div>

                <slot />
            </div>
        </div>
    </div>
</template>

<style scoped>
.auth-layout {
    min-height: 100vh;
    padding: 15px 20px 15px;
    display: flex;
    align-items: center;
    justify-content: center;
    background:
        radial-gradient(circle at 10% 14%, rgba(255,207,77,.24), transparent 28%),
        radial-gradient(circle at 88% 24%, rgba(240,74,42,.16), transparent 26%),
        linear-gradient(180deg,#fff9f2 0%,#fff3e6 100%);
}

.auth-shell {
    width: 100%;
    max-width: 900px;
    display: grid;
    grid-template-columns: 320px 1fr;
    background: rgba(255,255,255,.96);
    border: 1px solid #f0dfcc;
    border-radius: 24px;
    overflow: hidden;
    box-shadow: 0 16px 40px rgba(83,45,23,.10);
}

.auth-brand {
    background: linear-gradient(135deg,#f04a2a,#ff8a2a);
    color: #fff;
}

.brand-content {
    padding: 36px;
}

.brand-eyebrow {
    font-size: 11px;
    font-weight: 900;
    text-transform: uppercase;
    letter-spacing: 1.2px;
}

.brand-content h1 {
    font-size: 38px;
    line-height: 1.1;
    font-weight: 950;
    margin: 18px 0;
}

.brand-content p {
    line-height: 1.7;
    opacity: .92;
}

.brand-features {
    margin-top: 24px;
    display: grid;
    gap: 12px;
}

.feature-card {
    padding: 12px;
    border-radius: 14px;
    background: rgba(255,255,255,.12);
}

.feature-card strong {
    display:block;
    margin-bottom:4px;
}

.feature-card span {
    font-size: 12px;
}

.auth-content {
    padding: 36px;
}

.auth-header span {
    color: #f04a2a;
    font-size: 12px;
    font-weight: 900;
    text-transform: uppercase;
}

.auth-header h2 {
    font-size: 30px;
    font-weight: 950;
    color: #261b16;
    margin: 8px 0;
}

.auth-header p {
    color: #6b5b52;
}

:deep(input) {
    min-height: 48px;
    border-radius: 12px;
}

:deep(button[type='submit']) {
    min-height: 50px;
    border-radius: 12px;
    background: linear-gradient(135deg,#f04a2a,#ff8a2a) !important;
}

@media (max-width: 768px) {
    .auth-shell {
        grid-template-columns: 1fr;
    }

    .auth-content,
    .brand-content {
        padding: 24px;
    }

    .brand-content h1 {
        font-size: 32px;
    }
}
</style>
