<template>
    <div v-show="status == 4" class="relative badge badge-secondary badge-outline tooltip tooltip-bottom ml-2" data-tip="Pemilihan Tim HPS oleh PPK">
        Penunjukan Tim HPS
    </div>
    <div v-show="status == 5" class="relative badge badge-first badge-outline tooltip tooltip-bottom ml-2" data-tip="Proses penyusunan HPS">
        Pembuatan HPS
    </div>
    <div v-show="status == 6" class="relative badge badge-secondary badge-outline tooltip tooltip-bottom ml-2" data-tip="Persetujuan HPS oleh PPK">
        Persetujuan HPS
    </div>
    <div v-show="status == 7" class="relative badge badge-first badge-outline tooltip tooltip-bottom ml-2" data-tip="Proses pengecekan ulang HPS">
        HPS ditolak
    </div>
    <div v-show="status > 7" class="relative badge badge-first badge-outline tooltip tooltip-bottom ml-2" data-tip="HPS disetujui">
        HPS diterima
    </div>
</template>

<script setup>
    defineProps(['status'])
</script>