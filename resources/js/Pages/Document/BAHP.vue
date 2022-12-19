<template>
    <div class="flex justify-center  ">
        <div id="app" ref="document" class="w-1/2 ">
            <button class="btn bg-first border-none w-full text-white mb-5" @click="exportToPDF(procurement.name)">Download BAHPL</button>
            <div class="border-2 border-black">
                <div id="element-to-convert" >
                    <Kop/>
                    <div class="mx-10">
                        <div class="font-bold text-lg text-center mt-10">BERITA ACARA HASIL PENGADAAN LANGSUNG</div>
                        <div class=" text-center">Nomor : {{procurement.contract.no_bahp}}</div>
                        <div class=" text-center my-5 font-bold">{{procurement.name}}</div>
                        <div class=" text-center">Hari/Tanggal : {{getDate(procurement.contract.date_bahp)}}</div>
                        <div class=" text-center">Tempat : Institut Teknologi Sumatera</div>
                        <div class="indent-10 mt-10 text-justify">
                            Berdasarkan Berita Acara Negosiasi Pejabat Pengadaan Institut Teknologi Sumatera telah menyelenggarakan proses Pengadaan Langsung dengan metode evaluasi penawaran, dengan hasil ditetapkan penyedia barang pekerjaan diatas adalah sebagai berikut:
                        </div>
                        <div class="flex mt-2 ml-10">
                            <div class="font-bold">1.</div>
                            <div class="font-bold ml-3 w-36 ">Nama Penyedia</div>
                            <div class="pl-3">: {{procurement.suppliers.name}}</div>
                        </div>
                        <div class="flex mt-2 ml-10">
                            <div class="font-bold">2.</div>
                            <div class="font-bold ml-3 w-36 ">Alamat</div>
                            <div class="pl-3">: {{procurement.suppliers.address + ', ' + procurement.suppliers.regency + ', ' + procurement.suppliers.province}}</div>
                        </div>
                        <div class="flex mt-2 ml-10">
                            <div class="font-bold">3.</div>
                            <div class="font-bold ml-3 w-36 ">NPWP</div>
                            <div class="pl-3">: {{procurement.suppliers.npwp}}</div>
                        </div>
                        <div class="flex mt-2 ml-10">
                            <div class="font-bold">4.</div>
                            <div class="font-bold ml-3 w-36 ">Jenis Pekerjaan</div>
                            <div class="pl-3">: {{procurement.category}}</div>
                        </div>
                        <div class="flex mt-2 ml-10">
                            <div class="font-bold">5.</div>
                            <div class="font-bold ml-3 w-36 ">Lokasi Pekerjaan</div>
                            <div class="pl-3">: Institut Teknologi Sumatera</div>
                        </div>
                        <div class="flex mt-2 ml-10">
                            <div class="font-bold">6.</div>
                            <div class="font-bold ml-3 w-36 ">Nilai HPS</div>
                            <div class="pl-3">: {{convertToRupiah(procurement.estimate.total)}}</div>
                        </div>
                        <div class="flex mt-2 ml-10">
                            <div class="font-bold">7.</div>
                            <div class="font-bold ml-3 w-36 ">Harga Negoisasi</div>
                            <div class="pl-3">: {{convertToRupiah(procurement.contract.offer)}}</div>
                        </div>
                        <div class="flex mt-2 ml-10">
                            <div class="font-bold">8.</div>
                            <div class="font-bold ml-3 w-36 ">Sumber Dana</div>
                            <div class="pl-3">: PNPB {{procurement.year}}</div>
                        </div>
                        <div class="indent-10 mt-3 text-justify">Demikian Berita Acara Hasil Pengadaan Langsung ini dibuat dengan tanggung jawab dan agar dapat digunakan sebagaimana mestinya.</div>
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
            filename: "BAHP_" + name + ".pdf",
            image:        { type: 'jpeg', quality: 0.98 },
            html2canvas:  { scale: 2 },
            jsPDF:        { unit: 'in', format: 'a4', orientation: 'portrait' },
        });
    }
</script>