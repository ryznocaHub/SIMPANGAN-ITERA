import { ref } from "vue";
import { read, utils } from "xlsx";

export default function () {
    const info = ref([]);
    const data = ref([]);

    async function addFiles(newFiles) {
        // let newUploadableFiles = [...newFiles]
        //     .map((file) => new UploadableFile(file))
        // files.value = newUploadableFiles;
        // files.value = newFiles;

        //read file RAB
        const file_read = read(await newFiles[0].arrayBuffer());
        //get Data RAB
        var dataRow = utils.sheet_to_json(file_read.Sheets[file_read.SheetNames[0]], { header: 1 });
        //hapus row xlxs yaang kosong
        dataRow = dataRow.filter(x => x.length > 0);
        //simpan data umum ke info
        info.value = new DataDetail(dataRow,dataRow[0]);
        //hanya mengambil data item
        data.value = dataRow.slice(5,-7)
        // console.log("file_read",file_read)
        // console.log("datarow",dataRow)
        // console.log("data",data.value)
        // console.log("info in file list",info.value);
    }

    function fileExists(otherId) {
        return info.value.some(({ id }) => id === otherId);
    }

    function removeFile(file) {
        info.value = [];
    }

    return { info, data, addFiles, removeFile };
}

class DataDetail {
    constructor(data,file_name) {
        // this.data = data;
        this.file_name              = file_name
        this.name                   = `${data[1]}`;
        this.year                   = `${data[2]}`;
        this.unit                   = `${data[3]}`;
        this.sub_total              = `${data[data.length-7][5]}`;
        this.PPN                    = `${data[data.length-6][5]}`;
        this.total                  = `${data[data.length-5][5]}`;
        this.executor               = `${data[data.length-2][0]}`;
        this.executor_id            = `${data[data.length-1][0]}`;
        this.person_responsible     = `${data[data.length-2][2]}`;
        this.person_responsible_id  = `${data[data.length-1][2]}`;
        this.PPK                    = `${data[data.length-2][4]}`;
        this.PPK_id                 = `${data[data.length-1][4]}`;
        this.treasurer              = `${data[data.length-2][6]}`;
        this.treasurer_id           = `${data[data.length-1][6]}`;
        // this.url = URL.createObjectURL(file);
        this.status = null;
    }
    // constructor(file) {
    //     this.file = file;
    //     this.id = `${file.name}-${file.size}-${file.lastModified}-${file.type}`;
    //     this.url = URL.createObjectURL(file);
    //     this.status = null;
    // }
}
