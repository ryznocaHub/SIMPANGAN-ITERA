<template>
    <div class="flex justify-center  ">
        <div id="app" ref="document" class="w-1/2 ">
            <button class="btn bg-first border-none w-full text-white mb-5" @click="exportToPDF(procurement.name)">Download BAP</button>
            <div class="border-2 border-black">
                <div id="element-to-convert" >
                    <Kop/>
                    <div class="mx-10">
                        <div class="font-bold text-lg text-center mt-10">BERITA ACARA PEMBAYARAN</div>
                        <div class=" text-center">Nomor : {{procurement.contract.no_bap}}</div>
                        <div class="indent-10 mt-10 text-justify">
                            Pada hari ini {{getDate(procurement.contract.date_bap)}}, kami yang bertanda tangan di bawah ini:
                        </div>
                        <div class="flex mt-5">
                            <div class="font-bold text-lg">I</div>
                            <div class="ml-5">
                                <div class="flex">
                                    <div class="w-28">Nama/NIP</div>
                                    <div>: {{procurement.executor.ppk.name}} / {{procurement.executor.ppk.identity_number}}</div>
                                </div>
                                <div class="flex">
                                    <div class="w-28">Jabatan</div>
                                    <div>: Pejabat Pembuat Komitmen
                                        <div>  INSTITUT TEKNOLOGI SUMATERA</div>
                                    </div>
                                </div>
                                <div class="flex">
                                    <div class="w-28">Alamat</div>
                                    <div>: Jl. Terusan Ryacudu, Way Huwi, Jati Agung, Lampung Selatan, 35365</div>
                                </div>
                                <div class="mt-5">Selanjutnya disebut sebagai <span class="font-lg font-bold">PIHAK PERTAMA</span> </div>
                            </div>
                        </div>
                        <div class="flex mt-5">
                            <div class="font-bold text-lg">II</div>
                            <div class="ml-5">
                                <div class="flex">
                                    <div class="w-28">Nama</div>
                                    <div>: {{procurement.contract.pic}}</div>
                                </div>
                                <div class="flex">
                                    <div class="w-28">Jabatan</div>
                                    <div>: {{procurement.contract.pic_position}}</div>
                                </div>
                                <div class="flex">
                                    <div class="w-28">Alamat</div>
                                    <div class="text-justify">: {{procurement.suppliers.address + ', ' + procurement.suppliers.regency + ', ' + procurement.suppliers.province}}</div>
                                </div>
                                <div class="flex">
                                    <div class="w-28">NPWP</div>
                                    <div>: {{procurement.suppliers.npwp}}</div>
                                </div>
                                <div class="mt-5">Selanjutnya disebut sebagai <span class="font-lg font-bold">PIHAK KEDUA</span> </div>
                            </div>
                        </div>
                        <div class="indent-10 mt-5 text-justify"> <span class="font-lg font-bold">PIHAK PERTAMA</span> telah menerima pekerjaan dari <span class="font-lg font-bold">PIHAK KEDUA</span> berdasarkan Berita Acara Serah Terima Pekerjaan Nomor : {{procurement.contract.no_bastp}} tanggal <span class="">{{moment(procurement.contract.date_start_spk, 'YYYY-MM-DD').format('DD-MM-YYYY') }}</span>, dan <span class="font-lg font-bold">PIHAK KEDUA</span> berhak menerima pembayaran dari <span class="font-lg font-bold">PIHAK PERTAMA</span> sebesar {{convertToRupiah(procurement.contract.offer)}} ({{angkaTerbilang(procurement.contract.offer)}} rupiah).</div>
                        <div class="indent-10 mt-5 text-justify">Demikian Berita Acara Pembayaran ini dibuat untuk dapat digunakan sebagaimana mestinya.</div>
                        <div class="flex justify-between mt-14 mb-10">
                            <div class="flex flex-col text-center">
                                <div class="font-bold text-lg">PIHAK KEDUA</div>
                                <div class="font-bold mt-14">{{procurement.contract.pic}}</div>
                                <div class="font-bold ">{{procurement.contract.pic_position}}</div>
                            </div>
                            <div class="flex flex-col text-center">
                                <div class="font-bold text-lg">PIHAK PERTAMA</div>
                                <div class="font-bold mt-14">{{procurement.executor.ppk.name}}</div>
                                <div class="font-bold ">{{procurement.executor.ppk.identity_type}}. {{procurement.executor.ppk.identity_number}}</div>
                            </div>

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
    return moment(date, 'YYYY-MM-DD h:mm:ss a').format('dddd [Tanggal] DD [bulan] MMMM [tahun] YYYY');

    // return moment().format('dddd [Tanggal] DD [bulan] MMMM [tahun] YYYY');
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
            filename: "BAP_" + name + ".pdf",
            image:        { type: 'jpeg', quality: 0.98 },
            html2canvas:  { scale: 2 },
            jsPDF:        { unit: 'in', format: 'a4', orientation: 'portrait' },
        });
    }
</script>