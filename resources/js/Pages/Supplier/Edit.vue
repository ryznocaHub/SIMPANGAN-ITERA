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
                            :value="data.entity"
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
                            :value="data.name"
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
                            :value="data.pic_position"
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
                            :value="data.pic"
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
                    :value="data.npwp"
                    :status="data.errors.npwp"
                />
                <div class="text-sm text-error mt-1 mb-4" v-if="data.errors.npwp">{{ data.errors.npwp }}</div>
                <Label value="Alamat" />
                <Input
                    id="alamat"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="data.address"
                    :value="data.address"
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
                            :value="data.province"
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
                            :value="data.regency"
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
                            :value="data.bank"
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
                            :value="data.account"
                            :status="data.errors.account"
                            required
                        />
                        <div class="text-sm text-error mt-1 mb-4" v-if="data.errors.account">{{ data.errors.account }}</div>
                    </div>
                </div>
                <div class="flex justify-end mt-10">
                    <button @click="back()" class="btn text-first bg-slate-200 border-none hover:text-white hover:bg-first font-bold">Cancel</button>
                    <button @click="edit(supplier.id, loading)" class="btn border-first modal-button bg-first ml-3">Edit</button>
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
const props = defineProps({
	supplier: { type: Object, required: true },
})

const data = useForm({
    name        : props.supplier.name,
    pic         : props.supplier.pic,
    pic_position: props.supplier.pic_position,
    npwp        : props.supplier.npwp,
    entity      : props.supplier.entity,
    address     : props.supplier.address,
    province    : props.supplier.province,
    regency     : props.supplier.regency,
    bank        : props.supplier.bank,
    account     : props.supplier.account,
    _method     : 'patch',
})

const edit = (id,loading) =>{
    data.post(route("supplier.update", id),{
        onSuccess   :   (e) => toast('success', 'Berhasil ubah data supplier ' + data.name),
        onError     :   (e) => {toast('error', 'Gagal ubah data supplier'); console.log(e)},
        onStart     :   (e) => data.clearErrors(),
        onStart     :   ()  => loading(),
        onFinish    :   ()  => loading()
    })
}

let back = function()
{
    window.history.back();
}

const banks = [
    'Bank Aceh Syariah',
    'Bank Aladin Syariah',
    'Bank Allo Indonesia',
    'Bank Amar Indonesia',
    'Bank ANZ Indonesia',
    'Bank Artha Graha Internasional',
    'Bank Banten',
    'Bank BCA Syariah',
    'Bank Bengkulu',
    'Bank Bisnis Internasional',
    'Bank BJB',
    'Bank BJB Syariah',
    'Bank BNP Paribas Indonesia',
    'Bank BPD Bali',
    'Bank BPD DIY',
    'Bank BRK Syariah',
    'Bank BSG',
    'Bank BTPN',
    'Bank BTPN Syariah',
    'Bank Bumi Arta',
    'Bank Capital Indonesia',
    'Bank Central Asia (BCA)',
    'Bank China Construction Bank Indonesia',
    'Bank CIMB Niaga',
    'Bank Commonwealth',
    'Bank CTBC Indonesia',
    'Bank Danamon Indonesia',
    'Bank DBS Indonesia',
    'Bank Digital BCA',
    'Bank DKI',
    'Bank Fama Internasional',
    'Bank Ganesha',
    'Bank HSBC Indonesia',
    'Bank IBK Indonesia',
    'Bank ICBC Indonesia',
    'Bank Ina Perdana',
    'Bank Index Selindo',
    'Bank J Trust Indonesia',
    'Bank Jago',
    'Bank Jambi',
    'Bank Jasa Jakarta',
    'Bank Jateng',
    'Bank Jatim',
    'Bank Kalbar',
    'Bank Kalsel',
    'Bank Kalteng',
    'Bank Kaltimtara',
    'Bank KB Bukopin',
    'Bank KB Bukopin Syariah',
    'Bank KEB Hana Indonesia',
    'Bank Lampung',
    'Bank Maluku Malut',
    'Bank Mandiri',
    'Bank Mandiri Taspen',
    'Bank Maspion',
    'Bank Mayapada Internasional',
    'Bank MaybankIndonesia',
    'Bank Mayora',
    'Bank Mega',
    'Bank Mega Syariah',
    'Bank Mestika Dharma',
    'Bank Mizuho Indonesia',
    'Bank MNC Internasional',
    'Bank Muamalat Indonesia',
    'Bank Multiarta Sentosa',
    'Bank Nagari',
    'Bank Nationalnobu',
    'Bank Negara Indonesia',
    'Bank Neo Commerce',
    'Bank NTB Syariah',
    'Bank NTT',
    'Bank OCBC NISP',
    'Bank Bank of India Indonesia',
    'Bank Oke Indonesia',
    'Bank Panin',
    'Bank Panin Dubai Syariah',
    'Bank Papua',
    'Bank Permata',
    'Bank Prima Master',
    'Bank QNB Indonesia',
    'Bank Rakyat Indonesia (BRI)',
    'Bank Raya Indonesia',
    'Bank Resona Perdania',
    'Bank Sahabat Sampoerna',
    'Bank SBI Indonesia',
    'Bank Seabank Indonesia',
    'Bank Shinhan Indonesia',
    'Bank Sinarmas',
    'Bank Sulselbar',
    'Bank Sulteng',
    'Bank Sultra',
    'Bank Sumsel Babel',
    'Bank Sumut',
    'Bank Syariah Indonesia',
    'Bank Tabungan Negara',
    'Bank UOB Indonesia',
    'Bank Victoria Internasional',
    'Bank Victoria Syariah',
    'Bank Woori Saudara',
]

</script>
