<template>
    <Show :procurement=procurement >
        <template #file>
            <a v-show="procurement.hps_submitted" :href="route('kontrak.document.boq',procurement.id)" class="btn text-first w-full btn-outline font-bold hover:bg-first hover:text-white hover:border-none" target="_blank">Lihat BOQ</a>
        </template>
        <template #comment>
            <Link v-if="!procurement.suppliers.province" :href="route('kontrak.supplier.edit',procurement.suppliers.id)" class="btn btn-sm mt-10 text-first bg-slate-200 border-none hover:text-white hover:bg-first  font-bold" >Lengkapi Data Supplier</Link>
        </template>
        <!-- <div class="divider"></div> -->
        <template #extra-info>
            <div class="flex gap-4 mt-10">
            <Container  v-if="procurement.suppliers.province">
                <div >
                    <Header1 title="Data Supplier" widthSize="60" />
                    <Label value="Nama" class="mt-5"/>
                    <p class="font-bold text-lg tracking-wider mb-3">
                        <span >{{procurement.suppliers.entity}}. {{procurement.suppliers.name}}</span>
                    </p>
                    <Label value="NPWP" class="mt-5"/>
                    <p class="font-bold text-lg tracking-wider mb-3">
                        <span >{{procurement.suppliers.npwp}}</span>
                    </p>
                    <Label value="Alamat" />
                    <p class="font-bold text-lg tracking-wider mb-3">
                        <span >{{procurement.suppliers.address + ', ' + procurement.suppliers.regency + ', ' + procurement.suppliers.province}}</span>
                    </p>
                    <Label value="Rekening" />
                    <p class="font-bold text-lg tracking-wider mb-3">
                        <span >{{procurement.suppliers.bank}} {{procurement.suppliers.account}}</span>
                    </p>
                </div>
            </Container>
            <Container v-if="procurement.suppliers.province">
                <Header1 title="File Kontrak" widthSize="60" />
                <div class="grid grid-rows-4 grid-flow-col gap-x-3">
                    <div v-if="procurement.estimate.total >= 50000000">
                        <!--SPPBJ-->
                        <a v-if="procurement.contract.no_sppbj" :href="route('kontrak.document.sppbj',procurement.id)" class="mt-3 btn text-first w-full btn-outline font-bold hover:bg-first hover:text-white hover:border-none" target="_blank">SPPBJ</a>
                        <!-- The button to open modal -->
                        <label v-else for="sppbj" class="btn w-full border-first modal-button bg-first">Buat SPPBJ</label>
    
                            <!-- Put this part before </body> tag -->
                            <input type="checkbox" id="sppbj" class="modal-toggle" v-model="sppbj.modal" />
                            <label for="sppbj" class="modal cursor-pointer">
                            <label class="modal-box relative" for="">
                                <label for="sppbj" class="btn btn-xs border-first bg-first btn-circle absolute right-2 top-2">✕</label>
                                <!-- <Header1 title="Setujui HPS" class="my-12" :widhSize=50 /> -->
                                <Header1 title="Surat Penunjukan Penyedia Barang/Jasa" :widthSize="100" />
                                <Label value="Nomor SPPBJ" class="mt-10" />
                                <Input
                                type="text"
                                class="mt-1 block w-full"
                                v-model="sppbj.no_sppbj"
                                />
                                <Label value="Prihal" />
                                <Input
                                type="text"
                                class="mt-1 block w-full"
                                v-model="sppbj.purpose_sppbj"
                                />
                                <Label value="Nomor Penawaran" />
                                <Input
                                type="text"
                                class="mt-1 block w-full"
                                v-model="sppbj.no_offer"
                                />
                                <Label value="Tanggal SPPBJ" />
                                <Datepicker 
                                    v-model="sppbj.date_sppbj" 
                                    :enableTimePicker="false"  
                                    format='dd-MM-yyyy'
                                    selectText="Pilih"
                                    cancelText="Batal"
                                />
                                <Label value="Tanggal Penawaran" class="mt-3" />
                                <Datepicker 
                                    v-model="sppbj.date_offer" 
                                    :enableTimePicker="false"  
                                    format='dd-MM-yyyy'
                                    selectText="Pilih"
                                    cancelText="Batal"
                                />
                                <div class="flex justify-center my-5">
                                    <button @click="createsppbj(procurement.id)" class="btn border-first bg-first mt-5 tracking-wide" >Buat SPK</button>
                                </div>
                            </label>
                        </label>
                        <!-- EndSPPBJ-->
                    </div>

                    <!-- SPK -->
                    <div v-if="procurement.contract.no_sppbj && procurement.estimate.total >= 50000000">
                        <a v-if="procurement.contract.no_spk" :href="route('kontrak.document.spk',procurement.id)" class="mt-3 btn text-first w-full btn-outline font-bold hover:bg-first hover:text-white hover:border-none" target="_blank">SPK</a>
                        <!-- The button to open modal -->
                        <label v-else for="spk" class="btn w-full mt-3 border-first modal-button bg-first">Buat SPK</label>
    
                            <!-- Put this part before </body> tag -->
                            <input type="checkbox" id="spk" class="modal-toggle" v-model="spk.modal" />
                            <label for="spk" class="modal cursor-pointer">
                            <label class="modal-box relative" for="">
                                <label for="spk" class="btn btn-xs border-first bg-first btn-circle absolute right-2 top-2">✕</label>
                                <!-- <Header1 title="Setujui HPS" class="my-12" :widhSize=50 /> -->
                                <Header1 title="Data Surat Perintah Kerja" :widthSize="100" />
                                <Label value="Nomor SPK" class="mt-10" />
                                <Input
                                type="text"
                                class="mt-1 block w-full"
                                v-model="spk.no_spk"
                                />
                                <Label value="Kode MAK" />
                                <Input
                                type="text"
                                class="mt-1 block w-full"
                                v-model="spk.mak_code"
                                />
                                <!-- <div class="divider my-10"></div> -->
                                <Label value="Jumlah Hari Kerja" class="mt-5" />
                                <Input
                                type="number"
                                class="mt-1 block w-full"
                                v-model="spk.days"
                                @input="e => convert(e.target.value)"
                                />
                                <!-- @input="e => workEnd(spk.start, e.target.value)" -->
                                <div class="grid grid-flow-row-dense grid-cols-2 grid-rows-2 gap-x-4">
                                    <Label value="Tanggal Mulai" />
                                    <Label value="Tanggal Selesai" class="pb-0 mb-0" />
                                    <!-- {
                                        format: 'DD-MM-YYYY'
                                    } -->
                                    <Datepicker 
                                        v-model="spk.start" 
                                        :enableTimePicker="false"  
                                        @update:modelValue="convert(spk.days)"
                                        format='dd-MM-yyyy'
                                        selectText="Pilih"
                                        cancelText="Batal"
                                    />
                                    <div v-if="spk.end" >{{spk.end}}</div>
                                    <div v-else class="text-secondary font-bold" >Atur Tanggal Mulai</div>
                                </div>
                                <div class="flex justify-center my-5">
                                    <button @click="createspk(procurement.id)" class="btn border-first bg-first mt-5 tracking-wide" >Buat SPK</button>
                                </div>
                            </label>
                        </label>
                    </div>
                    <!-- End SPK -->

                    <!-- End SPP/SPMK -->
                    <div v-if="procurement.contract.no_spk || procurement.estimate.total <= 50000000">
                        <a v-if="procurement.contract.no_sp" :href="route('kontrak.document.sp',procurement.id)" class="mt-3 btn text-first w-full btn-outline font-bold hover:bg-first hover:text-white hover:border-none" target="_blank">{{procurement.category == 'Barang' ? 'SPP' : 'SPMK'}}</a>
                        <!-- The button to open modal -->
                        <label v-else for="sp" class="btn w-full mt-3 border-first modal-button bg-first">Buat {{procurement.category == 'Barang' ? 'SPP' : 'SPMK'}}</label>
    
                            <!-- Put this part before </body> tag -->
                            <input type="checkbox" id="sp" class="modal-toggle" v-model="sp.modal" />
                            <label for="sp" class="modal cursor-pointer">
                            <label class="modal-box relative" for="">
                                <label for="sp" class="btn btn-xs border-first bg-first btn-circle absolute right-2 top-2">✕</label>
                                <!-- <Header1 title="Setujui HPS" class="my-12" :widhSize=50 /> -->
                                <Header1 :title="procurement.category == 'Barang' ? 'Surat Perintah Pengiriman' : 'Surat Perintah Mulai Kerja'"   :widthSize="100" />
                                <Label value="Nomor" class="mt-10" />
                                <Input
                                type="text"
                                class="mt-1 block w-full"
                                v-model="sp.no_sp"
                                />
                                <!-- <Label value="Paket Pekerjaan" class="mt-3" />
                                <Input
                                type="text"
                                class="mt-1 block w-full"
                                v-model="sp.paket_sp"
                                /> -->
                                <Label value="Tanggal" />
                                <Datepicker 
                                    v-model="sp.date_sp" 
                                    :enableTimePicker="false"  
                                    format='dd-MM-yyyy'
                                    selectText="Pilih"
                                    cancelText="Batal"
                                />
                                <div class="flex justify-center my-5">
                                    <button @click="createsp(procurement.id)" class="btn border-first bg-first mt-5 tracking-wide" >Buat {{procurement.category == 'Barang' ? 'SPP' : 'SPMK'}}</button>
                                </div>
                            </label>
                        </label>
                    </div>
                    <!-- End SPP/SPMK -->

                </div>
            </Container>
            <Container v-if="procurement.contract.no_sp">
                <Header1 title="Berita Acara" widthSize="60" />
                <div class="grid grid-rows-4 grid-flow-col gap-x-3">
                    <!-- BAHP -->
                    <div v-if="procurement.contract.no_sp">
                        <a v-if="procurement.contract.no_bap" :href="route('kontrak.document.bap',procurement.id)" class="mt-3 btn text-first w-full btn-outline font-bold hover:bg-first hover:text-white hover:border-none" target="_blank">BAHP</a>
                        <!-- The button to open modal -->
                        <label v-else for="bap" class="btn w-full mt-3 border-first modal-button bg-first">Buat BAHP</label>
    
                            <!-- Put this part before </body> tag -->
                            <input type="checkbox" id="bap" class="modal-toggle" v-model="bap.modal" />
                            <label for="bap" class="modal cursor-pointer">
                            <label class="modal-box relative" for="">
                                <label for="bap" class="btn btn-xs border-first bg-first btn-circle absolute right-2 top-2">✕</label>
                                <!-- <Header1 title="Setujui HPS" class="my-12" :widhSize=50 /> -->
                                <Header1 title="Berita Acara Hasil Pemeriksaan" :widthSize="100" />
                                <Label value="Nomor" class="mt-10" />
                                <Input
                                type="text"
                                class="mt-1 block w-full"
                                v-model="bap.no_bap"
                                />
                                <Label value="Tanggal" />
                                <Datepicker 
                                    v-model="bap.date_bap" 
                                    :enableTimePicker="false"  
                                    format='dd-MM-yyyy'
                                    selectText="Pilih"
                                    cancelText="Batal"
                                />
                                <div class="flex justify-center my-5">
                                    <button @click="createbap(procurement.id)" class="btn border-first bg-first mt-5 tracking-wide" >Buat BAP</button>
                                </div>
                            </label>
                        </label>
                    </div>
                    <!-- End BAP -->

                    <!-- BAST -->
                    <div v-if="procurement.contract.no_bap">
                        <a v-if="procurement.contract.no_bastp" :href="route('kontrak.document.bastp',procurement.id)" class="mt-3 btn text-first w-full btn-outline font-bold hover:bg-first hover:text-white hover:border-none" target="_blank">BAST</a>
                        <!-- The button to open modal -->
                        <label v-else for="bastp" class="btn w-full mt-3 border-first modal-button bg-first">Buat BAST</label>
    
                            <!-- Put this part before </body> tag -->
                            <input type="checkbox" id="bastp" class="modal-toggle" v-model="bastp.modal" />
                            <label for="bastp" class="modal cursor-pointer">
                            <label class="modal-box relative" for="">
                                <label for="bastp" class="btn btn-xs border-first bg-first btn-circle absolute right-2 top-2">✕</label>
                                <!-- <Header1 title="Setujui HPS" class="my-12" :widhSize=50 /> -->
                                <Header1 title="Berita Acara Serah Terima" :widthSize="100" />
                                <Label value="Nomor" class="mt-10" />
                                <Input
                                type="text"
                                class="mt-1 block w-full"
                                v-model="bastp.no_bastp"
                                />
                                <Label value="Tanggal" />
                                <Datepicker 
                                    v-model="bastp.date_bastp" 
                                    :enableTimePicker="false"  
                                    format='dd-MM-yyyy'
                                    selectText="Pilih"
                                    cancelText="Batal"
                                />
                                <div class="flex justify-center my-5">
                                    <button @click="createbastp(procurement.id)" class="btn border-first bg-first mt-5 tracking-wide" >Buat BASTP</button>
                                </div>
                            </label>
                        </label>
                    </div>
                    <!-- End BAST -->

                    
                </div>
            </Container>
            </div>
        </template>

    </Show>
</template>

<script setup>
import Show from "@/Layouts/Procurement/Show.vue";
import Label from '@/Components/utils/Label.vue';
import Input from '@/Components/utils/Input.vue';
import Header1 from "@/Components/utils/Header1.vue";
import { Link,useForm } from '@inertiajs/inertia-vue3'
import Datepicker from '@vuepic/vue-datepicker';
import '@vuepic/vue-datepicker/dist/main.css'
import Container from "@/Components/utils/Container.vue";
import moment from 'moment';

const props = defineProps({
	procurement: { type: Object, required: true },
})

const cek = () =>{
    console.log("masuk")
}

const sppbj = useForm({
    status          : 1,
    no_sppbj        : "",
    purpose_sppbj   : "",
    date_sppbj      : null,
    date_offer      : null,
    no_offer        : "",
    modal           : 0,
    _method         : 'patch',
})

const spk = useForm({
    status      : 2,
    no_spk      : "",
    mak_code    : "",
    start       : null,
    days        : 1,
    end         : null,
    modal       : 0,
    _method     : 'patch',
})

const bastp = useForm({
    status      : 3,
    no_bastp    : "",
    date_bastp  : null,
    modal       : 0,
    _method     : 'patch',
})

const bap = useForm({
    status      : 4,
    no_bap      : "",
    date_bap    : null,
    modal       : 0,
    _method     : 'patch',
})

const sp = useForm({
    status      : 5,
    no_sp       : "",
    paket_sp    : "",
    date_sp     : null,
    modal       : 0,
    _method     : 'patch',
})

const createsppbj = (id) =>{
    sppbj.post(route("kontrak.procurement.update", id),{
        onSuccess:  (e) => {
            console.log("sukses membuat SPPBJ",e)
            sppbj.reset()
        },
        onError:    (e) => {console.log(e)}
    })
}

const createspk = (id) =>{
    spk.post(route("kontrak.procurement.update", id),{
        onSuccess:  (e) => {
            console.log("sukses membuat SPK",e)
            spk.reset()
        },
        onError:    (e) => {console.log(e)}
    })
}

const createbastp = (id) =>{
    bastp.post(route("kontrak.procurement.update", id),{
        onSuccess:  (e) => {
            console.log("sukses membuat bastp",e)
            bastp.reset()
        },
        onError:    (e) => {console.log(e)}
    })
}

const createbap = (id) =>{
    bap.post(route("kontrak.procurement.update", id),{
        onSuccess:  (e) => {
            console.log("sukses membuat bap",e)
            bap.reset()
        },
        onError:    (e) => {console.log(e)}
    })
}

const createsp = (id) =>{
        sp.post(route("kontrak.procurement.update", id),{
            onSuccess:  (e) => {
                console.log("sukses membuat sp",e)
                sp.reset()
            },
            onError:    (e) => {console.log(e)}
        })
}

const convert = (days) => {
    console.log("masuk")
    const x     = moment(spk.start , 'MM-DD-YYYY').add(days, 'days').format('DD-MM-YYYY'); 
    spk.days    = days;
    spk.end     = x;
}

const textInputOptions = () => {
          format: 'DD-MM-YYYY'
        }

</script>