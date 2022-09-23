<template>
    <Master>
        <Header1 :title="'Form Pengajuan RAB'" widthSize="100" />
        <Container>
            <div class="flex flex-row max-w-max p-5">
                <div>
                    <Label for="Account" value="Akun Pengadaan" />
                    <Input
                        id="Account"
                        type="text"
                        class="mt-1 block w-full"
                        v-model="formRAB.account"
                        placeholder="Akun Pengadaan"
                        required
                    />
                    <Label for="judul" value="Judul Pengadaan" />
                    <Input
                        id="judul"
                        type="text"
                        class="mt-1 block w-full"
                        v-model="formRAB.judul"
                        placeholder="Judul Pengadaan"
                        required
                        autocomplete="judul"
                    />

                    <Label for="category" value="Kategori Pengadaan" />
                    <Input
                        id="category"
                        type="search"
                        class="mt-1 block w-full"
                        v-model="formRAB.category"
                        placeholder="Kategori Pengadaan"
                        list="categoryList"
                        required
                    />
                    <datalist id="categoryList">
                        <option value="Barang" />
                        <option value="Pekerjaan Konstruksi" />
                        <option value="Jasa Konsultasi" />
                        <option value="Jasa Lainnya" />
                    </datalist>
                </div>
                <div class="ml-10">
                    <!-- <Label for="file" value="File RAB" /> -->
                    <DropZone
                        class="drop-area border-4 border-first border-dashed text-center flex place-items-center drop-area border-4 border-first border-dashed text-center flex place-items-center w-full h-full"
                        @files-dropped="addFiles"
                        #default="{ dropZoneActive }"
                        v-if="!info.file_name"
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
                        <p class="text-first font-bold flex-1">{{ info.file_name }}</p>
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
                                @click="storeDataXlxs()"
                                class="ml-5 btn text-white bg-first border-none font-bold"
                            >
                                Convert RAB
                            </button>
    
                        </div>
                    </div>
                </div>
            </div>
        </Container>
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
// import createUploader from "../composables/File-Uploader";

const formRAB = useForm({
    judul: "",
    category: "",
    account: "",
    terms: false,
    dataList: null,
    dataInfo: null
});

const emit = defineEmits(["convert"]);
// const { uploadFiles } = createUploader("google.com");
const { info, data, addFiles, removeFile } = useFileList();

// const submit = () => {
    // form.post(route("procureAccount.store"), {
        // onFinish: () => form.reset("judul", "category"),
    // });
// };
const cancel = () => {
    removeFile();
}

const storeDataXlxs = () => {
    formRAB.dataList = data.value
    formRAB.dataInfo = info.value
    // emit('convert',data,info);
    formRAB.post(route("unit.procurement.store"),{
        onSuccess:  () => {emit('convert',data,info);},
        onError:    (e) => {console.log("error", e)}
    
    })
    // console.log(formRAB.dataList)
}

// untuk tag input
function onInputChange(e) {
    addFiles(e.target.files);
    e.target.value = null;
}
</script>