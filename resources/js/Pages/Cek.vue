<template>
    <div class="flex justify-center  ">
    <div id="app" ref="document" class="w-1/2 border-2 border-black">
    <div id="element-to-convert invisible" >
        <div class="flex tex-center">
            <img :src="'image/logoitera.png'" class="w-28">
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
            <div class="mt-3">Nama Paket</div>
            <div>Tahun Anggaran 2022</div>
            <div>Unit Pengadaan</div>

            <EasyDataTable
                v-model:items-selected="itemsSelected"
                hide-footer
                :headers="headers"
                :items="items"
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
            </EasyDataTable>
        </div>
    </div>
    <button @click="exportToPDF">Export to PDF</button>
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
  { text: "Gambar",         value: "image", width: 50},
  { text: "Jumlah",         value: "unit", width: 20},
  { text: "Satuan",         value: "satuan", width: 20},
  { text: "Spesifikasi",    value: "specification", width: 110}, // set fixed to true
];

defineProps({
    items : {
        tipe : Object
    }
})

// const getNowData = () =>{
//     return moment(props.time, 'YYYY-MM-DD h:mm:ss a').format('DD/MM/YYYY, h:mm:ss a');
// }

// const data = useForm({
//     forceFormData: true,
//     image: null,
// });

// const inputFile = (e) => {
//    data.image = e.target.files[0]
// }

// const verifikasi = () =>{
//     data.post(route("procurementItem.store"),{
//         onSuccess:  () => {console.log("sukses")},
//         onError:    (e) => {console.log(e)}
//     })
// }
</script>