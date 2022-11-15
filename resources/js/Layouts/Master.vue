<template>
    <Drawer @loading="loading">
        <Navbar @loading="loading" />
        <div v-if="data.status" class="px-5 py-10 mx-24" >
            <slot :loading="loading" />
        </div>
        <div v-else class="flex h-full flex-col justify-center">
            <Vue3Lottie :animationData="Loading" :height="230" :width="350" />
            <Vue3Lottie :animationData="Wait" :height="150" :width="500" />
        </div>
    </Drawer>
</template>

<script setup>
import Navbar from "@/Components/Navbar/index.vue";
import Drawer from "@/Components/Drawer/index.vue";
import Loading from "/public/image/dashboard/paperLoading.json"
import Wait from "/public/image/dashboard/wait.json"
import { useForm } from '@inertiajs/inertia-vue3';

const data = useForm({
    status: 1
});

function loading () {
    data.status = !data.status
}

</script>
