<template>
	<div v-if="files.length">
		<FilePreview v-for="file of files" :key="file.id" :file="file" tag="span" @remove="removeImage" />
		<!-- <button @click.prevent="uploadFiles(files)" class="upload-button">Upload</button> -->
	</div>
	<DropZone class="drop-area border-4 border-first border-dashed text-center flex flex-col align-center justify-center w-full h-full" @files-dropped="addImage" #default="{ dropZoneActive }" v-else>
		<div v-show="info.status == 9" class="text-secondary">{{ info.message }}</div>
		<label for="file-input" class="">
			<span v-if="dropZoneActive">
				<span>Letakkan Gambar disini</span>
				<!-- <span class="smaller">to add them</span> -->
			</span>
			<span v-else>
				<span c>Seret Gambar disini</span>
				<span class="smaller">
					atau <strong><em>klik disini</em></strong> untuk memilih file
				</span>
			</span>

			<input type="file" id="file-input" @change="onInputChange" accept="image/*" hidden />
		</label>
	</DropZone>
</template>

<script setup>
// Components
import DropZone from '@/Components/DropZoneImage/Dropzone.vue'
import FilePreview from '@/Components/DropZone/File-Preview.vue'


const emit = defineEmits(['addFiles','removeFile'])
const props = defineProps({
	files: { default: null },
	info : { default: null}
})

const addImage = (Image) => {
	emit('addFiles',Image)
}

const removeImage = (Image) => {
	emit('removeFile',Image)
}

function onInputChange(e) {
	emit('addFiles',e.target.files);
	// emit('verifikasiItem',e.target.files[0])
	e.target.value = null // reset so that selecting the same file again will still cause it to fire this change
}

</script>
