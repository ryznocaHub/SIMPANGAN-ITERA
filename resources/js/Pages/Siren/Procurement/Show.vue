<template>
    <Show :procurement=procurement >
        <template #comment>
            <div v-if="procurement.comment">
                <div class="divider"></div>
                <div class="text-secondary font-bold ">
                    Catatan Penolakan RAB: {{ procurement.comment }}
                </div>
            </div>
        </template>
    </Show>
</template>

<script setup>
import Show from "@/Layouts/Procurement/Show.vue";

const props = defineProps({
	procurement: { type: Object, required: true },
})

</script>