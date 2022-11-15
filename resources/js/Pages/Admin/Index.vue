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
                <div v-if="data.preview" class="w-6/12  ml-5  ">
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
                                <Link @click="loading()" :href="route('admin.procurement.show', id)" class="btn btn-xs text-first bg-slate-200 border-none hover:text-white hover:bg-first font-bold" >Lihat</Link>
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
            <div class="flex justify-between items-center">
                <div class="w-5/12">
                    <div class="flex ">
                        <span class="flex h-5 w-5 relative justify-center items-center">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-error opacity-75 delay-200"></span>
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-none border-error border-2 border-solid delay-75"></span>
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-none border-error border-2 border-solid"></span>
                            <span class="right-0 relative inline-flex rounded-full h-3 w-3 bg-error"></span>
                        </span>
                        <div class="text-4xl font-extrabold tracking-widest text-first drop-shadow-xl flex ">Institut</div>
                    </div>
                    <div class="ml-5 text-4xl font-extrabold mb-5 tracking-widest text-first drop-shadow-xl">Teknologi Sumatera</div>
                    <div class="text-lg tracking-wide leading-7">Sebagai salah satu Perguruan Tinggi Negeri di Indonesia, ITERA turut melaksanakan kegiatan pengadaan barang dan jasa guna menunjang tercapainya Tridharma Perguruan Tinggi.</div> 
                    <div class="text-lg tracking-wide leading-7">Setidaknya terdapat &#177;50 unit kerja yang melaksanakan kegiatan pengadaan barang dan jasa.</div> 
                </div>
                <div class="w-7/12 grid place-items-center ml-10">
                    <Header1 title="Sebaran Nilai RAB" width-size="100" class="place-self-start"  />
                    <Container class=" mt-0 w-full">
                        <Line
                            :chart-options="chartLineOptions"
                            :chart-data="data.cek"
                            :height="200"
                        />
                    </Container>
                    <Header1 title="Filter Data" width-size="100" class="place-self-start mt-8"  />
                    <div class="flex justify-between">
                        <Container class=" w-6/12 flex flex-col justify-between">
                            <div>
                                <div>Filter Berdasarkan Jangkauan Tanggal</div>
                                <div class="flex justify-center mb-5 mt-5" :class="{'mb-5' : !data.error}">
                                    <Datepicker 
                                        v-model="data.start" 
                                        :enableTimePicker="false"  
                                        format='dd-MM-yy'
                                        :maxDate="new Date()"
                                        :monthChangeOnScroll="false"
                                        autoApply 
                                        @update:modelValue="() => {data.year = null; data.month = null}"
                                    />
                                    <span class="mx-5 font-bold text-lg">-</span>
                                    <Datepicker 
                                        v-model="data.end" 
                                        :enableTimePicker="false"  
                                        format='dd-MM-yy'
                                        :maxDate="new Date()"
                                        :monthChangeOnScroll="false"
                                        autoApply 
                                        @update:modelValue="() => {data.year = null; data.month = null}"
                                    />
                                </div>
                                <div class="text-error text-sm mb-5 mt-2" v-if="data.error" >{{data.error}}</div>
                            </div>
                            <button @click="filterObj()" class="btn btn-sm mt-8 text-first bg-slate-200 border-none hover:text-white hover:bg-first font-bold">Filter</button>
                        </Container>
                        <Container class="w-4/12 flex-col justify-between">
                            <div>
                                <div class="mb-3">Filter Berdasarkan Bulan</div>
                                <Datepicker 
                                    v-model="data.month" 
                                    :enableTimePicker="false"  
                                    format="MMMM"
                                    :maxDate="new Date()"
                                    :monthChangeOnScroll="false"
                                    autoApply 
                                    monthPicker 
                                    monthNameFormat="long" 
                                    @update:modelValue="() => {data.year = null; data.start = null; data.end = null}"
                                />
                            </div>
                            <!-- <div class="mt-5">Filter Berdasarkan Tahun</div>
                            <Datepicker 
                                v-model="data.year" 
                                :enableTimePicker="false"  
                                format="yyyy"
                                :maxDate="new Date()"
                                :monthChangeOnScroll="false"
                                autoApply 
                                yearPicker  
                                @update:modelValue="() => {data.month = null; data.start = null; data.end = null}"
                            /> -->
                            <div class="text-error text-sm  mt-2" v-if="data.error2" >{{data.error2}}</div>
                            <button @click="filterObj2()" class="btn btn-sm mt-8 text-first bg-slate-200 border-none hover:text-white hover:bg-first font-bold">Filter</button>
                        </Container>
                    </div>
                </div>
            </div>
        </template>

    </Master>
</template>

<script setup>
import Master from "@/Layouts/Master.vue";
import Container from "@/Components/utils/Container.vue";
import Input from "@/Components/utils/Input.vue";
import { Bar, Line } from 'vue-chartjs'
import { useForm, Link } from "@inertiajs/inertia-vue3";
import Header1 from "@/Components/utils/Header1.vue";
// import BarChart from "./chart.json"
import Dashboard from "/public/image/dashboard/dashboard.json"
import Datepicker from '@vuepic/vue-datepicker';
import '@vuepic/vue-datepicker/dist/main.css'
import moment from 'moment';

import { Chart as ChartJS, Title, Tooltip, BarElement, CategoryScale, LinearScale, LineElement, PointElement } from 'chart.js'

ChartJS.register(Title, Tooltip, BarElement, CategoryScale, LinearScale, LineElement, PointElement)

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


function filterLength (datas) {
    var arr = []

    for (let i = 2; i < 11; i++) {
        if(datas[i]) arr.push(datas[i].length)
        else arr.push(0)
    }
    return arr
}

function filterData (datas) {
    var arr = []
    for (const data in datas) {
        arr.push(datas[data].id)
    }
    // console.log(arr)
    return arr
}

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

var chartLineData = {
    labels: filterData(props.procurements.data),
    datasets: [
        {
            data: props.procurements.data,
            tension: 0.3,
            borderColor: 'rgb(34,211,238)',
            pointBackgroundColor: '#ff7674',
            pointHoverBorderWidth: 10,
            pointBorderColor: 'rgb(255, 118, 116, 0.4)',
            pointBorderWidth: 4,
            borderWidth: 2,
            backgroundColor: '#ffd700',
            fill: true,
        }
    ]
}

const data = useForm({
    preview : null,
    start   : null,
    end     : null,
    month   : null,
    year    : null,
    error   : '',
    error2   : '',
    show    : 0,
    cek     : chartLineData
})

const label = ['RAB Masuk', 'Revisi RAB', 'Penunjukan Tim HPS', 'Pembuatan HPS', 'Pengecekan HPS', 'Revisi HPS', 'Penunjukan Supplier', 'Proses Kontrak', 'Pengadaan Selesai']

const chartData = {
    labels: [1,2,3,4,5,6,7,8,9],
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
            title :{
                text : 'Fase Pengadaan',
                display: true,
            }
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
        data.preview    = props.groupedProc[array[0].index + 2]
        data.show       = 1
        // console.log(data.preview)
    }
    
}

const all = () => {
    data.preview = props.groupedProc
    data.show = 0
} 

const chartLineOptions = {
    responsive: true,
    maintainAspectRatio: false,
    parsing: {
        xAxisKey: 'id',
        yAxisKey: 'total'
    },
    scales: {
        y: {
            ticks: {
                // Include a dollar sign in the ticks
                // beginAtZero: true,
                callback: function(value) {if (value % 10000000 === 0) {return (value / 1000000) + " Jt"}
                }
            },
            title :{
                text : 'Nilai RAB',
                display: true,
            }
        },
        x: {
            ticks:{
                display: false
            }
        }
    },
    plugins:{
        tooltip: {
            callbacks: {
                title: function(context) {
                    // console.log("title",context[0].raw.name)
                    return context[0].raw.name;
                },

                label: function(context) {
                    // console.log("label",context)
                    return "Rp. " + context.formattedValue;
                },
                // afterFooter: function() {
                //     return 'Klik untuk melihat'
                // }
            }
        },
        filler: {
            drawTime: 'beforeDraw'
        }
    },
    elements: {
        line: {
            fill: true,
            backgroundColor: 'rgb(186,230,253, 0.2)',
        }
    },
    datasets: {
        line: {
            fill: true,
            backgroundColor: 'rgb(186,230,253, 0.2)',
        }
    }
}

const  filterObj = () => {
    if (data.start == null || data.end == null) {
        data.error = "Kedua Field jangkauan tanggal harus terisi"
        return 
    }
    if (data.start > data.end ){
        data.error = "Field Jangkauan Awal harus lebih kecil"
        return
    }

    data.error = ""
    data.error2 = ""
    var temp = props.procurements.data.filter(function (x) {
        return moment(data.start) < moment(x.date) && moment(data.end) > moment(x.date)
    });
    
    data.cek = {
        labels: filterData(temp),
        datasets: [
            {
                backgroundColor: '#f87979',
                data: temp
            }
        ]
    }
}

const  filterObj2 = () => {
    if (data.year == null && data.month == null) {
        data.error2 = "Salah satu field harus terisi"
        return 
    }
    // console.log(data.year, data.month)

    data.error = ""
    data.error2 = ""
    
    
    var temp = props.procurements.data.filter(function (x) {
        // console.log(data.month && true)
        // console.log(moment(x.date).isSame(data.month, 'month') && true)
        if(data.month) return data.month && moment(x.date).isSame(data.month, 'month')
        // else if (data.year) return data.year && moment(x.date).isSame(data.year, 'year')
        console.log(data.year)
        console.log(moment(x.date).isSame(data.year, 'year'))
        // console.log("year",moment(x.date).isSame(data.year, 'year'))
        // console.log("month", moment(x.date).isSame(data.month, 'month'))
    });
    
    data.cek = {
        labels: filterData(temp),
        datasets: [
            {
                backgroundColor: '#f87979',
                data: temp
            }
        ]
    }
}

const headers = [
    { text: "Tanggal",          value: "date"   , sortable: true },
    { text: "Nama Paket PL",    value: "name"   , sortable: true },
    { text: "Unit Kerja",       value: "unit"   , sortable: true },
    { text: "Nilai RAB",        value: "total"  , sortable: true },
    { text: "aksi",             value: "aksi"},
];

</script>

<style></style>
