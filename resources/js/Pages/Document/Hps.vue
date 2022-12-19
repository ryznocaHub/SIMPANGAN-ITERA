<template>
    <div class="flex justify-center  ">
        <div id="app" ref="document" class="w-1/2 ">
            <button class="btn bg-first border-none w-full text-white mb-5" @click="exportToPDF">Download HPS</button>
            <div class="border-2 border-black">
                <div id="element-to-convert" >
                    <Kop />
                    <div class="text-center text-lg font-bold underline">PENETAPAN HARGA PERKIRAAN SENDIRI</div>
                    <div class="text-center ">Nomor: {{procurement.account}}</div>
                    <div class="text-center mt-5">{{procurement.category}}</div>
                    <div class="text-center font-bold">{{procurement.name}}</div>
                    <div class="text-center mt-3">SUMBER DANA : PNBP</div>
                    <div class="text-center ">TAHUN ANGGARAN : {{procurement.year}}</div>
                    
                    <div class="mx-10 text-justify">
                        <div class="indent-10 mt-10">
                            Pada hari ini 
                            <span v-if="procurement.timeline.hps_approved">{{ nowDay(procurement.timeline.hps_approved)}}</span> 
                            <span v-else>{{nowDay(moment())}}</span> 
                            dibawah ini selaku Pejabat Pembuat Komitmen telah melakukan klarifikasi dan pemeriksaan ulang terhadap spesifikasi, maka secara seksama saya menyetujui rencana pelaksanaan Pengadaan dan menetapkan Harga Perkiraan Sendiri (HPS) sebagai berikut :
                        </div>
                        <div class="text-center font-bold italic mt-3">{{convertToRupiah(procurement.estimate.total)}}</div>
                        <div class="text-center font-bold italic mb-5">({{angkaTerbilang(procurement.estimate.total)}} rupiah)</div>
                        <div class="indent-10">
                            Harga tersebut telah memperhitungkan Pajak Pertambahan Nilai (PPN) sesuai dengan peraturan perundang-undangan yang berlaku dan keuntungan yang wajar bagi penyedia barang/jasa. Pekerjaan ini dilaksanakan dengan jangka waktu pelaksanaan selama <span class="">14 Hari</span>  Kalender.
                        </div>
                        <div class="grid place-items-end mt-14" id="signature">
                            <div class="w-6/12 flex flex-col align-end text-end">
                                <div>
                                    <div>Ditetapkan Oleh:</div>
                                    <div>Pejabat Pembuat Komitmen</div>
                                    <div>Institut Teknologi Sumatera</div>
                                </div>
                                <div>
                                    <div class="mt-20">{{procurement.executor.ppk.name}}</div>
                                    <div class="" >{{procurement.executor.ppk.identity_type}}. {{procurement.executor.ppk.identity_number}}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <Kop />
                    <div class="mt-5 pb-3 align-top text-white w-full bg-black font-bold tracking-widest text-center">Harga Perkiraan Sendiri</div>
                    <div class="px-5 text-sm">
                        <div class="flex justify-between mt-3">
                            <div>
                                <div class="">{{procurement.name}}</div>
                                <div>Tahun Anggaran {{procurement.year}}</div>
                                <div>Unit Kerja {{procurement.unit}}</div>
                            </div>
                            <div>
                                <div class="text-sm">Sub Total &nbsp;: {{convertToRupiah(procurement.estimate.sub_total)}}</div>
                                <div v-if="procurement.estimate.overheat" class="text-sm">Overheat &nbsp;&nbsp;: {{convertToRupiah(procurement.estimate.overheat)}}</div>
                                <div v-if="procurement.estimate.ppn" class="text-sm">PPN      &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: {{convertToRupiah(procurement.estimate.ppn)}}</div>
                                <div class="text-lg font-bold">Total    &nbsp;&nbsp;&nbsp;&nbsp;: {{convertToRupiah(procurement.estimate.total)}}</div>
                            </div>
                        </div>
    
                        <EasyDataTable
                            v-model:items-selected="itemsSelected"
                            hide-footer
                            table-class-name="customize-table"
                            :headers="headers"
                            :items="procurement.items"
                            border-cell
                            class="mt-3"
                        >
                            <template #item-image="{ image }">
                                <img class="w-25" :src="image" />
                            </template>
                            <template #item-specification="{ specification }">
                                <div class="mb-2" style="white-space: pre-wrap;">
                                    {{specification}}
                                </div>
                            </template>
                        </EasyDataTable>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>


<script setup>
    import Input from "@/Components/utils/Input.vue";
    import { useForm } from "@inertiajs/inertia-vue3";
    import moment from 'moment';
    import html2pdf from "html2pdf.js";
    import Kop from "./Kop.vue";
    import angkaTerbilang from '@develoka/angka-terbilang-js';
    import 'moment/locale/id'

    const props = defineProps({
        procurement : {
            tipe : Object,
        }
    })

    const exportToPDF = () => {
        html2pdf(document.getElementById("element-to-convert"), {
            margin: 0,
            filename: "HPS_" + props.procurement.name + ".pdf",
            image:        { type: 'jpeg', quality: 0.98 },
            html2canvas:  { scale: 2 },
            jsPDF:        { unit: 'in', format: 'a4', orientation: 'portrait' },
            pagebreak:    { after: '#signature' }
        });
    }

    function nowDay (date) {
        moment.updateLocale('en', {
            months : [
                "Januari", "Feruari", "Maret", "April", "Mei", "Juni", "Juli",
                "Agustus", "September", "Oktober", "November", "Desember"
            ],
            weekdays : [
            "Minggu", "Senin", "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu"
        ]
        });

        return moment( date, 'YYYY-MM-DD h:mm:ss a').format('dddd [Tanggal] D [bulan] MMMM [tahun] YYYY'); 
    }
    
    const headers = [
      { text: "Nama",           value: "name", fixed: true, width: 40, sortable: true }, // set fixed to true
      { text: "Spesifikasi",    value: "specification", width: 80}, // set fixed to true
      { text: "Jumlah",         value: "quantity", width: 25},
      { text: "Satuan",         value: "unit", width: 25},
      { text: "Harga",          value: "estimate_price", width: 40},
      { text: "Total",          value: "estimate_total", width: 40},
      { text: "Gambar",         value: "image", width: 60},
      { text: "Source",         value: "source", width: 40},
    ];
    
    function convertToRupiah(angka) {
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

<style>
.customize-table {
  --easy-table-header-font-size: 10px;
  --easy-table-header-height: 30px;

  --easy-table-body-row-font-size: 9px;

  --easy-table-footer-font-size: 10px;
}
</style>