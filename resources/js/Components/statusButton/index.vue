<template>
<div v-show="status == 1" class="badge badge-secondary badge-outline tooltip tooltip-bottom ml-2" data-tip="Dalam proses mengunggah gambar">
    Unggah Gambar
</div>
<div v-show="status == 2" class="badge badge-secondary badge-outline tooltip tooltip-bottom ml-2" data-tip="RAB sudah diajukan, dalam pengecekan tim pengadaan">
    Mengajukan RAB
</div>
</template>

<script setup>
    defineProps(['status'])
</script>