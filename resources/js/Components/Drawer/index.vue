<template>
  <div class="drawer">
  <input id="my-drawer" type="checkbox" class="drawer-toggle" />
  <div class="drawer-content bg-gray-100 ">
    <!-- Page content here -->
    <slot/>
  </div> 
  <div class="drawer-side">
    <label for="my-drawer" class="drawer-overlay"></label>
    <ul class="menu p-4 overflow-y-auto w-80 bg-base-100 text-base-content ">
      <!-- Sidebar content here -->
      <Admin    v-if="user.role === 1" @loading="emit('loading')"/>
      <Ppk      v-else-if="user.role === 2" @loading="emit('loading')"/>
      <Pp       v-else-if="user.role === 3" @loading="emit('loading')"/>
      <Hps      v-else-if="user.role === 4" @loading="emit('loading')"/>
      <Kontrak  v-else-if="user.role === 5" @loading="emit('loading')"/>
      <Unit     v-else-if="user.role === 7" @loading="emit('loading')"/>
      <Siren    v-else-if="user.role === 8" @loading="emit('loading')"/>
    </ul>
  </div>
</div>
</template>

<script setup>

  import { Link } from '@inertiajs/inertia-vue3'
  import Admin from './admin.vue';
  import Ppk from './ppk.vue';
  import Pp from './pp.vue';
  import Hps from './hps.vue'
  import Kontrak from './kontrak.vue';
  import Unit from './unit.vue';
  import Siren from './siren.vue';
  import { computed } from 'vue'
  import { usePage } from '@inertiajs/inertia-vue3'

  const user = computed(() => usePage().props.value.auth.user)
  const emit = defineEmits('loading')

  </script>