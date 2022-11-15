<template>
    <Container
        class="ml-5 card border-2 bg-grey-50 border-dashed border-gray-600 p-5 w-1/3"
    >
        <span class="h3 text-xl font-extrabold tracking-wider flex">
            Data HPS 
            <div v-if="hps.total == 0"></div>
            <span v-else-if="hps.total > items['total']" class="tooltip tooltip-bottom flex text-sm align-bottom text-secondary" data-tip="Lebih mahal dari harga RAB">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trending-up text-secondary ml-3 mr-1"><polyline points="23 6 13.5 15.5 8.5 10.5 1 18"></polyline><polyline points="17 6 23 6 23 12"></polyline></svg>
                {{convertToRupiah(hps.total - items['total'])}}
            </span>
            <span v-else-if="hps.total < items['total']" class="tooltip tooltip-bottom flex text-sm align-bottom text-first" data-tip="Lebih murah dari harga RAB">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trending-down text-first ml-3 mr-1" ><polyline points="23 18 13.5 8.5 8.5 13.5 1 6"></polyline><polyline points="17 18 23 18 23 12"></polyline></svg>
                {{convertToRupiah(items['total'] - hps.total) }}
            </span>
        </span>
        <div class="divider"></div>
        <div class="flex flex-wrap">
            <div class="flex flex-col basis-1/2 pr-5">
                <Label value="Harga Satuan" />
                <Input
                    id="price"
                    type="number"
                    class="mt-1 block w-full"
                    v-model.number="hps.price"
                    min="1000"
                    :status="hps.errors.price"
                    @change="total()"
                    placeholder="Harga Satuan"
                />
                <div v-if="hps.errors.price" class="text-sm text-error mt-1 mb-5">{{ hps.errors.price }}</div>
            </div>

            <div class="flex flex-col">
                <Label value="Jumlah" />
                <p class="font-bold text-lg tracking-wider">
                    {{ items['quantity'] }} {{ items['unit'] }}
                </p>
            </div>
            <div class="flex flex-col basis-1/2 mt-5">
                <Label value="Total" />
                <p class="font-bold text-lg tracking-wider">
                    {{ convertToRupiah(hps.unit*hps.price) }}
                </p>
            </div>
        </div>
        <Label value="Sumber" class="mt-5" />
        <Input
            class="w-full"
            type="text"
            v-model="hps.source"
            @change="onInputChangeSource"
            :status="hps.errors.source"
        />
        <div class="text-sm text-error mt-1 mb-5" v-if="hps.errors.source" >{{ hps.errors.source }}</div>
        <input
            class="mb-5"
            type="file"
            accept=".pdf"
            @input="(e) => onInputChangeFile(e)"
            v-if="!x.fileName || x.status==0"
        />
        <div    v-else class="mb-5">{{x.fileName}}</div>
        <a      v-if="x.status == 0 && hps.file && !hps.source"  class="mb-5 text-sm font-bold text-first underline underline-offset-8" :href="x.fileName" download target="_self">Lihat File {{hps.source}}</a>
        <div class="text-sm text-error mt-1 mb-5" v-if="hps.errors.file" >{{ hps.errors.file }}</div>
        <div class="flex justify-between">
            <a v-show="hps.source" class=" hover:bg-none text-xs text-first underline underline-offset-8 " id="visit" :href="hps.source" target="_blank">
                Kunjungi Sumber
            </a>
            <button
                v-if="(hps.total != 0 && hps.total != null) &&( (hps.source != '' && hps.source != null) || hps.file != null)"
                class="btn btn-xs text-white bg-first border-none  font-bold"
                id="use"
                @click="verifikasi()"
            >
                Verifikasi
            </button>
            <button
                class="btn btn-xs text-first bg-slate-200 border-none hover:text-white hover:bg-first font-bold"
                id="use"
                @click="useRAB()"
            >
                Gunakan Sumber RAB
            </button>
        </div>
    </Container>
</template>

<script setup>
import Container from '@/Components/utils/Container.vue';
import Input from '@/Components/utils/Input.vue';
import Label from '@/Components/utils/Label.vue';
import { useForm } from "@inertiajs/inertia-vue3";
import Notification from "@/Components/composables/Notification"

const props = defineProps({
	items: { type: Object },
})

const emit = defineEmits(['successVerification','editTotal'])
const toast = Notification() 

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

const hps = useForm({
    price   : props.items['estimate_price'],
    unit    : props.items['quantity'],
    source  : props.items['estimate_source'],
    file    : props.items['estimate_file'],
    total   : props.items['estimate_total'],
    status  : 1
});

const isiForm = () => {
    hps.price       = props.items['estimate_price']
    hps.unit        = props.items['quantity']
    hps.source      = props.items['estimate_source']
    hps.file        = props.items['estimate_file']
    hps.total       = props.items['estimate_total']
    hps.status      = 1
}

// function fillForm (){
// }

const x = useForm({
    fileName        : props.items.estimate_file,
    status          : 0
})

const total = () =>{
    hps.total=hps.unit*hps.price
    hps.status  = 0
}

const useRAB = () => {
    hps.unit    = props.items['quantity']
    hps.price   = props.items['price']
    hps.source  = props.items['source']
    hps.file    = null
    hps.status  = 0
    x.status    = 0
    total();
}

const verifikasi = () => {
    hps.post(route('hps.item.updateHPS', props.items['id']),{
        onSuccess   : (e) =>{
            // console.log("succes",props.items)
            emit('editTotal',hps, props.items.estimate_total);
            // console.log("sukses",props.items['id'])
            emit('successVerification', props.items['id'])
            toast('success', 'Berhasil ubah data '+ props.items['name'])
        },
        onError     : (e) => {
            console.log(e)
            toast('error', 'Gagal merubah data '+ props.items['name'])
        },
        onStart     : () => hps.clearErrors(),
        onFinish    : () => {
            isiForm()
            x.reset()
        },
    })

}

function onInputChangeFile(e) {
    x.status=1
    hps.file = e.target.files
    hps.source = ""
    // console.log(e.target.files[0].name)
    x.fileName = e.target.files[0].name
    hps.status  = 0
}

function onInputChangeSource(e) {
    x.fileName  = null;
    hps.file    = null;
    hps.status  = 0
    x.status    = 1
    hps.clearErrors('file')
}
</script>