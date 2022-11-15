<template>
    <Master>
        <template v-slot="{ loading }" }>
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
                            :status="data.errors.entity"
                            list="categoryList"
                            required
                        />
                        <div class="text-sm text-error mt-1 mb-4" v-if="data.errors.entity">{{ data.errors.entity }}</div>
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
                            placeholder="Nama Perusahaan"
                            :status="data.errors.name"
                            required
                        />
                        <div class="text-sm text-error mt-1 mb-4" v-if="data.errors.name">{{ data.errors.name }}</div>
                    </div>
                </div>
                <div class="flex">
                    <div class="mt-1 w-4/12 ">
                
                        <Label value="Jabatan" />
                        <Input
                            id="entity"
                            type="text"
                            class="w-full"
                            v-model="data.pic_position"
                            :status="data.errors.pic_position"
                        />
                        <div class="text-sm text-error mt-1 mb-4" v-if="data.errors.pic_position">{{ data.errors.pic_position }}</div>
                    </div>
                    <div class="mt-1 w-full ml-10">
                        <Label value="Nama Penanggung Jawab" />
                        <Input
                            id="nama"
                            class="w-full"
                            type="text"
                            v-model="data.pic"
                            :status="data.errors.pic"
                        />
                        <div class="text-sm text-error mt-1 mb-4" v-if="data.errors.pic">{{ data.errors.pic }}</div>
                    </div>
                </div>
                <Label value="NPWP" />
                <Input
                    id="npwp"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="data.npwp"
                    :status="data.errors.npwp"
                />
                <div class="text-sm text-error mt-1 mb-4" v-if="data.errors.npwp">{{ data.errors.npwp }}</div>
                <Label value="Alamat" />
                <Input
                    id="alamat"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="data.address"
                    :status="data.errors.address"
                    required
                />
                <div class="text-sm text-error mt-1 mb-4" v-if="data.errors.address">{{ data.errors.address }}</div>
                <div class="flex">
                    <div class="w-4/12">
                        <Label value="Provinsi" />
                        <Input
                            id="Province"
                            type="text"
                            class="mt-1 block w-full"
                            v-model="data.province"
                            :status="data.errors.province"
                            required
                        />
                        <div class="text-sm text-error mt-1 mb-4" v-if="data.errors.province">{{ data.errors.province }}</div>
                    </div>
                    <div class="w-full ml-10">
                        <Label value="Kota / Kabupaten" />
                        <Input
                            id="regency"
                            type="text"
                            class="mt-1 block w-full"
                            v-model="data.regency"
                            :status="data.errors.regency"
                            required
                        />
                        <div class="text-sm text-error mt-1 mb-4" v-if="data.errors.regency">{{ data.errors.regency }}</div>
                    </div>
                </div>
                <div class="flex">
                    <div class="mt-1 w-4/12 ">
                        <Label value="Bank" />
                        <Input
                            id="bank"
                            type="search"
                            class="mt-1 block w-full"
                            v-model="data.bank"
                            :status="data.errors.bank"
                            list="listBank"
                            required
                        />
                        <div class="text-sm text-error mt-1 mb-4" v-if="data.errors.bank">{{ data.errors.bank }}</div>
                        <datalist id="listBank">
                            <option v-for="bank in banks" :key=bank>{{bank}}</option>
                        </datalist>
                    </div>
                    <div class="w-full ml-10">
                        <Label value="Rekening" />
                        <Input
                            id="account"
                            type="text"
                            class="mt-1 block w-full"
                            v-model="data.account"
                            :status="data.errors.account"
                            required
                        />
                        <div class="text-sm text-error mt-1 mb-4" v-if="data.errors.account">{{ data.errors.account }}</div>
                    </div>
                </div>
                <div class="flex justify-end mt-10">
                    <button @click="back()" class="btn text-first bg-slate-200 border-none hover:text-white hover:bg-first font-bold">Cancel</button>
                    <button @click="create(loading)" class="btn border-first modal-button bg-first ml-3">Buat</button>
                </div>
            </Container>
        </template>
    </Master>
</template>

<script setup>
import Master from "@/Layouts/Master.vue";
import { Link, useForm } from '@inertiajs/inertia-vue3'
import Container from "@/Components/utils/Container.vue";
import Header1 from "@/Components/utils/Header1.vue";
import Label from '@/Components/utils/Label.vue';
import Input from '@/Components/utils/Input.vue';
import Notification from "@/Components/composables/Notification"

const toast = Notification() 
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

const edit = (loading) =>{
    data.post(route("supplier.store"),{
        onSuccess   :   (e) => toast('success', 'Berhasil menambah data supplier ' + data.name),
        onError     :   (e) => toast('error', 'Gagal menambah data supplier'),
        onStart     :   (e) => {
            loading()
            data.clearErrors()
        },
        onFinish    :   () => loading()
    })
}

let back = function()
{
    window.history.back();
}

</script>
