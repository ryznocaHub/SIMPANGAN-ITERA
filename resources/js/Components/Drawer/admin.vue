<template>
    <li><Link @click="emit('loading')" :href="route('admin.procurement.index')" >Daftar Pengadaan</Link></li>
    <li><Link @click="emit('loading')" :href="route('supplier.index')" >Daftar Supplier</Link></li>
    <li><Link @click="emit('loading')" :href="route('admin.user.create')" >Tambah User</Link></li>
    <li><Link @click="emit('loading')" :href="route('admin.user.index')" >Daftar User Aktif</Link></li>
    <li><Link @click="emit('loading')" :href="route('admin.usersNonActive')" >Daftar User Non Aktif</Link></li>
</template>

<script setup>
import { Link } from '@inertiajs/inertia-vue3'
const emit = defineEmits('loading')
</script>