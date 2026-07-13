<script setup lang="ts">
const props = defineProps({
    menu: Object
})
</script>

<template>
    <!-- Menu Section -->
    <section id="menu" class="menu section meathouse-menu-section">

        <!-- Section Title -->
        <div class="container section-title meathouse-menu-title" data-aos="fade-up">
            <span class="menu-title-kicker">Freshly Flame-Grilled</span>
            <h2>Menu</h2>
            <p>Check Our Tasty Menu</p>
        </div><!-- End Section Title -->

        <div class="container isotope-layout" data-default-filter="*" data-layout="masonry" data-sort="original-order">

            <div class="row" data-aos="fade-up" data-aos-delay="100">
                <div class="col-lg-12 d-flex justify-content-center">
                    <ul class="menu-filters isotope-filters meathouse-menu-filters">
                        <li data-filter="*" class="filter-active">All</li>
                        <li v-for="menu_category in menu.menu_category" :data-filter="'.'+menu_category.slug" :key="menu_category.id">
                            {{ menu_category.name }}
                        </li>
                    </ul>
                </div>
            </div><!-- Menu Filters -->

            <div class="row isotope-container meathouse-menu-grid" data-aos="fade-up" data-aos-delay="200">
                <template v-for="menu_category in menu.menu_category" :key="menu_category.id">
                    <div v-for="(menu_item, itemIndex) in menu_category.menu_items" class="col-lg-4 isotope-item meathouse-menu-col" :class="menu_category.slug" :key="menu_item.id">

                        <article class="meathouse-menu-card">
                            <div class="menu-card-topline">
                                <span class="category-name">{{ menu_category.name }}</span>
                                <span v-if="itemIndex === 0" class="hero-product-badge">Top Pick</span>
                            </div>

                            <div class="menu-card-main">
                                <div class="menu-image-wrap">
                                    <img :src="menu_item.image" class="menu-img" alt="">
                                </div>

                                <div class="menu-card-details">
                                    <div class="menu-content">
                                        <a href="#">{{ menu_item.name }}</a>
                                        <span>{{ menu_item.price }}</span>
                                    </div>

                                    <div class="menu-ingredients">
                                        {{ menu_item.description }}
                                    </div>

                                    <div v-if="menu_item.chips_price" class="menu-content-upgrade">
                                        <a href="#">+ Chips Only</a>
                                        <span>R{{ menu_item.chips_price }}</span>
                                    </div>

                                    <div v-if="menu_item.drink_price" class="menu-content-upgrade">
                                        <a href="#">+ Chips &amp; Soft Drink</a>
                                        <span>R{{ menu_item.drink_price }}</span>
                                    </div>
                                </div>
                            </div>
                        </article>

                    </div><!-- Menu Item -->
                </template>
            </div><!-- Menu Container -->

        </div>

    </section><!-- /Menu Section -->
</template>

<style scoped>
/* ==========================================
   MEATHOUSE MENU - CLEAN WHITE MENU CARD STYLE
   White background always, no category numbers
========================================== */
.meathouse-menu-section {
    background: #ffffff !important;
    color: #252525;
}

.meathouse-menu-title {
    text-align: left;
}

.menu-title-kicker {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 12px;
    color: #3f6f1d;
    font-size: 13px;
    font-weight: 900;
    text-transform: uppercase;
    letter-spacing: 2px;
}

.meathouse-menu-title h2 {
    color: #3f6f1d;
    font-weight: 900;
}

.meathouse-menu-title h2::after {
    background: linear-gradient(90deg, #d70000, #f0a100);
}

.meathouse-menu-title p {
    color: #d70000;
    font-weight: 900;
    letter-spacing: -.5px;
}

/* ==========================================
   FILTERS
========================================== */
.meathouse-menu-filters {
    display: flex;
    flex-wrap: wrap;
    justify-content: flex-start;
    gap: 8px;
    padding: 8px !important;
    background: #ffffff;
    border: 1px solid #f1c789;
    border-radius: 999px;
    box-shadow: 0 8px 24px rgba(64, 38, 14, .06);
}

.meathouse-menu-filters li {
    color: #252525 !important;
    background: #ffffff;
    border: 1px solid #f1c789;
    border-radius: 999px;
    padding: 9px 18px !important;
    margin: 0 !important;
    font-size: 14px !important;
    font-weight: 900 !important;
    text-transform: uppercase;
    letter-spacing: .4px;
}

.meathouse-menu-filters li:hover,
.meathouse-menu-filters li.filter-active {
    color: #ffffff !important;
    background: #d70000;
    border-color: #d70000;
}

/* ==========================================
   MENU GRID + CARD
========================================== */
.meathouse-menu-grid {
    margin-top: 8px;
    row-gap: 20px;
}

.meathouse-menu-col {
    margin-top: 20px !important;
}

.meathouse-menu-card {
    position: relative;
    height: 100%;
    padding: 14px;
    background: #ffffff;
    border: 1px solid #f1c789;
    border-radius: 16px;
    box-shadow: 0 8px 22px rgba(64, 38, 14, .06);
    overflow: hidden;
    transition: transform .25s ease, box-shadow .25s ease, border-color .25s ease;
}

.meathouse-menu-card:hover {
    transform: translateY(-4px);
    border-color: #d70000;
    box-shadow: 0 14px 34px rgba(64, 38, 14, .11);
}

.menu-card-topline {
    position: relative;
    z-index: 3;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 10px;
    margin-bottom: 10px;
    padding-bottom: 8px;
    border-bottom: 1px solid #f1c789;
}

.category-name {
    color: #3f6f1d;
    font-size: 13px;
    font-weight: 950;
    text-transform: uppercase;
    letter-spacing: .7px;
}

.hero-product-badge {
    display: inline-flex;
    align-items: center;
    color: #ffffff;
    background: #3f6f1d;
    border-radius: 999px;
    padding: 4px 9px;
    font-size: 10px;
    font-weight: 900;
    text-transform: uppercase;
    letter-spacing: .4px;
    white-space: nowrap;
}

.menu-card-main {
    position: relative;
    z-index: 3;
    display: flex;
    align-items: flex-start;
    gap: 12px;
}

.menu-image-wrap {
    flex: 0 0 auto;
}

.meathouse-menu-card .menu-img {
    float: none !important;
    width: 94px !important;
    height: 94px !important;
    margin: 0 !important;
    object-fit: cover;
    border-radius: 14px !important;
    border: 4px solid #fff4e6 !important;
    box-shadow: 0 8px 18px rgba(0, 0, 0, .12);
}

.menu-card-details {
    flex: 1;
    min-width: 0;
}

/* ==========================================
   ORIGINAL MENU CONTENT RE-STYLED
========================================== */
.meathouse-menu-card .menu-content {
    margin-left: 0 !important;
    overflow: visible !important;
    align-items: flex-start;
    gap: 10px;
}

.meathouse-menu-card .menu-content::after {
    color: #cfc4b5 !important;
    top: 1px !important;
}

.meathouse-menu-card .menu-content a {
    color: #252525 !important;
    background: #ffffff !important;
    font-weight: 950 !important;
    text-transform: uppercase;
    letter-spacing: .2px;
    line-height: 1.25;
    font-size: 14px;
}

.meathouse-menu-card .menu-content a:hover {
    color: #d70000 !important;
}

.meathouse-menu-card .menu-content span {
    color: #d70000 !important;
    background: #ffffff !important;
    opacity: 1 !important;
    font-size: 15px;
    font-weight: 950 !important;
    white-space: nowrap;
}

.meathouse-menu-card .menu-ingredients {
    margin-left: 0 !important;
    margin-top: 7px;
    color: #575757 !important;
    font-size: 13px;
    line-height: 1.5;
    font-style: normal !important;
}

.meathouse-menu-card .menu-content-addons {
    margin-left: 0 !important;
    margin-top: 12px;
    display: inline-flex !important;
    align-items: center;
    color: #3f6f1d;
    background: #f4fbef;
    border: 1px solid rgba(63, 111, 29, .20);
    border-radius: 999px;
    padding: 6px 12px;
    font-size: 11px;
    font-weight: 950;
    letter-spacing: .6px;
}

.meathouse-menu-card .menu-content-upgrade {
    margin-left: 0 !important;
    margin-top: 7px;
    padding-top: 7px;
    border-top: 1px dashed #d9c8b0;
}

.meathouse-menu-card .menu-content-upgrade::after {
    display: none;
}

.meathouse-menu-card .menu-content-upgrade a {
    color: #252525 !important;
    background: transparent !important;
    font-weight: 850 !important;
    font-size: 13px;
}

.meathouse-menu-card .menu-content-upgrade span {
    color: #3f6f1d !important;
    background: transparent !important;
    font-weight: 950 !important;
}

/* ==========================================
   RESPONSIVE
========================================== */
@media (max-width: 767px) {
    .meathouse-menu-filters {
        border-radius: 20px;
    }

    .menu-card-main {
        flex-direction: column;
    }

    .meathouse-menu-card .menu-img {
        width: 100% !important;
        height: 210px !important;
    }
}

@media (max-width: 575px) {
    .meathouse-menu-card {
        padding: 14px;
    }

    .meathouse-menu-card .menu-content {
        flex-direction: column;
    }

    .meathouse-menu-card .menu-content::after {
        display: none;
    }

    .meathouse-menu-card .menu-content span {
        padding-left: 0 !important;
    }
}
</style>
