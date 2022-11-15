<template>
    <Master>
        <template v-slot="{ loading }" }>
            <Vue3Lottie :animationData="Dashboard" :height="450" :width="700" />

            <div class="flex justify-between items-center h-screen mt-10">
    
                <div class="w-6/12 " >
                    <Header1 title="Status Pengadaan" width-size="100" class="" />
                    <Container >
                        <Bar
                            :chart-options="chartOptions"
                            :chart-data="chartData"
                            :width="width"
                            :height="height"
                        />
                    </Container>
                </div>
                <div v-if="data.preview.length > 0" class="w-6/12  ml-5  ">
                    <div class="flex justify-between">
                        <Header1 title="Daftar Pengadaan" width-size="100" />
                        <button @click="() => data.preview = null" class="btn btn-sm  text-first bg-slate-200 border-none hover:text-white hover:bg-first font-bold" >X</button>
                    </div>
                    <Container  >
                        <!-- <button @click="all()"  class=" w-3/12 btn btn-sm mb-3 text-first bg-slate-200 border-none hover:text-white hover:bg-first font-bold" >Lihat Semua</button> -->
                        <EasyDataTable 
                        :headers="headers" 
                        :items="data.preview" 
                        table-class-name="customize-table"
                        sortBy="status"
                        sortType="asc" 
                        :rows-per-page="5"
                        :maxPaginationNumber="10"
                        buttons-pagination>
                            <template #item-date="{ date }">
                                {{moment(date).format('DD-MM-yy')}}
                            </template>
                            <template #item-total="{ total }">
                                {{convertToRupiah(total)}}
                            </template>
                            <template #item-aksi="{ id }">
                                <Link @click="loading()" :href="route('kontrak.procurement.show', id)" class="btn btn-xs text-first bg-slate-200 border-none hover:text-white hover:bg-first font-bold" >Lihat</Link>
                            </template>
                        </EasyDataTable>
                    </Container>
    
                </div>
                <!-- <img  src="/image/dashboard/Data.svg" class="w-3/12 h-3/12"/> -->
                <!-- <Vue3Lottie v-else :animationData="BarChart" :height="450" :width="450" /> -->
                <div v-else class="w-5/12 text-right ">
                    <div class="flex justify-end ">
                        <div class="text-right text-4xl font-extrabold tracking-widest text-first drop-shadow-xl flex ">Pengadaan</div>
                        <span class="flex h-5 w-5 relative justify-center items-center">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-error opacity-75 delay-200"></span>
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-none border-error border-2 border-solid delay-75"></span>
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-none border-error border-2 border-solid"></span>
                            <span class="right-0 relative inline-flex rounded-full h-3 w-3 bg-error"></span>
                        </span>
                    </div>
                    <div class="text-right mr-5 text-4xl font-extrabold mb-5 tracking-widest text-first drop-shadow-xl">Barang dan Jasa</div>
                    <div class="text-lg tracking-wide leading-7">adalah kegiatan Pengadaan Barang / Jasa oleh Kementerian / Lembaga / Perangkat Daerah yang dibiayai oleh APBN/APBD yang prosesnya sejak identifikasi kebutuhan, sampai dengan serah terima hasil pekerjaan.</div> 
                </div>
            </div>
        </template>
    </Master>
</template>

<script setup>

import Master from "@/Layouts/Master.vue";
import Container from "../../Components/utils/Container.vue";
import Header1 from "@/Components/utils/Header1.vue";
import { Bar } from 'vue-chartjs'
import { useForm, Link } from "@inertiajs/inertia-vue3";
import moment from 'moment';
import Dashboard from "/public/image/dashboard/dashboard.json"

import { Chart as ChartJS, Title, Tooltip, BarElement, CategoryScale, LinearScale } from 'chart.js'

ChartJS.register(Title, Tooltip, BarElement, CategoryScale, LinearScale )


const props = defineProps({ 
    procurements: {
        type: Object
    },
    groupedProc: {
        type: Object
    },
    width: {
      type: Number,
      default: 200
    },
    height: {
      type: Number,
      default: 300
    },
})

function convertToRupiah (angka) {
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

function filterLength (datas) {
    var arr = []
    const lastIndex = 1
    const firstLoop = 9
    const lastLoop  = 9
    //looping count by minimum status (5)
    //first looping must be 5
    for (let i = firstLoop; i < 11; i++) {
        console.log(datas[i])
        if (i > lastLoop ) {
            if(arr[lastIndex] && datas[i] ) arr[lastIndex] = arr[lastIndex] + datas[i].length
            else if(datas[i]) arr.push(datas[i].length)
        }
            
        else if(datas[i]) arr.push(datas[i].length)
        else arr.push(0)
    }
    return arr
}
const data = useForm({
    preview : [],
    start   : null,
    end     : null,
    month   : null,
    year    : null,
    error   : '',
    error2   : '',
    show    : 0,
})

const label = ['Pembuatan Dokumen', 'Kontrak Selesai']

const chartData = {
    labels: label,
    datasets: [
    {
        label: 'Total',
        backgroundColor: [
            'rgb(207,250,254, 0.4)',
            'rgb(255,255,152, 0.3)',
            'rgb(186,230,253, 0.2)',
            'rgb(165,243,252, 0.3)',
            'rgb(103,232,249, 0.3)',
            'rgb(255,255,152, 0.6)',
            'rgb(34,211,238, 0.3)',
            'rgb(56,189,248, 0.4)',
        ],
        borderColor: [
            'rgb(207,250,254, 0.9)',
            'rgb(255,231,138, 0.6)',
            'rgb(186,230,253, 0.4)',
            'rgb(165,243,252, 0.4)',
            'rgb(103,232,249, 0.4)',
            'rgb(255,231,138, 0.6)',
            'rgb(34,211,238, 0.4)',
            'rgb(56,189,248, 0.4)',
        ],
        borderWidth: 2,
        borderRadius: 5,
        data: filterLength(props.groupedProc)
    }
    ]
}

const chartOptions = {
    responsive: true,
    maintainAspectRatio: false,
    scales: {
        y: {
            ticks: {
                // Include a dollar sign in the ticks
                beginAtZero: true,
                callback: function(value) {if (value % 1 === 0) {return value;}}
            },
            title :{
                text : 'Total',
                display: true,
            }
        },
        x: {
            ticks: {
                // display: false,

            },
            // title :{
            //     text : 'Fase Pengadaan',
            //     display: true,
            // }
        },
        
    },
    plugins:{
        tooltip: {
            callbacks: {
                title: function(context) {
                    return label[context[0].dataIndex];
                },
                label: function(context) {
                    // console.log(context)
                    return 'Total : ' + context.formattedValue;
                },
                afterFooter: function() {
                    return 'Klik untuk melihat'
                },
            },
        }
    },
    parsing: {
        xAxisKey: 'id',
    },
    onClick: (event, array) => {
        data.preview = null
        if(array[0].index + 9 >= 10){
            for (let i = 10; i < 11; i++) {
                if(props.groupedProc[i]) {
                    props.groupedProc[i].forEach(item => data.preview.push(item))
                }
            }
        }else{
            data.preview = props.groupedProc[array[0].index+9]
        }
        data.show       = 1
    }
    
}

const headers = [
    { text: "Tanggal",          value: "date"       , sortable: true },
    { text: "Nama",             value: "name"       , sortable: true },
    { text: "Nomor Akun",       value: "account"    , sortable: true },
    { text: "Nilai HPS",        value: "total"      , sortable: true },
    { text: "aksi",             value: "aksi"},
];
</script>

<style></style>
