<script setup lang="ts">

</script>

<template>
    <!-- Hero Section -->
    <section id="hero" class="hero section dark-background">

        <img src="/themes/restaurantly/assets/img/hero-bg.png" alt="Meathouse Grill flame grilled meals background" data-aos="fade-in">
        <!-- <img src="/themes/restaurantly/assets/img/hero-light.png" alt="Meathouse Grill flame grilled meals background" data-aos="fade-in"> -->

        <div class="hero-readable-overlay"></div>

        <div class="container">
            <div class="row">
                <div class="col-lg-8 d-flex flex-column align-items-center align-items-lg-start">

                    <div class="hero-content">
                        <span class="hero-eyebrow" data-aos="fade-up" data-aos-delay="50">
                            Flame Grilled Takeaway
                        </span>

                        <h2 data-aos="fade-up" data-aos-delay="100">
                            Welcome to <span>Meathouse Grill</span>
                        </h2>

                        <p data-aos="fade-up" data-aos-delay="200" class="hero-tagline">
                            FLAME GRILLED. BOLD FLAVOUR. MADE TO GO.
                        </p>

                        <p class="hero-description" data-aos="fade-up" data-aos-delay="250">
                            Meathouse Grill is your ultimate takeaway spot for bold, satisfying meals made with passion and served with pride. From flame-grilled chicken, juicy ribs, and smoky sausages to hearty curries, wraps, burgers and tasty sides - signature taste you'll keep coming back for.
                        </p>

                        <div class="hero-actions d-flex mt-4" data-aos="fade-up" data-aos-delay="300">
                            <a href="#menu" class="cta-btn primary-hero-btn">Our Menu</a>
                            <a href="/order" class="cta-btn secondary-hero-btn">Order Now</a>
                        </div>
                    </div>

                </div>

                <div class="col-lg-4 d-flex align-items-center justify-content-center mt-5 mt-lg-0">
                    <!-- Nothing -->
                </div>
            </div>
        </div>

    </section><!-- /Hero Section -->
</template>

<style scoped>






/* ==========================================
   FROSTED / MILKY TOPBAR ONLY
   This only affects: class="topbar"
========================================== */

.topbar {
    position: relative;
    z-index: 1001;

    background: rgba(255, 255, 255, 0.82) !important;
    backdrop-filter: blur(18px);
    -webkit-backdrop-filter: blur(18px);

    border-bottom: 1px solid rgba(255, 255, 255, 0.35);
    box-shadow: 0 3px 18px rgba(0, 0, 0, 0.08);

    color: #1f1f1f !important;
}

/* Extra milky layer */
.topbar::before {
    content: "";
    position: absolute;
    inset: 0;
    z-index: -1;
    pointer-events: none;

    background: linear-gradient(
        90deg,
        rgba(255, 255, 255, 0.95) 0%,
        rgba(255, 255, 255, 0.78) 50%,
        rgba(255, 255, 255, 0.95) 100%
    );
}

/* Make all text inside topbar readable */
.topbar,
.topbar a,
.topbar span,
.topbar div {
    color: #1f1f1f !important;
    text-shadow: none !important;
    font-weight: 600;
}

/* Icons in the topbar */
.topbar i {
    color: #b62323 !important;
}

/* Links hover */
.topbar a:hover {
    color: #971d1d !important;
}

/* Mobile stronger opacity */
@media (max-width: 991px) {
    .topbar {
        background: rgba(255, 255, 255, 0.94) !important;
    }
}

/* ==========================================
   PREMIUM MEATHOUSE HERO
   Professional flame-grilled landing section
========================================== */
.hero {
    --charcoal: #17120f;
    --charcoal-soft: #241b16;
    --ember: #b62323;
    --ember-dark: #8f1b1b;
    --flame: #d97a1c;
    --gold: #c79a3b;
    --cream: #fffaf3;
    --muted-cream: rgba(255, 250, 243, .78);
    --shadow: 0 18px 52px rgba(23, 18, 15, .30);

    position: relative;
    overflow: hidden;
    min-height: 100vh;
    background: var(--charcoal);
}

.hero img {
    position: absolute;
    inset: 0;
    display: block;
    width: 100%;
    height: 100%;
    object-fit: cover;
    z-index: 1;
    filter: saturate(.95) contrast(1.05) brightness(.78);
    transform: scale(1.015);
}

/* Dark premium overlay: image remains visible but text becomes clean and readable */
.hero-readable-overlay {
    position: absolute;
    inset: 0;
    z-index: 2;
    pointer-events: none;
    background:
        linear-gradient(
            90deg,
            rgba(15, 11, 9, .94) 0%,
            rgba(23, 18, 15, .88) 28%,
            rgba(23, 18, 15, .58) 54%,
            rgba(23, 18, 15, .25) 78%,
            rgba(23, 18, 15, .38) 100%
        ),
        radial-gradient(
            circle at 22% 46%,
            rgba(182, 35, 35, .23),
            rgba(182, 35, 35, 0) 30%
        ),
        radial-gradient(
            circle at 30% 74%,
            rgba(217, 122, 28, .18),
            rgba(217, 122, 28, 0) 34%
        );
}

.hero::after {
    content: "";
    position: absolute;
    inset: 0;
    z-index: 2;
    pointer-events: none;
    background:
        repeating-linear-gradient(
            135deg,
            rgba(255,255,255,.026) 0,
            rgba(255,255,255,.026) 1px,
            transparent 1px,
            transparent 13px
        );
    opacity: .46;
}

.hero .container {
    position: relative;
    z-index: 4;
}

.hero-content {
    max-width: 760px;
    padding-top: 22px;
}

.hero-eyebrow {
    display: inline-flex;
    align-items: center;
    gap: 10px;
    color: #f3c978;
    font-size: 12px;
    font-weight: 850;
    text-transform: uppercase;
    letter-spacing: 1.4px;
    margin-bottom: 16px;
}

.hero-eyebrow::before {
    content: "";
    width: 30px;
    height: 3px;
    border-radius: 999px;
    background: linear-gradient(90deg, var(--ember), var(--flame), var(--gold));
    box-shadow: 0 6px 18px rgba(217, 122, 28, .28);
}

.hero h2 {
    margin: 0;
    color: #ffffff;
    font-size: clamp(42px, 4.4vw, 70px);
    font-weight: 900;
    line-height: 1.02;
    letter-spacing: -1.8px;
    text-shadow: 0 16px 38px rgba(0, 0, 0, .45);
}

.hero h2 span {
    color: #ffffff;
    position: relative;
    display: inline-block;
}

.hero h2 span::after {
    content: "";
    position: absolute;
    left: 2px;
    right: 2px;
    bottom: -6px;
    height: 4px;
    border-radius: 999px;
    background: linear-gradient(90deg, var(--ember), var(--flame), var(--gold));
    box-shadow: 0 8px 22px rgba(182, 35, 35, .30);
}

.hero-tagline {
    color: #f3c978 !important;
    font-size: clamp(15px, 1.3vw, 18px);
    font-weight: 850;
    letter-spacing: 2px;
    margin: 26px 0 14px;
    text-transform: uppercase;
}

.hero-description {
    max-width: 700px;
    color: var(--muted-cream);
    font-size: 17px;
    line-height: 1.82;
    font-weight: 500;
    margin: 0;
    text-shadow: 0 10px 28px rgba(0, 0, 0, .34);
}

.hero-actions {
    gap: 12px;
    flex-wrap: wrap;
}

.hero .cta-btn,
.hero .cta-btn:focus {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    min-width: 160px;
    padding: 13px 24px;
    border-radius: 10px;
    font-size: 13px;
    font-weight: 850;
    text-transform: none;
    letter-spacing: .25px;
    transition: all .2s ease;
    text-decoration: none;
}

.primary-hero-btn {
    color: #ffffff !important;
    background: linear-gradient(135deg, var(--ember), var(--ember-dark));
    border: 1px solid rgba(255,255,255,.08) !important;
    box-shadow: 0 14px 30px rgba(182, 35, 35, .28);
}

.primary-hero-btn:hover {
    color: #ffffff !important;
    background: linear-gradient(135deg, var(--ember-dark), #731515);
    transform: translateY(-1px);
}

.secondary-hero-btn {
    color: #fffaf3 !important;
    background: rgba(255, 250, 243, .08);
    border: 1px solid rgba(255, 250, 243, .32) !important;
    backdrop-filter: blur(10px);
}

.secondary-hero-btn:hover {
    color: var(--charcoal) !important;
    background: #fffaf3;
    border-color: #fffaf3 !important;
    transform: translateY(-1px);
}

/* ==========================================
   RESPONSIVE
========================================== */
@media (max-width: 991px) {
    .hero-readable-overlay {
        background:
            linear-gradient(
                180deg,
                rgba(15, 11, 9, .92) 0%,
                rgba(23, 18, 15, .82) 50%,
                rgba(23, 18, 15, .58) 100%
            ),
            radial-gradient(circle at 50% 20%, rgba(182,35,35,.18), transparent 36%);
    }

    .hero-content {
        max-width: 100%;
        text-align: center;
        padding: 0 10px;
    }

    .hero-eyebrow {
        justify-content: center;
    }

    .hero h2 span::after {
        left: 8px;
        right: 8px;
    }

    .hero-description {
        font-size: 16px;
        line-height: 1.75;
        max-width: 100%;
    }

    .hero-actions {
        justify-content: center;
    }
}

@media (max-width: 575px) {
    .hero-content {
        padding: 0;
    }

    .hero h2 {
        font-size: 40px;
    }

    .hero-tagline {
        font-size: 14px;
        letter-spacing: 1.3px;
    }

    .hero .cta-btn,
    .hero .cta-btn:focus {
        width: 100%;
    }
}


/*Custom Added by - Klaas */
@media (min-width: 991px) {
    .hero-readable-overlay {
        position: absolute;
        inset: 0;
        z-index: 2;
        pointer-events: none;

        background:
            linear-gradient(
                180deg,
                rgba(255,255,255,.75) 0px,
                rgba(255,255,255,.60) 90px,
                rgba(255,255,255,.25) 160px,
                rgba(255,255,255,0) 260px
            );
    }
}
</style>
