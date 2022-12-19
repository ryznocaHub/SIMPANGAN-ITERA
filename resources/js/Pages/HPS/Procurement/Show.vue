<template>
    <Show :procurement=procurement >
        <template #file="{loading}">
            <!-- <a v-show="procurement.timeline.hps_approved" :href="route('hps.document.boq',procurement.id)" class="btn text-first mb-3 w-full btn-outline font-bold hover:bg-first hover:text-white hover:border-none" target="_blank">Lihat BOQ</a> -->
            <!-- <a     @click="loading()" v-show="procurement.timeline.hps_submitted && procurement.status != 7"    :href="route('hps.document.hps',procurement.id)"        class="btn text-first w-full btn-outline font-bold hover:bg-first hover:text-white hover:border-none" target="_blank">Lihat HPS</a> -->
            <Link  @click="loading()"   v-if        ="procurement.status == 5"   :href="route('hps.procurement.edit', procurement.id)"   class="ml-5 btn bg-first border-first" >Buat HPS</Link>
            <Link  @click="loading()"   v-else-if   ="procurement.status == 7"   :href="route('hps.procurement.edit', procurement.id)"   class="ml-5 btn text-first bg-slate-200 border-none hover:text-white hover:bg-first font-bold" >Ajukan Ulang</Link>
            <a                          v-else-if   ="procurement.status >= 6 && !procurement.estimate.file"   :href="route('hps.document.hps',procurement.id)"        class="ml-5 btn text-first bg-slate-200 border-none hover:text-white hover:bg-first font-bold" target="_blank">Lihat HPS</a>
            
            <label  v-if ="procurement.status >= 8 && !procurement.estimate.file" for="filebaep" class="ml-5 btn text-first bg-slate-200 border-none hover:text-white hover:bg-first font-bold" >Unggah HPS</label>
            <a  v-else  :href="procurement.estimate.file" class="ml-3 btn text-first btn-outline font-bold hover:bg-first hover:text-white hover:border-none">Download HPS</a>
            <!-- Put this part before </body> tag -->
            <input type="checkbox" id="filebaep" class="modal-toggle" v-model="hps.modal" />
            <label for="filebaep" class="modal cursor-pointer">
            <label class="modal-box relative" for="">
                <label for="filebaep" class="btn btn-xs border-first bg-first btn-circle absolute right-2 top-2">✕</label>
                <!-- <Header1 title="Setujui HPS" class="my-12" :widhSize=50 /> -->
                <Header1 title="Unggah File HPS" widthSize="100" />
                
                <label class="block mb-3 mt-10">
                    <span class="sr-only">Pilih File</span>
                    <input type="file" class=" block w-full text-sm text-first
                    file:mr-4 file:py-2 file:px-4
                    file:rounded-full file:border-0
                    file:text-sm file:font-semibold
                    file:bg-slate-200 file:text-first
                    hover:file:bg-slate-300"
                    accept=".pdf"
                    @input="(e) => onInputChangeFile(e)"
                />
                </label>
                <div class="text-sm text-error mt-1 mb-5">{{ hps.errors.file }}</div>
                <div class="flex justify-center my-5">
                    <button @click="uploadFile(procurement.id, loading)" class="btn border-first bg-first mt-5 tracking-wide" >Unggah</button>
                </div>
            </label>
            </label>
        </template>
        <template #amount>
            <Container class="mb-5">
                <Label value="Nilai RAB" />
                <p class="font-bold text-lg tracking-wider">{{ convertToRupiah(procurement.budget_plan.total) }}</p>
            </Container>
            <Container class="mb-5">
                <Label value="Nilai HPS" />
                <p class="font-bold text-lg tracking-wider">{{ convertToRupiah(procurement.estimate.total) }}</p>
            </Container>
        </template>
        <template #comment>
            <div v-if="procurement.comment">
                <div class="divider"></div>
                <div class="text-secondary font-bold ">
                    Catatan Penolakan HPS: {{ procurement.comment }}
                </div>
            </div>
        </template>
    </Show>
</template>

<script setup>
import Show from "@/Layouts/Procurement/Show.vue";
import { useForm, Link } from "@inertiajs/inertia-vue3";
import Header1 from "@/Components/utils/Header1.vue";
import Label from '@/Components/utils/Label.vue';
import Container from "@/Components/utils/Container.vue";
import Notification from "@/Components/composables/Notification"

const toast = Notification()
defineProps({
	procurement: { type: Object, required: true },
})

const hps = useForm({
    file   : null,
    modal  : 0,
    _method: 'patch',
})

const uploadFile = (id, loading) =>{
    hps.post(route("hps.fisik.hps", id),{
        onSuccess:  (e) => {
            toast('success', 'Berhasil unggah file HPS'),
            hps.reset()
        },
        onError:    (e) => {toast('error', 'Gagal unggah file HPS')},
        onStart     :   ()  => loading(),
        onFinish    :   ()  => loading(),
    })
}

function onInputChangeFile(e) {
    hps.file = e.target.files
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
</script>