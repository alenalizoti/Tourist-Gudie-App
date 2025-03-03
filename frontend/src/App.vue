<script setup>
import { RouterLink, RouterView } from 'vue-router'
import Navbar from '@/components/Navbar.vue';
import { useRoute } from 'vue-router';
import { computed } from 'vue';
import NavbarApp from './components/NavbarApp.vue';
import router from './router';

const route = useRoute();
</script>

<template>
  <div>
    <NavbarApp v-if="route.path.startsWith('/app')" />
    <Navbar v-else-if="!$route.meta.hideNavbar" />
    <RouterView />
  </div>
</template>






