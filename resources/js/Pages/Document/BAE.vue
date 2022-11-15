<template>
    <div class="flex justify-center  ">
        <div id="app" ref="document" class="w-1/2 ">
            <button class="btn bg-first border-none w-full text-white mb-5" @click="exportToPDF(procurement.name)">Download BAE</button>
            <div class="border-2 border-black">
                <div id="element-to-convert" >
                    <Kop/>
                    <div class="mx-10">
                        <div class="font-bold text-lg text-center mt-10">BERITA ACARA HASIL EVALUASI</div>
                        <div class=" text-center">Nomor : {{procurement.contract.no_baep}}</div>
                        <div class="indent-10 mt-10 text-justify">
                            Pada hari ini {{getDate(procurement.contract.date_baep)}}, saya yang bertanda tangan dibawah ini Pejabat Pengadaan Institut Teknologi Sumatera telah mengadakan evaluasi terhadap dokumen penawaran Pengadaan {{procurement.name}}, dengan hasil sebagai berikut:
                        </div>
                        <div class="mt-1">1. Evaluasi Penawaran</div>
                        <div class="mb-3">a. Koreksi Aritmatik</div>
                        <div class="text-xs flex border-2 border-black  items-center justify-items-center text-justify">
                            <div class="text-center flex flex-col flex-grow border-r-2 border-black">
                                <div class="border-b-2 border-black font-xs pb-3">No</div>
                                <div class=" pb-3">1</div>
                            </div>
                            <div class="text-center flex flex-col flex-grow border-r-2 border-black">
                                <div class="border-b-2 border-black pb-3">Nama Peserta</div>
                                <div class=" pb-3">{{procurement.suppliers.name}}</div>
                            </div>
                            <div class="text-center flex flex-col flex-grow border-r-2 border-black">
                                <div class="border-b-2 border-black pb-3">Nilai Penawaran</div>
                                <div class=" pb-3">{{convertToRupiah(procurement.contract.offer)}}</div>
                            </div>
                            <div class="text-center flex flex-col flex-grow border-black">
                                <div class="border-b-2 border-black pb-3">Nilai Terkoreksi</div>
                                <div class=" pb-3">{{convertToRupiah(procurement.contract.correction)}}</div>
                            </div>
                        </div>
                        <div class="mt-1 mb-3">b. Evaluasi Administrasi</div>
                        <div class="text-xs flex border-2 border-black  items-center justify-items-center text-justify">
                            <div class="text-center flex flex-col flex-grow border-r-2 border-black">
                                <div class="border-b-2 border-black pb-3">No</div>
                                <div class=" pb-3">1</div>
                            </div>
                            <div class="text-center flex flex-col flex-grow border-r-2 border-black">
                                <div class="border-b-2 border-black pb-3">Nama Peserta</div>
                                <div class=" pb-3">{{procurement.suppliers.name}}</div>
                            </div>
                            <div class="text-center flex flex-col flex-grow border-r-2 border-black">
                                <div class="border-b-2 border-black pb-3">Hasil Evaluasi Administrasi</div>
                                <div class=" pb-3">Memenuhi Syarat</div>
                            </div>
                            <div class="text-center flex flex-col flex-grow border-black">
                                <div class="border-b-2 border-black pb-3">Keterangan</div>
                                <div class=" pb-3">Lulus</div>
                            </div>
                        </div>
                        <div class="mt-1 mb-3">c. Evaluasi Teknis</div>
                        <div class="text-xs flex border-2 border-black  items-center justify-items-center text-justify">
                            <div class="text-center flex flex-col flex-grow border-r-2 border-black">
                                <div class="border-b-2 border-black pb-3 ">No</div>
                                <div class=" pb-3">1</div>
                            </div>
                            <div class="text-center flex flex-col flex-grow border-r-2 border-black">
                                <div class="border-b-2 border-black pb-3">Nama Peserta</div>
                                <div class=" pb-3">{{procurement.suppliers.name}}</div>
                            </div>
                            <div class="text-center flex flex-col flex-grow border-r-2 border-black">
                                <div class="border-b-2 border-black pb-3">Hasil Evaluasi Teknis</div>
                                <div class=" pb-3">Memenuhi Syarat</div>
                            </div>
                            <div class="text-center flex flex-col flex-grow border-black">
                                <div class="border-b-2 border-black pb-3">Keterangan</div>
                                <div class=" pb-3">Lulus</div>
                            </div>
                        </div>
                        <div class="mt-1 mb-3">c. Evaluasi Harga</div>
                        <div class="text-xs flex border-2 border-black  items-center justify-items-center text-justify">
                            <div class="text-center flex flex-col flex-grow border-r-2 border-black">
                                <div class="border-b-2 border-black pb-3">No</div>
                                <div class=" pb-3">1</div>
                            </div>
                            <div class="text-center flex flex-col flex-grow border-r-2 border-black">
                                <div class="border-b-2 border-black pb-3">Nama Peserta</div>
                                <div class=" pb-3">{{procurement.suppliers.name}}</div>
                            </div>
                            <div class="text-center flex flex-col flex-grow border-r-2 border-black">
                                <div class="border-b-2 border-black pb-3">Nilai HPS</div>
                                <div class=" pb-3">{{convertToRupiah(procurement.estimate.total)}}</div>
                            </div>
                            <div class="text-center flex flex-col flex-grow border-r-2 border-black">
                                <div class="border-b-2 border-black pb-3">Penawaran</div>
                                <div class=" pb-3">{{convertToRupiah(procurement.contract.offer)}}</div>
                            </div>
                            <div class="text-center flex flex-col flex-grow border-black">
                                <div class="border-b-2 border-black pb-3">Keterangan</div>
                                <div class=" pb-3">Lulus</div>
                            </div>
                        </div>
                        <div class="mt-1 mb-3">2. Evaluasi Kualifikasi</div>
                        <div class="text-xs flex border-2 border-black  items-center justify-items-center text-justify">
                            <div class="text-center flex flex-col flex-grow border-r-2 border-black">
                                <div class="border-b-2 border-black pb-3">No</div>
                                <div class="pb-3">1</div>
                            </div>
                            <div class="text-center flex flex-col flex-grow border-r-2 border-black">
                                <div class="border-b-2 border-black pb-3">Nama Peserta</div>
                                <div class="pb-3 ">{{procurement.suppliers.name}}</div>
                            </div>
                            <div class="text-center flex flex-col flex-grow border-r-2 border-black">
                                <div class="border-b-2 border-black pb-3">Hasil Evaluasi Kualifikasi</div>
                                <div class="pb-3 ">Memenuhi Syarat</div>
                            </div>
                            <div class="text-center flex flex-col flex-grow border-black">
                                <div class="border-b-2 border-black pb-3">Keterangan</div>
                                <div class=" pb-3">Lulus</div>
                            </div>
                        </div>

                        <div class="indent-10 mt-3 text-justify">Demikian Berita Acara Hasil Evaluasi ini dibuat dengan tanggung jawab dam agar dapat digunakan sebagaimana mestinya.</div>
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
    return moment(date, 'YYYY-MM-DD h:mm:ss').format('dddd [tanggal] D [bulan] MMMM [tahun] YYYY');
}

const getSimpleDate = (date) => {
    return moment().format('DD-MM-YYYY');
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
            filename: "BAE_" + name + ".pdf",
            image:        { type: 'jpeg', quality: 0.98 },
            html2canvas:  { scale: 2 },
            jsPDF:        { unit: 'in', format: 'a4', orientation: 'portrait' },
        });
    }
</script>