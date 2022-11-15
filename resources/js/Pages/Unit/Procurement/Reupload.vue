<template>
    <Master>
        <template v-slot="{ loading }" }>
            <Header1 :title="'Form Revisi RAB'" widthSize="100" />
            <div class="flex items-center">
                <Container class="w-7/12">
                    <div class="flex flex-row px-5 pt-5">
                        <div class="w-5/12">
                            <Label for="Account" value="Akun Pengadaan" />
                            <Input
                                id="Account"
                                type="text"
                                class="mt-1 block w-full"
                                v-model="formRAB.account"
                                :status="formRAB.errors.account"
                            />
                            <div class="text-sm text-error mt-1 mb-4">{{ formRAB.errors.account }}</div>
        
                            <Label for="judul" value="Judul Pengadaan" />
                            <Input
                                id="judul"
                                type="text"
                                class="mt-1 block w-full"
                                v-model="formRAB.judul"
                                :status="formRAB.errors.judul"
                            />
                            <div class="text-sm text-error mt-1 mb-4">{{ formRAB.errors.judul }}</div>
                            <Label for="Description" value="Deskripsi Singkat" />
                            <Input
                                id="Description"
                                type="text"
                                class="mt-1 block w-full"
                                v-model="formRAB.description"
                                :status="formRAB.errors.description"
                            />
                            <div class="text-sm text-error mt-1 mb-4">{{ formRAB.errors.description }}</div>
                            
                            <Label for="category" value="Kategori Pengadaan" />
                            <Input
                                id="category"
                                type="search"
                                class="mt-1 block w-full"
                                v-model="formRAB.category"
                                list="categoryList"
                                :status="formRAB.errors.category"
                            />
                            <div class="text-sm text-error mt-1 mb-4">{{ formRAB.errors.category }}</div>
                            <datalist id="categoryList">
                                <option value="Barang" />
                                <option value="Pekerjaan Konstruksi" />
                                <option value="Jasa Konsultasi" />
                                <option value="Jasa Lainnya" />
                            </datalist>
                        <a href="http://127.0.0.1:8000/storage/format_rab.xlsx" target="_blank" download class="text-xs text-first underline underline-offset-8">Download Format RAB</a>
                        </div>
                        <div class="ml-10 grow">
                            <div v-if="formRAB.reupload" class="h-full pb-5 flex flex-col">
                                <Label for="judul" value="Data RAB" />
                                <p class="text-first font-bold flex-1">{{ procurement.name }}</p>
                                <div>
                                    <button
                                        @click="changeItem()"
                                        class="btn text-first bg-slate-200 border-none hover:text-white hover:bg-first font-bold"
                                    >
                                        Ubah Item
                                    </button>
                                    <button
                                        @click="reupload(loading)"
                                        class="ml-5 btn text-white bg-first border-none font-bold"
                                    >
                                        Ajukan Ulang
                                    </button>
            
                                </div>
                            </div>
                            <DropZone
                                class="drop-area border-4 border-first border-dashed text-center flex place-items-center drop-area border-4 border-first border-dashed text-center flex place-items-center w-full h-full"
                                @files-dropped="addFiles"
                                #default="{ dropZoneActive }"
                                v-else-if="!info.file_name"
                            >
                                <label for="file-input">
                                    <div v-if="info.status == 9" class="text-secondary">{{ info.message }}</div>
                                    <span v-if="dropZoneActive">
                                        <span>Letakkan File disini</span>
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
                                        @change="onInputChange"
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
                                <div>
                                    <button
                                        @click="cancel()"
                                        class="btn text-first bg-slate-200 border-none hover:text-white hover:bg-first font-bold"
                                    >
                                        Batal
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
                    <div class="divider"></div>
                    <div class="text-secondary font-bold ">
                        Catatan Penolakan RAB: {{ procurement.comment }}
                    </div>
                </Container>
                <Vue3Lottie v-if="!info.file_name" :animationData="RevisiDoc" :height="350" :width="500" />
                <Vue3Lottie v-else :animationData="GoodDocument" :height="250" :width="500" />
            </div>
            
        </template>

    </Master>
</template>

<script setup>

import Input from "@/Components/utils/Input.vue";
import Label from "@/Components/utils/Label.vue";
import Button from "@/Components/Button.vue";
import { useForm } from "@inertiajs/inertia-vue3";
import useFileList from "@/Components/composables/File-list";
import DropZone from "@/Components/DropZone/Index.vue";
import FilePreview from "@/Components/DropZone/File-Preview.vue";
import Master from "@/Layouts/Master.vue";
import Header1 from "@/Components/utils/Header1.vue";
import Container from "@/Components/utils/Container.vue";
import Notification from "@/Components/composables/Notification"
import GoodDocument from "/public/image/dashboard/goodDocument.json"
import RevisiDoc from "/public/image/dashboard/revisiDoc.json"

const emit = defineEmits(["convert"]);
const props = defineProps(['procurement']);
// const { uploadFiles } = createUploader("google.com");
const { info, data, addFiles, removeFile } = useFileList();
const toast = Notification() 

const formRAB = useForm({
    judul       : props.procurement.name,
    description : props.procurement.description,
    category    : props.procurement.category,
    account     : props.procurement.account,
    terms       : false,
    dataList    : null,
    dataInfo    : null,
    reupload    : true,
    _method     : 'patch',
});

const cancel = () => {
    formRAB.reupload = true;
    removeFile();
}

const changeItem = () => {
    formRAB.reupload = false;
    console.log("done")
}

const reupload = (loading) => {
    formRAB.post(route("unit.procurement.editinfo",props.procurement.id),{
        onSuccess:  () => {
            emit('convert',data,info)
            toast('success', 'Data RAB diubah, Berhasil mengajukan ulang RAB')
    },
        onError:    (e) => toast('error', 'Gagal mengajukan ulang RAB'),
        onStart: (e) => {
            loading()
            formRAB.clearErrors()
        },
        onFinish: () => loading()
    })
}

const storeDataXlxs = (loading) => {
    formRAB.dataList = data.value
    formRAB.dataInfo = info.value
    formRAB.post(route("unit.procurement.edititem",props.procurement.id),{
        onSuccess:  () => {
            emit('convert',data,info)
            toast('success', 'Item RAB diubah, Berhasil mengajukan ulang RAB')
    },
        onError:    (e) => {console.log("error", e)},
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
    addFiles(e.target.files);
    e.target.value = null;
}
</script>