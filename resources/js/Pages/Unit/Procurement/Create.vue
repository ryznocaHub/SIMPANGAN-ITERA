<template>
    <Master >
        <template v-slot="{ loading }" }>
            <Header1 :title="'Form Pengajuan RAB'" widthSize="100" />
            <div class="flex">
                <Container class="w-7/12">
                    <div class="flex flex-row p-5">
                        <div class="w-4/12">
                            <Label for="Account" value="Akun Pengadaan" />
                            <Input
                                id="Account"
                                type="text"
                                class="mt-1 block w-full"
                                v-model="formRAB.account"
                                :status="formRAB.errors.account"
                            />
                            <div class="text-sm text-error mt-1 mb-4" v-if="formRAB.errors.account">{{ formRAB.errors.account }}</div>
                            <Label for="Description" value="Deskripsi Singkat" />
                            <Input
                                id="Description"
                                type="text"
                                class="mt-1 block w-full"
                                v-model="formRAB.description"
                                :status="formRAB.errors.description"
                            />
                            <div class="text-sm text-error mt-1 mb-4"  v-if="formRAB.errors.description">{{ formRAB.errors.description }}</div>
                            <Label for="category" value="Kategori Pengadaan" />
                            <Input
                                id="category"
                                type="search"
                                class="mt-1 block w-full"
                                v-model="formRAB.category"
                                list="categoryList"
                                :status="formRAB.errors.category"
                            />
                            <div class="text-sm text-error mt-1 mb-4"  v-if="formRAB.errors.category">{{ formRAB.errors.category }}</div>
                            <datalist id="categoryList">
                                <option value="Barang" />
                                <option value="Pekerjaan Konstruksi" />
                                <option value="Jasa Konsultasi" />
                                <option value="Jasa Lainnya" />
                            </datalist>
                        <a href="http://127.0.0.1:8000/storage/format_rab.xlsx" target="_blank" download class="text-xs text-first underline underline-offset-8">Download Format RAB</a>
                        </div>
                        <div class="ml-10 grow">
                            <!-- <Label for="file" value="File RAB" /> -->
                            <DropZone
                                class="drop-area border-4 border-first border-dashed text-center flex flex-col align-center justify-center w-full h-full"
                                :class="{'border-success' : dropZoneActive}"
                                @files-dropped="addFiles"
                                #default="{ dropZoneActive }"
                                v-if="!info.file_name"
                            >
                                <label for="file-input">
                                    <div v-if="info.status == 9" class="text-secondary">{{ info.message }}</div>
                                    <span v-if="dropZoneActive">
                                        <span>Letakkan File disini </span>
                                        <span class="smaller">untuk menambah file</span>
                                    </span>
                                    <span v-else>
                                        <span>Seret File RAB ke area ini</span>
                                        <span class="smaller">
                                            atau <strong><em>klik disini</em></strong> untuk
                                            memilih file
                                        </span>
                                    </span>
                                        <input
                                        type="file"
                                        id="file-input"
                                        accept=".xlsx"
                                        hidden
                                        @change="e => onInputChange(e)"
                                    />
                                </label>
                            </DropZone>
                            <div v-else class="h-full pb-5 flex flex-col">
                                <Label for="judul" value="File RAB" />
                                <p class="text-first font-bold " :class="{'flex-1' : !formRAB.errors['dataInfo.PPK']}">{{ info.file_name }}</p>
                                <div v-if="formRAB.errors['dataInfo.PPK']" class="my-3">
                                    <div class="text-error text-sm flex-1">Tidak Sesuai Format RAB / {{ formRAB.errors['dataInfo.PPK'] }}</div>
                                    <div class="text-error text-sm flex-1">PPK yang tersedia:</div>
                                    <div v-for="ppk in ppks" :key="ppk.id" class="text-error text-sm flex-1">{{ppk.name}}</div>
                                </div>
                                <!-- @click.prevent="uploadFiles(info)" -->
                                    <!-- @click="emit('convert',data,info)" -->
                                <div>
                                    <button
                                        @click="cancel()"
                                        class="btn text-first bg-slate-200 border-none hover:text-white hover:bg-first font-bold"
                                    >
                                        Cancel
                                    </button>
                                    <button
                                        @click="storeDataXlxs(loading)"
                                        class="ml-5 btn text-white bg-first border-none font-bold"
                                    >
                                        Convert RAB
                                    </button>
            
                                </div>
                            </div>
                        </div>
                    </div>
                </Container>
                <Vue3Lottie v-if="!info.file_name" :animationData="Upload" :height="250" :width="500" />
                <Vue3Lottie v-else :animationData="GoodDocument" :height="250" :width="500" />
            </div>
        </template>
    </Master>
</template>

<script setup>

import Input from "@/Components/utils/Input.vue";
import Label from "@/Components/utils/Label.vue";
import { useForm } from "@inertiajs/inertia-vue3";
import useFileList from "@/Components/composables/File-list";
import DropZone from "@/Components/DropZone/Index.vue";
import FilePreview from "@/Components/DropZone/File-Preview.vue";
import Master from "@/Layouts/Master.vue";
import Header1 from "@/Components/utils/Header1.vue";
import Container from "@/Components/utils/Container.vue";
import Notification from "@/Components/composables/Notification"
import Upload from "/public/image/dashboard/uploadFile.json"
import GoodDocument from "/public/image/dashboard/goodDocument.json"

defineProps({
    ppks        : {type: Object}
})

const formRAB = useForm({
    judul       : "",
    description : "",
    category    : "",
    account     : "",
    terms       : false,
    dataList    : null,
    dataInfo    : null
});

const emit = defineEmits(["convert"]);
const { info, data, addFiles, removeFile } = useFileList();
const toast = Notification() 

const cancel = () => {
    formRAB.clearErrors('dataInfo.PPK')
    removeFile();
}

const storeDataXlxs = (loading) => {
    formRAB.dataList = data.value
    formRAB.dataInfo = info.value
    
    formRAB.post(route("unit.procurement.store"),{
        onSuccess:  () => {
            emit('convert',data,info);
            toast('success', 'Berhasil Convert RAB')
        },
        onError:    (e) => {
            console.log("error", e)
            toast('error', 'Gagal Convert RAB')

        },
        onStart: (e) => {
            loading()
            formRAB.clearErrors()
        },
        onFinish: () => loading()
    })
    // console.log(formRAB.dataList)
}

// untuk tag input
function onInputChange(e) {
    addFiles(e.target.files, e.target.files[0].name);
    e.target.value = null;
}
</script>