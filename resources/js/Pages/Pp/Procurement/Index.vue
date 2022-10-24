<template>
    <Master>
        <Container >
            <Header1 title="Daftar Pengadaan" widthSize="100" />
            <EasyDataTable :headers="headers" :items="procurements" buttons-pagination>
                <template #item-status="{ status }">
                    <StatusButton :status=status />
                </template>
                <template #item-aksi="{ id }">
                    <Link :href="route('pp.procurement.show', id)" class="btn btn-xs btn-outline text-first font-bold" >Lihat</Link>
                </template>
                <template #item-supplier="{ suppliers, supplier_id, id }">
                    <div v-if="supplier_id != null">{{suppliers.name}}</div>
                    <div v-else>
                        <!-- The button to open modal -->
                        <label :for=id class="btn btn-xs border-first modal-button bg-first">Tunjuk Supplier</label>

                        <!-- Put this part before </body> tag -->
                        <input type="checkbox" :id=id class="modal-toggle" />
                        <label :for=id class="modal cursor-pointer">
                        <label class="modal-box relative" for="">
                            <label :for=id class="btn btn-xs border-first bg-first btn-circle absolute right-2 top-2">✕</label>
                            <Header1 title="Data Supplier" class="my-12" widhSize=50 />
                            <Label value="Nominal Penawaran" class="mt-10" />
                            <input id="offer"
                            type="number"
                            class=" block w-full"
                            v-model="data.offer"
                            >
                            <Label value="Supplier" class="mt-5"/>
                            <input id="suppliers"
                                type="search"
                                class="block w-full mb-5"
                                v-model="data.supplier"
                                placeholder="Pilih Supplier"
                                list="listsuppliers"
                            >
                            <datalist id="listsuppliers">
                                <option v-for="supplier in props.suppliers" :key=supplier.id>{{supplier.name}}</option>
                            </datalist>
                            <button @click="verifikasi(id)" class="btn border-first bg-first mt-5" >Pilih</button>
                        </label>
                        </label>
                    </div>
                </template>
            </EasyDataTable>
            <!-- <button @click="cek()">cek</button> -->
        </Container>
    </Master>
</template>

<script setup>
import Master from "@/Layouts/Master.vue";
import { useForm } from "@inertiajs/inertia-vue3";
import { Link } from '@inertiajs/inertia-vue3'
import Container from "@/Components/utils/Container.vue";
import Header1 from "@/Components/utils/Header1.vue";
import StatusButton from "@/Components/statusButton/index.vue"
import Label from '@/Components/utils/Label.vue';

 const props = defineProps({
	procurements: { type: Object, required: true },
	suppliers: { type: Object, required: true },
})

const cek = () =>{
    console.log(props.suppliers[0].name)
}
const headers = [
    { text: "Nama",             value: "name", sortable: true },
    { text: "Tahun Anggaran",   value: "year", sortable: true },
    { text: "Kategori",         value: "category", sortable: true },
    { text: "Status",           value: "status", sortable: true },
    { text: "Supplier",         value: "supplier", sortable: true },
    { text: "Total",            value: "estimate.total", sortable: true },
    { text: "aksi",             value: "aksi", sortable: true },
];

const data = useForm({
    _method     : 'patch',
    supplier    : "",
    offer       : 0,
    status      : 9
});

const verifikasi = (id) =>{
    data.post(route("pp.procurement.update", id),{
        onSuccess:  () => {
            console.log("sukses memilih Supplier")
            data.reset()
        },
        onError:    (e) => {console.log(e)}
    })
}
</script>
