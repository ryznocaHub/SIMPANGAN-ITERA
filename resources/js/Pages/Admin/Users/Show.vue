<template>
    <Master>
        <template v-slot="{ loading }" }>
            <div class="flex flex-col items-center">
                <Vue3Lottie :animationData="Avatar" :height="300" :width="400" />
    
                <Container class="w-3/12 mr-5 mb-5 text-center">
                    <div class="font-bold text-lg capitalize">{{user.name}}</div>
                    <div class="text-sm text-gray-400">{{user.identity_type}}. {{user.identity_number}}</div>
                    <div class="text-sm text-gray-400">{{user.email}}</div>
                    <div class="text-sm text-gray-400">{{user.units.full_name}}</div>
                    <div class="divider"></div>
                    
                    <div class="flex justify-center ">
                        <Link @click="loading()" :href="route('actor.edit', user.id)" class="btn btn-xs text-first bg-slate-100 border-none hover:text-white hover:bg-first font-bold px-4">Edit</Link>
                    </div>
                </Container>
            </div>
        </template>
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
