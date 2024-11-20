<script setup>
import { RouterLink, RouterView } from 'vue-router'
import Navbar from '@/components/Navbar.vue';
import { useRoute } from 'vue-router';
import { computed } from 'vue';

</script>

<template>
  <div>

    <Navbar v-if="!$route.meta.hideNavbar" />
    <RouterView />
  </div>
</template>






