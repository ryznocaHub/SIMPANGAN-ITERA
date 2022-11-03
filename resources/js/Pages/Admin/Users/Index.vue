<template>
    <Master>
        <div v-if="users.length != 0" >
            <div v-for="(data, index) in users"  :key="index" :tabindex="index" class="collapse group collapse-arrow mx-32">
                <div v-if="index != 1">
                    <div class="collapse">
                        <input type="checkbox" class="peer" :id="index" /> 
                        <!-- <div class="collapse-title rounded-md bg-white drop-shadow-lg peer-checked:rounded-none peer-checked:bg-gray-100 peer-checked:drop-shadow-none peer-checked:border-none"> -->
                        <div class="collapse-title bg-white rounded-md peer-checked:bg-gray-100 peer-checked:border-none">
                            <Header1 :title="stringRole[index-1]" class="mb-0" />
                        </div>
                        <div class="collapse-content flex mt-5 flex-wrap">
                            <Container v-for="user in data" :key="user.id" class="w-3/12 mr-5 mb-5">
                                <div class="font-bold text-lg capitalize">{{user.name}}</div>
                                <div class="text-sm text-gray-400">{{user.identity_type}}. {{user.identity_number}}</div>
                                <div class="text-sm text-gray-400">{{user.email}}</div>
                                <div class="text-sm text-gray-400">{{units[user.unit_id-1].full_name}}</div>
                                <div class="divider"></div>
                                <div class="flex justify-between ">
                                    <label :for=user.id class="btn btn-xs text-error  border-none hover:text-error hover:bg-slate-100 bg-white underline underline-offset-2 font-bold">Non Aktif</label>
                    
                                    <input type="checkbox" :id=user.id class="modal-toggle" />
                                    <label :for=user.id class="modal cursor-pointer">
                                    <label class="modal-box relative border-error border-1" for="">
                                        <label :for=user.id class="btn btn-xs border-error bg-error btn-circle absolute right-2 top-2">✕</label>
                                        <div class="text-center font-bold text-2xl mt-3">Apakah anda yakin ingin Non Aktif <span class="text-first font-bold underline underline-offset-8 capitalize">{{user.name}}</span>  ?</div>
                                        <div class="flex justify-center">
                                            <button v-if="user.status == 1" @click="nonActive(user.id, user.name)" class="btn text-error border-none bg-slate-100 hover:text-white hover:bg-error bg-white font-bold mt-5 tracking-wide">Non Aktif</button>
                                            <button v-else                  @click="nonActive(user.id, user.name)" class="btn text-error border-none bg-slate-100 hover:text-white hover:bg-error bg-white font-bold mt-5 tracking-wide">Aktifkan</button>
                                        </div>
                                    </label>
                                    </label>
                                    <Link v-if="user.status == 1" :href="route('admin.user.edit', user.id)" class="btn btn-xs text-first bg-slate-100 border-none hover:text-white hover:bg-first font-bold px-4">Edit</Link>
                                </div>
                            </Container>
                        </div>
                    </div>
                </div>
                <div class="divider"></div>
            </div>
        </div>
        <EmptyPage v-else text="pengguna non aktif"/>
    </Master>
</template>

<script setup>
import Master from "@/Layouts/Master.vue";
import { Link, useForm } from '@inertiajs/inertia-vue3'
import Container from "@/Components/utils/Container.vue";
import Header1 from "@/Components/utils/Header1.vue";
import Label from '@/Components/utils/Label.vue';
import Notification from "@/Components/composables/Notification"
import EmptyPage from "@/Components/StatusPage/Empty.vue";

const toast = Notification() 

defineProps({
	users: { type: Object, required: true },
    units: { type: Object, required: true }
})

const stringRole = ['Admin','Pejabat Pembuat Komitmen','Pejabat Pengadilan', 'Tim HPS', 'Tim Kontrak', 'Tim Teknis', 'Unit', 'RAB Checker'];
// const role = () => {

const nonActive = (id, name) =>{
    const x = useForm()
    x.post(route("admin.nonActiveUser", id),{
        onSuccess:  (e) => toast('success', 'Berhasil non aktif '+ name),
        onError:    (e) => toast('error', 'Gagal non aktif  '+ name),
    })
}

const activeUser = (id, name) =>{
    const x = useForm()
    x.post(route("admin.activeUser", id),{
        onSuccess:  (e) => toast('success', 'Berhasil aktifkan  '+ name),
        onError:    (e) => toast('error', 'Gagal aktifkan  '+ name),
    })
}

</script>
