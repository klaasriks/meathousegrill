<script setup lang="ts">

const props = defineProps({
    menu: Object
})
</script>

<template>
    <!-- Menu Section -->
    <section id="menu" class="menu section">

        <!-- Section Title -->
        <div class="container section-title" data-aos="fade-up">
            <h2>Menu</h2>
            <p>Check Our Tasty Menu</p>
        </div><!-- End Section Title -->

        <div class="container isotope-layout" data-default-filter="*" data-layout="masonry" data-sort="original-order">

            <div class="row" data-aos="fade-up" data-aos-delay="100">
                <div class="col-lg-12 d-flex justify-content-center">
                    <ul class="menu-filters isotope-filters">
                        <li data-filter="*" class="filter-active">All</li>
                        <li v-for="menu_category in menu.menu_category" :data-filter="'.'+menu_category.slug" :key="menu_category.id">{{ menu_category.name}}</li>
                    </ul>
                </div>
            </div><!-- Menu Filters -->

            <div class="row isotope-container" data-aos="fade-up" data-aos-delay="200">
                <template v-for="menu_category in menu.menu_category" :key="menu_category.id">
                    <div v-for="menu_item in menu_category.menu_items" class="col-lg-6 menu-item isotope-item" :class="menu_category.slug" :key="menu_item.id">
                        <img :src="menu_item.image" class="menu-img" alt="">
                        <div class="menu-content">
                            <a href="#">{{ menu_item.name }}</a>
                            <span>{{ menu_item.price }}</span>
                        </div>

                        <div class="menu-ingredients">
                            {{ menu_item.description }}
                        </div>

                        <div
                            v-if="menu_item.chips_price || menu_item.drink_price"
                            class="menu-content-addons"
                        >
                            Upgrade your meal
                        </div>

                        <div v-if="menu_item.chips_price" class="menu-content-upgrade">
                            <a href="#">+ Chips Only</a>
                            <span>R{{ menu_item.chips_price }}</span>
                        </div>

                        <div v-if="menu_item.drink_price" class="menu-content-upgrade">
                            <a href="#">+ Chips &amp; Soft Drink</a>
                            <span>R{{ menu_item.drink_price }}</span>
                        </div>

                    </div><!-- Menu Item -->
                </template>
            </div><!-- Menu Container -->

        </div>

    </section><!-- /Menu Section -->
</template>
