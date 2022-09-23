<template>
    <Show :items=items  >
        <template v-slot="{ data, successVerification }">
            <InfoHPS :items="data" @successVerification="successVerification" />
        </template>
        <template #status>
            <StatusRedirect text="Semua RAB sudah dibuatkan HPS. Silahkan ajukan HPS">
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

const props = defineProps({
	items: { type: Object },
	id: { type: Number },
})

const dataConfirmation = useForm({
    _method: 'patch',
    status: 6,
})

const confirm = () => {
    dataConfirmation.post(route('hps.procurement.update',props.id),{
        onSuccess : () => {
            console.log("sukses ajukan HPS")
        },
        onError: (e) => {
            console.log("gagal ajukan RAB",e)
        }
    });
}
</script>