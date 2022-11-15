<template>
    <Show :procurement=procurement >
        <template #file="{loading}">
            <!-- <a v-show="procurement.timeline.hps_approved" :href="route('hps.document.boq',procurement.id)" class="btn text-first mb-3 w-full btn-outline font-bold hover:bg-first hover:text-white hover:border-none" target="_blank">Lihat BOQ</a> -->
            <a     @click="loading()" v-show="procurement.timeline.hps_submitted && procurement.status != 7"    :href="route('hps.document.hps',procurement.id)"        class="btn text-first w-full btn-outline font-bold hover:bg-first hover:text-white hover:border-none" target="_blank">Lihat HPS</a>
            <Link  @click="loading()" v-show="procurement.status == 7"                                          :href="route('hps.procurement.edit', procurement.id)"   class="btn w-full text-first bg-slate-200 border-none hover:text-white hover:bg-first font-bold" >Ajukan Ulang</Link>
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
import { useForm, Link } from "@inertiajs/inertia-vue3";

defineProps({
	procurement: { type: Object, required: true },
})

</script>