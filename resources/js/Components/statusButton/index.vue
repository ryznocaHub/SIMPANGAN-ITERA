<template>
    <Ppk        v-if="user.role == 2" :status="status"/>
    <Pp         v-if="user.role == 3" :status="status"/>
    <Hps        v-if="user.role == 4" :status="status"/>
    <Kontrak    v-if="user.role == 5" :status="status"/>
    <Unit       v-if="user.role == 7" :status="status"/>
    <Siren      v-if="user.role == 8" :status="status"/>
</template>

<script setup>
    import Ppk from "./Ppk.vue";
    import Hps from "./Hps.vue";
    import Pp from "./Pp.vue";
    import Kontrak from "./Kontrak.vue";
    import Unit from "./Unit.vue";
    import Siren from "./Siren.vue";
    import { computed } from 'vue'
    import { usePage } from '@inertiajs/inertia-vue3'

    defineProps(['status'])
    const user = computed(() => usePage().props.value.auth.user)
</script>