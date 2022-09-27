<template>
    <Master>
        <Container class="w-6/12">
            <Header1 title="Tambah Data Supplier" widthSize="100" />
            <div class="flex mt-5">
                <div class="mt-1 w-4/12 ">
            
                    <Label value="Jenis Perusahaan" />
                    <Input
                        id="entity"
                        type="text"
                        class="w-full"
                        v-model="data.entity"
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
                        v-model="data.name"
                        required
                    />
                </div>
            </div>
            <Label value="NPWP" />
            <Input
                id="npwp"
                type="text"
                class="mt-1 block w-full"
                v-model="data.npwp"
                required
            />
            <Label value="Alamat" />
            <Input
                id="alamat"
                type="text"
                class="mt-1 block w-full"
                v-model="data.address"
                required
            />
            <div class="flex">
                <div class="w-4/12">
                    <Label value="Provinsi" />
                    <Input
                        id="Province"
                        type="text"
                        class="mt-1 block w-full"
                        v-model="data.province"
                        required
                    />
                </div>
                <div class="w-full ml-10">
                    <Label value="Kota / Kabupaten" />
                    <Input
                        id="regency"
                        type="text"
                        class="mt-1 block w-full"
                        v-model="data.regency"
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
                        v-model="data.bank"
                        required
                    />
                </div>
                <div class="w-full ml-10">
                    <Label value="Rekening" />
                    <Input
                        id="account"
                        type="text"
                        class="mt-1 block w-full"
                        v-model="data.account"
                        required
                    />
                </div>
            </div>
            <div class="flex justify-end mt-10">
                <button @click="back()" class="btn text-first bg-slate-200 border-none hover:text-white hover:bg-first font-bold">Cancel</button>
                <button @click="create()" class="btn border-first modal-button bg-first ml-3">Tambah</button>
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

const data = useForm({
    name:       "",
    npwp:       "",
    entity:     "",
    address:    "",
    province:   "",
    regency:    "",
    bank:       "",
    account:    "",
})

const create = () =>{
    data.post(route("kontrak.supplier.store"),{
        onSuccess:  (e) => {
            console.log("sukses menambah data supplier ",e)
        },
        onError:    (e) => {console.log(e)}
    })
}

let back = function()
{
    window.history.back();
}

</script>
