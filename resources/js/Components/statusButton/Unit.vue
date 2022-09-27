<template>
    <div v-show="status == 1" class="relative badge badge-secondary badge-outline tooltip tooltip-bottom ml-2" data-tip="Dalam proses mengunggah gambar">
        Unggah Gambar
    </div>
    <div v-show="status == 2" class="relative badge badge-first badge-outline tooltip tooltip-bottom ml-2" data-tip="RAB sudah diajukan, dalam pengecekan tim pengadaan">
        Mengajukan RAB
    </div>
    <div v-show="status == 3" class="relative badge badge-first badge-outline tooltip tooltip-bottom ml-2" data-tip="RAB sudah diajukan, dalam pengecekan tim pengadaan">
        RAB Ditolak
    </div>
    <div v-show="status == 4" class="relative badge badge-first badge-outline tooltip tooltip-bottom ml-2" data-tip="RAB sudah diajukan, dalam pengecekan tim pengadaan">
        RAB Disetujui
    </div>
    <div v-show="status >= 5 && status < 8" class="relative badge badge-first badge-outline tooltip tooltip-bottom ml-2" data-tip="RAB sudah diajukan, dalam pengecekan tim pengadaan">
        Pembuatan HPS
    </div>
    <div v-show="status == 8" class="relative badge badge-first badge-outline tooltip tooltip-bottom ml-2" data-tip="RAB sudah diajukan, dalam pengecekan tim pengadaan">
        Proses PP
    </div>
    <div v-show="status == 9" class="relative badge badge-first badge-outline tooltip tooltip-bottom ml-2" data-tip="RAB sudah diajukan, dalam pengecekan tim pengadaan">
        Proses Kontrak
    </div>
    <div v-show="status >= 10" class="relative badge badge-first badge-outline tooltip tooltip-bottom ml-2" data-tip="RAB sudah diajukan, dalam pengecekan tim pengadaan">
        Barang Tiba
    </div>
</template>
<script setup>
    defineProps(['status'])
</script>