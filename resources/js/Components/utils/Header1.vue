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
    <div class="flex flex-col mb-5">
        <h1 class="text-2xl font-black tracking-widest">{{ title }}</h1>
        <div class="h-1 bg-first rounded" :style="{ width: widthSize + 'px' }"></div>
    </div>
</template>
