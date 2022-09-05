<template>
    <Master>
        <Container >
        <!-- <h3 class="h3 text-xl font-extrabold tracking-wider">
            {{ info.name }}
        </h3> -->
        <div class="flex max-h-96 mb-10">
            <div class="flex-1 max-w-[50%] p-5 flex place-content-center bg-green-100">
                <!-- <ImgLogin class="object-contain" /> -->
                <!-- <img src="/storage/cek.svg" alt="" /> -->
                <DropZoneImage/>
            </div>
            <div class="flex-1 flex flex-col">
                <h3 class="h3 text-xl font-extrabold tracking-wider">
                    {{ x.itemPreview[1] }}
                </h3>
                <Label value="Spesifikasi" class="mb-3 mt-10" />
                <div class="list-disc overflow-y-auto" style="white-space: pre-wrap;">
                        {{ x.itemPreview[2] }}
                    <!-- ... -->
                </div>
                <div class="flex justify-between mt-10">
                    <button
                        class="btn gap-2 bg-first border-none"
                        :disabled="x.itemPreview[0]==1 ? true : false"
                        @click="prevItemPreview()"
                    >
                        &lt; Sebelumnya
                    </button>
                    <button
                        class="btn gap-2 bg-first border-none"
                        @click="prevItemPreview()"
                    >
                    verifikasi
                    </button>
                    <button
                        class="btn gap-2 bg-first border-none"
                        :disabled="x.itemPreview[0]==(data.length) ? true : false"
                        @click="nextItemPreview()"       
                    >
                        Selanjutnya &gt;
                    </button>
                </div>
            </div>
        </div>
        <div
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
                        {{ convertToRupiaj(x.itemPreview[4]) }}
                    </p>
                </div>
                <div class="ml-5 flex flex-col">
                    <Label value="Jumlah" />
                    <p class="font-bold text-lg tracking-wider">
                        {{ x.itemPreview[3] }} Unit
                    </p>
                </div>
                <div class="flex flex-col basis-1/2 mt-5">
                    <Label value="Total" />
                    <p class="font-bold text-lg tracking-wider">
                        {{ convertToRupiaj(x.itemPreview[5]) }}
                    </p>
                </div>
            </div>
            <Label value="Sumber" class="mt-5" />
            <Input
                class="w-full"
                type="text"
                isDisable
                :value=x.itemPreview[8]
            />
            <div class="flex justify-between">
                <a class="btn btn-xs bg-first border-none" id="visit" :href=x.itemPreview[8] target="_blank">
                    Kunjungi Laman
                </a>
                <button
                    class="btn btn-xs bg-first border-none"
                    id="use"
                >
                    Gunakan Laman
                </button>
            </div>
        </div>
    </Container>
    <EasyDataTable :headers="headers" :items="x.items" buttons-pagination>
            <template #item-aksi="{ id }">
            <!-- <a :href="teamUrl">{{ teamName }}</a> -->
            <button @click="changePreview(id)">Lihat</button>
        </template>
    </EasyDataTable>
    </Master>
</template>

<script setup>
import Master from "@/Layouts/Master.vue";
import Header1 from "../../Components/utils/Header1.vue";
import Container from "../../Components/utils/Container.vue";
import Label from "../../Components/utils/Label.vue";
import Input from "../../Components/utils/Input.vue";
import { ref } from "vue";
import { useForm } from "@inertiajs/inertia-vue3";
import ImgLogin from "@/Components/icons/ImgLogin.vue";
import FilePreview from "@/Components/DropZone/File-Preview.vue";
import DropZoneImage from "../../Components/DropZoneImage/index.vue";

defineProps({
	items: { type: Object, required: true },
})

const x = useForm({
    items: items,
    itemPreview: items[0],
    convert: false,
});

const info = ref([]);
const data = ref([]);

const submit = () => {
    form.post(route("register"), {
        onFinish: () => form.reset("judul", "jenis"),
    });
};

const convertXlxs = (datas,infos) => {
    data.value = datas.value;
    info.value = infos.value;
    x.items = convertToArrObj(datas.value);
    console.log(x.items);
    x.itemPreview = datas.value[0];
    x.convert = !x.convert;
};

const nextItemPreview = () => {
    x.itemPreview=data.value[x.itemPreview[0]]
}

const prevItemPreview = () => {
    x.itemPreview=data.value[x.itemPreview[0]-2]
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
    console.log(id)
    x.itemPreview = data.value[id-1];
}

function onInputChangeImage(e) {
    addFiles(e.target.files);
    e.target.value = null;
}

const headers = [
    { text: "Nama", value: "nama" },
    { text: "Jumlah", value: "jumlah", sortable: true },
    { text: "Status", value: "status", sortable: true },
    { text: "Aksi", value: "aksi", sortable: true },
];
</script>
