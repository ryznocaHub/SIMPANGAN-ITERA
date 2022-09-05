<template>
    <div>
        <input type="file" id="file-input" v-on:change="inputFile"/>
        <button type="submit" @click="verifikasi">verifikasi</button>
    </div>
</template>

<script setup>
import Input from "@/Components/utils/Input.vue";
import { useForm } from "@inertiajs/inertia-vue3";

const data = useForm({
    forceFormData: true,
    image: null,
});

const inputFile = (e) => {
   data.image = e.target.files[0]
}

const verifikasi = () =>{
    data.post(route("procurementItem.store"),{
        onSuccess:  () => {console.log("sukses")},
        onError:    (e) => {console.log(e)}
    })
}
</script>
