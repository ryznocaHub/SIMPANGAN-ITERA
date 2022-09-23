<template>
    <Master>
        <div v-if="x.items.length != 0">
            <div >
            <!-- <h3 class="h3 text-xl font-extrabold tracking-wider">
                {{ info.name }}
            </h3> -->
            <div class="flex max-h-96 mb-10">
                <div class="flex-1 max-w-[50%] p-5 flex place-content-center">
                    <div class="grid place-items-center">
                        <img class="max-w-full min-h-80 max-h-80" :src="x.itemPreview['image']" />
                    </div>
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
                            class="btn text-white bg-first border-none  font-bold"
                            :disabled="x.currentIndex == 0 ? true : false"
                            @click="prevItemPreview(x.itemPreview['id'])"
                        >
                            &lt; Sebelumnya
                        </button>
                        <!-- class="btn gap-2 bg-first border-none" -->
                        <button
                            class="btn text-white bg-first border-none  font-bold"
                            :disabled="x.currentIndex == x.items.length-1 ? true : false"
                            @click="nextItemPreview(x.itemPreview['id'])"       
                        >
                            Selanjutnya &gt;
                        </button>
                    </div>
                </Container>
            </div>
            <div class="flex">
                <InfoDetail :items=x.itemPreview :status="1" />
                <slot :data=x.itemPreview :successVerification="verification" />
            </div>
        </div>
            <Container class="mt-10">
                <Header1 title="Daftar Item" :widthSize=60 />
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
        <div v-else>
            <slot name="status" :cek="cek()" />
        </div>
    </Master>
</template>

<script setup>
import Master from "@/Layouts/Master.vue";
import Container from "@/Components/utils/Container.vue";
import Label from "@/Components/utils/Label.vue";
import Header1 from "@/Components/utils/Header1.vue";
import Input from "@/Components/utils/Input.vue";
import { ref } from "vue";
import { useForm } from "@inertiajs/inertia-vue3";
// File Management
import { Inertia } from "@inertiajs/inertia";
import InfoDetail from "@/Components/InfoDetail/Index.vue";

const props = defineProps({
	items: { type: Object },
})

const x = useForm({
    items : props.items,
    itemPreview: props.items[0],
    currentIndex: 0,
    errFunction : 0
});

const cek = () =>{
    console.log(x.items == null)
}

const nextItemPreview = () => {
    x.itemPreview = x.items[++x.currentIndex];
}

const prevItemPreview = () => {
    x.itemPreview = x.items[--x.currentIndex];
}

function verification (id) {
    const succesID = x.items.map(object => object.id).indexOf(x.itemPreview['id']);
    if(succesID == x.items.length -1){
        prevItemPreview();
    }else{
        nextItemPreview();
    }
    
    x.items = x.items.filter(function (item) {
        return item.id != id;
    });
    x.currentIndex = x.items.map(object => object.id).indexOf(x.itemPreview['id']);
    console.log(x.items)
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

function changePreview(id){
    // console.log("index",x.items.map(object => object.id).indexOf(id))
    x.currentIndex = x.items.map(object => object.id).indexOf(id);
    x.itemPreview = x.items[x.currentIndex];
}

const headers = [
    { text: "Nama", value: "name" },
    { text: "Jumlah", value: "unit", sortable: true },
    { text: "Status", value: "status", sortable: true },
    { text: "Aksi", value: "aksi", sortable: true },
];
</script>
