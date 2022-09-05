<script setup>
defineProps({
    title: String,
    widthSize: String,
    // type: {
    //     type: String,
    //     default: 'submit',
    // },
});
</script>

<template>
    <h1 class="text-2xl font-black tracking-widest">{{ title }}</h1>
    <div class="m h-1 bg-first mb-5 rounded" :style="{ width: widthSize + 'px' }"></div>
</template>
