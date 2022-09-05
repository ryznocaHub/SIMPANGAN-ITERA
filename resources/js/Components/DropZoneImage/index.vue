<template>
	<div v-if="files.length">
		<FilePreview v-for="file of files" :key="file.id" :file="file" tag="span" @remove="removeImage" />
		<!-- <button @click.prevent="uploadFiles(files)" class="upload-button">Upload</button> -->
	</div>
	<DropZone class="drop-area border-2 border-slate-300 border-dashed text-center flex place-items-center w-full h-full" @files-dropped="addImage" #default="{ dropZoneActive }" @verifikasi="verifikasi" v-else>
		<label for="file-input " class="">
			<span v-if="dropZoneActive">
				<span>Drop Them Here</span>
				<span class="smaller">to add them</span>
			</span>
			<span v-else>
				<span>Drag Your Files Here</span>
				<span class="smaller">
					or <strong><em>click here</em></strong> to select files
				</span>
			</span>

			<input type="file" id="file-input" @change="onInputChange" />
		</label>
	</DropZone>
</template>

<script setup>
// Components
import DropZone from '@/Components/DropZoneImage/Dropzone.vue'
import FilePreview from '@/Components/DropZone/File-Preview.vue'


const emit = defineEmits(['verifikasiItem','addFiles','removeFile'])
const props = defineProps({
	files: { default: null },
})

const addImage = (Image) => {
	emit('addFiles',Image)
}

const removeImage = (Image) => {
	emit('removeFile',Image)
}

const verifikasi = (imageFile) => {
	emit('verifikasiItem',imageFile)
}

function onInputChange(e) {
	emit('addFiles',e.target.files);
	emit('verifikasiItem',e.target.files[0])
	e.target.value = null // reset so that selecting the same file again will still cause it to fire this change
}

</script>
