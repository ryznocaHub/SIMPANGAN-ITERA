<template>
    <Show :procurement=procurement >
        <template #file>
            <!-- <a v-show="procurement.timeline.hps_approved" :href="route('hps.document.boq',procurement.id)" class="btn text-first mb-3 w-full btn-outline font-bold hover:bg-first hover:text-white hover:border-none" target="_blank">Lihat BOQ</a> -->
            <a v-show="procurement.timeline.hps_submitted" :href="route('hps.document.hps',procurement.id)" class="btn text-first w-full btn-outline font-bold hover:bg-first hover:text-white hover:border-none" target="_blank">Lihat HPS</a>
            <Link v-show="procurement.status == 7"  :href="route('hps.procurement.edit', procurement.id)" class="btn w-full mt-3 text-first bg-slate-200 border-none hover:text-white hover:bg-first font-bold" >Ajukan Ulang</Link>
        </template>
        <template #comment="{data}">
            <div v-if="data.comment">
                <div class="divider"></div>
                <div class="text-secondary font-bold ">
                    Catatan Penolakan HPS: {{ data.comment }}
                </div>
            </div>
        </template>
    </Show>
</template>

<script setup>
import Show from "@/Layouts/Procurement/Show.vue";
import { useForm, Link } from "@inertiajs/inertia-vue3";

const props = defineProps({
	procurement: { type: Object, required: true },
})
const dataConfirmation = useForm({
    _method: 'patch',
    status: 6,
})
const newRequest = () => {
    dataConfirmation.post(route('hps.procurement.update',props.procurement.id),{
        onSuccess : () => {
            console.log("sukses ajukan ulang HPS")
        },
        onError: (e) => {
            console.log("gagal ajukan ulang RAB",e)
        }
    });
}

</script>