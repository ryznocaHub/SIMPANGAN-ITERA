<template>
    <Master>
        <template v-slot="{ loading }" }>
            <Header1 title="Daftar Pengadaan" widthSize="100" />
            <Container >
                <EasyDataTable 
                :headers="headers" 
                :items="procurements"
                table-class-name="customize-table"
                sortBy="status"
                sortType="asc" 
                :rows-per-page="5"
                :maxPaginationNumber="10"
                buttons-pagination
                >
                    <template #item-status="{ status }">
                        <StatusButton :status=status />
                    </template>
                    <template #item-aksi="{ id }">
                        <Link @click="loading()" :href="route('pp.procurement.show', id)" class="btn btn-xs btn-outline text-first font-bold" >Lihat</Link>
                    </template>
                    <template #item-supplier="{ suppliers, supplier_id }">
                        <div v-if="supplier_id != null">{{suppliers.name}}</div>
                        <div v-else>
                            ---
                        </div>
                    </template>
                </EasyDataTable>
                <!-- <button @click="cek()">cek</button> -->
            </Container>
        </template>
    </Master>
</template>

<script setup>
import Master from "@/Layouts/Master.vue";
import { useForm } from "@inertiajs/inertia-vue3";
import { Link } from '@inertiajs/inertia-vue3'
import Container from "@/Components/utils/Container.vue";
import Input from "@/Components/utils/Input.vue";
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
    { text: "Kategori",         value: "category", sortable: true },
    { text: "Status",           value: "status", sortable: true },
    { text: "Supplier",         value: "supplier", sortable: true },
    { text: "Nilai HPS",        value: "estimate.total", sortable: true },
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
