import { ref } from 'vue'

export default function () {
	const files = ref([])
	const info = ref([])

	function addFiles(newFiles) {
		const type = newFiles[0].type
		if(!type.includes("image")){
            info.value = new Fail("File harus berupa gambar");

            return;
        }
		info.value.status = 0;
		let newUploadableFiles = [...newFiles].map((file) => new UploadableFile(file)).filter((file) => !fileExists(file.id))
		files.value = newUploadableFiles
	}

	function fileExists(otherId) {
		return files.value.some(({ id }) => id === otherId)
	}

	function removeFile(file) {
		const index = files.value.indexOf(file)

		if (index > -1) files.value.splice(index, 1)
		info.value.status = 0;
	}

	return { files, info, addFiles, removeFile }
}

class Fail {
	constructor(text) {
		this.message = text
		this.status= 9
	}
}
class UploadableFile {
	constructor(file) {
		this.file = file
		this.id = `${file.name}-${file.size}-${file.lastModified}-${file.type}`
		this.url = URL.createObjectURL(file)
		this.status = null
	}
}