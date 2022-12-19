<template>
    <Master>
        <template v-slot="{ loading }" }>
            <Header1 v-if="suppliers.length != 0" title="Daftar Supplier" widthSize="100" />
            <Container v-if="suppliers.length != 0" >
                <Link @click="loading()" v-if="user.role == 4 || user.role == 3" :href="route('supplier.create')" class="btn btn-sm mt-5 mb-5 text-first bg-slate-200 border-none hover:text-white hover:bg-first  font-bold" >Tambah Data Supplier</Link>
                <EasyDataTable 
                :headers="headers" 
                :items="suppliers" 
                table-class-name="customize-table"
                sortBy="status"
                sortType="asc" 
                :rows-per-page="5"
                :maxPaginationNumber="10"
                buttons-pagination>
                    <template #item-province="{ province }">
                        <div v-if="province">{{province}}</div>
                        <div v-else class="text-secondary">---</div>
                    </template>
                    <template #item-regency="{ regency }">
                        <div v-if="regency">{{regency}}</div>
                        <div v-else class="text-secondary">---</div>
                    </template>
                    <template #item-npwp="{ npwp }">
                        <div v-if="npwp">{{npwp}}</div>
                        <div v-else class="text-secondary">---</div>
                    </template>
                    <!-- <template #item-status="{ status }">
                        <StatusButton :status=status />
                    </template> -->
                    <template #item-complete="{ entity }">
                        <div v-if="entity">Lengkap</div>
                        <div v-else class="text-secondary">Belum Lengkap</div>
                    </template>
                    <template #item-aksi="{ entity,id }">
                        <!-- <Link @click="loading()" v-if="entity && user.role==1"  :href="route('admin.supplier.show', id)"    class="btn btn-xs btn-outline text-first font-bold" >Lihat</Link> -->
                        <!-- <Link @click="loading()" v-else-if="entity"             :href="route('kontrak.supplier.show', id)"  class="btn btn-xs btn-outline text-first font-bold" >Lihat</Link> -->
                        <Link @click="loading()" v-if="entity"  :href="route('supplier.show', id)"  class="btn btn-xs btn-outline text-first font-bold" >Lihat</Link>
                        <Link @click="loading()" v-else         :href="route('supplier.edit', id)"  class="btn btn-xs text-white bg-first border-none font-bold" >Lengkapi Data</Link>
                    </template>
                </EasyDataTable>
            </Container>
            <div v-else>
                <EmptyPage text="supplier"/>
                <!-- <Vue3Lottie :animationData="Empty" :height="450" :width="700" /> -->
                <!-- <div class="text-x drop-shadow text-2xl font-bold text-first text-center">Maaf, Belum ada data supplier yang tersedia</div> -->
            </div>
        </template>
    </Master>
</template>

<script setup>
import Master from "@/Layouts/Master.vue";
import { Link } from '@inertiajs/inertia-vue3'
import Container from "@/Components/utils/Container.vue";
import Header1 from "@/Components/utils/Header1.vue";
import EmptyPage from "@/Components/StatusPage/Empty.vue";
import { computed } from 'vue'
import { usePage } from '@inertiajs/inertia-vue3'

const user = computed(() => usePage().props.value.auth.user)
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
