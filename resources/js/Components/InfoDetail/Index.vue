<template>
    <Container
        class="card border-2 bg-grey-50 border-dashed border-gray-600 p-5 w-1/3"
    >
        <h3 class="h3 text-xl font-extrabold tracking-wider">
            <span v-if="status == 1">Data RAB</span>
            <span v-else >Data HPS</span>
        </h3>
        <div class="divider"></div>
        <div class="flex flex-wrap">
            <div class="flex flex-col basis-1/2">
                <Label value="Harga Satuan" />
                <p class="font-bold text-lg tracking-wider">
                    <span v-if="status == 1">{{convertToRupiah(items['price'])}}</span>
                    <span v-else >{{convertToRupiah(items['estimate_price'])}}</span>
                </p>
            </div>
            <div class="ml-5 flex flex-col">
                <Label value="Jumlah" />
                <p class="font-bold text-lg tracking-wider">
                    {{ items['quantity'] }} {{ items['unit'] }}
                </p>
            </div>
            <div class="flex flex-col basis-1/2 mt-5">
                <Label value="Total" />
                <p class="font-bold text-lg tracking-wider">
                    <span v-if="status == 1">{{convertToRupiah(items['total'])}}</span>
                    <span v-else>{{convertToRupiah(items['estimate_total'])}}</span>
                </p>
            </div>
        </div>
        <Label value="Sumber" class="mt-5" />
        <div v-if="status == 1">
            <Input
                class="w-full"
                type="text"
                isDisable
                :value="items['source']"
            />
            <a class="text-xs text-first underline underline-offset-8 " id="visit" :href="items['source']" target="_blank">
                Kunjungi Sumber
            </a>
        </div>
        <div v-else-if="items['estimate_source'] != null">
            <Input
                class="w-full"
                type="text"
                isDisable
                :value="items['estimate_source']"
                />
                <a class="text-xs text-first underline underline-offset-8 " id="visit" :href="items['estimate_source']" >
                    Kunjungi Sumber
                </a>
        </div>
        <a v-else class="mb-5 text-sm font-bold text-first underline underline-offset-8" :href="items['estimate_file']" download target="_self">Lihat File</a>
        <!-- <button @click="cek()">cek</button> -->
    </Container>
</template>

<script setup>
import Container from '@/Components/utils/Container.vue';
import Input from '@/Components/utils/Input.vue';
import Label from '@/Components/utils/Label.vue';

const props = defineProps({
	items: { type: Object },
    status: { type: Number }
})

const cek = () => {
    console.log(props.items['estimate_source'])
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
</script>