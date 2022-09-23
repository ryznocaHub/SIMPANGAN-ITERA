<template>
    <Master>
        <Container >
            <Header1 title="Daftar Pengadaan" widthSize="100" />
            <EasyDataTable :headers="headers" :items="procurements" buttons-pagination>
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
                                <Header1 title="Alasan Penolakan RAB" class="my-12" widhSize=50 />
                                <input 
                                    type="text"
                                    class="mt-12 mb-5 block w-full"
                                    v-model="reject.comment"
                                    placeholder="Komentar"
                                    required
                                >
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
                                <Header1 title="Kode RUP" class="my-12" widhSize=50 />
                                <input 
                                    type="text"
                                    class="mt-12 mb-5 block w-full"
                                    v-model="approve.rup_code"
                                    placeholder="Kode RUP"
                                    required
                                >
                                <div class="flex justify-center my-5">
                                    <button @click="approveRAB(id)" class="btn border-first bg-first" >Verifikasi RAB</button>
                                </div>
                            </label>
                        </label>

                    </div>
                    <div v-if="status == 3">RAB Ditolak</div>
                    <div v-if="status > 3">RAB Diterima</div>
                </template>
                <template #item-aksi="{ id }">
                    <Link :href="route('siren.procurement.show', id)" class="btn btn-xs btn-outline text-first font-bold" >Lihat</Link>
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

 const props = defineProps({
	procurements: { type: Object, required: true },
})

const cek = () =>{
    console.log(props.suppliers[0].name)
}
const headers = [
    { text: "No Akun",          value: "account", sortable: true },
    { text: "Nama",             value: "name", sortable: true },
    { text: "Tahun Anggaran",   value: "year", sortable: true },
    { text: "Kategori",         value: "category", sortable: true },
    { text: "Status",           value: "status", sortable: true },
    { text: "Kode RUP",         value: "rup_code", sortable: true },
    { text: "Total",            value: "total", sortable: true },
    { text: "Persetujuan RAB",  value: "approval", sortable: true },
    { text: "aksi",             value: "aksi", sortable: true },
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


const approveRAB = (id) =>{
    approve.post(route("siren.procurement.update", id),{
        onSuccess:  () => {
            console.log("sukses menyetujui RAB")
        },
        onError:    (e) => {console.log(e)}
    })
}

const rejectRAB = (id) =>{
    reject.post(route("siren.procurement.update", id),{
        onSuccess:  () => {
            console.log("sukses menolak RAB")
        },
        onError:    (e) => {console.log(e)}
    })
}
</script>
