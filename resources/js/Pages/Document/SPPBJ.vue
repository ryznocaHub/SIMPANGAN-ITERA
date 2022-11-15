<template>
    <div class="flex justify-center  ">
        <div id="app" ref="document" class="w-1/2 ">
            <button class="btn bg-first border-none w-full text-white mb-5" @click="exportToPDF(procurement.name)">Download SPPBJ</button>
            <div class="border-2 border-black">
                <div id="element-to-convert" >
                    <Kop/>
                    <div class="mx-10">
                        <div class="flex justify-between mt-5">
                            <div>
                                <div >Nomor &nbsp;&nbsp;&nbsp;&nbsp;  : {{procurement.contract.no_sppbj}}</div>
                                <div>Lampiran &nbsp;: -</div>
                                <div >Hal &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; : {{procurement.contract.purpose_sppbj}}</div>
                            </div>
                            <div>
                                <!-- Lampung Selatan, {{getDate(procurement.contract.date_sppbj)}} -->
                                Lampung Selatan, {{getDate(procurement.contract.date_sppbj)}}
                            </div>
                        </div>
                        <div class="mt-10">Yth.</div>
                        <div>{{procurement.suppliers.name}}</div>
                        <div>di</div>
                        <div>{{procurement.suppliers.province}}</div>
                        <div class="indent-10 mt-10 text-justify">
                            Dengan ini kami beritahukan bahwa penawaran Saudara nomor {{procurement.contract.no_offer}} tanggal {{getDate(procurement.contract.date_offer)}} perihal penawaran pekerjaan {{procurement.name}} dengan hasil negosiasi harga sebesar {{convertToRupiah(procurement.contract.offer)}} kami nyatakan diterima/disetujui.
                        </div>
                        <div class="indent-10 mt-5 text-justify">
                            Sebagai tindak lanjut dari Surat Penunjukan Penyedia Barang/Jasa (SPPBJ) ini, Saudara diharuskan menandatangani Surat Perintah Kerja (SPK) paling lambat 14 (empat belas) hari kerja setelah diterbitkannya SPPBJ. Kegagalan Saudara untuk menerima penunjukan ini yang disusun berdasarkan evaluasi terhadap penawaran Saudara, akan dikenakan sanksi sesuai ketentuan dalam Peraturan Presiden nomor 12 tahun 2021 tentang Pengadaan Barang/Jasa Pemerintah.
                        </div>
                        <div class="grid place-items-end mt-14" id="signature">
                            <div class="w-6/12 flex flex-col align-end text-center">
                                <div>
                                    <div>Pejabat Pembuat Komitmen</div>
                                    <div>Institut Teknologi Sumatera</div>
                                </div>
                                <div>
                                    <div class="mt-20">{{procurement.executor.ppk.name}}</div>
                                    <div class="" >{{procurement.executor.ppk.identity_type}}. {{procurement.executor.ppk.identity_number}}</div>
                                </div>
                            </div>
                        </div>
                        <div class="mt-14 mb-10">
                            <div>
                                Tembusan:
                            </div>
                            <div>
                                1. Kuasa Pengguna Anggaran Institut Teknologi Sumatera.
                            </div>
                            <div class="text-justify">
                                2. Aparat Pengawas Intern Pemerintah Kementerian Pendidikan, Kebudayaan, Riset, Dan Teknologi.
                            </div>
                            <div>
                                3. Pejabat Pengadaan Institut Teknologi Sumatera.
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

defineProps({
    procurement : {
        tipe : Object
    }
})

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
    return moment(date, 'YYYY-MM-DD h:mm:ss a').format('DD MMMM YYYY');
    // return moment().format('DD MMMM YYYY');
}

const getSimpleDate = (date) => {
    return moment().format('DD-MM-YYYY');
}

const exportToPDF = (name) => {
        html2pdf(document.getElementById("element-to-convert"), {
            margin: 0,
            filename: "SPPBJ_" + name + ".pdf",
            image:        { type: 'jpeg', quality: 0.98 },
            html2canvas:  { scale: 2 },
            jsPDF:        { unit: 'in', format: 'a4', orientation: 'portrait' },
        });
    }
</script>