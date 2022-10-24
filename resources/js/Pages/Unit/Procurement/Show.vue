<template>
    <Show :procurement=procurement >
        <template #comment="{data}">
            <div v-if="data.comment">
                <div class="divider"></div>
                <div class="text-secondary font-bold ">
                    Catatan Penolakan RAB: {{ data.comment }}
                </div>
            </div>
        </template>
        <template #file v-if="procurement.status == 3">
            <Link :href="route('unit.procurement.reupload', procurement.id)" class="btn text-first bg-slate-200 border-none hover:text-white hover:bg-first font-bold" >Ajukan Ulang</Link>

            <!-- <button @click="newRequest()" class="btn text-first bg-slate-200 border-none hover:text-white hover:bg-first font-bold">Ajukan Ulang</button> -->
        </template>
    </Show>
</template>

<script setup>
import Show from "@/Layouts/Procurement/Show.vue";
import { useForm, Link } from "@inertiajs/inertia-vue3";

const props = defineProps({
	procurement: { type: Object, required: true },
})

const approve = useForm({
    _method: 'patch',
    status: 2
});

const newRequest = () => 
{
    approve.post(route('unit.procurement.update',props.procurement.id),{
        onSuccess : () => {
            console.log("sukses ajukan ulang RAB")
        },
        onError: () => {
            console.log("gagal ajukan ulang RAB")
        }
    });
}

</script>
