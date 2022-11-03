<script setup>
import { computed } from 'vue';
import { usePage } from '@inertiajs/inertia-vue3';

const errors = computed(() => usePage().props.value.errors);

const hasErrors = computed(() => Object.keys(errors.value).length > 0);
</script>

<template>
    <div v-if="hasErrors">
        <!-- <div class="font-medium text-red-600">Terdapat </div> -->

        <!-- <ul class="mt-3 list-disc list-inside text-sm text-red-600"> -->
            <span class="mt-3 text-error text-sm" v-for="(error, key) in errors" :key="key">{{ error }}</span>
        <!-- </ul> -->
    </div>
</template>
