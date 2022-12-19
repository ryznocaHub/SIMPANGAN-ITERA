<template>
    <div v-show="status == 2" class="relative badge badge-first badge-outline tooltip tooltip-bottom ml-2" data-tip="Pengecekan RAB">
        RAB Masuk
    </div>
    <div v-show="status == 3" class="relative badge badge-first badge-outline tooltip tooltip-bottom ml-2" data-tip="Revisi RAB oleh Unit">
        Revisi RAB
    </div>
    <div v-show="status == 4" class="relative badge badge-first badge-outline tooltip tooltip-bottom ml-2" data-tip="Penunjukan PIC HPS oleh PPK">
        Penunjukan Tim HPS
    </div>
    <div v-show="status >= 5 && status < 8" class="relative badge badge-first badge-outline tooltip tooltip-bottom ml-2" data-tip="Pembuatan HPS">
        Pembuatan HPS
    </div>
    <div v-show="status == 8" class="relative badge badge-first badge-outline tooltip tooltip-bottom ml-2" data-tip="Penunjukan Supplier oleh PP">
        Penunjukan Supplier
    </div>
    <div v-show="status == 9" class="relative badge badge-first badge-outline tooltip tooltip-bottom ml-2" data-tip="Pembuatan dokumen kontrak">
        Proses Kontrak
    </div>
    <div v-show="status >= 10" class="relative badge badge-first badge-outline tooltip tooltip-bottom ml-2" data-tip="Dokumen Kontrak Selesai">
        Pengadaan Selesai
    </div>
</template>
<script setup>
    defineProps(['status'])
</script>