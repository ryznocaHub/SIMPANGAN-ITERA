import{_ as L}from"./Master.83d66d13.js";import{_ as b}from"./Container.3c236ea6.js";import{_ as p}from"./Header1.4d5ae8c0.js";import{C as j,p as B,a as C,B as S,b as N,L as T,D as A,d as H}from"./dashboard.00611658.js";import{u as I,o as h,c as V,w as l,a as o,b as d,d as r,e as m,f as g,t as x,L as E,r as _}from"./app.cbadd5a6.js";import{h as R}from"./moment.9709ab41.js";const $={class:"flex justify-between items-center h-screen mt-10"},z={class:"w-6/12"},F={key:0,class:"w-6/12 ml-5"},K={class:"flex justify-between"},O=g("Lihat"),J={key:1,class:"w-5/12 text-right"},M=r("div",{class:"flex justify-end"},[r("div",{class:"text-right text-4xl font-extrabold tracking-widest text-first drop-shadow-xl flex"},"Pengadaan"),r("span",{class:"flex h-5 w-5 relative justify-center items-center"},[r("span",{class:"animate-ping absolute inline-flex h-full w-full rounded-full bg-error opacity-75 delay-200"}),r("span",{class:"animate-ping absolute inline-flex h-full w-full rounded-full bg-none border-error border-2 border-solid delay-75"}),r("span",{class:"animate-ping absolute inline-flex h-full w-full rounded-full bg-none border-error border-2 border-solid"}),r("span",{class:"right-0 relative inline-flex rounded-full h-3 w-3 bg-error"})])],-1),W=r("div",{class:"text-right mr-5 text-4xl font-extrabold mb-5 tracking-widest text-first drop-shadow-xl"},"Barang dan Jasa",-1),X=r("div",{class:"text-lg tracking-wide leading-7"},"adalah kegiatan Pengadaan Barang / Jasa oleh Kementerian / Lembaga / Perangkat Daerah yang dibiayai oleh APBN/APBD yang prosesnya sejak identifikasi kebutuhan, sampai dengan serah terima hasil pekerjaan.",-1),Z=[M,W,X],ae={__name:"Index",props:{procurements:{type:Object},groupedProc:{type:Object},width:{type:Number,default:200},height:{type:Number,default:300}},setup(c){const u=c;j.register(B,C,S,N,T);function v(e){for(var t="",s=e.toString().split("").reverse().join(""),n=0;n<s.length;n++)n%3==0&&(t+=s.substr(n,3)+".");return"Rp. "+t.split("",t.length-1).reverse().join("")}function w(e){var t=[];for(let a=4;a<11;a++)a>7?t[4]&&e[a]?t[4]=t[4]+e[a].length:e[a]&&t.push(e[a].length):e[a]?t.push(e[a].length):t.push(0);return t}const i=I({preview:[],start:null,end:null,month:null,year:null,error:"",error2:"",show:0}),k=["Penunjukan Tim HPS","Pembuatan HPS","Persetujuan HPS","HPS ditolak","HPS diterima"],y={labels:[1,2,3,4,5],datasets:[{label:"Total",backgroundColor:["rgb(207,250,254, 0.4)","rgb(255,255,152, 0.3)","rgb(186,230,253, 0.2)","rgb(165,243,252, 0.3)","rgb(103,232,249, 0.3)","rgb(255,255,152, 0.6)","rgb(34,211,238, 0.3)","rgb(56,189,248, 0.4)"],borderColor:["rgb(207,250,254, 0.9)","rgb(255,231,138, 0.6)","rgb(186,230,253, 0.4)","rgb(165,243,252, 0.4)","rgb(103,232,249, 0.4)","rgb(255,231,138, 0.6)","rgb(34,211,238, 0.4)","rgb(56,189,248, 0.4)"],borderWidth:2,borderRadius:5,data:w(u.groupedProc)}]},P={responsive:!0,maintainAspectRatio:!1,scales:{y:{ticks:{beginAtZero:!0,callback:function(e){if(e%1===0)return e}},title:{text:"Total",display:!0}},x:{ticks:{},title:{text:"Fase Pengadaan",display:!0}}},plugins:{tooltip:{callbacks:{title:function(e){return k[e[0].dataIndex]},label:function(e){return"Total : "+e.formattedValue},afterFooter:function(){return"Klik untuk melihat"}}}},parsing:{xAxisKey:"id"},onClick:(e,t)=>{if(i.preview=[],t[0].index+4>=8)for(let s=8;s<11;s++)u.groupedProc[s]&&u.groupedProc[s].forEach(n=>i.preview.push(n));else i.preview=u.groupedProc[t[0].index+4];i.show=1}},D=[{text:"Tanggal",value:"date",sortable:!0},{text:"Nama",value:"name",sortable:!0},{text:"Nomor Akun",value:"account",sortable:!0},{text:"Nilai HPS",value:"total",sortable:!0},{text:"aksi",value:"aksi"}];return(e,t)=>{const s=_("Vue3Lottie"),n=_("EasyDataTable");return h(),V(L,null,{default:l(({loading:f})=>[o(s,{animationData:d(A),height:450,width:700},null,8,["animationData"]),r("div",$,[r("div",z,[o(p,{title:"Status Pengadaan","width-size":"100",class:""}),o(b,null,{default:l(()=>[o(d(H),{"chart-options":P,"chart-data":y,width:c.width,height:c.height},null,8,["width","height"])]),_:1})]),d(i).preview.length>0?(h(),m("div",F,[r("div",K,[o(p,{title:"Daftar Pengadaan","width-size":"100"}),r("button",{onClick:t[0]||(t[0]=()=>d(i).preview=[]),class:"btn btn-sm text-first bg-slate-200 border-none hover:text-white hover:bg-first font-bold"},"X")]),o(b,null,{default:l(()=>[o(n,{headers:D,items:d(i).preview,"table-class-name":"customize-table",sortBy:"status",sortType:"asc","rows-per-page":5,maxPaginationNumber:10,"buttons-pagination":""},{"item-date":l(({date:a})=>[g(x(d(R)(a).format("DD-MM-yy")),1)]),"item-total":l(({total:a})=>[g(x(v(a)),1)]),"item-aksi":l(({id:a})=>[o(d(E),{onClick:q=>f(),href:e.route("ppk.procurement.show",a),class:"btn btn-xs text-first bg-slate-200 border-none hover:text-white hover:bg-first font-bold"},{default:l(()=>[O]),_:2},1032,["onClick","href"])]),_:2},1032,["items"])]),_:2},1024)])):(h(),m("div",J,Z))])]),_:1})}}};export{ae as default};
