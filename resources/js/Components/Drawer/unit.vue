<template>
      <li><Link @click="emit('loading')" :href="route('unit.procurement.index')" >Daftar Pengadaan</Link></li>
      <li><Link @click="emit('loading')" :href="route('unit.procurement.create')" >Ajukan Pengadaan</Link></li>
</template>

<script setup>

  import { Link } from '@inertiajs/inertia-vue3'
  const emit = defineEmits('loading')
</script>