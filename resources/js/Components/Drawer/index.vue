<template>
  <div class="drawer">
  <input id="my-drawer" type="checkbox" class="drawer-toggle" />
  <div class="drawer-content bg-gray-100 snap-none">
    <!-- Page content here -->
    <slot/>
  </div> 
  <div class="drawer-side">
    <label for="my-drawer" class="drawer-overlay"></label>
    <ul class="menu p-4 overflow-y-auto w-80 bg-base-100 text-base-content ">
      <!-- Sidebar content here -->
      <Ppk      v-if="user.role === 2"/>
      <Pp       v-if="user.role === 3"/>
      <Hps      v-if="user.role === 4"/>
      <Kontrak  v-if="user.role === 5"/>
      <Unit     v-if="user.role === 7"/>
      <Siren    v-if="user.role === 8"/>
    </ul>
  </div>
</div>
</template>

<script setup>

  import { Link } from '@inertiajs/inertia-vue3'
  import Ppk from './ppk.vue';
  import Pp from './pp.vue';
  import Hps from './hps.vue'
  import Kontrak from './kontrak.vue';
  import Unit from './unit.vue';
  import Siren from './siren.vue';
  import { computed } from 'vue'
  import { usePage } from '@inertiajs/inertia-vue3'

  const user = computed(() => usePage().props.value.auth.user)
  </script>