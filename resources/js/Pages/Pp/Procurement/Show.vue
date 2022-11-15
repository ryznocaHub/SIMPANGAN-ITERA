<template>
    <Show :procurement=procurement >
        <template #file>
            <a v-show="procurement.timeline.hps_approved" :href="route('pp.document.boq',procurement.id)" class="btn text-first w-full btn-outline font-bold hover:bg-first hover:text-white hover:border-none" target="_blank">Lihat BOQ</a>
        </template>
        <template #extra-info="{loading}">
            <div class="flex mt-10">
                <Container>
                    <Header1 title="Format Berkas" widthSize="60" />
                    <div class="grid grid-rows-4 grid-flow-col gap-x-3">
                         <!-- offer -->
                        <div v-if="!procurement.contract.no_offer">
                            <!-- The button to open modal -->
                            <label   for="offer" class="btn w-full mt-3 border-first modal-button bg-first">Unggah Penawaran</label>
        
                                <!-- Put this part before </body> tag -->
                                <input type="checkbox" id="offer" class="modal-toggle" v-model="offer.modal" />
                                <label for="offer" class="modal cursor-pointer">
                                <label class="modal-box relative" for="">
                                    <label for="offer" class="btn btn-xs border-first bg-first btn-circle absolute right-2 top-2">✕</label>
                                    <!-- <Header1 title="Setujui HPS" class="my-12" :widhSize=50 /> -->
                                    <Header1 title="Penawaran Supplier" widthSize="100" />
                                    <Label value="Nomor" class="mt-10" />
                                    <Input
                                    type="text"
                                    class="mt-1 block w-full"
                                    v-model="offer.no_offer"
                                    :status="offer.errors.no_offer"
                                    />
                                    <div class="text-sm text-error mt-1 mb-5" >{{ offer.errors.no_offer }}</div>
                                    <Label value="Nilai Penawaran" class="mt-5" />
                                    <Input
                                        type="text"
                                        class="mt-1 block w-full"
                                        v-model="offer.offer"
                                        :status="offer.errors.offer"
                                    />
                                    <div class="text-sm text-error mt-1 mb-5">{{ offer.errors.offer }}</div>
                                    <Label value="Supplier" class="mt-5"/>
                                    <Input 
                                        type="search"
                                        class="block w-full"
                                        v-model="offer.supplier"
                                        :status="offer.errors.supplier"
                                        list="listsuppliers"
                                    />
                                    <div class="text-sm text-error mt-1 mb-5">{{ offer.errors.supplier }}</div>
                                    <datalist id="listsuppliers">
                                        <option v-for="supplier in props.suppliers" :key=supplier.id>{{supplier.name}}</option>
                                    </datalist>
                                    <Label value="Tanggal" />
                                    <Datepicker 
                                        v-model="offer.date_offer" 
                                        :enableTimePicker="false"  
                                        format='dd-MM-yyyy'
                                        selectText="Pilih"
                                        cancelText="Batal"
                                    />
                                    <div class="text-sm text-error mt-1 mb-5">{{ offer.errors.date_offer }}</div>
                                    <label class="block">
                                        <span class="sr-only">Pilih File</span>
                                        <input type="file" class="my-5 block w-full text-sm text-first
                                            file:mr-4 file:py-2 file:px-4
                                            file:rounded-full file:border-0
                                            file:text-sm file:font-semibold
                                            file:bg-slate-200 file:text-first
                                            hover:file:bg-slate-300"
                                            accept=".pdf"
                                            @input="(e) => onInputChangeFile(e,4)"
                                        />
                                    </label>
                                    <div class="text-sm text-error mt-1 mb-5">{{ offer.errors.file_offer }}</div>
                                    <div class="flex justify-center my-5">
                                        <button @click="createoffer(procurement.id, procurement.name ,loading)" class="btn border-first bg-first mt-5 tracking-wide" >Unggah</button>
                                    </div>
                                </label>
                            </label>
                        </div>
                        <!-- End offer -->

                         <!-- BAEP -->
                        <div v-if="procurement.contract.no_offer">
                            <a v-if="procurement.contract.no_baep" :href="route('pp.document.baep',procurement.id)" class="mt-3 btn text-first w-full btn-outline font-bold hover:bg-first hover:text-white hover:border-none" target="_blank">BAE</a>
                            <!-- The button to open modal -->
                            <label v-else for="baep" class="btn w-full mt-3 border-first modal-button bg-first">Buat BAE</label>
        
                                <!-- Put this part before </body> tag -->
                                <input type="checkbox" id="baep" class="modal-toggle" v-model="baep.modal" />
                                <label for="baep" class="modal cursor-pointer">
                                <label class="modal-box relative" for="">
                                    <label for="baep" class="btn btn-xs border-first bg-first btn-circle absolute right-2 top-2">✕</label>
                                    <!-- <Header1 title="Setujui HPS" class="my-12" :widhSize=50 /> -->
                                    <Header1 title="Berita Acara Hasil Evaluasi" widthSize="100" />
                                    <Label value="Nomor" class="mt-10" />
                                    <Input
                                    type="text"
                                    class="mt-1 block w-full"
                                    v-model="baep.no_baep"
                                    :status="baep.errors.no_baep"
                                    />
                                    <div class="text-sm text-error mt-1 mb-5">{{ baep.errors.no_baep }}</div>
                                    <Label value="Nilai Koreksi" class="mt-5" />
                                    <Input
                                    type="text"
                                    class="mt-1 block w-full"
                                    v-model="baep.correction"
                                    :status="baep.errors.correction"
                                    />
                                    <div class="text-sm text-error mt-1 mb-5">{{ baep.errors.correction }}</div>
                                    <Label value="Tanggal" />
                                    <Datepicker 
                                        v-model="baep.date_baep" 
                                        :enableTimePicker="false"  
                                        format='dd-MM-yyyy'
                                        selectText="Pilih"
                                        cancelText="Batal"
                                    />
                                    <div class="text-sm text-error mt-1 mb-5">{{ baep.errors.date_baep }}</div>
                                    <div class="flex justify-center my-5">
                                        <button @click="createbaep(procurement.id, procurement.name ,loading)" class="btn border-first bg-first mt-5 tracking-wide" >Buat</button>
                                    </div>
                                </label>
                            </label>
                        </div>
                        <!-- End BAeP -->
                        
                        <!-- BAKN -->
                        <div v-if="procurement.contract.no_baep">
                            <a v-if="procurement.contract.no_bakn" :href="route('pp.document.bakn',procurement.id)" class="mt-3 btn text-first w-full btn-outline font-bold hover:bg-first hover:text-white hover:border-none" target="_blank">BAKN</a>
                            <!-- The button to open modal -->
                            <label v-else for="bakn" class="btn w-full mt-3 border-first modal-button bg-first">Buat BAKN</label>
        
                                <!-- Put this part before </body> tag -->
                                <input type="checkbox" id="bakn" class="modal-toggle" v-model="bakn.modal" />
                                <label for="bakn" class="modal cursor-pointer">
                                <label class="modal-box relative" for="">
                                    <label for="bakn" class="btn btn-xs border-first bg-first btn-circle absolute right-2 top-2">✕</label>
                                    <!-- <Header1 title="Setujui HPS" class="my-12" :widhSize=50 /> -->
                                    <Header1 title="Berita Acara Klarifikasi dan Negosiasi" widthSize="100" />
                                    <Label value="Nomor BAKN" class="mt-10" />
                                    <Input
                                    type="text"
                                    class="mt-1 block w-full"
                                    v-model="bakn.no_bakn"
                                    />
                                    <Label value="Masa Pekerjaan" class="mt-5" />
                                    <Input 
                                        type="text"
                                        class="block w-full"
                                        :status="bakn.errors.days"
                                        v-model="bakn.days"
                                    />
                                    <div class="text-sm text-error mt-1 mb-5">{{ bakn.errors.days }}</div>

                                    <Label value="Tanggal" />
                                    <Datepicker 
                                        v-model="bakn.date_bakn" 
                                        :enableTimePicker="false"  
                                        format='dd-MM-yyyy'
                                        selectText="Pilih"
                                        cancelText="Batal"
                                    />

                                    <div class="flex justify-center my-5">
                                        <button @click="createbakn(procurement.id, procurement.name ,loading)" class="btn border-first bg-first mt-5 tracking-wide" >Buat BAKN</button>
                                    </div>
                                </label>
                            </label>
                        </div>
                        <!-- End BAKN -->
    
                        <!-- BAHP -->
                        <div v-if="procurement.contract.no_bakn">
                            <a v-if="procurement.contract.no_bahp" :href="route('pp.document.bahp',procurement.id)" class="mt-3 btn text-first w-full btn-outline font-bold hover:bg-first hover:text-white hover:border-none" target="_blank">BAHP</a>
                            <!-- The button to open modal -->
                            <label v-else for="BAHP" class="btn w-full mt-3 border-first modal-button bg-first">Buat BAHP</label>
        
                                <!-- Put this part before </body> tag -->
                                <input type="checkbox" id="BAHP" class="modal-toggle" v-model="bahp.modal" />
                                <label for="BAHP" class="modal cursor-pointer">
                                <label class="modal-box relative" for="">
                                    <label for="BAHP" class="btn btn-xs border-first bg-first btn-circle absolute right-2 top-2">✕</label>
                                    <!-- <Header1 title="Setujui HPS" class="my-12" :widhSize=50 /> -->
                                    <Header1 title="Berita Acara Hasil Pengadaan Langsung" widthSize="100" />
                                    <Label value="Nomor" class="mt-10" />
                                    <Input
                                    type="text"
                                    class="mt-1 block w-full"
                                    v-model="bahp.no_bahp"
                                    :status="bakn.errors.no_bahp"
                                    />
                                    <div class="text-sm text-error mt-1 mb-5">{{ bahp.errors.no_bahp }}</div>
                                    
                                    <Label value="Tanggal" />
                                    <Datepicker 
                                        v-model="bahp.date_bahp" 
                                        :enableTimePicker="false"  
                                        format='dd-MM-yyyy'
                                        selectText="Pilih"
                                        cancelText="Batal"
                                        />
                                    <div class="text-sm text-error mt-1 mb-5">{{ bahp.errors.date_bahp }}</div>
                                    <div class="flex justify-center my-5">
                                        <button @click="createbahp(procurement.id, procurement.name ,loading)" class="btn border-first bg-first mt-5 tracking-wide" >Buat BAHP</button>
                                    </div>
                                </label>
                            </label>
                        </div>
                        <!-- End BAHP -->
                    </div>
                </Container>
                <Container class="ml-10" v-if="procurement.contract.no_offer">
                    <Header1 title="Berkas Fisik" widthSize="60" />
                    <div class="grid grid-rows-4 grid-flow-col gap-x-3 ">
                        <!-- terdapat berkas dari penyedia -->
                        <a :href="procurement.contract.file_offer" class="mt-3 btn text-first w-full btn-outline font-bold hover:bg-first hover:text-white hover:border-none" target="_blank">Penawaran</a>

                        <!-- BAEP -->
                        <div v-if="procurement.contract.no_baep">
                            <a v-if="procurement.contract.file_baep" :href="procurement.contract.file_baep" class="mt-3 btn text-first w-full btn-outline font-bold hover:bg-first hover:text-white hover:border-none" target="_blank">BAE</a>
                            <!-- The button to open modal -->
                            <label v-else for="filebaep" class="btn w-full  mt-3 border-first modal-button bg-first">Unggah BAE</label>
        
                                <!-- Put this part before </body> tag -->
                                <input type="checkbox" id="filebaep" class="modal-toggle" v-model="file.modal3" />
                                <label for="filebaep" class="modal cursor-pointer">
                                <label class="modal-box relative" for="">
                                    <label for="filebaep" class="btn btn-xs border-first bg-first btn-circle absolute right-2 top-2">✕</label>
                                    <!-- <Header1 title="Setujui HPS" class="my-12" :widhSize=50 /> -->
                                    <Header1 title="Unggah File BAE" widthSize="100" />
                                    
                                    <label class="block mb-3 mt-10">
                                        <span class="sr-only">Pilih File</span>
                                        <input type="file" class=" block w-full text-sm text-first
                                        file:mr-4 file:py-2 file:px-4
                                        file:rounded-full file:border-0
                                        file:text-sm file:font-semibold
                                        file:bg-slate-200 file:text-first
                                        hover:file:bg-slate-300"
                                        accept=".pdf"
                                        @input="(e) => onInputChangeFile(e,3)"
                                    />
                                    </label>
                                    <div class="flex justify-center my-5">
                                        <button @click="uploadFile(procurement.id, procurement.name, 6, loading)" class="btn border-first bg-first mt-5 tracking-wide" >Unggah</button>
                                    </div>
                                </label>
                            </label>
                        </div>
                        <!-- End BAeP -->

                        <!-- BAKN -->
                        <div v-if="procurement.contract.no_bakn">
                            <a v-if="procurement.contract.file_bakn" :href="procurement.contract.file_bakn" class="mt-3 btn text-first w-full btn-outline font-bold hover:bg-first hover:text-white hover:border-none" target="_blank">BAKN</a>
                            <!-- The button to open modal -->
                            <label v-else for="filebakn" class="btn w-full  mt-3 border-first modal-button bg-first">Unggah BAKN</label>
        
                                <!-- Put this part before </body> tag -->
                                <input type="checkbox" id="filebakn" class="modal-toggle" v-model="file.modal1" />
                                <label for="filebakn" class="modal cursor-pointer">
                                <label class="modal-box relative" for="">
                                    <label for="filebakn" class="btn btn-xs border-first bg-first btn-circle absolute right-2 top-2">✕</label>
                                    <!-- <Header1 title="Setujui HPS" class="my-12" :widhSize=50 /> -->
                                    <Header1 title="Unggah File BAKN" widthSize="100" />
                                    
                                    <label class="block">
                                        <span class="sr-only">Pilih File</span>
                                        <input type="file" class="my-5 block w-full text-sm text-first
                                        file:mr-4 file:py-2 file:px-4
                                        file:rounded-full file:border-0
                                        file:text-sm file:font-semibold
                                        file:bg-slate-200 file:text-first
                                        hover:file:bg-slate-300"
                                        accept=".pdf"
                                        @input="(e) => onInputChangeFile(e,1)"
                                    />
                                    </label>
                                    <div class="flex justify-center my-5">
                                        <button @click="uploadFile(procurement.id, procurement.name, 4, loading)" class="btn border-first bg-first mt-5 tracking-wide" >Unggah</button>
                                    </div>
                                </label>
                            </label>
                        </div>
                        <!-- End BAKN -->
    
                        <!-- BAHP -->
                        <div v-if="procurement.contract.no_bahp">
                            <a v-if="procurement.contract.file_bahp" :href="procurement.contract.file_bahp" class="mt-3 btn text-first w-full btn-outline font-bold hover:bg-first hover:text-white hover:border-none" target="_blank">BAHP</a>
                            <!-- The button to open modal -->
                            <label v-else for="filebahp" class="btn w-full  mt-3 border-first modal-button bg-first">Unggah BAHP</label>
        
                                <!-- Put this part before </body> tag -->
                                <input type="checkbox" id="filebahp" class="modal-toggle" v-model="file.modal2" />
                                <label for="filebahp" class="modal cursor-pointer">
                                <label class="modal-box relative" for="">
                                    <label for="filebahp" class="btn btn-xs border-first bg-first btn-circle absolute right-2 top-2">✕</label>
                                    <!-- <Header1 title="Setujui HPS" class="my-12" :widhSize=50 /> -->
                                    <Header1 title="Unggah File BAHP" widthSize="100" />
                                    
                                    <label class="block">
                                        <span class="sr-only">Pilih File</span>
                                        <input type="file" class="my-5 block w-full text-sm text-first
                                        file:mr-4 file:py-2 file:px-4
                                        file:rounded-full file:border-0
                                        file:text-sm file:font-semibold
                                        file:bg-slate-200 file:text-first
                                        hover:file:bg-slate-300"
                                        accept=".pdf"
                                        @input="(e) => onInputChangeFile(e,2)"
                                    />
                                    </label>
                                    <div class="flex justify-center my-5">
                                        <button @click="uploadFile(procurement.id, procurement.name, 5, loading)" class="btn border-first bg-first mt-5 tracking-wide" >Unggah</button>
                                    </div>
                                </label>
                            </label>
                        </div>
                        <!-- End BAHP -->
    
                        
                    </div>
                </Container>
            </div>
        </template>
    </Show>
</template>

<script setup>
import Show from "@/Layouts/Procurement/Show.vue";
import Container from "@/Components/utils/Container.vue";
import Input from "@/Components/utils/Input.vue";
import Header1 from "@/Components/utils/Header1.vue";
import Label from '@/Components/utils/Label.vue';
import { useForm } from "@inertiajs/inertia-vue3";
import Notification from "@/Components/composables/Notification"
import Datepicker from '@vuepic/vue-datepicker';
import '@vuepic/vue-datepicker/dist/main.css'

const props = defineProps({
	procurement: { type: Object, required: true },
	suppliers: { type: Object, required: true },
})
const toast = Notification() 

const offer = useForm({
    status      : 4,
    no_offer    : null,
    date_offer  : null,
    offer       : null,
    supplier    : null,
    file_offer  : null,
    modal       : 0,
    _method     : 'patch',
})

const bakn = useForm({
    status      : 1,
    no_bakn     : null,
    days        : null,
    date_bakn   : null,
    modal       : 0,
    _method     : 'patch',
})

const bahp = useForm({
    status      : 2,
    no_bahp     : null,
    date_bahp   : null,
    modal       : 0,
    _method     : 'patch',
})

const baep = useForm({
    status      : 3,
    no_baep     : null,
    date_baep   : null,
    correction  : null,
    modal       : 0,
    _method     : 'patch',
})

const file = useForm({
    status      : null,
    file_bakn   : null,
    file_bahp   : null,
    file_baep   : null,
    modal1      : 0,
    modal2      : 0,
    modal3      : 0,
    _method     : 'patch',
})

const createoffer = (id, name, loading) =>{
    offer.post(route("pp.procurement.update", id),{
        onSuccess:  (e) => {
            toast('success', 'Berhasil Mengunggah Penawaran '+ name),
            offer.reset()
        },
        onError:    (e) => toast('error', 'Gagal Mengunggah Penawaran '+ name),
        onStart     :   ()  => loading(),
        onFinish    :   ()  => loading(),
    })
}

const createbakn = (id, name, loading) =>{
    bakn.post(route("pp.procurement.update", id),{
        onSuccess:  (e) => {
            toast('success', 'Berhasil membuat BAKN '+ name),
            bakn.reset()
        },
        onError:    (e) => toast('error', 'Gagal membuat BAKN '+ name),
        onStart     :   ()  => loading(),
        onFinish    :   ()  => loading(),
    })
}

const createbahp = (id, name, loading) =>{
    bahp.post(route("pp.procurement.update", id),{
        onSuccess:  (e) => {
            toast('success', 'Berhasil membuat BAHP '+ name),
            bahp.reset()
        },
        onError:    (e) => {toast('error', 'Gagal membuat BAHP '+ name); console.log(e)},
        onStart     :   ()  => loading(),
        onFinish    :   ()  => loading(),
    })
}

const createbaep = (id, name, loading) =>{
    baep.post(route("pp.procurement.update", id),{
        onSuccess:  (e) => {
            console.log(e)
            toast('success', 'Berhasil membuat BAE '+ name),
            baep.reset()
        },
        onError:    (e) => toast('error', 'Gagal membuat BAE '+ name),
        onStart     :   ()  => loading(),
        onFinish    :   ()  => loading(),
    })
}

const uploadFile = (id, name, status, loading) =>{
    const type = {
        4: "BAKN",
        5: "BAHP",
        6: "BAEP"
    }
    file.status = status
    file.post(route("pp.procurement.update", id),{
        onSuccess:  (e) => {
            toast('success', 'Berhasil unggah file '+ type[status] +" "+  name),
            file.reset()
        },
        onError:    (e) => toast('error', 'Gagal unggah file '+ type[status] +" "+  name),
        onStart     :   ()  => loading(),
        onFinish    :   ()  => loading(),
    })
}

function onInputChangeFile(e,status) {
    if(status==1) file.file_bakn = e.target.files
    else if(status ==2 ) file.file_bahp = e.target.files
    else if(status ==3 ) file.file_baep = e.target.files
    else if(status ==4 ) offer.file_offer = e.target.files
}


</script>