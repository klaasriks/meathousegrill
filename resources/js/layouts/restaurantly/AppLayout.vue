<script setup>
import { onMounted } from 'vue';

import Header from './Header.vue';
import Footer from './Footer.vue';
import Preloader from './Preloader.vue';

// Load JS plugins after render
onMounted(() => {
    const scripts = [
        '/themes/restaurantly/assets/vendor/bootstrap/js/bootstrap.bundle.min.js',
        '/themes/restaurantly/assets/vendor/php-email-form/validate.js',
        '/themes/restaurantly/assets/vendor/aos/aos.js',
        '/themes/restaurantly/assets/vendor/glightbox/js/glightbox.min.js',
        '/themes/restaurantly/assets/vendor/imagesloaded/imagesloaded.pkgd.min.js',
        '/themes/restaurantly/assets/vendor/isotope-layout/isotope.pkgd.min.js',
        '/themes/restaurantly/assets/vendor/swiper/swiper-bundle.min.js',
        '/themes/restaurantly/assets/js/main.js',
    ];

    scripts.forEach(src => {
        const script = document.createElement('script');
        script.src = src;
        script.async = false;
        document.body.appendChild(script);
    });
});
</script>

<template>

    <Header/>

    <main>
        <slot />
    </main>

    <Footer/>

    <!-- Scroll Top -->
    <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>
    <!-- PreLoader -->
    <Preloader/>
</template>
