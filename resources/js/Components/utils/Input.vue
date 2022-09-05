<script setup>
import { onMounted, ref } from "vue";

defineProps({
    modelValue: {
        type: [String,Number]
    },
    isDisable: {
        type: Boolean,
        default: false
    }
})

defineEmits(["update:modelValue"]);

const input = ref(null);

onMounted(() => {
    if (input.value.hasAttribute("autofocus")) {
        input.value.focus();
    }
});
</script>

<template>
    <input
        class="input input-bordered mb-4 border-gray-300 focus:border-first focus:ring focus:ring-first focus:ring-opacity-50 rounded-md shadow-sm"
        :value="modelValue"
        @input="$emit('update:modelValue', $event.target.value)"
        :disabled="isDisable"
        ref="input"
    />
</template>
