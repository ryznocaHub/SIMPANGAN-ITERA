<template>
    <Master>
        <template v-slot="{ loading }" }>
            <div class="flex">
                <Header1 :title=procurement.name widthSize="100" class="mb-5" />
                <StatusButton :status=procurement.status />
            </div>
            <p class="text-sm mb-10 text-gray-500">{{procurement.description}}</p>

            <div class="flex">
                <Container class="justify-between w-10/12">
                    <div class="flex justify-between">
                        <div>
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
                            <Label :value='"diajukan pada " + getNowDate(procurement.timeline.rab_submitted)' />
                        </div>
                        <div class="flex">
                            <Link @click="loading()" v-if       ="procurement.status == 1"                      :href="route('unit.procurement.edit', procurement.id)"  class="btn bg-first border-first" >Unggah Gambar</Link>
                            <Link @click="loading()" v-else-if  ="procurement.status == 5 && user.role == 4"    :href="route('hps.procurement.edit', procurement.id)"   class="btn bg-first border-first" >Buat HPS</Link>
                            <Link @click="loading()" v-else-if  ="procurement.status >= 2"                      :href="route('item.show', procurement.id)"              class="btn bg-first border-first" >Lihat Item</Link>
                            <div class="ml-5">
                                <slot name="file" :loading="loading" />
                            </div>
                        </div>
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
                    <slot name="comment" />
                </Container>

                <div v-if="user.role > 2" class="flex-auto flex flex-col ml-5" >
                    <Container v-if="user.role != 3 && user.role != 5" class="mb-5">
                        <Label value="Nilai RAB" />
                        <p class="font-bold text-lg tracking-wider">{{ convertToRupiah(procurement.budget_plan.total) }}</p>
                    </Container>
                    <Container v-if="procurement.estimate && user.role < 6" class="mb-5">
                        <Label value="Nilai HPS" />
                        <p class="font-bold text-lg tracking-wider">{{ convertToRupiah(procurement.estimate.total) }}</p>
                    </Container>
                    <Container  v-if="procurement.contract && user.role < 6 && user.role != 4">
                        <Label value="Nilai Penawaran" />
                        <p class="font-bold text-lg tracking-wider">{{ convertToRupiah(procurement.contract.offer) }}</p>
                    </Container>
                </div>
                <slot/>
            </div>
            <div class="flex mt-10 w-10/12" v-if="user.role < 3">
                <Container class="flex flex-col w-4/12 " >
                    <Header1 title="Tim UKPBJ" widthSize="50" class="mb-5" />
                    
                    <div class="" v-if="procurement.executor.siren_approval">
                        <Label value="Verifikasi RAB" />
                        <p class="font-bold text-lg tracking-wider">{{ procurement.executor.siren_approval.name }}</p>
                    </div>
                    <div class="mt-5" v-if="procurement.executor.siren_reject">
                        <Label value="Penolakan RAB" />
                        <p class="font-bold text-lg tracking-wider">{{ procurement.executor.siren_reject.name }}</p>
                    </div>
                    <div class="mt-5" v-if="procurement.executor.hps">
                        <Label value="PIC HPS" />
                        <p class="font-bold text-lg tracking-wider">{{ procurement.executor.hps.name }}</p>
                    </div>
                    <div class="mt-5" v-if="procurement.executor.pp">
                        <Label value="PP" />
                        <p class="font-bold text-lg tracking-wider">{{ procurement.executor.pp.name }}</p>
                    </div>
                    <div class="mt-5" v-if="procurement.executor.contract">
                        <Label value="PIC Kontrak" />
                        <p class="font-bold text-lg tracking-wider">{{ procurement.executor.contract.name }}</p>
                    </div>
                </Container>
                <Container class="flex flex-col justify-between w-3/12 ml-5" >
                    <div>
                        <Header1 title="Nilai RAB" widthSize="50" class="mb-5" />
                        
                        <div class="mt-5">
                            <Label value="Sub total" />
                            <p class="font-bold text-lg tracking-wider">{{ convertToRupiah(procurement.budget_plan.sub_total) }}</p>
                        </div>
                        <div class="mt-5" v-if="procurement.budget_plan.ppn">
                            <Label value="PPN 11%" />
                            <p class="font-bold text-lg tracking-wider">{{ convertToRupiah(procurement.budget_plan.ppn) }}</p>
                        </div>
                        <div class="mt-5" v-if="procurement.budget_plan.overheat">
                            <Label value="overheat" />
                            <p class="font-bold text-lg tracking-wider">{{ convertToRupiah(procurement.budget_plan.overheat) }}</p>
                        </div>
                        <div class="mt-5">
                            <Label value="Total" />
                            <p class="font-bold text-lg tracking-wider">{{ convertToRupiah(procurement.budget_plan.total) }}</p>
                        </div>
                    </div>
                </Container>
                <Container class="flex flex-col justify-between w-3/12 ml-5" v-if="procurement.status > 5" >
                    <div v-if="procurement.status >= 6">
                        <Header1 title="Nilai HPS" widthSize="50" class="mb-5" />
                        
                        <div class="mt-5">
                            <Label value="Sub Total" />
                            <p class="font-bold text-lg tracking-wider">{{ convertToRupiah(procurement.estimate.sub_total) }}</p>
                        </div>
                        <div class="mt-5" v-if="procurement.estimate.ppn">
                            <Label value="PPN 11%" />
                            <p class="font-bold text-lg tracking-wider">{{ convertToRupiah(procurement.estimate.ppn) }}</p>
                        </div>
                        <div class="mt-5" v-if="procurement.estimate.overheat">
                            <Label :value="'Overheat (' + procurement.estimate.overheat_percentage + '%)'" />
                            <p class="font-bold text-lg tracking-wider">{{ convertToRupiah(procurement.estimate.overheat) }}</p>
                        </div>
                        <div class="mt-5" >
                            <Label value="Total" />
                            <p class="font-bold text-lg tracking-wider">{{ convertToRupiah(procurement.estimate.total) }}</p>
                        </div>
                    </div>
                </Container>
            </div>
            <slot name="extra-info" :loading="loading" />
        </template>
        <!-- <template #file="{loading}" >
            <Link v-if="procurement.status == 4" @click="loading()" :href="route('unit.procurement.reupload', procurement.id)" class="btn text-first bg-slate-200 border-none hover:text-white hover:bg-first font-bold" >Pilih Tim HPS</Link>
            <div v-if="procurement.status == 6">

            </div>
        </template> -->
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

const getNowDate = (date) =>{
    return moment(date, 'YYYY-MM-DD h:mm:ss a').format('DD-MM-YYYY');
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
