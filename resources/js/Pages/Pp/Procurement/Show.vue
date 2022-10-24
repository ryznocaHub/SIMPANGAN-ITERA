<template>
    <Show :procurement=procurement >
        <template #file>
            <a v-show="procurement.timeline.hps_approved" :href="route('pp.document.boq',procurement.id)" class="btn text-first w-full btn-outline font-bold hover:bg-first hover:text-white hover:border-none" target="_blank">Lihat BOQ</a>
        </template>
    </Show>
</template>

<script setup>
import Show from "@/Layouts/Procurement/Show.vue";

const props = defineProps({
	procurement: { type: Object, required: true },
})

</script>