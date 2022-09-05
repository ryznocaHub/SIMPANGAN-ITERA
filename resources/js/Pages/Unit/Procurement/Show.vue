<template>
    <Master>
        <Container class="w-10/12">
            <div class="flex">
                <div class=" flex-initial justify-between ">
                    <div class="flex justify-between items-center">
                        <div>
                            <div class="flex">
                                <Header1 :title=props.procurement.name widthSize="0" />
                                <StatusButton :status=status />
                            </div>
        
                            <div class="flex">
                                <Label :value='"Kategori " + props.procurement.category' />
                                <div class="mx-3 text-first">I</div>
                                <Label :value='"Tahun Anggaran " + props.procurement.year' />
                                <div class="mx-3 text-first">I</div>
                                <Label :value='"Unit " + props.procurement.unit' />
                                <div class="mx-3 text-first">I</div>
                                <Label :value='"Nomor Akun .........." ' />
                            </div>
                        </div>
                        <Link v-show="props.procurement.status == 1" :href="route('procurement.edit', props.procurement.id)" class="btn btn-first " >Unggah Gambar</Link>
                        <Link v-show="props.procurement.status == 2" :href="route('item.index', props.procurement.id)" class="btn btn-first " >Lihat Item</Link>
                    </div>
                    

                    <!-- <div class="flex">
                        <Label :value='"Diunggah pada " + props.procurement.created_at' />
                        <div class="mx-3 text-first">I</div>
                        <Label :value='"Oleh " + props.procurement.user_id' />
                    </div> -->

                    <div class="divider"></div>
                    
                    <div class="flex flex-wrap">
                        <div class="flex flex-col basis-1/2">
                            <Label value="Pelaksana" />
                            <p class="font-bold text-lg tracking-wider">{{ props.procurement.executor }}</p>
                            <p class="font-bold text-sm tracking-wider">{{ props.procurement.executor_id }}</p>
                        </div>
                        <div class="ml-5 flex flex-col">
                            <Label value="Penanggung Jawab" />
                            <p class="font-bold text-lg tracking-wider">{{ props.procurement.person_responsible }}</p>
                            <p class="font-bold text-sm tracking-wider">{{ props.procurement.person_responsible_id }}</p>
                        </div>
                        <div class="flex flex-col basis-1/2 mt-10">
                            <Label value="Pejabat Pembuat Komitmen (PPK)" />
                            <p class="font-bold text-lg tracking-wider">{{ props.procurement.PPK }}</p>
                            <p class="font-bold text-sm tracking-wider">{{ props.procurement.PPK_id }}</p>
                        </div>
                        <div class="ml-5 flex flex-col mt-10">
                            <Label value="Bendahara Pengeluaran" />
                            <p class="font-bold text-lg tracking-wider">{{ props.procurement.treasurer }}</p>
                            <p class="font-bold text-sm tracking-wider">{{ props.procurement.treasurer_id }}</p>
                        </div>
                    </div>
                </div>
                <div class="divider divider-horizontal"></div>
                <div class="flex-auto flex flex-col justify-between w-1/12 ">
                    <div>
                        <Label value="Sub Total" />
                        <p class="font-bold text-lg tracking-wider">{{ convertToRupiah(props.procurement.sub_total) }}</p>
                    </div>
                    <div>
                        <Label value="PPN" />
                        <p class="font-bold text-lg tracking-wider">{{ convertToRupiah(props.procurement.PPN) }}</p>
                    </div>
                    <div>
                        <Label value="Total" />
                        <p class="font-bold text-lg tracking-wider">{{ convertToRupiah(props.procurement.total) }}</p>
                    </div>
                    <div>
                        <Label value="File RAB" />
                        <a href="#" download class="font-bold text-lg tracking-wider">download</a>
                    </div>
                    <div>
                        <Label value="File BOQ" />
                        <a href="#" download class="font-bold text-lg tracking-wider">donwload</a>
                    </div>
                </div>
            </div>

            <div v-if="props.procurement.comment">
                <div class="divider"></div>
                <div>
                    Note : {{ props.procurement.comment }}
                </div>
            </div>
        </Container>
    </Master>
</template>

<script setup>
import Master from "@/Layouts/Master.vue";
import Container from "@/Components/utils/Container.vue";
import Header1 from "@/Components/utils/Header1.vue";
import Label from "@/Components/utils/Label.vue";
import StatusButton from "@/Components/statusButton/index.vue"
import { useForm } from "@inertiajs/inertia-vue3";
import { Link } from '@inertiajs/inertia-vue3'

const props = defineProps({
	procurement: { type: Object, required: true },
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

const headers = [
    { text: "Nama", value: "nama" },
    { text: "Jumlah", value: "jumlah", sortable: true },
    { text: "Status", value: "status", sortable: true },
    { text: "Aksi", value: "aksi", sortable: true },
];
</script>
