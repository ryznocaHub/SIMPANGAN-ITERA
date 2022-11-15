<template>
    <li><Link @click="emit('loading')"  :href="route('ppk.procurement.index')" >Daftar Pengadaan</Link></li>
</template>

<script setup>
import { Link } from '@inertiajs/inertia-vue3'
const emit = defineEmits('loading')
</script>