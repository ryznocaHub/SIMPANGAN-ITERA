<template>
    <div class="flex flex-col text-center justify-items-center items-center ">
        <img :src="'/image/status/complete.svg'" class="w-2/12 mb-5"/>
        <Header1 :title=text :widthSize="0" />
        <slot/>
    </div>

</template>

<script setup>
import Header1 from "@/Components/utils/Header1.vue";

defineProps(['text']);
</script>
