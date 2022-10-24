<template>
    <Master>
        <Container class="w-6/12">
            <Header1 :title="supplier.entity + '. ' + supplier.name" widthSize="100" />
            <Label value="NPWP" class="mt-5"/>
            <p class="font-bold text-lg tracking-wider mb-3">
                <span >{{supplier.npwp}}</span>
            </p>
            <Label value="Alamat" />
            <p class="font-bold text-lg tracking-wider mb-3">
                <span >{{supplier.address + ', ' + supplier.regency + ', ' + supplier.province}}</span>
            </p>
            <Label value="Rekening" />
            <p class="font-bold text-lg tracking-wider mb-3">
                <span >{{supplier.bank}} {{supplier.account}}</span>
            </p>
            <Link :href="route('kontrak.supplier.edit',supplier.id)" class="btn mt-5 text-first bg-slate-200 border-none hover:text-white hover:bg-first font-bold">Edit</Link>
        </Container>
    </Master>
</template>

<script setup>
import Master from "@/Layouts/Master.vue";
import { Link } from '@inertiajs/inertia-vue3'
import Container from "@/Components/utils/Container.vue";
import Header1 from "@/Components/utils/Header1.vue";
import Label from '@/Components/utils/Label.vue';

 defineProps({
	supplier: { type: Object, required: true },
})

</script>
