<template>
    <Show :items=items  >
        <template v-slot="{ data, successVerification }">
            <InfoHPS :items="data" @successVerification="successVerification" @editTotal="editTotal"/>
        </template>
        <template #status>
            <StatusRedirect text="Semua RAB sudah dibuatkan HPS. Silahkan ajukan HPS">
                <div class="flex mb-10 text-start">
                    <Container class="w-6/12">
                        <Header1 title="Data RAB" widthSize="40" />
                        <Label value="Sub Total" class="mt-5"/>
                        <p class="font-bold text-lg tracking-wider mb-3">
                            <span >{{convertToRupiah(procurement.budget_plan.sub_total)}}</span>
                        </p>
                        <Label value="PPN" class="mt-5"/>
                        <p class="font-bold text-lg tracking-wider mb-3">
                            <span >{{convertToRupiah(procurement.budget_plan.ppn)}}</span>
                        </p>
                        <Label value="Total" class="mt-5"/>
                        <p class="font-bold text-lg tracking-wider mb-3">
                            <span >{{convertToRupiah(procurement.budget_plan.total)}}</span>
                        </p>
                    </Container>
                    <Container class="ml-10 w-6/12">
                        <Header1 title="Data HPS" widthSize="40" />
                        <Label value="Sub Total" class="mt-5"/>
                        <p class="font-bold text-lg tracking-wider mb-3">
                            <span >{{convertToRupiah(hps.sub_total)}}</span>
                        </p>
                        <Label value="PPN" class="mt-5"/>
                        <div class="form-control">
                            <label class="label cursor-pointer">
                                <input type="radio" name="radio-6" class="radio checked:bg-blue-500" checked @input="event => emptyPPN()" />
                                <span class="label-text">Rp. 0</span> 
                            </label>
                        </div>
                        <div class="form-control">
                            <label class="label cursor-pointer">
                                <input type="radio" name="radio-6" class="radio checked:bg-blue-500" @input="event => ppn(1)" />
                                <span class="label-text">{{convertToRupiah(hps.ppn)}}</span> 
                            </label>
                        </div>
                        <Label value="Overheat" class="mt-5"/>
                        <p class="font-bold text-lg tracking-wider mb-3">
                            <span >{{convertToRupiah(hps.overheat)}} </span>
                        </p>
                        <div class="flex">
                            <Input
                                id="provit"
                                type="number"
                                class="mt-1 w-6/12"
                                v-model="hps.percentage"
                                @input="event => overheat(event.target.value)"
                            />
                            <div class="self-center ml-3 place-self-center">%</div>
                        </div>
                        <Label value="Total" class="mt-5"/>
                        <p class="font-bold text-lg tracking-wider mb-3">
                            <span >{{convertToRupiah(hps.sub_total + hps.overheat + (hps.ppn*hps.chooser) )}}</span>
                        </p>
                    </Container>

                </div>
                <button
                    class="btn gap-2 bg-first border-none"
                    @click="confirm()"       
                >
                    Ajukan HPS
                </button>
            </StatusRedirect>
        </template>
    </Show>
</template>

<script setup>
import Show from "@/Layouts/Item/Show.vue";
import InfoDetail from "@/Components/InfoDetail/Index.vue";
import StatusRedirect from "@/Components/StatusRedirect/index.vue";
import InfoHPS from "@/Components/infoHPS/Index.vue";
import { useForm } from "@inertiajs/inertia-vue3";
import Master from "@/Layouts/Master.vue";
import Container from "@/Components/utils/Container.vue";
import Header1 from "@/Components/utils/Header1.vue";
import Label from "@/Components/utils/Label.vue";
import Input from "@/Components/utils/Input.vue";

const props = defineProps({
	items       : { type: Object },
	procurement : { type: Object },
	id          : { type: Number },
})

function Pembulatan(nilai){
    var hasil = (Math.ceil(parseInt(nilai))%parseInt(100) == 0) ? Math.ceil(parseInt(nilai)):
    Math.round((parseInt(nilai)+parseInt(100)/2)/parseInt(100)) *parseInt(100);
    
    return hasil;
}

const hps = useForm({
    sub_total   : props.procurement.estimate.sub_total,
    ppn         : Pembulatan(0.11 * (props.procurement.estimate.sub_total + props.procurement.estimate.overheat)),
    overheat    : props.procurement.estimate.overheat,
    percentage  : props.procurement.estimate.overheat_percentage,
    chooser     : 0,
    _method     : 'patch',
    status      : 6,
})

const ppn = (x) => {
    const sum = 0.11 * (hps.sub_total + hps.overheat) 
    hps.ppn = Pembulatan(sum)
    hps.chooser = x
}

const overheat = (e) => {
    console.log("sub",hps.sub_total,"overheat",hps.overheat,"ppn",hps.ppn, "chooser", hps.chooser)
    const sum = e * hps.sub_total /100
    // const sum = e * hps.sub_total 
    hps.overheat = Pembulatan(sum)
    ppn(hps.chooser)
}

const editTotal = (e,sub_total) => {
    if (e.status == 1) return 0

    hps.sub_total   = hps.sub_total + e.total - sub_total
    overheat(hps.percentage)

    console.log("overheat", hps.overheat, "sub_total", hps.sub_total )
}

const emptyPPN = () => {
    hps.chooser = 0
}

const confirm = () => {
    hps.post(route('hps.procurement.update',props.id),{
        onSuccess : (e) => {
            console.log("sukses ajukan HPS")
        },
        onError: (e) => {
            console.log("gagal ajukan RAB",e)
        }
    });
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