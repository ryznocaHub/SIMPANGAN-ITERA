<template>
    <Master>
        <div v-if="x.items.length == 0">
            <StatusRedirect text="Anda sudah mengunggah semua gambar. Silahkan ajukan RAB">
                <button
                    class="btn gap-2 bg-first border-none"
                    @click="confirm()"       
                >
                    Ajukan RAB
                </button>
            </StatusRedirect>
        </div>

        <div v-else>
            <div >
            <!-- <h3 class="h3 text-xl font-extrabold tracking-wider">
                {{ info.name }}
            </h3> -->
            <div class="flex max-h-96 mb-10">
                <div class="flex-1 max-w-[50%] p-5 flex place-content-center">
                    <!-- <ImgLogin class="object-contain" /> -->
                    <!-- <img src="/storage/cek.svg" alt="" /> -->
                    <div class="grid place-items-center" v-if="x.itemPreview['image'] != null">
                        <img class="max-w-full min-h-80 max-h-80" :src="x.itemPreview['image']" />
                    </div>
                    <DropZoneImage  :files=files  @addFiles="insertImage" :info=info @removeFile="deleteImage" v-else/>
                </div>
                <Container class="flex-1 flex flex-col">
                    <h3 class="h3 text-xl font-extrabold tracking-wider">
                        {{ x.itemPreview['name'] }}
                    </h3>
                    <Label value="Spesifikasi" class="mb-3 mt-10" />
                    <div class="list-disc overflow-y-auto" style="white-space: pre-wrap;">
                            {{ x.itemPreview['specification'] }}
                    </div>
                    <div class="flex justify-between mt-10">
                        <button
                            class="btn text-first bg-slate-200 border-none hover:text-white hover:bg-first font-bold"
                            :disabled="x.orderArr[0] == x.itemPreview['id'] ? true : false"
                            @click="prevItemPreview(x.itemPreview['id'])"
                        >
                            &lt; Sebelumnya
                        </button>
                        <button
                            v-show="data.image"
                            class="btn text-white bg-first border-none font-bold"
                            @click="verifikasi()"
                        >
                        verifikasi
                        </button>
                        <button
                            class="btn text-first bg-slate-200 border-none hover:text-white hover:bg-first font-bold"
                            :disabled="x.orderArr[x.orderArr.length-1]==(x.itemPreview['id']) ? true : false"
                            @click="nextItemPreview(x.itemPreview['id'])"       
                        >
                            Selanjutnya &gt;
                        </button>
                    </div>
                </Container>
            </div>
            <Container
                class="card border-2 bg-grey-50 border-dashed border-gray-600 p-5 w-1/3"
            >
                <h3 class="h3 text-xl font-extrabold tracking-wider">
                    Data RAB
                </h3>
                <div class="divider"></div>
                <div class="flex flex-wrap">
                    <div class="flex flex-col basis-1/2">
                        <Label value="Satuan" />
                        <p class="font-bold text-lg tracking-wider">
                            {{ convertToRupiaj(x.itemPreview['price']) }}
                        </p>
                    </div>
                    <div class="ml-5 flex flex-col">
                        <Label value="Jumlah" />
                        <p class="font-bold text-lg tracking-wider">
                            {{ x.itemPreview['unit'] }} Unit
                        </p>
                    </div>
                    <div class="flex flex-col basis-1/2 mt-5">
                        <Label value="Total" />
                        <p class="font-bold text-lg tracking-wider">
                            {{ convertToRupiaj(x.itemPreview['total']) }}
                        </p>
                    </div>
                </div>
                <Label value="Sumber" class="mt-5" />
                <Input
                    class="w-full"
                    type="text"
                    isDisable
                    :value="x.itemPreview['source']"
                />
                <div class="flex justify-between">
                    <a class="hover:bg-none text-xs text-first underline underline-offset-8 " id="visit" :href=x.itemPreview[8] target="_blank">
                        Kunjungi Laman
                    </a>
                    <!-- <button @click="cek()">cek</button> -->
                </div>
            </Container>
            </div>
            <Container class="mt-10">
                <Header1 title="Daftar Item" widthSize="60" />
                <EasyDataTable :headers="headers" :items="x.items" buttons-pagination>
                    <template #item-aksi="{ id }">
                    <!-- <a :href="teamUrl">{{ teamName }}</a> -->
                        <button @click="changePreview(id)">Lihat</button>
                    </template>
                    <template #item-status="{ image }">
                        <div v-if="image"> terverifikasi </div>
                        <div v-else> tertunda </div>
                    </template>
                </EasyDataTable>
            </Container>
        </div>
    </Master>
</template>

<script setup>
import Master from "@/Layouts/Master.vue";
import Container from "@/Components/utils/Container.vue";
import Label from "@/Components/utils/Label.vue";
import Header1 from "@/Components/utils/Header1.vue";
import Input from "@/Components/utils/Input.vue";
import { useForm } from "@inertiajs/inertia-vue3";
import FilePreview from "@/Components/DropZone/File-Preview.vue";
import DropZoneImage from "@/Components/DropZoneImage/index.vue";
import StatusRedirect from "@/Components/StatusRedirect/index.vue"
// File Management
import useFileList from '@/Components/composables/Dropzone-Image'
import ImgComplete from "@/Components/icons/imgComplete.vue";
import { Inertia } from "@inertiajs/inertia";

const { files, info, addFiles, removeFile } = useFileList()

const props = defineProps({
	items: { type: Object },
    id: {type: Number}
})

const x = useForm({
    items : props.items,
    itemPreview: props.items[0],
    orderArr: convertToOrderOfArray(props.items)
});

const data = useForm({
    forceFormData: true,
    _method: 'patch',
    image: null
});

const verifikasi = () =>{
    data.post(route("unit.item.update",parseInt(x.itemPreview['id'])),{
        onSuccess:  () => { 
            const id = x.itemPreview['id'];
            if(x.itemPreview['id'] == x.orderArr[x.orderArr.length - 1]){
                prevItemPreview(x.itemPreview['id']);
            }else{
            // }else if(x.itemPreview['id'] == x.orderArr[0]){
                nextItemPreview(x.itemPreview['id']);
            }

            x.orderArr = x.orderArr.filter(function(value, index, arr){ 
                return value != id;
            });
            x.items = x.items.filter(function (item) {
                return item.id != id;
            });
        },
        onError:    (e) => {console.log(e)}
    })
}

const dataConfirmation = useForm({
    _method: 'patch',
    status: 2,
})

const confirm = () => {
    console.log("props",props.id)
    dataConfirmation.post(route('unit.procurement.update',props.id),{
        onSuccess : () => {
            console.log("sukses ajukan RAB")
        },
        onError: () => {
            console.log("gagal ajukan RAB")
        }
    });
}

const cek = () => {
    console.log("image",data.image)
}

const insertImage = (file) => {
    addFiles(file);

    if(info.value.status != 9){
        data.image = file[0];   
    }
}

const deleteImage = () => {
    removeFile(files.value[0]);
    data.image = null;
}

const nextItemPreview = (id) => {
    const start = x.items.map(object => object.id).indexOf(id) + 1
    deleteImage();
    var next = 0;
    for (let index = start; index < x.items.length; index++) {
        if(x.items[index]['image'] == null) {
            next = index;
            break;
        }
    }
    x.itemPreview = x.items[next];
    console.log("finish")
}

const prevItemPreview = (id) => {
    const start = x.items.map(object => object.id).indexOf(id)
    deleteImage();
    var prev = 0;
    for (let index = start; index > 0; index--) {
        if(x.items[index]['image'] == null) {
            prev = index-1;
            break;
        }
    }
    x.itemPreview = x.items[prev];
    console.log("finish")
}

function convertToRupiaj(angka) {
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

function convertToArrObj(collection) {
    var obj = [];
    collection.map(function (row) {
        obj.push({
            id:row[0],
            nama: row[1],
            jumlah: row[3],
            status: false,
        });
    });

    return obj;
}

function changePreview(id){
    deleteImage();
    x.itemPreview = x.items[id-1];
}

function onInputChangeImage(e) {
    addFiles(e.target.files);
    e.target.value = null;
}

function convertToOrderOfArray(arr){
    var list = []
    arr.map(function (row) {
        list.push(row['id']);
    });
    return list;
}


const headers = [
    { text: "Nama", value: "name" },
    { text: "Jumlah", value: "unit", sortable: true },
    { text: "Status", value: "status", sortable: true },
    { text: "Aksi", value: "aksi", sortable: true },
];
</script>
