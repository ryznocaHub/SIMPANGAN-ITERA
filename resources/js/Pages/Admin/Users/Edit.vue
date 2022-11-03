<template>
    <Master>
        <Header1 title="Buat Akun Baru" widthSize="100" class="mb-5" />
        <Container class="w-6/12">
            <Label value="Nama" />
            <Input
                type="text"
                class="mt-1 block w-full"
                v-model="data.name"
                :status="data.errors.name"
            />
            <div class="text-sm text-error mt-1 mb-4">{{ data.errors.name }}</div>

            <div class="flex">
                <div class="mt-1 w-4/12 ">
                    <Label value="Tipe Identitas" />
                    <Input
                        type="text"
                        class="w-full"
                        v-model="data.identity_type"
                        :status="data.errors.identity_type"
                        list="identityType"
                    />
                    <div class="text-sm text-error mt-1 mb-4">{{ data.errors.identity_type }}</div>
                    <datalist id="identityType">
                        <option value="NIP" />
                        <option value="NPWP" />
                    </datalist>
                </div>
                <div class="mt-1 w-full ml-10">
                    <Label value="Nomor Identitas" />
                    <Input
                        class="w-full"
                        type="text"
                        v-model="data.identity_number"
                        :status="data.errors.identity_number"
                    />
                    <div class="text-sm text-error mt-1 mb-4">{{ data.errors.identity_number }}</div>
                </div>
            </div>

            <Label value="Email" />
            <Input
                type="email"
                class="mt-1 block w-full"
                v-model="data.email"
                :status="data.errors.email"
            />
            <div class="text-sm text-error mt-1 mb-4">{{ data.errors.email }}</div>

            <Label value="Password" />
            <Input
                type="password"
                class="mt-1 block w-full"
                v-model="data.password"
                :status="data.errors.password"
            />
            <div class="text-sm text-error mt-1 mb-4">{{ data.errors.password }}</div>
<!-- 
            <Label value="Konfirmasi Password" />
            <Input
                type="password_confirmed"
                class="mt-1 block w-full"
                v-model="data.password_confirmed"
                :status="data.errors.password_confirmed"
            />
            <div class="text-sm text-error mt-1 mb-4">{{ data.errors.password_confirmed }}</div> -->

            <Label value="Asal Unit" />
            <Input
                type="text"
                class="w-full"
                v-model="data.unit"
                list="unitList"
                :status="data.errors.unit"
            />
            <datalist id="unitList">
                <option v-for="unit in units" :key=unit.id>{{unit.full_name}}</option>
            </datalist>
            <div class="text-sm text-error mt-1 mb-4">{{ data.errors.unit }}</div>
            
            <Label value="Peran pada sistem" />
            <Input
                type="text"
                class="w-full"
                v-model="data.role_string"
                list="role"
                :status="data.errors.role"
            />
            <div class="text-sm text-error mt-1 mb-4">{{ data.errors.role }}</div>

            <datalist id="role">
                <option v-for="(role,index) in stringRole" :key=index>{{role}}</option>
            </datalist>
            <div class="flex justify-end mt-10">
                <button @click="back()" class="btn text-first bg-slate-200 border-none hover:text-white hover:bg-first font-bold">Batal</button>
                <button @click="Ubah(user.id)" class="btn border-first modal-button bg-first ml-3">Edit</button>
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
import Notification from "@/Components/composables/Notification"

const toast = Notification()
const props = defineProps({
	units   : { type: Object, required: true },
    user    : {type: Object, required: true}
})

const stringRole = ['Admin','Pejabat Pembuat Komitmen (PPK)','Pejabat Pengadilan (PP)', 'Tim HPS', 'Tim Kontrak', 'Tim Teknis', 'Unit', 'RAB Checker'];

const data = useForm({
    name            : props.user.name,
    identity_number : props.user.identity_number,
    identity_type   : props.user.identity_type,
    email           : props.user.email,
    role_string     : stringRole[props.user.role - 1],
    role            : stringRole[props.user.role - 1],
    unit            : props.units[props.user.unit_id - 1].full_name,
    password        : null,
    _method         : 'patch',
})

const Ubah = (id) =>{
    var role = stringRole.indexOf(data.role_string)
    if(role == -1) {
        data.setError('role', 'Pilih peran yang tersedia')
        return
    }
    data.role = role + 1

    data.post(route("admin.user.update", id),{

        onSuccess:  (e) => toast('success', 'Berhasil edit data user ' + data.name),
        onError:    (e) => toast('error', 'Gagal edit data user'),
        onStart:    (e) => data.clearErrors(),
        onFinish:   (e) => {
            // if(data.unit) data.unit = props.units[data.unit -1].full_name
            // if(data.role) data.role = stringRole[data.role - 1]
        }
    })
}

let back = function()
{
    window.history.back();
}

</script>
