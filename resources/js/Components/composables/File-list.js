import { ref } from "vue";
import { read, utils } from "xlsx";

export default function () {
    const info = ref([]);
    const data = ref([]);

    async function addFiles(newFiles, fileName) {
        const availableType = 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
        const title = ['No', 'Nama Barang', 'Spesifikasi', 'Jumlah', 'unit', 'Harga Satuan', 'Total Harga', 'Gambar', 'Peruntukan', 'Sumber']

        if(newFiles[0].type != availableType){
            info.value = new Fail("Tidak sesuai format RAB. File harus berformat xlxs.");

            return;
        }

        //read file RAB
        const file_read = read(await newFiles[0].arrayBuffer());
        //get Data RAB
        var dataRow = utils.sheet_to_json(file_read.Sheets[file_read.SheetNames[0]], { header: 1 });
        //hapus row xlxs yaang kosong
        console.log("old",dataRow)
        dataRow = dataRow.filter(x => x.length > 0);
        console.log("new",dataRow)
        if(JSON.stringify(dataRow[4]) != JSON.stringify(title) )         return info.value = new Fail("Urutan kolom item salah, Periksa kembali Format RAB")
        if(dataRow[dataRow.length-8][0] != 'Sub Total')   return info.value = new Fail("Kolom Sub Total tidak ditemukan, Periksa kembali Format RAB")
        if(dataRow[dataRow.length-7][0] != 'PPN 11%')     return info.value = new Fail("Kolom PPN tidak ditemukan, Periksa kembali Format RAB")
        if(dataRow[dataRow.length-6][0] != 'Overheat')    return info.value = new Fail("Kolom Overheat tidak ditemukan, Periksa kembali Format RAB")
        if(dataRow[dataRow.length-5][0] != 'Total')      return info.value = new Fail("Kolom Total tidak ditemukan, Periksa kembali Format RAB")
        //simpan data umum ke info
        info.value = new DataDetail(dataRow,fileName);
        data.value = dataRow.slice(5,-8)
    }

    function fileExists(otherId) {
        return info.value.some(({ id }) => id === otherId);
    }

    function removeFile(file) {
        info.value = [];
    }

    return { info, data, addFiles, removeFile };
}

class Fail {
    constructor(data){
        this.status = 9;
        this.message = data;
    }
}

class DataDetail {
    constructor(data,file_name) {
        // this.data = data;
        this.file_name              = file_name
        this.name                   = `${data[1]}`;
        this.year                   = `${data[2]}`;
        this.unit                   = `${data[3]}`;
        this.sub_total              = `${data[data.length-8][6]}`;
        this.ppn                    = `${data[data.length-7][6]}`;
        this.overheat               = `${data[data.length-6][6]}`;
        this.total                  = `${data[data.length-5][6]}`;
        this.executor               = `${data[data.length-2][0]}`;
        this.executor_id            = `${data[data.length-1][0]}`;
        this.person_responsible     = `${data[data.length-2][2]}`;
        this.person_responsible_id  = `${data[data.length-1][2]}`;
        this.PPK                    = `${data[data.length-2][4]}`;
        this.PPK_id                 = `${data[data.length-1][4]}`;
        this.treasurer              = `${data[data.length-2][6]}`;
        this.treasurer_id           = `${data[data.length-1][6]}`;
        this.status = 1;
    }
}
