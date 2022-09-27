<template>
    <Show :procurement=procurement >
        <template #file>
            <a v-show="procurement.hps_submitted" :href="route('kontrak.document.boq',procurement.id)" class="btn text-first w-full btn-outline font-bold hover:bg-first hover:text-white hover:border-none" target="_blank">Lihat BOQ</a>
        </template>
        <template #comment>
            <div class="divider"></div>
            <div v-if="procurement.suppliers.province" class="flex gap-4">
                <div>
                    <div >
                        <Header1 title="Data Supplier" widthSize="60" />
                        
                        <Label value="Nama" class="mt-5"/>
                        <p class="font-bold text-lg tracking-wider mb-3">
                            <span >{{procurement.suppliers.entity}}. {{procurement.suppliers.name}}</span>
                        </p>
                        <Label value="NPWP" class="mt-5"/>
                        <p class="font-bold text-lg tracking-wider mb-3">
                            <span >{{procurement.suppliers.npwp}}</span>
                        </p>
                        <Label value="Alamat" />
                        <p class="font-bold text-lg tracking-wider mb-3">
                            <span >{{procurement.suppliers.address + ', ' + procurement.suppliers.regency + ', ' + procurement.suppliers.province}}</span>
                        </p>
                        <Label value="Rekening" />
                        <p class="font-bold text-lg tracking-wider mb-3">
                            <span >{{procurement.suppliers.bank}} {{procurement.suppliers.account}}</span>
                        </p>
                    </div>
                </div>
                <div class=" divider divider-horizontal"></div>
                <div>
                    <Header1 title="File Kontrak" widthSize="60" />
                    <div class="flex flex-col">
                        <a v-show="procurement.hps_submitted" :href="route('kontrak.document.boq',procurement.id)" class="btn text-first w-full btn-outline font-bold hover:bg-first hover:text-white hover:border-none" target="_blank">SPPBJ</a>
                        <a v-show="procurement.hps_submitted" :href="route('kontrak.document.boq',procurement.id)" class="mt-5 btn text-first w-full btn-outline font-bold hover:bg-first hover:text-white hover:border-none" target="_blank">SPK</a>
                        <a v-show="procurement.hps_submitted" :href="route('kontrak.document.boq',procurement.id)" class="mt-5 btn text-first w-full btn-outline font-bold hover:bg-first hover:text-white hover:border-none" target="_blank">SPMK</a>
                    </div>
                </div>
            </div>
            <Link v-else :href="route('kontrak.supplier.edit',procurement.suppliers.id)" class="btn btn-sm mt-10 text-first bg-slate-200 border-none hover:text-white hover:bg-first  font-bold" >Lengkapi Data Supplier</Link>
        </template>
    </Show>
</template>

<script setup>
import Show from "@/Layouts/Procurement/Show.vue";
import Label from '@/Components/utils/Label.vue';
import Header1 from "@/Components/utils/Header1.vue";

const props = defineProps({
	procurement: { type: Object, required: true },
})

</script>