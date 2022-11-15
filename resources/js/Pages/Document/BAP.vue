<template>
    <div class="flex justify-center  ">
        <div id="app" ref="document" class="w-1/2 ">
            <button class="btn bg-first border-none w-full text-white mb-5" @click="exportToPDF(procurement.name)">Download BAHP</button>
            <div class="border-2 border-black">
                <div id="element-to-convert" >
                    <Kop/>
                    <div class="mx-10">
                        <div class="font-bold text-lg text-center mt-10">BERITA ACARA HASIL PEMERIKSAAN (BAHP)</div>
                        <div class=" text-center">Nomor : {{procurement.contract.no_bap}}</div>
                        <div class="indent-10 mt-10 text-justify">
                            Pada hari ini {{getDate(procurement.contract.date_bap)}}, kami yang bertanda tangan di bawah ini:
                        </div>
                        <div class="flex">
                            <div class="w-28">Nama/NIP</div>
                            <div>: {{procurement.executor.ppk.name}} / {{procurement.executor.ppk.identity_number}}</div>
                        </div>
                        <div class="flex">
                            <div class="w-28">Jabatan</div>
                            <div>: Pejabat Pembuat Komitmen
                                <div>  Institut Teknologi Sumatera</div>
                            </div>
                        </div>
                        <div class="flex">
                            <div class="w-28">Alamat</div>
                            <div>: Jl. Terusan Ryacudu, Way Huwi, Jati Agung, Lampung Selatan, 35365</div>
                        </div>

                        <div v-if="procurement.estimate.total > 50000000" class="mt-5 indent-10 text-justify" >Telah melakukan pemeriksaa dan penelitian atas pekerjaan <span class="">{{procurement.name}}</span> sebagaimana daftar terlampir yang diserahkan oleh {{procurement.suppliers.name}}. Hasil pemeriksaan dinyatakan bahwa pekerjaan tersebut telah dilaksanakan dengan baik serta sesuai dengan SPK nomor {{procurement.contract.no_spk}} tanggal {{moment(procurement.contract.date_start_spk, 'YYYY-MM-DD').format('DD-MM-YYYY')}}. </div>
                        <div v-else class="mt-5 indent-10 text-justify" >Telah melakukan pemeriksaa dan penelitian atas pekerjaan <span class="">{{procurement.name}}</span> sebagaimana daftar terlampir yang diserahkan oleh {{procurement.suppliers.name}}. Hasil pemeriksaan dinyatakan bahwa pekerjaan tersebut telah dilaksanakan dengan baik serta sesuai dengan Berita Acara Hasil Pengadaan Langsung (BAHPL) nomor {{procurement.contract.no_bahp}} tanggal {{moment(procurement.contract.date_bahp, 'YYYY-MM-DD').format('DD-MM-YYYY')}}. </div>
                        <div class="indent-10 mt-5 text-justify">Demikian Berita Acara Hasil Pemeriksaan (BAHP) ini dibuat untuk dapat digunakan sebagaimana mestinya.</div>
                        
                        <div class="flex flex-col text-center mb-10">
                            <div class="text-end">Pejabat Pembuat Komitmen</div>
                            <div class="text-end mt-14">{{procurement.executor.ppk.name}}</div>
                            <div class="text-end ">{{procurement.executor.ppk.identity_type}}. {{procurement.executor.ppk.identity_number}}</div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import Kop from './Kop.vue';
import moment from 'moment';
import html2pdf from "html2pdf.js";

defineProps({
    procurement : {
        tipe : Object
    }
})
    
const getDate = (date) =>{
    moment.updateLocale('en', {
        months : [
            "Januari", "Feruari", "Maret", "April", "Mei", "Juni", "Juli",
            "Agustus", "September", "Oktober", "November", "Desember"
        ],
        weekdays : [
        "Minggu", "Senin", "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu"
    ]
    });
    // return moment(date, 'YYYY-MM-DD h:mm:ss a').format('DD-MM-YYYY');
    return moment(date, 'YYYY-MM-DD h:mm:ss a').format('dddd [Tanggal] D [bulan] MMMM [tahun] YYYY');
}

const getSimpleDate = (date) => {
    return moment().format('DD-MM-YYYY');
}

const exportToPDF = (name) => {
        html2pdf(document.getElementById("element-to-convert"), {
            margin: 0,
            filename: "BAP_" + name + ".pdf",
            image:        { type: 'jpeg', quality: 0.98 },
            html2canvas:  { scale: 2 },
            jsPDF:        { unit: 'in', format: 'a4', orientation: 'portrait' },
        });
    }
</script>