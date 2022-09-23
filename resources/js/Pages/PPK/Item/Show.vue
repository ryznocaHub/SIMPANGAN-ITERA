<template>
    <Show :items=items v-slot="slotProps">
        <InfoDetail v-if="slotProps.data['estimate_price']" :items="slotProps.data" :status="2" class="ml-5"/>
    </Show>
</template>

<script setup>
import Show from "@/Layouts/Item/Show.vue";
import InfoDetail from "@/Components/InfoDetail/Index.vue";
import InfoHPS from "@/Components/infoHPS/Index.vue";

const props = defineProps({
	items: { type: Object },
})

</script>