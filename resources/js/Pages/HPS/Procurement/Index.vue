<template>
    <Master>
        <Container >
            <Header1 title="Daftar Pengadaan" widthSize="100" />
            <EasyDataTable :headers="headers" :items="procurements" buttons-pagination>
                <template #item-status="{ status }">
                    <StatusButton :status=status />
                </template>
                <template #item-aksi="{ id }">
                    <Link :href="route('hps.procurement.show', id)" class="btn btn-xs text-white bg-first border-none font-bold" >Lihat</Link>
                </template>
            </EasyDataTable>
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

 defineProps({
	procurements: { type: Object, required: true },
})

const headers = [
    { text: "Nama",             value: "name", sortable: true },
    { text: "Kode RUP",         value: "rup_code", sortable: true },
    { text: "Nomor Akun",         value: "account", sortable: true },
    { text: "Unit",             value: "unit", sortable: true },
    { text: "Tahun Anggaran",   value: "year", sortable: true },
    { text: "Kategori",         value: "category", sortable: true },
    { text: "Status",           value: "status", sortable: true },
    { text: "aksi",             value: "aksi", sortable: true },
];
</script>
