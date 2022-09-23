<template>
    <Master>
        <Container class="w-6/12">
            <Header1 title="Data Supplier" widthSize="100" />
            <div class="flex mt-5">
                <div class="mt-1 w-4/12 ">
            
                    <Label value="Jenis Perusahaan" />
                    <Input
                        id="entity"
                        type="text"
                        class="w-full"
                        v-model="data.entity"
                        :value="data.entity"
                        list="categoryList"
                        required
                    />
                    <datalist id="categoryList">
                        <option value="PT" />
                        <option value="CV" />
                    </datalist>
                </div>
                <div class="mt-1 w-full ml-10">
                    <Label value="Nama" />
                    <Input
                        id="nama"
                        class="w-full"
                        type="text"
                        v-model.number="data.name"
                        placeholder="Nama Perusahaan"
                        :value="data.name"
                        required
                    />
                </div>
            </div>
            <Label value="NPWP" />
            <Input
                id="npwp"
                type="text"
                class="mt-1 block w-full"
                v-model.number="data.npwp"
                :value="data.npwp"
                required
            />
            <Label value="Alamat" />
            <Input
                id="alamat"
                type="text"
                class="mt-1 block w-full"
                v-model.number="data.address"
                :value="data.address"
                required
            />
            <div class="flex">
                <div class="w-4/12">
                    <Label value="Provinsi" />
                    <Input
                        id="Province"
                        type="text"
                        class="mt-1 block w-full"
                        v-model.number="data.province"
                        :value="data.province"
                        required
                    />
                </div>
                <div class="w-full ml-10">
                    <Label value="Kota / Kabupaten" />
                    <Input
                        id="regency"
                        type="text"
                        class="mt-1 block w-full"
                        v-model.number="data.regency"
                        :value="data.regency"
                        required
                    />
                </div>
            </div>
            <div class="flex">
                <div class="mt-1 w-4/12 ">
                    <Label value="Bank" />
                    <Input
                        id="bank"
                        type="text"
                        class="mt-1 block w-full"
                        v-model.number="data.bank"
                        :value="data.bank"
                        required
                    />
                </div>
                <div class="w-full ml-10">
                    <Label value="Rekening" />
                    <Input
                        id="account"
                        type="text"
                        class="mt-1 block w-full"
                        v-model.number="data.account"
                        :value="data.account"
                        required
                    />
                </div>
            </div>
            <div class="flex justify-end mt-10">
                <button @click="back()" class="btn text-first bg-slate-200 border-none hover:text-white hover:bg-first font-bold">Cancel</button>
                <button @click="edit(supplier.id)" class="btn border-first modal-button bg-first ml-3">Edit</button>
            </div>
        </Container>
    </Master>
</template>

<script setup>
import Master from "@/Layouts/Master.vue";
import { Link, useForm } from '@inertiajs/inertia-vue3'
import Container from "@/Components/utils/Container.vue";
import Header1 from "@/Components/utils/Header1.vue";
import Label from '@/Components/utils/Label.vue';
import Input from '@/Components/utils/Input.vue';

const props = defineProps({
	supplier: { type: Object, required: true },
})

const data = useForm({
    name:       props.supplier.name,
    npwp:       props.supplier.npwp,
    entity:     props.supplier.entity,
    address:    props.supplier.address,
    province:   props.supplier.province,
    regency:    props.supplier.regency,
    bank:       props.supplier.bank,
    account:    props.supplier.account,
})

const edit = (id) =>{
    data.post(route("kontrak.supplier.update", id),{
        onSuccess:  (e) => {
            console.log("sukses mengubah data supplier ",e)
        },
        onError:    (e) => {console.log(e)}
    })
}

let back = function()
{
    window.history.back();
}

</script>
