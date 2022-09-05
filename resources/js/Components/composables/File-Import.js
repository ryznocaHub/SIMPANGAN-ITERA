import { ref } from "vue";
import { read, utils } from "xlsx";

export default function () {
    const files = ref([]);

    async function addFiles(newFiles) {
        console.log("files",newFiles)
        let newUploadableFiles = [...newFiles]
            .map((file) => new UploadableFile(file))
            .filter((file) => !fileExists(file.id));
        files.value = newUploadableFiles;
        console.log("new",files)
        // files.value = newFiles;
        // const data = read(await newFiles[0].arrayBuffer());
        // dataRow.value = utils.sheet_to_json(data.Sheets[data.SheetNames[0]], { header: 1 });
        // dataRow.value = dataRow.filter(x => x.length > 0);
        // console.log("value",dataRow.value);
        // console.log("dat",dataRow);
    }

    function fileExists(otherId) {
        return files.value.some(({ id }) => id === otherId);
    }

    function removeFile(file) {
        files.value = [];
    }

    return { files, addFiles, removeFile };
}

class UploadableFile {
    constructor(file) {
        this.file = file;
        this.id = `${file.name}-${file.size}-${file.lastModified}-${file.type}`;
        this.url = URL.createObjectURL(file);
        
        this.status = null;
    }
}
