<template>
    <div v-show="status == 2" class="relative badge badge-secondary badge-outline tooltip tooltip-bottom ml-2" data-tip="Pengecekan Akun Pengadaan">
        Pengecekan Akun
    </div>
    <div v-show="status == 3" class="relative badge badge-first badge-outline tooltip tooltip-bottom ml-2" data-tip="RAB ditolak">
        RAB ditolak 
    </div>
    <div v-show="status >= 4" class="relative badge badge-first badge-outline tooltip tooltip-bottom ml-2" data-tip="RAB disetujui">
        RAB diterima 
    </div>
</template>
<script setup>
    defineProps(['status'])
</script>