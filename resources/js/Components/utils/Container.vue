<script setup>
defineProps({
    // title: String,
    // widthSize: String,
    // type: {
    //     type: String,
    //     default: 'submit',
    // },
});
</script>

<template>
    <div class="card bg-base-100 shadow-md p-5">
        <slot/>
    </div>
</template>
