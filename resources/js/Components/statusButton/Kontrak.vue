<template>
    <div v-show="status == 9" class="relative badge badge-secondary badge-outline tooltip tooltip-bottom ml-2" data-tip="Pemilihan Supplier oleh PP">
        Pembuatan Dokumen Kontrak
    </div>
    <div v-show="status >= 10 " class="relative badge badge-first badge-outline tooltip tooltip-bottom ml-2" data-tip="Supplier telah di tunjuk">
        Proses Kontrak Selesai
    </div>
</template>

<script setup>
    defineProps(['status'])
</script>