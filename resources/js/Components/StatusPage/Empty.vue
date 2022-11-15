
<template>
    <Vue3Lottie :animationData="Empty" :height="450" :width="700" />
    <div class="text-x drop-shadow text-2xl font-bold text-first text-center">Maaf, Data {{text}} belum tersedia</div>
</template>

<script setup>
import Empty from "/public/image/dashboard/empty3.json"
defineProps(['text']);

</script>
            