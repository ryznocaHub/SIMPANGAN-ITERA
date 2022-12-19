<template>
    <div class="flex justify-center  ">
        <div id="app" ref="document" class="w-1/2 ">
            <button class="btn bg-first border-none w-full text-white mb-5" @click="exportToPDF(procurement.name, procurement.category)">Download {{procurement.category == 'Barang' ? 'SPP' : 'SPMK'}}</button>
            <div class="border-2 border-black">
                <div id="element-to-convert" >
                    <Kop/>
                    <div class="mx-10">
                        <div class="font-bold text-lg text-center mt-5">{{title}}</div>
                        <div class=" text-center">Nomor : {{procurement.contract.no_sp}}</div>
                        <div class="text-center">Paket Pekerjaan : {{procurement.account}}</div>
                        <div class="text-justify mt-10">
                            Yang bertanda tangan di bawah ini:
                        </div>
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

                        <div class="mt-3">Selanjutnya disebut sebagai Pejabat Pembuat Komitmen </div>
                        <div v-if="procurement.estimate.total > 50000000" class="mt-3 text-justify">berdasarkan Surat Perintah Kerja (SPK) nomor: {{procurement.contract.no_spk}} <span class="">tanggal  {{getDate(procurement.contract.date_start_spk)}}</span>, bersama ini memerintahkan: </div>
                        <div v-else class="mt-3 text-justify">berdasarkan Berita Acara Hasil Pengadaan Langsung (BAHPL) nomor: {{procurement.contract.no_bahp}} <span class="">tanggal  {{getDate(procurement.contract.date_bahp)}}</span>, bersama ini memerintahkan: </div>
                        
                        <div class="flex mt-3">
                            <div class="w-36">Nama Penyedia</div>
                            <div>: {{procurement.suppliers.name}}</div>
                        </div>
                        <div class="flex text-justify">
                            <div class="w-36">Alamat</div>
                            <div>: {{procurement.suppliers.address + ', ' + procurement.suppliers.regency + ', ' + procurement.suppliers.province}}</div>
                        </div>

                        <div class="mt-3 text-justify">yang dalam hal ini diwakili oleh: {{procurement.contract.pic}} selanjutnya disebut sebagai Penyedia untuk segera memulai pelaksanaan pekerjaan dengan memperhatikan ketentuan-ketentuan sebagai berikut:</div>
                        
                        <div class="flex mt-3">
                            <div class=" font-bold underline">1. Paket Pengadaan </div>
                            <div> : {{procurement.account}};</div>
                        </div>
                        
                        <div class="flex">
                            <div class=" font-bold underline">2. Tanggal Mulai Kerja </div>
                            <div> : {{moment(procurement.contract.date_start_spk, 'YYYY-MM-DD').format('DD MMMM YYYY')}};</div>
                        </div>
                        <div class="flex">
                            <div class=" font-bold underline">3. Syarat-syarat Pekerjaan</div>
                            <div> : Sesuai dengan persyaratan dan ketentuan SPK;</div>
                        </div>
                        <div class="flex ">
                            <div class=" font-bold underline w-64">4. Waktu Penyelesaian</div>
                            <div>: Selama {{procurement.contract.days}} ({{angkaTerbilang(procurement.contract.days)}}) hari kalender dan pekerjaan harus sudah selesai pada tanggal {{moment(procurement.contract.date_end_spk, 'YYYY-MM-DD').format('DD MMMM YYYY')}};</div>
                        </div>
                        <div class="flex">
                            <div class="w-64 grow font-bold underline">5. Denda</div>
                            <div class="text-justify">: Terhadap setiap hari keterlambatan pelasanaan/penyelesaian pekerjaan Penyedia akan dikenakan Denda Keterlambatan sebesar 1/1000 (satu permil) dari nilai SPK atau dari nilai bagian SPK (tidak termasuk PPN) sesuai ketentuan dalam SPK.</div>
                        </div>

                        <!-- <div class="indent-10 mt-3"> <span class="font-lg font-bold">PIHAK PERTAMA</span> telah menerima pekerjaan dari <span class="font-lg font-bold">PIHAK KEDUA</span> berdasarkan Berita Acara Serah Terima Pekerjaan Nomor : <span class="text-secondary">nomor BASTP</span> tanggal <span class="text-secondary">{{procurement.contract.date_start_spk}}</span>, dan <span class="font-lg font-bold">PIHAK KEDUA</span> berhak menerima pembayaran dari <span class="font-lg font-bold">PIHAK PERTAMA</span> sebesar {{convertToRupiah(procurement.contract.offer)}} ({{angkaTerbilang(procurement.contract.offer)}} rupiah).</div>
                        <div class="indent-10 mt-3">Demikian Berita Acara Pembayaran ini dibuat untuk dapat digunakan sebagaimana mestinya.</div> -->
                        <div class="text-end mt-14">Lampung Selatan, {{getSimpleDate(procurement.contract.date_sp)}}</div>
                        <div class="flex justify-between  mb-5">
                            <div class="flex flex-col text-left">
                                <div class="">Untuk dan atas nama</div>
                                <div class="">Institut Teknologi Sumatera</div>
                                <div class="">Pejabat Pembuat Komitmen</div>
                                <div class="font-bold mt-14">{{procurement.executor.ppk.name}}</div>
                                <div class="font-bold ">{{procurement.executor.ppk.identity_type}}. {{procurement.executor.ppk.identity_number}}</div>
                            </div>
                            <div class="flex flex-col text-end ">
                                <div >Menerima dan menyetujui</div>
                                <div >Untuk dan atas nama</div>
                                <div >{{procurement.suppliers.name}}</div>
                                <div class="font-bold mt-14">{{procurement.contract.pic}}</div>
                                <div class="font-bold ">{{procurement.contract.pic_position}}</div>
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
    },
    title : {
        tipe : String
    }
})
    
moment.updateLocale('en', {
    months : [
        "Januari", "Feruari", "Maret", "April", "Mei", "Juni", "Juli",
        "Agustus", "September", "Oktober", "November", "Desember"
    ],
    weekdays : [
    "Minggu", "Senin", "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu"
]
});

const getDate = (date) =>{
    return moment(date, 'YYYY-MM-DD h:mm:ss a').format('DD-MM-YYYY');
}

const getSimpleDate = (date) =>{
    return moment(date, 'YYYY-MM-DD h:mm:ss a').format('DD MMMM YYYY');
    // return moment().format('DD MMMM YYYY');
}

// function convertToRupiah(angka) {
//         var rupiah = "";
//         var angkarev = angka.toString().split("").reverse().join("");
//         for (var i = 0; i < angkarev.length; i++)
//             if (i % 3 == 0) rupiah += angkarev.substr(i, 3) + ".";
//         return (
//             "Rp. " +
//             rupiah
//                 .split("", rupiah.length - 1)
//                 .reverse()
//                 .join("")
//         );
//     }

const exportToPDF = (name,category) => {
        var category = category == 'Barang' ? 'SPP' : 'SPMK'
        html2pdf(document.getElementById("element-to-convert"), {
            margin: 0,
            filename: category + "_" + name + ".pdf",
            image:        { type: 'jpeg', quality: 0.98 },
            html2canvas:  { scale: 2 },
            jsPDF:        { unit: 'in', format: 'a4', orientation: 'portrait' },
        });
    }
</script>