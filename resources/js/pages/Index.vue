<script setup lang="ts">
import Hero from '@/pages/sections/Hero.vue';
import Menu from '@/pages/sections/Menu.vue';
import Specials from '@/pages/sections/Specials.vue';
import Contact from '@/pages/sections/Contact.vue';
import AppLayout from '@/layouts/restaurantly/AppLayout.vue';

defineOptions({
    layout: AppLayout,
});

const props = defineProps({
    menu: Object
})
</script>

<template>
    <Hero/>
    <Menu :menu="menu"/>
    <Specials/>
    <Contact/>
</template>
