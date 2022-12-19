<template>
    <Show :procurement=procurement >
        <template #amount>
            <Container class="mb-5">
                <Label value="Nilai RAB" />
                <p class="font-bold text-lg tracking-wider">{{ convertToRupiah(procurement.budget_plan.total) }}</p>
            </Container>
        </template>
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
import Container from "@/Components/utils/Container.vue";
import Header1 from "@/Components/utils/Header1.vue";
import Label from "@/Components/utils/Label.vue";

const props = defineProps({
	procurement: { type: Object, required: true },
})

function convertToRupiah (angka) {
    var rupiah = "";
    var angkarev = angka.toString().split("").reverse().join("");
    for (var i = 0; i < angkarev.length; i++)
        if (i % 3 == 0) rupiah += angkarev.substr(i, 3) + ".";
    return (
        "Rp. " +
        rupiah
            .split("", rupiah.length - 1)
            .reverse()
            .join("")
    );
}
</script>