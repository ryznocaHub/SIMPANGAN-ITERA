<template>
    <div class="flex justify-center  ">
        <div id="app" ref="document" class="w-1/2 ">
            <button class="btn bg-first border-none w-full text-white mb-5" @click="exportToPDF(procurement.name)">Download {{type}}</button>
            <div class="border-2 border-black">
                <div id="element-to-convert" >
                    <div class="border-double border-4 mx-16 mt-16 p-5">
                        <div class="text-center font-bold uppercase">
                            <div>SURAT PERINTAH KERJA</div>
                            <div class="">NOMOR: {{procurement.contract.no_spk}}</div>
                            <div class="underline pb-3 mt-10">{{procurement.category}}</div>
                            <div >{{procurement.name}}</div>
                            <div class=" mt-16">ANTARA</div>
                            <div class=" mt-1">INSTITUT TEKNOLOGI SUMATERA</div>
                            <div class=" mt-1">DAN</div>
                            <div class="uppercase">{{procurement.suppliers.entity}}. {{procurement.suppliers.name}}</div>
                        </div>
                        <div class="grid grid-cols-4 font-bold mt-14">
                            <div>NILAI SPK</div>
                            <div class="col-span-3">: {{convertToRupiah(procurement.contract.offer)}} ({{angkaTerbilang(procurement.contract.offer)}})</div>
                            <div>JANGKA WAKTU</div>
                            <div class="col-span-3">: {{procurement.contract.days}} ({{angkaTerbilang(procurement.contract.days)}}) Hari Kalender ({{moment( procurement.contract.date_start_spk, 'YYYY-MM-DD').format('DD-MM-YYYY')}} s/d {{moment(procurement.contract.date_end_spk, 'YYYY-MM-DD').format('DD-MM-YYYY')}})</div>
                            <div>MAK</div>
                            <div class="">: {{procurement.contract.mak_code}}</div>
                        </div>
                        <div class="flex justify-center mt-16">
                            <img :src="'/image/logoitera.png'" class="w-36">
                        </div>
                        <div class="text-center font-bold mt-16">INSTITUT TEKNOLOGI SUMATERA</div>
                        <div class="text-center font-bold">TAHUN ANGGARAN {{procurement.year}}</div>
                    </div>
                    <div id="page2">

                        <slot/>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>


<script setup>
import Input from "@/Components/utils/Input.vue";
import moment from 'moment';
import html2pdf from "html2pdf.js";
import angkaTerbilang from '@develoka/angka-terbilang-js';

const exportToPDF = (name) => {
    html2pdf(document.getElementById("element-to-convert"), {
        margin      : 0,
        filename    : "SPK_" + name + ".pdf",
        image       : { type: 'jpeg', quality: 0.98 },
        html2canvas : { scale: 2 },
        jsPDF       : { unit: 'in', format: 'a4', orientation: 'portrait' },
        pagebreak   : { mode: 'legacy', before: ['#page2' ,'#signature', '#rule' ,'.break'] }
    })
}

defineProps({
    procurement : {
        tipe : Object
    },
    type : {
        tipe: String
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
        
</script>