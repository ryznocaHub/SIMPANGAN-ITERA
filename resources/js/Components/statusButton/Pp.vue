<template>
    <div v-show="status == 8" class="relative badge badge-secondary badge-outline tooltip tooltip-bottom ml-2" data-tip="Pemilihan Supplier oleh PP">
        Penunjukan Supplier
    </div>
    <div v-show="status >= 9 " class="relative badge badge-first badge-outline tooltip tooltip-bottom ml-2" data-tip="Supplier telah di tunjuk">
        Supplier Terpilih
    </div>
</template>

<script setup>
    defineProps(['status'])
</script>