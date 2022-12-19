<template>
    <div v-show="status == 9" class="relative badge badge-secondary badge-outline tooltip tooltip-bottom ml-2" data-tip="Proses Kontrak">
        Proses Kontrak
    </div>
    <div v-show="status >= 10 " class="relative badge badge-first badge-outline tooltip tooltip-bottom ml-2" data-tip="Dokumen Kontrak Selesai">
        Pengadaan Selesai
    </div>
</template>

<script setup>
    defineProps(['status'])
</script>