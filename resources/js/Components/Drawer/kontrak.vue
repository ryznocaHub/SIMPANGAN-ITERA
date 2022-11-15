<template>
    <li><Link @click="emit('loading')"   :href="route('kontrak.procurement.index')" >Daftar Pengadaan</Link></li>
    <li><Link @click="emit('loading')"   :href="route('supplier.index')" >Daftar Supplier</Link></li>
</template>

<script setup>
import { Link } from '@inertiajs/inertia-vue3'
const emit = defineEmits('loading')
</script>