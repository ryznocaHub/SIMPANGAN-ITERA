<template>
    <Master>
        <template v-slot="{ loading }" }>
            <Header1 title="Daftar Pengadaan" widthSize="100" />
            <Container class="max-h-[80vh] pb-10">
                <EasyDataTable 
                    :headers="headers" 
                    :items="procurements"
                    sortBy="status"
                    sortType="asc" 
                    :rows-per-page="5"
                    :maxPaginationNumber="10"
                    table-class-name="customize-table" 
                    buttons-pagination
                >
                    <template #item-date="{timeline}">
                        {{moment(timeline.rab_submitted).format('DD-MM-yy')}}
                    </template>
                    <!-- v-model:server-options="serverOptions" -->
                    <template #item-status="{ status }">
                        <StatusButton :status=status />
                    </template>
                    <template #item-rup_code="{ rup_code }">
                        <div v-if="rup_code">{{rup_code}}</div>
                        <div v-else>---</div>
                    </template>
                    <template #item-approval="{ status,id }">
                        <div v-if="status == 2">
                            <!-- The button to open modal -->
                            <!-- <button @click="rejectRAB(id)" class="btn text-first btn-xs bg-slate-200 border-none hover:text-white hover:bg-first font-bold">tolak</button> -->
                            <label :for="id + 'tolak'" class="btn text-first btn-xs bg-slate-200 border-none hover:text-white hover:bg-first font-bold">Tolak</label>
        
                            <!-- Put this part before </body> tag -->
                            <input type="checkbox" :id="id + 'tolak'" class="modal-toggle" />
                            <label :for="id + 'tolak'" class="modal cursor-pointer">
                                <label class="modal-box relative" for="">
                                    <label :for="id + 'tolak'" class="btn btn-xs border-first bg-first btn-circle absolute right-2 top-2">✕</label>
                                    <Header1 title="Alasan Penolakan RAB" class="mt-3 mb-6" widhSize=50 />
                                    <Input 
                                        type="text"
                                        class=" block w-full"
                                        v-model="reject.comment"
                                        :status="reject.errors.comment"    
                                    />
                                    <div v-if="reject.errors.comment" class="text-sm text-error mt-1 mb-5">{{ reject.errors.comment }}</div>

                                    <div class="flex justify-center my-5">
                                        <button @click="rejectRAB(id)" class="btn border-first bg-first" >Tolak RAB</button>
                                    </div>
                                </label>
                            </label>
        
                            <label :for=id class="btn btn-xs border-first modal-button bg-first ml-3">Setuju</label>
        
                            <!-- Put this part before </body> tag -->
                            <input type="checkbox" :id=id class="modal-toggle" />
                            <label :for=id class="modal cursor-pointer">
                                <label class="modal-box relative" for="">
                                    <label :for=id class="btn btn-xs border-first bg-first btn-circle absolute right-2 top-2">✕</label>
                                    <Header1 title="Kode RUP" class="mt-3 mb-6" widhSize=50 />
                                    <Input 
                                        type="text"
                                        class=" block w-full"
                                        v-model="approve.rup_code"
                                        :status="approve.errors.rup_code"    
                                    />
                                    <div v-if="approve.errors.rup_code" class="text-sm text-error mt-1 mb-5">{{ approve.errors.rup_code }}</div>

                                    <div class="flex justify-center my-5">
                                        <button @click="approveRAB(id, loading)" class="btn border-first bg-first" >Verifikasi RAB</button>
                                    </div>
                                </label>
                            </label>
        
                        </div>
                        <div v-if="status == 3">RAB Ditolak</div>
                        <div v-if="status > 3">RAB Diterima</div>
                    </template>
                    <template #item-aksi="{ id }">
                        <Link @click="loading()" :href="route('siren.procurement.show', id)" class="btn btn-xs btn-outline text-first font-bold" >Lihat</Link>
                    </template>
                </EasyDataTable>
                <!-- <button @click="cek()">cek</button> -->
            </Container>
        </template>
    </Master>
</template>

<script setup>
import Master       from "@/Layouts/Master.vue";
import { useForm }  from "@inertiajs/inertia-vue3";
import { Link }     from '@inertiajs/inertia-vue3'
import Container    from "@/Components/utils/Container.vue";
import Input        from "@/Components/utils/Input.vue";
import Header1      from "@/Components/utils/Header1.vue";
import StatusButton from "@/Components/statusButton/index.vue"
import moment from 'moment';
import Notification from "@/Components/composables/Notification"

const props = defineProps({
	procurements: { type: Object, required: true },
})
const toast = Notification() 

const headers = [
    { text: "Tanggal Masuk",    value: "date"       , sortable: true },
    { text: "No Akun",          value: "account"    , sortable: true },
    { text: "Judul Paket",      value: "name"       , sortable: true },
    { text: "Kategori",         value: "category"   , sortable: true },
    { text: "Status",           value: "status"     , sortable: true },
    { text: "Kode RUP",         value: "rup_code"   , sortable: true },
    { text: "Nilai RAB",        value: "budget_plan.total", sortable: true },
    { text: "Persetujuan RAB",  value: "approval"},
    { text: "aksi",             value: "aksi"},
];

const reject = useForm({
    _method: 'patch',
    comment: "",
    status: 3
});

const approve = useForm({
    _method: 'patch',
    rup_code: "",
    status: 4
});

const approveRAB = (id, loading) =>{
    console.log("func", loading)
    approve.post(route("siren.procurement.update", id),{
        onSuccess   :   ()  => {
            toast('success', 'Berhasil menyetujui RAB - ' + approve.rup_code)
            approve.reset()
        },
        onError     :   (e) => {
            console.log(e)
            toast('error', 'Gagal menyetujui RAB')
        },
        onStart     :   (e) => {
            approve.clearErrors()
            loading()
        },
        onFinish    :   ()  => loading()
    })
}

const rejectRAB = (id)  =>  {
    reject.post(route("siren.procurement.update", id),{
        onSuccess   :   ()  => toast('success', 'Berhasil menolak RAB'),
        onError     :   (e) => toast('error', 'Gagal menolak RAB '),
        onStart     :   (e) => {
            reject.clearErrors()

        },
    })
}
</script>
