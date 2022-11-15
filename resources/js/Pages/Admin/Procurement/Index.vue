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
                    <template #item-start="{ contract }">
                        <div v-if="contract.date_start_spk">{{moment(contract.date_start_spk).format('DD-MM-yy')}}</div>
                        <div v-else class="text-center">---</div>
                    </template>
                    <template #item-days="{ contract }">
                        <div class="text-center" v-if="contract.days">{{contract.days}} hari</div>
                        <div class="text-center" v-else>---</div>
                    </template>
                    <template #item-end="{ contract }">
                        <div v-if="contract.date_end_spk">{{moment(contract.date_end_spk).format('DD-MM-yy')}}</div>
                        <div v-else class="text-center">---</div>
                    </template>
                    <template #item-remaining="{ contract }">
                        <div v-if="contract.days > 0" class="text-center">{{contract.days}} hari</div>
                        <div v-else class="text-center">Selesai</div>
                    </template>
                    <template #item-supplier="{ suppliers }">
                        <div>{{suppliers.name}}</div>
                    </template>
                    <template #item-offer="{ contract }">
                        <div>{{ convertToRupiah(contract.offer)}}</div>
                    </template>
                    <template #item-aksi="{ id }">
                        <Link @click="loading()" :href="route('admin.procurement.show', id)" class="btn btn-xs text-white bg-first border-none font-bold" >Lihat</Link>
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
import moment from 'moment';

 defineProps({
	procurements: { type: Object, required: true },
	suppliers: { type: Object, required: true },
})

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

const headers = [
    { text: "Judul Paket",      value: "name"       , sortable: true },
    { text: "Status",           value: "status"     , sortable: true , width:150},
    { text: "Mulai Kontrak",    value: "start"      , sortable: true },
    { text: "Masa Kontrak",     value: "days"       , sortable: true },
    { text: "Selesai Kontrak",  value: "end"        , sortable: true },
    { text: "Sisa Masa",        value: "remaining"  , sortable: true },
    { text: "Supplier",         value: "supplier"   , sortable: true },
    { text: "Nilai Penawaran",  value: "offer"      , sortable: true },
    { text: "aksi",             value: "aksi"},
];
</script>
