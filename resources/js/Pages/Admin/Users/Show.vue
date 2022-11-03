<template>
    <Master>
        <div class="flex flex-col items-center">
            <Vue3Lottie :animationData="Avatar" :height="300" :width="400" />

            <Container class="w-3/12 mr-5 mb-5 text-center">
                <div class="font-bold text-lg capitalize">{{user.name}}</div>
                <div class="text-sm text-gray-400">{{user.identity_type}}. {{user.identity_number}}</div>
                <div class="text-sm text-gray-400">{{user.email}}</div>
                <div class="text-sm text-gray-400">{{user.units.full_name}}</div>
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
    </Master>
</template>

<script setup>
import Master from "@/Layouts/Master.vue";
import { Link } from '@inertiajs/inertia-vue3'
import Container from "@/Components/utils/Container.vue";
import Header1 from "@/Components/utils/Header1.vue";
import Label from '@/Components/utils/Label.vue';
import Avatar from "/public/image/dashboard/male1.json"

defineProps({
	user: { type: Object, required: true },
})

</script>
