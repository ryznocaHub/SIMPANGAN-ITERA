import h from"./Kop.ebbffca2.js";import{h as s}from"./moment.9709ab41.js";import{h as b}from"./html2pdf.12a6135b.js";import{a as f}from"./index.9ac7e1de.js";import{o as d,e as c,d as e,t as a,a as _,f as o,b as r,$ as g}from"./app.cbadd5a6.js";import"./_plugin-vue_export-helper.cdc0426e.js";const k={class:"flex justify-center"},p={id:"app",ref:"document",class:"w-1/2"},x={class:"border-2 border-black"},y={id:"element-to-convert"},P={class:"mx-10"},M={class:"font-bold text-lg text-center mt-5"},Y={class:"text-center"},S={class:"text-center"},j=e("div",{class:"text-justify mt-10"}," Yang bertanda tangan di bawah ini: ",-1),D={class:"flex"},w=e("div",{class:"w-28"},"Nama/NIP",-1),K=g('<div class="flex"><div class="w-28">Jabatan</div><div>: Pejabat Pembuat Komitmen <div> INSTITUT TEKNOLOGI SUMATERA</div></div></div><div class="flex"><div class="w-28">Alamat</div><div>: Jl. Terusan Ryacudu, Way Huwi, Jati Agung, Lampung Selatan, 35365</div></div><div class="mt-3">Selanjutnya disebut sebagai Pejabat Pembuat Komitmen </div>',3),N={key:0,class:"mt-3 text-justify"},T={class:"text-secondary"},A=o(", bersama ini memerintahkan: "),B={key:1,class:"mt-3 text-justify"},J={class:"text-secondary"},I=o(", bersama ini memerintahkan: "),L={class:"flex mt-3"},E=e("div",{class:"w-36"},"Nama Penyedia",-1),O={class:"flex text-justify"},U=e("div",{class:"w-36"},"Alamat",-1),V={class:"mt-3 text-justify"},F={class:"flex mt-3"},H=e("div",{class:"font-bold underline"},"1. Paket Pengadaan ",-1),R={class:"flex"},W=e("div",{class:"font-bold underline"},"2. Tanggal Mulai Kerja ",-1),$=e("div",{class:"flex"},[e("div",{class:"font-bold underline"},"3. Syarat-syarat Pekerjaan"),e("div",null," : Sesuai dengan persyaratan dan ketentuan SPK;")],-1),q={class:"flex"},C=e("div",{class:"font-bold underline w-64"},"4. Waktu Penyelesaian",-1),G=e("div",{class:"flex"},[e("div",{class:"w-64 grow font-bold underline"},"5. Denda"),e("div",{class:"text-justify"},": Terhadap setiap hari keterlambatan pelasanaan/penyelesaian pekerjaan Penyedia akan dikenakan Denda Keterlambatan sebesar 1/1000 (satu permil) dari nilai SPK atau dari nilai bagian SPK (tidak termasuk PPN) sesuai ketentuan dalam SPK.")],-1),z={class:"text-end mt-14"},Q={class:"flex justify-between mb-5"},X={class:"flex flex-col text-left"},Z=e("div",{class:""},"Untuk dan atas nama",-1),ee=e("div",{class:""},"Institut Teknologi Sumatera",-1),te=e("div",{class:""},"Pejabat Pembuat Komitmen",-1),ae={class:"font-bold mt-14"},ne={class:"font-bold"},se={class:"flex flex-col text-end"},ie=e("div",null,"Menerima dan menyetujui",-1),oe=e("div",null,"Untuk dan atas nama",-1),de={class:"font-bold mt-14"},ce={class:"font-bold"},be={__name:"SP",props:{procurement:{tipe:Object},title:{tipe:String}},setup(t){s.updateLocale("en",{months:["Januari","Feruari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember"],weekdays:["Minggu","Senin","Selasa","Rabu","Kamis","Jumat","Sabtu"]});const l=n=>s().format("DD MMMM YYYY"),u=n=>s(n,"YYYY-MM-DD h:mm:ss a").format("DD MMMM YYYY"),v=(n,i)=>{var i=i=="Barang"?"SPP":"SPMK";b(document.getElementById("element-to-convert"),{margin:0,filename:i+"_"+n+".pdf",image:{type:"jpeg",quality:.98},html2canvas:{scale:2},jsPDF:{unit:"in",format:"a4",orientation:"portrait"}})};return(n,m)=>(d(),c("div",k,[e("div",p,[e("button",{class:"btn bg-first border-none w-full text-white mb-5",onClick:m[0]||(m[0]=i=>v(t.procurement.name,t.procurement.category))},"Download "+a(t.procurement.category=="Barang"?"SPP":"SPMK"),1),e("div",x,[e("div",y,[_(h),e("div",P,[e("div",M,a(t.title),1),e("div",Y,"Nomor : "+a(t.procurement.contract.no_sp),1),e("div",S,"Paket Pekerjaan : "+a(t.procurement.account),1),j,e("div",D,[w,e("div",null,": "+a(t.procurement.executor.ppk.name)+" / "+a(t.procurement.executor.ppk.identity_number),1)]),K,t.procurement.estimate.total>5e7?(d(),c("div",N,[o("berdasarkan Surat Perintah Kerja (SPK) nomor: "+a(t.procurement.contract.no_spk)+" ",1),e("span",T,"tanggal "+a(l()),1),A])):(d(),c("div",B,[o("berdasarkan Berita Acara Hasil Pengadaan Langsung (BAHPL) nomor: "+a(t.procurement.contract.no_bahp)+" ",1),e("span",J,"tanggal "+a(l()),1),I])),e("div",L,[E,e("div",null,": "+a(t.procurement.suppliers.name),1)]),e("div",O,[U,e("div",null,": "+a(t.procurement.suppliers.address+", "+t.procurement.suppliers.regency+", "+t.procurement.suppliers.province),1)]),e("div",V,"yang dalam hal ini diwakili oleh: "+a(t.procurement.contract.pic)+" selanjutnya disebut sebagai Penyedia untuk segera memulai pelaksanaan pekerjaan dengan memperhatikan ketentuan-ketentuan sebagai berikut:",1),e("div",F,[H,e("div",null," : "+a(t.procurement.account)+";",1)]),e("div",R,[W,e("div",null," : "+a(r(s)(t.procurement.contract.date_start_spk,"YYYY-MM-DD").format("DD MMMM YYYY"))+";",1)]),$,e("div",q,[C,e("div",null,": Selama "+a(t.procurement.contract.days)+" ("+a(r(f)(t.procurement.contract.days))+") hari kalender dan pekerjaan harus sudah selesai pada tanggal "+a(r(s)(t.procurement.contract.date_end_spk,"YYYY-MM-DD").format("DD MMMM YYYY"))+";",1)]),G,e("div",z,"Lampung Selatan, "+a(u(t.procurement.contract.date_sp)),1),e("div",Q,[e("div",X,[Z,ee,te,e("div",ae,a(t.procurement.executor.ppk.name),1),e("div",ne,a(t.procurement.executor.ppk.identity_type)+". "+a(t.procurement.executor.ppk.identity_number),1)]),e("div",se,[ie,oe,e("div",null,a(t.procurement.suppliers.name),1),e("div",de,a(t.procurement.contract.pic),1),e("div",ce,a(t.procurement.contract.pic_position),1)])])])])])],512)]))}};export{be as default};
