import{_ as D}from"./Master.83d66d13.js";import{_ as m}from"./Container.3c236ea6.js";import{_ as x}from"./Header1.4d5ae8c0.js";import{C as L,p as C,a as N,B as j,b as A,L as T,D as R,d as I}from"./dashboard.00611658.js";import{u as V,o as c,c as E,w as n,a as i,b as d,d as r,e as h,f as b,t as f,L as S,r as _}from"./app.cbadd5a6.js";import{h as K}from"./moment.9709ab41.js";const $={class:"flex justify-between items-center h-screen mt-10"},z={class:"w-6/12"},F={key:0,class:"w-6/12 ml-5"},J={class:"flex justify-between"},M={key:0},O={key:1,class:"text-center"},U=b("Lihat"),W={key:1,class:"w-5/12 text-right"},X=r("div",{class:"flex justify-end"},[r("div",{class:"text-right text-4xl font-extrabold tracking-widest text-first drop-shadow-xl flex"},"Pengadaan"),r("span",{class:"flex h-5 w-5 relative justify-center items-center"},[r("span",{class:"animate-ping absolute inline-flex h-full w-full rounded-full bg-error opacity-75 delay-200"}),r("span",{class:"animate-ping absolute inline-flex h-full w-full rounded-full bg-none border-error border-2 border-solid delay-75"}),r("span",{class:"animate-ping absolute inline-flex h-full w-full rounded-full bg-none border-error border-2 border-solid"}),r("span",{class:"right-0 relative inline-flex rounded-full h-3 w-3 bg-error"})])],-1),Z=r("div",{class:"text-right mr-5 text-4xl font-extrabold mb-5 tracking-widest text-first drop-shadow-xl"},"Barang dan Jasa",-1),q=r("div",{class:"text-lg tracking-wide leading-7"},"adalah kegiatan Pengadaan Barang / Jasa oleh Kementerian / Lembaga / Perangkat Daerah yang dibiayai oleh APBN/APBD yang prosesnya sejak identifikasi kebutuhan, sampai dengan serah terima hasil pekerjaan.",-1),G=[X,Z,q],se={__name:"Index",props:{groupedProc:{type:Object},width:{type:Number,default:200},height:{type:Number,default:300}},setup(g){const u=g;L.register(C,N,j,A,T);function v(e){for(var a="",s=e.toString().split("").reverse().join(""),o=0;o<s.length;o++)o%3==0&&(a+=s.substr(o,3)+".");return"Rp. "+a.split("",a.length-1).reverse().join("")}function k(e){var a=[];for(let t=2;t<11;t++)t>3?a[2]&&e[t]?a[2]=a[2]+e[t].length:e[t]&&a.push(e[t].length):e[t]?a.push(e[t].length):a.push(0);return a}const l=V({preview:[],start:null,end:null,month:null,year:null,error:"",error2:"",show:0}),w=["Pengecekan Akun","RAB ditolak","RAB diterima"],y={labels:[1,2,3],datasets:[{label:"Total",backgroundColor:["rgb(207,250,254, 0.4)","rgb(255,255,152, 0.3)","rgb(186,230,253, 0.2)","rgb(165,243,252, 0.3)","rgb(103,232,249, 0.3)","rgb(255,255,152, 0.6)","rgb(34,211,238, 0.3)","rgb(56,189,248, 0.4)"],borderColor:["rgb(207,250,254, 0.9)","rgb(255,231,138, 0.6)","rgb(186,230,253, 0.4)","rgb(165,243,252, 0.4)","rgb(103,232,249, 0.4)","rgb(255,231,138, 0.6)","rgb(34,211,238, 0.4)","rgb(56,189,248, 0.4)"],borderWidth:2,borderRadius:5,data:k(u.groupedProc)}]},P={responsive:!0,maintainAspectRatio:!1,scales:{y:{ticks:{beginAtZero:!0,callback:function(e){if(e%1===0)return e}},title:{text:"Total",display:!0}},x:{ticks:{},title:{text:"Fase Pengadaan",display:!0}}},plugins:{tooltip:{callbacks:{title:function(e){return w[e[0].dataIndex]},label:function(e){return"Total : "+e.formattedValue},afterFooter:function(){return"Klik untuk melihat"}}}},parsing:{xAxisKey:"id"},onClick:(e,a)=>{if(l.preview=[],a[0].index+2>3)for(let s=4;s<11;s++)u.groupedProc[s]&&(console.log(s,u.groupedProc[s]),u.groupedProc[s].forEach(o=>l.preview.push(o)));else l.preview=u.groupedProc[a[0].index+2];l.show=1}},B=[{text:"Tanggal",value:"date",sortable:!0},{text:"Nama",value:"name",sortable:!0},{text:"Kode RUP",value:"rup_code",sortable:!0},{text:"Nomor Akun",value:"account",sortable:!0},{text:"Nilai Rab",value:"total",sortable:!0},{text:"aksi",value:"aksi"}];return(e,a)=>{const s=_("Vue3Lottie"),o=_("EasyDataTable");return c(),E(D,null,{default:n(({loading:p})=>[i(s,{animationData:d(R),height:450,width:700},null,8,["animationData"]),r("div",$,[r("div",z,[i(x,{title:"Status Pengadaan","width-size":"100",class:""}),i(m,null,{default:n(()=>[i(d(I),{"chart-options":P,"chart-data":y,width:g.width,height:g.height},null,8,["width","height"])]),_:1})]),d(l).preview.length>0?(c(),h("div",F,[r("div",J,[i(x,{title:"Daftar Pengadaan","width-size":"100"}),r("button",{onClick:a[0]||(a[0]=()=>d(l).preview=[]),class:"btn btn-sm text-first bg-slate-200 border-none hover:text-white hover:bg-first font-bold"},"X")]),i(m,null,{default:n(()=>[i(o,{headers:B,items:d(l).preview,"table-class-name":"customize-table",sortBy:"status",sortType:"asc","rows-per-page":5,maxPaginationNumber:10,"buttons-pagination":""},{"item-date":n(({date:t})=>[b(f(d(K)(t).format("DD-MM-yy")),1)]),"item-rup_code":n(({rup_code:t})=>[t?(c(),h("div",M,f(t),1)):(c(),h("div",O,"---"))]),"item-total":n(({total:t})=>[b(f(v(t)),1)]),"item-aksi":n(({id:t})=>[i(d(S),{onClick:H=>p(),href:e.route("siren.procurement.show",t),class:"btn btn-xs text-first bg-slate-200 border-none hover:text-white hover:bg-first font-bold"},{default:n(()=>[U]),_:2},1032,["onClick","href"])]),_:2},1032,["items"])]),_:2},1024)])):(c(),h("div",W,G))])]),_:1})}}};export{se as default};
