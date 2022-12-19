<template>
    <Master>
        <template v-slot="{ loading }" }>
            <Container v-if="procurements.length > 0">
                <Header1 title="Daftar Pengadaan" widthSize="100" />
                
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
                    <template #item-aksi="{ id }">
                        <Link @click="loading()" :href="route('ppk.procurement.show', id)" class="btn btn-xs btn-outline text-first font-bold" >Lihat</Link>
                    </template>
                    <template #item-hps_executor="{ executor, id }">
                        <div v-if="executor.hps != null">{{executor.hps.name}}</div>
                        <div v-else>
                            <!-- The button to open modal -->
                            <label :for=id class="btn btn-xs border-first modal-button bg-first">Pilih Tim HPS</label>
    
                            <!-- Put this part before </body> tag -->
                            <input type="checkbox" :id=id class="modal-toggle" />
                            <label :for=id class="modal cursor-pointer">
                            <label class="modal-box relative" for="">
                                <label :for=id class="btn btn-xs border-first bg-first btn-circle absolute right-2 top-2">✕</label>
                                <Header1 title="Tunjuk Tim HPS" class="mt-3 mb-6" widhSize=50 />
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
    
                                <Input id="category"
                                    type="search"
                                    class="block w-full"
                                    v-model="data.hps"
                                    list="hpsTeams"
                                    :status="data.errors.hps"    
                                />
                                <div v-if="data.errors.hps" class="text-sm text-error mt-1 mb-5">{{ data.errors.hps }}</div>
    
                                <datalist id="hpsTeams">
                                    <option v-for="hps in hpsteams" :key=hps.id>{{hps.name}}</option>
                                </datalist>
                                <div class="flex justify-center my-5">
                                    <button @click="verifikasi(id, loading)" class="btn border-first bg-first mt-5" >Pilih</button>
                                </div>
                            </label>
                            </label>
                        </div>
                        <!-- <Link :href="route('hps.procurement.show', id)" class="btn btn-first btn-xs" >Lihat</Link> -->
                    </template>
                    <template #item-persetujuan="{ status, id, name }">
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
                                    <Header1 title="Alasan Penolakan HPS" class="mt-3 mb-6" widhSize=50 />
                                    <Input 
                                        type="text"
                                        class="block w-full"
                                        v-model="reject.comment"
                                        :status="reject.errors.comment"
                                    />
                                    <div class="text-sm text-error mt-1 mb-5">{{ reject.errors.comment }}</div>
                                    <div class="flex justify-center my-5">
                                        <button @click="rejectHPS(id,name)" class="btn border-first bg-first" >Tolak HPS</button>
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
                                <div class="text-center text-first font-bold text-2xl">Tunjuk Pejabat Pengadaan (PP) untuk menyetujui HPS</div>
                                <Input id="category"
                                    type="search"
                                    class="block w-full mt-5"
                                    v-model="x.pp"
                                    list="ppList"
                                    :status="x.errors.pp"    
                                />
                                <div v-if="x.errors.pp" class="text-sm text-error mt-1 mb-5">{{ x.errors.pp }}</div>
    
                                <datalist id="ppList">
                                    <option v-for="pp in ppList" :key=pp.id>{{pp.name}}</option>
                                </datalist>
                                <div class="flex justify-center my-5">
                                    <button @click="approval(id, name, loading)" class="btn border-first bg-first mt-5 tracking-wide" >Pilih</button>
                                </div>
                            </label>
                            </label>
    
                        </div>
                        <!-- <Link :href="route('hps.procurement.show', id)" class="btn btn-first btn-xs" >Lihat</Link> -->
                    </template>
                    <template #item-rab="{ budget_plan }">
                        {{convertToRupiah(budget_plan.total)}}
                    </template>
                    <template #item-hps="{ estimate }">
                        {{convertToRupiah(estimate.total)}}
                    </template>
                </EasyDataTable>
            </Container>
            <EmptyPage v-else text="pengadaan"/>
        </template>
    </Master>
</template>

<script setup>
import Master from "@/Layouts/Master.vue";
import { useForm } from "@inertiajs/inertia-vue3";
import { Link } from '@inertiajs/inertia-vue3'
import Container from "@/Components/utils/Container.vue";
import StatusButton from "@/Components/statusButton/index.vue"
import Header1 from "@/Components/utils/Header1.vue";
import Notification from "@/Components/composables/Notification"
import Input from "@/Components/utils/Input.vue";
import EmptyPage from "@/Components/StatusPage/Empty.vue";

const props = defineProps({
	procurements: { type: Object, required: true },
    hpsteams : {type: Object , required: true},
    ppList : {type: Object , required: true}
})
const toast = Notification() 

const data = useForm({
    _method: 'patch',
    hps: "",
    status: 5
});

const x = useForm({
    pp: '',
    _method: 'patch',
    status: 8
});

const reject = useForm({
    _method: 'patch',
    comment: "",
    status: 7
});

const verifikasi = (id, loading) =>{
    data.post(route("ppk.procurement.update", id),{
        onSuccess   :  (e)  => {
            toast('success', 'Berhasil memilih '+ data.hps)
            data.reset()
        },
        onError     :  (e)  => toast('error', 'Gagal memilih '+ data.hps),
        onFinish    :  ()   => loading(),
        onStart     : () => {
            data.clearErrors()
            loading()
        }
    })
}

const approval = (id, name, loading) =>{
    x.post(route("ppk.procurement.update", id),{
        onSuccess   :   (e) => toast('success', 'Berhasil menyetujui HPS '+ name),
        onError     :   (e) => {toast('error', 'Gagal menyetujui HPS '+ name); console.log(e)},
        onStart     :   ()  => loading(),
        onFinish    :   ()  => loading(),
    })
}

const rejectHPS = (id,name) =>{
    reject.post(route("ppk.procurement.update", id),{
        onSuccess:  () => {
            toast('warning', 'Berhasil menolak HPS '+ name)
            reject.reset()
        },
        onError:    (e) => toast('error', 'Gagal menolak HPS '+ name),
    })
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
const headers = [
    { text: "Judul Paket",      value: "name"       , sortable: true },
    { text: "Kode Akun",        value: "account"    , sortable: true },
    { text: "Unit Kerja",       value: "unit"       , sortable: true },
    { text: "Status",           value: "status"     , sortable: true },
    { text: "Nilai RAB",        value: "rab"        , sortable: true },
    { text: "Nilai HPS",        value: "hps"        , sortable: true},
    { text: "PIC HPS",          value: "hps_executor"},
    { text: "Status HPS",       value: "persetujuan" },
    { text: "aksi",             value: "aksi"        },
];
</script>
