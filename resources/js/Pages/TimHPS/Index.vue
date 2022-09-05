<template>
    <Master>
        <Header1 :title="x.convert ? 'RAB '+ info.name :'Form Pengajuan RAB'" widthSize="100" />

        <div v-if="x.convert">
            done
        </div>

        <Container v-else>
            <FormRABUnit @convert="convertXlxs"/>
        </Container>
    </Master>
</template>

<script setup>
import FormRABUnit from "../../Components/FormRABUnit/index.vue";

const convertXlxs = (datas,infos) => {
    // data.value = datas.value;
    // info.value = infos.value;
    // x.items = convertToArrObj(datas.value);
    // console.log(x.items);
    // x.itemPreview = datas.value[0];
    // x.convert = !x.convert;
};

</script>

<style></style>
