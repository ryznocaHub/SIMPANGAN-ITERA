<template>
    <Show :items=items  >
        <template v-slot="{ data, successVerification }">
            <InfoHPS :items="data" @successVerification="successVerification" @editTotal="editTotal"/>
        </template>
        <template #status>
            <StatusRedirect text="Semua RAB sudah dibuatkan HPS. Silahkan ajukan HPS">
                <div class="flex mb-10 text-start">
                    <Container class="w-6/12">
                        <Header1 title="Data RAB" :widthSize="40" />
                        <Label value="Sub Total" class="mt-5"/>
                        <p class="font-bold text-lg tracking-wider mb-3">
                            <span >{{convertToRupiah(procurement.sub_total)}}</span>
                        </p>
                        <Label value="PPN" class="mt-5"/>
                        <p class="font-bold text-lg tracking-wider mb-3">
                            <span >{{convertToRupiah(procurement.PPN)}}</span>
                        </p>
                        <Label value="Total" class="mt-5"/>
                        <p class="font-bold text-lg tracking-wider mb-3">
                            <span >{{convertToRupiah(procurement.total)}}</span>
                        </p>
                    </Container>
                    <Container class="ml-10 w-6/12">
                        <Header1 title="Data HPS" :widthSize="40" />
                        <Label value="Sub Total" class="mt-5"/>
                        <p class="font-bold text-lg tracking-wider mb-3">
                            <span >{{convertToRupiah(hps.sub_total)}}</span>
                        </p>
                        <Label value="PPN" class="mt-5"/>
                        <p class="font-bold text-lg tracking-wider mb-3">
                            <span >{{convertToRupiah(hps.ppn)}}</span>
                        </p>
                        <Label value="Provit" class="mt-5"/>
                        <p class="font-bold text-lg tracking-wider mb-3">
                            <span >{{convertToRupiah(hps.provit*hps.sub_total/100)}}</span>
                        </p>
                        <div class="flex">
                            <Input
                                id="provit"
                                type="number"
                                class="mt-1 w-6/12"
                                v-model.number="hps.provit"
                                placeholder="%"
                            />
                            <div class="self-center ml-3 place-self-center">%</div>
                        </div>
                        <Label value="Total" class="mt-5"/>
                        <p class="font-bold text-lg tracking-wider mb-3">
                            <span >{{convertToRupiah(hps.sub_total + hps.ppn + (hps.provit * hps.sub_total/100))}}</span>
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

const hps = useForm({
    sub_total   : props.procurement.estimate_sub_total,
    ppn         : props.procurement.estimate_sub_total * 0.11,
    provit      : 0,
    _method     : 'patch',
    status      : 6,
})

const editTotal = (e) => {
    hps.sub_total   = hps.sub_total + e;
    hps.ppn         = hps.sub_total * 0.11;
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