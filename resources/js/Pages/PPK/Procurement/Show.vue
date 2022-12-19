<template>
    <Show :procurement=procurement >
        <template #file>
            <!-- <a v-show="procurement.timeline.hps_approved" :href="route('ppk.document.boq',procurement.id)" class="btn mb-3 text-first w-full btn-outline font-bold hover:bg-first hover:text-white hover:border-none" target="_blank">Lihat BOQ</a> -->
            <!-- <a v-show="procurement.estimate.file" :href="route('ppk.document.hps',procurement.id)" class="ml-5 btn text-first btn-outline font-bold hover:bg-first hover:text-white hover:border-none" target="_blank">Lihat HPS</a> -->
            <a v-show="procurement.estimate.file" :href="procurement.estimate.file" class="ml-3 btn text-first btn-outline font-bold hover:bg-first hover:text-white hover:border-none">Lihat HPS</a>
        </template>
        <template #comment>
            <div v-if="procurement.comment">
                <div class="divider"></div>
                <div class="text-secondary font-bold ">
                    Catatan Penolakan HPS: {{ procurement.comment }}
                </div>
            </div>
        </template>
    </Show>
</template>

<script setup>
import Show from "@/Layouts/Procurement/Show.vue";

const props = defineProps({
	procurement: { type: Object, required: true },
})

</script>