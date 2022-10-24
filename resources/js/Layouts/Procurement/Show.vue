<template>
    <Master>
        <Container class="w-10/12">
            <div class="flex">
                <div class="justify-between ">
                    <div class="flex justify-between">
                        <div>
                            <div class="flex">
                                <Header1 :title=procurement.name widthSize="0" />
                                <StatusButton :status=procurement.status />
                            </div>
        
                            <div class="flex">
                                <Label :value='"Kategori " + procurement.category' />
                                <div class="mx-3 text-first">I</div>
                                <Label :value='"Tahun Anggaran " + procurement.year' />
                                <div class="mx-3 text-first">I</div>
                                <Label :value='"Unit " + procurement.unit' />
                            </div>
                            <div class="flex">
                                <Label :value='"Nomor Akun " + procurement.account' />
                                <div    v-if="procurement.rup_code" class="mx-3 text-first">I</div>
                                <Label  v-if="procurement.rup_code" :value='"Kode RUP " + procurement.rup_code' />
                            </div>
                            <Label :value='"diajukan pada " + getNowDate()' />
                        </div>
                        <Link v-show="procurement.status == 1" :href="route('unit.procurement.edit', procurement.id)" class="btn bg-first border-first" >Unggah Gambar</Link>
                        <Link v-if="procurement.status == 5 && user.role == 4" :href="route('hps.procurement.edit', procurement.id)" class="btn bg-first border-first" >Buat HPS</Link>
                        <Link v-else-if="procurement.status >= 2" :href="route('item.show', procurement.id)" class="btn bg-first border-first" >Lihat Item</Link>
                    </div>
                    
                    <div class="divider"></div>
                    
                    <div class="flex flex-wrap">
                        <div class="flex flex-col basis-1/2">
                            <Label value="Pelaksana" />
                            <p class="font-bold text-lg tracking-wider">{{ procurement.executor.executor }}</p>
                            <p class="font-bold text-sm tracking-wider">{{ procurement.executor.executor_id }}</p>
                        </div>
                        <div class="ml-5 flex flex-col">
                            <Label value="Penanggung Jawab" />
                            <p class="font-bold text-lg tracking-wider">{{ procurement.executor.person_responsible }}</p>
                            <p class="font-bold text-sm tracking-wider">{{ procurement.executor.person_responsible_id }}</p>
                        </div>
                        <div class="flex flex-col basis-1/2 mt-10">
                            <Label value="Pejabat Pembuat Komitmen (PPK)" />
                            <p class="font-bold text-lg tracking-wider">{{ procurement.executor.ppk.name }}</p>
                            <p class="font-bold text-sm tracking-wider">{{ procurement.executor.ppk.identity_type }}. {{ procurement.executor.ppk.identity_number }}</p>
                        </div>
                        <div class="ml-5 flex flex-col mt-10">
                            <Label value="Bendahara Pengeluaran" />
                            <p class="font-bold text-lg tracking-wider">{{ procurement.executor.treasurer }}</p>
                            <p class="font-bold text-sm tracking-wider">{{ procurement.executor.treasurer_id }}</p>
                        </div>
                    </div>
                </div>
                <div class="divider divider-horizontal"></div>
                <div class="flex-auto flex flex-col justify-between w-1/12 ">
                    <div>
                        <slot name="file" />
                    </div>
                    <div>
                        <div class="mt-5">
                            <Label value="Sub Total" />
                            <p class="font-bold text-lg tracking-wider">{{ convertToRupiah(procurement.budget_plan.sub_total) }}</p>
                        </div>
                        <div class="mt-5">
                            <Label value="PPN" />
                            <p class="font-bold text-lg tracking-wider">{{ convertToRupiah(procurement.budget_plan.ppn) }}</p>
                        </div>
                        <div class="mt-5">
                            <Label value="Total" />
                            <p class="font-bold text-lg tracking-wider">{{ convertToRupiah(procurement.budget_plan.total) }}</p>
                        </div>
                    </div>
                </div>
                <slot/>
            </div>

            <slot name="comment" :data=procurement />
        </Container>
        <slot name="extra-info" />
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
import moment from 'moment';
import { computed } from 'vue'
import { usePage } from '@inertiajs/inertia-vue3'

const user = computed(() => usePage().props.value.auth.user)

const props = defineProps({
	procurement: { type: Object, required: true },
})

const getNowDate = () =>{
    return moment(props.procurement.timeline.rab_submitted, 'YYYY-MM-DD h:mm:ss a').format('DD-MM-YYYY');
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

</script>
