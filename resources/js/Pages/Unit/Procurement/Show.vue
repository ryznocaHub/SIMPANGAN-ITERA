<template>
    <Show :procurement=procurement >
        <template #comment>
            <div v-if="procurement.comment">
                <div class="divider"></div>
                <div class="text-secondary font-bold ">
                    Catatan Penolakan RAB: {{ procurement.comment }}
                </div>
            </div>
        </template>
        <template #amount>
            <Container class="mb-5">
                <Label value="Nilai RAB" />
                <p class="font-bold text-lg tracking-wider">{{ convertToRupiah(procurement.budget_plan.total) }}</p>
            </Container>
        </template>
        <template #file="{loading}" >
            <Link @click="loading()" v-if="procurement.status == 1"      :href="route('unit.procurement.edit', procurement.id)"     class="btn bg-first border-first" >Unggah Gambar</Link>
            <Link @click="loading()" v-else-if="procurement.status == 3" :href="route('unit.procurement.reupload', procurement.id)" class="btn text-first ml-5 bg-slate-200 border-none hover:text-white hover:bg-first font-bold" >Ajukan Ulang</Link>
            <!-- <button @click="newRequest()" class="btn text-first bg-slate-200 border-none hover:text-white hover:bg-first font-bold">Ajukan Ulang</button> -->
        </template>
    </Show>
</template>

<script setup>
import Show from "@/Layouts/Procurement/Show.vue";
import Container from "@/Components/utils/Container.vue";
import Header1 from "@/Components/utils/Header1.vue";
import Label from "@/Components/utils/Label.vue";
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

function convertToRupiah (angka) {
    var rupiah = "";
    var angkarev = angka.toString().split("").reverse().join("");
    for (var i = 0; i < angkarev.length; i++)
        if (i % 3 == 0) rupiah += angkarev.substr(i, 3) + ".";
    return (
        "Rp. " +
        rupiah
            .split("", rupiah.length - 1)
            .reverse()
            .join("")
    );
}

</script>
