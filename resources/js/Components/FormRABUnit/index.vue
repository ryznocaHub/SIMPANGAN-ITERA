<template>
    <div class="flex flex-row max-w-max">
        <div>
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
            <Label for="file" value="File RAB" />
            <DropZone
                class="drop-area"
                @files-dropped="addFiles"
                #default="{ dropZoneActive }"
                v-if="!info.name"
            >
                <label for="file-input">
                    <span v-if="dropZoneActive">
                        <span>Drop Them Here</span>
                        <span class="smaller">to add them</span>
                    </span>
                    <span v-else>
                        <span>Drag Your Files Here</span>
                        <span class="smaller">
                            or <strong><em>click here</em></strong> to
                            select files
                        </span>
                    </span>

                    <input
                        type="file"
                        id="file-input"
                        accept=".xlsx"
                        @change="onInputChange"
                    />
                </label>
                <!-- <ul class="image-list" v-show="files.value">
                    <FilePreview
                        v-for="file of files"
                        :key="file"
                        tag="li"
                        @remove="removeFile"
                    />
                </ul> -->
            </DropZone>
            <div v-else>
                <p>{{ info.name }}</p>
                <!-- @click.prevent="uploadFiles(info)" -->
                    <!-- @click="emit('convert',data,info)" -->
                <button
                    @click="storeDataXlxs()"
                    class="upload-button"
                >
                    Convert
                </button>
            </div>
        </div>
    </div>
</template>

<script setup>
import Input from "../../Components/utils/Input.vue";
import Label from "../../Components/utils/Label.vue";
import { useForm } from "@inertiajs/inertia-vue3";
import useFileList from "../composables/File-list";
import DropZone from "../DropZone/Index.vue";
import FilePreview from "../DropZone/File-Preview.vue";
// import createUploader from "../composables/File-Uploader";

const formRAB = useForm({
    judul: "",
    category: "",
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

const storeDataXlxs = () => {
    formRAB.dataList = data.value
    formRAB.dataInfo = info.value
    // emit('convert',data,info);
    formRAB.post(route("procurement.store"),{
        onSuccess:  () => {emit('convert',data,info);},
        onError:    () => {console.log("error")}
    
    })
    // console.log(formRAB.dataList)
}

// untuk tag input
function onInputChange(e) {
    addFiles(e.target.files);
    e.target.value = null;
}

</script>