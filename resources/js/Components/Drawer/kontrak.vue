<template>
    <li><Link :href="route('kontrak.procurement.index')" >Daftar Pengadaan</Link></li>
    <li><Link :href="route('kontrak.supplier.index')" >Daftar Supplier</Link></li>
</template>

<script setup>
import { Link } from '@inertiajs/inertia-vue3'
</script>