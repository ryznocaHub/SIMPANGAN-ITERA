<template>
    <Master>
        <Container >
            <Header1 title="Daftar Pengadaan" widthSize="100" />
            
            <EasyDataTable :headers="headers" :items="procurements" buttons-pagination>
                <template #item-status="{ status }">
                    <StatusButton :status=status />
                </template>
                <template #item-aksi="{ id }">
                    <Link :href="route('ppk.procurement.show', id)" class="btn btn-xs btn-outline text-first font-bold" >Lihat</Link>
                </template>
                <template #item-hps_executor="{ hps_executor, hpsexecutor, id }">
                    <div v-if="hps_executor != null">{{hpsexecutor.name}}</div>
                    <div v-else>
                        <!-- The button to open modal -->
                        <label :for=id class="btn btn-xs border-first modal-button bg-first">Pilih Tim HPS</label>

                        <!-- Put this part before </body> tag -->
                        <input type="checkbox" :id=id class="modal-toggle" />
                        <label :for=id class="modal cursor-pointer">
                        <label class="modal-box relative" for="">
                            <label :for=id class="btn btn-xs border-first bg-first btn-circle absolute right-2 top-2">✕</label>
                            <Header1 title="Tunjuk Tim HPS" class="my-12" widhSize=50 />
                            <!-- <p class="py-4 ">Pilih Tim HPS</p> -->
                            <!-- <Input
                                id="category"
                                type="search"
                                class="mt-12 mb-5 block w-full"
                                v-model="data.hps"
                                placeholder="Pilih Tim HPS"
                                list="hpsTeams"
                                required
                            />
                            <datalist id="hpsTeams">
                                <option v-for="hps in hpsteams" :key=hps.id :value=hps.id  :label=hps.name />
                            </datalist> -->

                            <input id="category"
                                type="search"
                                class="mt-12 mb-5 block w-full"
                                v-model="data.hps"
                                placeholder="Pilih Tim HPS"
                                list="hpsTeams"
                                required>
                            <datalist id="hpsTeams">
                                <option v-for="hps in hpsteams" :key=hps.id>{{hps.name}}</option>
                            </datalist>
                            <button @click="verifikasi(id)" class="btn border-first bg-first mt-5" >Pilih</button>
                        </label>
                        </label>
                    </div>
                    <!-- <Link :href="route('hps.procurement.show', id)" class="btn btn-first btn-xs" >Lihat</Link> -->
                </template>
                <template #item-persetujuan="{ status, id }">
                    <div v-if="status == 7">Ditolak</div>
                    <div v-else-if="status > 7">Disetujui</div>
                    <div v-else-if="status < 6">Belum Disetujui</div>
                    <div v-else>    
                        <label :for="id + 'tolak'" class="btn text-first btn-xs bg-slate-200 border-none hover:text-white hover:bg-first font-bold">Tolak</label>

                        <!-- Put this part before </body> tag -->
                        <input type="checkbox" :id="id + 'tolak'" class="modal-toggle" />
                        <label :for="id + 'tolak'" class="modal cursor-pointer">
                            <label class="modal-box relative" for="">
                                <label :for="id + 'tolak'" class="btn btn-xs border-first bg-first btn-circle absolute right-2 top-2">✕</label>
                                <Header1 title="Alasan Penolakan HPS" class="my-12" widhSize=50 />
                                <input 
                                    type="text"
                                    class="mt-12 mb-5 block w-full"
                                    v-model="reject.comment"
                                    placeholder="Komentar"
                                    required
                                >
                                <div class="flex justify-center my-5">
                                    <button @click="rejectHPS(id)" class="btn border-first bg-first" >Tolak HPS</button>
                                </div>
                            </label>
                        </label>

                        <!-- The button to open modal -->
                        <label :for=id class="btn btn-xs border-first modal-button bg-first ml-3">Setuju</label>

                        <!-- Put this part before </body> tag -->
                        <input type="checkbox" :id=id class="modal-toggle" />
                        <label :for=id class="modal cursor-pointer">
                        <label class="modal-box relative" for="">
                            <label :for=id class="btn btn-xs border-first bg-first btn-circle absolute right-2 top-2">✕</label>
                            <!-- <Header1 title="Setujui HPS" class="my-12" :widhSize=50 /> -->
                            <div class="text-center text-first font-bold text-2xl">Apakah anda yakin ingin menyetujui HPS?</div>
                            <div class="flex justify-center my-5">
                                <button @click="approval(id)" class="btn border-first bg-first mt-5 tracking-wide" >Setuju</button>
                            </div>
                        </label>
                        </label>

                    </div>
                    <!-- <Link :href="route('hps.procurement.show', id)" class="btn btn-first btn-xs" >Lihat</Link> -->
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
import StatusButton from "@/Components/statusButton/index.vue"
import Header1 from "@/Components/utils/Header1.vue";

 const props = defineProps({
	procurements: { type: Object, required: true },
    hpsteams : {type: Object , required: true}
})

const data = useForm({
    _method: 'patch',
    hps: "",
    status: 5
});

const x = useForm({
    _method: 'patch',
    status: 8
});

const reject = useForm({
    _method: 'patch',
    comment: "",
    status: 7
});

const verifikasi = (id) =>{
    data.post(route("ppk.procurement.update", id),{
        onSuccess:  (e) => {
            console.log("sukses memilih Tim HPS",e)
        },
        onError:    (e) => {console.log(e)}
    })
}

const approval = (id) =>{
    x.post(route("ppk.procurement.update", id),{
        onSuccess:  (e) => {
            console.log("sukses Menyetujui HPS",e)
        },
        onError:    (e) => {console.log(e)}
    })
}

const rejectHPS = (id) =>{
    reject.post(route("ppk.procurement.update", id),{
        onSuccess:  () => {
            console.log("sukses menolak HPS")
        },
        onError:    (e) => {console.log(e)}
    })
}

const cek = () => {
    console.log(props.procurements)
}

const headers = [
    { text: "Nama",             value: "name", sortable: true },
    { text: "Kategori",         value: "category", sortable: true },
    { text: "Tahun Anggaran",   value: "year", sortable: true },
    { text: "Unit",             value: "unit", sortable: true },
    { text: "Status",           value: "status", sortable: true },
    { text: "Tim HPS",          value: "hps_executor", sortable: true },
    { text: "Persetujuan HPS",      value: "persetujuan", sortable: true },
    { text: "aksi",             value: "aksi", sortable: true },
];
</script>
