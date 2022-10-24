<template>
    <div class="flex justify-center  ">
        <div id="app" ref="document" class="w-1/2 ">
            <button class="btn bg-first border-none w-full text-white mb-5" @click="exportToPDF">Download BOQ</button>
            <div class="border-2 border-black">
                <div id="element-to-convert" >
                    <div class="flex tex-center">
                        <img :src="'/image/logoitera.png'" class="w-28">
                        <div class="text-center">
                            <div class="text-lg font-bold">KEMENTERIAN PENDIDIKAN, KEBUDAYAAN, RISET, DAN TEKNOLOGI</div>
                            <div class="text-base font-bold">INSTITUT TEKNOLOGI SUMATERA</div>
                            <div class="text-xs">Jalan Terusan Ryacudu Way Hui, Kecamatan Jati Agung, Lampung Selatan 35365</div>
                            <div class="text-xs">Telepon: (0721) 8030188</div>
                            <div class="text-xs">Email: pusat@itera.ac.id Website: http://itera.ac.id</div>
                        </div>
                    </div>
                    <div class="mt-5 pb-3 align-top text-white w-full bg-black font-bold tracking-widest text-center">BILL OF QUANTITY</div>
                    <div class="px-5 text-sm">
                        <div class="flex justify-between mt-3">
                            <div>
                                <div class="">{{procurement.name}}</div>
                                <div>Tahun Anggaran {{procurement.year}}</div>
                                <div>Unit Kerja {{procurement.unit}}</div>
                            </div>
                            <div>
                                <div class="text-lg font-bold">Total : {{convertToRupiah(procurement.estimate.total)}}</div>
                            </div>
                        </div>
    
                        <!-- <EasyDataTable
                            v-model:items-selected="itemsSelected"
                            hide-footer
                            :headers="headers"
                            :items="procurement.items"
                            border-cell
                            class="mt-3"
                        >
                            <template #item-image="{ image }">
                                <img class="w-25" :src="image" />
                            </template>
                            <template #item-unit="{ unit }">
                                <div>{{unit}}</div>
                            </template>
                            <template #item-satuan >
                                <div>unit</div>
                            </template>
                            <template #item-specification="{ specification }">
                                <div class="mb-2" style="white-space: pre-wrap;">
                                    {{specification}}
                                </div>
                            </template>
                        </EasyDataTable> -->
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
    
    const exportToPDF = () => {
        html2pdf(document.getElementById("element-to-convert"), {
            margin: 0,
            filename: "i-was-html.pdf",
            image:        { type: 'jpeg', quality: 0.98 },
            html2canvas:  { scale: 2 },
            jsPDF:        { unit: 'in', format: 'a4', orientation: 'portrait' }
        });
    }
    
    const headers = [
      { text: "Nama",           value: "name", fixed: true, width: 60, sortable: true }, // set fixed to true
      { text: "Spesifikasi",    value: "specification", width: 110}, // set fixed to true
      { text: "Jumlah",         value: "quantity", width: 20},
      { text: "Satuan",         value: "unit", width: 20},
      { text: "Gambar",         value: "image", width: 50},
    ];
    
    defineProps({
        procurement : {
            tipe : Object,
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