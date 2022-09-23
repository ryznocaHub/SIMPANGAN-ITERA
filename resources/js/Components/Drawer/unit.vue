<template>
      <li><Link :href="route('unit.procurement.index')" >Daftar Pengadaan</Link></li>
      <li><Link :href="route('unit.procurement.create')" >Ajukan Pengadaan</Link></li>
</template>

<script setup>

  import { Link } from '@inertiajs/inertia-vue3'
  </script>