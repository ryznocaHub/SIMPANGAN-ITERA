<template>
    <Master>
        <Container >
            <Header1 title="Daftar Supplier" widthSize="100" />
            <button class="btn-sm mb-10 rounded-lg text-first bg-slate-200 border-none hover:text-white hover:bg-first font-bold">Tambah Data Supplier</button>
            <EasyDataTable :headers="headers" :items="suppliers" buttons-pagination>
                <template #item-status="{ status }">
                    <StatusButton :status=status />
                </template>
                <template #item-complete="{ entity }">
                    <div v-if="entity">Lengkap</div>
                    <div v-else class="text-secondary">Belum Lengkap</div>
                </template>
                <template #item-aksi="{ entity,id }">
                    <Link v-if="entity" :href="route('kontrak.supplier.show', id)" class="btn btn-xs btn-outline text-first font-bold" >Lihat</Link>
                    <Link v-else :href="route('kontrak.supplier.edit', id)" class="btn btn-xs text-white bg-first border-none font-bold" >Lengkapi Data</Link>
                </template>
            </EasyDataTable>
        </Container>
    </Master>
</template>

<script setup>
import Master from "@/Layouts/Master.vue";
import { Link } from '@inertiajs/inertia-vue3'
import Container from "@/Components/utils/Container.vue";
import Header1 from "@/Components/utils/Header1.vue";

 defineProps({
	suppliers: { type: Object, required: true },
})

const headers = [
    { text: "Nama",             value: "name", sortable: true },
    { text: "NPWP",             value: "npwp", sortable: true },
    { text: "Kab/Kota",         value: "regency", sortable: true },
    { text: "Provinsi",         value: "province", sortable: true },
    { text: "Kelengkapan Data", value: "complete", sortable: true },
    { text: "aksi",             value: "aksi", sortable: true },
];
</script>
