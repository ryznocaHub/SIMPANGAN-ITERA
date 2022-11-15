<template>
    <div class="flex justify-center  ">
        <div id="app" ref="document" class="w-1/2 ">
            <button class="btn bg-first border-none w-full text-white mb-5" @click="exportToPDF(procurement.name)">Download BAKN</button>
            <div class="border-2 border-black">
                <div id="element-to-convert" >
                    <Kop/>
                    <div class="mx-10">
                        <div class="font-bold text-lg text-center mt-10">BERITA ACARA KLARIFIKASI DAN NEGOSIASI</div>
                        <div class=" text-center">Nomor : {{procurement.contract.no_bakn}}</div>
                        <div class=" text-center my-5 font-bold">{{procurement.name}}</div>
                        <div class=" text-center">Hari/Tanggal : {{getDate(procurement.contract.date_bakn)}}</div>
                        <div class=" text-center">Tempat : Institut Teknologi Sumatera</div>
                        <div class="indent-10 mt-10 text-justify">
                            Berdasarkan berkas dokumen penawaran dari {{procurement.suppliers.entity + ' ' + procurement.suppliers.name}} Nomor : {{procurement.contract.no_offer}} Tanggal {{getSimpleDate(procurement.contract.date_offer)}}, dengan ini Pejabat Pengadaan telah melakukan klarifikasi teknis dan negosiasi harga bersama penyedia jasa.
                        </div>
                        <div class="indent-10 mt-10 text-justify">
                            Hal-hal yang dibahas dalam berita acara klarifikasi teknis dan negosiasi harga antara lain sebgai berikut:
                        </div>

                        <div class="flex mt-2 ml-3">
                            <div class="font-bold">1.</div>
                            <div class="text-justify  ml-5">Pejabat Pengadaan melakukan negosiasi harga penawaran dan penyedia menyanggupi atas negosiasi tersebut, sehingga total penawaran yang disepakati senilai {{convertToRupiah(procurement.contract.offer)}} <span class="font-bold">({{angkaTerbilang(procurement.contract.offer)}})</span>, dan penyedia berkomitmen akan sanggup melaksanakan Pengadaan tersebut sesuai dengan nilai Pengadaan di atas tanpa mengurangi kualitas jasa, serta melaksanakan sesuai dengan spesifikasi yang telah disepakati. </div> 
                        </div>
                        <div class="flex mt-2 ml-3">
                            <div class="font-bold">2.</div>
                            <div class="text-justify ml-5">Penyedia jasa menyanggupi untuk dapat melaksanakan pekerjaan Pengadaan tersebut dengan durasi pekerjaan selama <span class="font-bold">{{procurement.contract.days}} ({{angkaTerbilang(procurement.contract.days)}})</span> </div> 
                        </div>

                        <div class="flex flex-col text-center my-10">
                            <div class="text-end">Pejabat Pengadaan</div>
                            <div class="text-end mt-14">{{procurement.executor.pp.name}}</div>
                            <div class="text-end ">{{procurement.executor.pp.identity_type}}. {{procurement.executor.pp.identity_number}}</div>
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
import angkaTerbilang from '@develoka/angka-terbilang-js';

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
    return moment(date, 'YYYY-MM-DD h:mm:ss').format('dddd, D MMMM YYYY');
}

const getSimpleDate = (date) => {
    return moment(date, 'YYYY-MM-DD h:mm:ss').format('D MMMM YYYY');
}

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

const exportToPDF = (name) => {
        html2pdf(document.getElementById("element-to-convert"), {
            margin: 0,
            filename: "BAKN_" + name + ".pdf",
            image:        { type: 'jpeg', quality: 0.98 },
            html2canvas:  { scale: 2 },
            jsPDF:        { unit: 'in', format: 'a4', orientation: 'portrait' },
        });
    }
</script>