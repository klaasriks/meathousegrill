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
   HERO READABILITY FIX - IMAGE STILL VISIBLE
========================================== */
.hero {
    position: relative;
    overflow: hidden;
    min-height: 100vh;
}

.hero img {
    position: absolute;
    inset: 0;
    display: block;
    width: 100%;
    height: 100%;
    object-fit: cover;
    z-index: 1;
}

/* Soft left-side readability layer only; does not block the full image */
.hero-readable-overlay {
    position: absolute;
    inset: 0;
    z-index: 2;
    pointer-events: none;
    background:
        linear-gradient(
            90deg,
            rgba(255, 255, 255, .58) 0%,
            rgba(255, 255, 255, .42) 25%,
            rgba(255, 255, 255, .18) 48%,
            rgba(255, 255, 255, 0) 72%
        ),
        radial-gradient(
            circle at 20% 50%,
            rgba(255, 249, 242, .46),
            rgba(255, 249, 242, 0) 32%
        );
}

.hero .container {
    position: relative;
    z-index: 3;
}

/* No blocking card - content floats directly over image */
.hero-content {
    max-width: 790px;
    padding-top: 18px;
}

.hero-eyebrow {
    display: inline-flex;
    align-items: center;
    gap: 9px;
    color: #f04a2a;
    font-size: 13px;
    font-weight: 900;
    text-transform: uppercase;
    letter-spacing: 1.5px;
    margin-bottom: 12px;
    text-shadow: 0 2px 8px rgba(255, 255, 255, .72);
}

.hero-eyebrow::before {
    content: "";
    width: 30px;
    height: 4px;
    border-radius: 999px;
    background: linear-gradient(90deg, #f04a2a, #ff8a2a);
    box-shadow: 0 3px 12px rgba(240, 74, 42, .25);
}

.hero h2 {
    margin: 0;
    color: #19110d;
    font-size: clamp(35px, 4vw, 60px);
    font-weight: 950;
    line-height: 1.05;
    letter-spacing: -1.3px;
    text-shadow:
        0 2px 10px rgba(255, 255, 255, .78),
        0 12px 32px rgba(255, 249, 242, .38);
}

.hero h2 span {
    color: #f04a2a;
    text-shadow:
        0 2px 10px rgba(255, 255, 255, .76),
        0 10px 25px rgba(240, 74, 42, .20);
}

.hero-tagline {
    color: #f04a2a !important;
    font-size: clamp(18px, 2vw, 24px);
    font-weight: 950;
    letter-spacing: 1px;
    margin: 18px 0 14px;
    text-transform: uppercase;
    text-shadow: 0 2px 10px rgba(255, 255, 255, .78);
}

.hero-description {
    max-width: 770px;
    color: #1f1712;
    font-size: 18px;
    line-height: 1.85;
    font-weight: 600;
    margin: 0;
    text-shadow:
        0 1px 8px rgba(255, 255, 255, .82),
        0 8px 20px rgba(255, 249, 242, .30);
}

.hero-actions {
    gap: 14px;
    flex-wrap: wrap;
}

.hero .cta-btn,
.hero .cta-btn:focus {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    min-width: 170px;
    padding: 13px 28px;
    border-radius: 999px;
    font-size: 14px;
    font-weight: 900;
    text-transform: uppercase;
    letter-spacing: .8px;
    transition: all .25s ease;
    text-decoration: none;
}

.primary-hero-btn {
    color: #ffffff !important;
    background: linear-gradient(135deg, #f04a2a, #ff8a2a);
    border: 1px solid transparent !important;
    box-shadow: 0 14px 30px rgba(240, 74, 42, .28);
}

.primary-hero-btn:hover {
    color: #ffffff !important;
    background: linear-gradient(135deg, #df3517, #f04a2a);
    transform: translateY(-2px);
}

.secondary-hero-btn {
    color: #f04a2a !important;
    background: rgba(255, 255, 255, .38);
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, .65) !important;
    box-shadow: 0 12px 26px rgba(61, 38, 22, .08);
}

.secondary-hero-btn:hover {
    color: #ffffff !important;
    background: #f04a2a;
    border-color: #f04a2a !important;
    transform: translateY(-2px);
}

/* ==========================================
   RESPONSIVE
========================================== */
@media (max-width: 991px) {
    .hero-readable-overlay {
        background:
            linear-gradient(
                180deg,
                rgba(255, 255, 255, .72) 0%,
                rgba(255, 255, 255, .46) 48%,
                rgba(255, 255, 255, .12) 100%
            );
    }

    .hero-content {
        max-width: 100%;
        text-align: center;
        padding: 0 10px;
    }

    .hero-eyebrow {
        justify-content: center;
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
        font-size: 38px;
    }

    .hero-tagline {
        font-size: 16px;
    }

    .hero .cta-btn,
    .hero .cta-btn:focus {
        width: 100%;
    }
}
</style>
