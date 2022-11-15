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
                buttons-pagination>
                    <template #item-status="{ status }">
                        <StatusButton :status=status />
                    </template>
                    <template #item-supplier="{ suppliers }">
                        <div>{{suppliers.name}}</div>
                    </template>
                    <template #item-aksi="{ id }">
                        <Link @click="loading()" :href="route('kontrak.procurement.show', id)" class="btn btn-xs text-white bg-first border-none font-bold" >Lihat</Link>
                    </template>
                </EasyDataTable>
            </Container>
        </template>
    </Master>
</template>

<script setup>
import Master from "@/Layouts/Master.vue";
import { Link } from '@inertiajs/inertia-vue3'
import Container from "@/Components/utils/Container.vue";
import Header1 from "@/Components/utils/Header1.vue";
import StatusButton from "@/Components/statusButton/index.vue"

 defineProps({
	procurements: { type: Object, required: true },
	suppliers: { type: Object, required: true },
})

const headers = [
    { text: "Nama",             value: "name", sortable: true },
    { text: "Kategori",         value: "category", sortable: true },
    { text: "Status",           value: "status", sortable: true },
    { text: "Supplier",         value: "supplier", sortable: true },
    { text: "Total",            value: "estimate.total", sortable: true },
    { text: "aksi",             value: "aksi", sortable: true },
];
</script>
