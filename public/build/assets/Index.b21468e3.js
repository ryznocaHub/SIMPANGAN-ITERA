import{_ as L}from"./Master.83d66d13.js";import{_ as p}from"./Container.3c236ea6.js";import{_ as m}from"./Header1.4d5ae8c0.js";import{C as B,p as C,a as j,B as N,b as T,L as S,D as A,d as I}from"./dashboard.00611658.js";import{u as V,o as h,c as E,w as i,a as n,b as d,d as r,e as x,f as g,t as _,L as K,r as v}from"./app.cbadd5a6.js";import{h as R}from"./moment.9709ab41.js";const $={class:"flex justify-between items-center h-screen mt-10"},z={class:"w-6/12"},O={key:0,class:"w-6/12 ml-5"},F={class:"flex justify-between"},J=g("Lihat"),M={key:1,class:"w-5/12 text-right"},H=r("div",{class:"flex justify-end"},[r("div",{class:"text-right text-4xl font-extrabold tracking-widest text-first drop-shadow-xl flex"},"Pengadaan"),r("span",{class:"flex h-5 w-5 relative justify-center items-center"},[r("span",{class:"animate-ping absolute inline-flex h-full w-full rounded-full bg-error opacity-75 delay-200"}),r("span",{class:"animate-ping absolute inline-flex h-full w-full rounded-full bg-none border-error border-2 border-solid delay-75"}),r("span",{class:"animate-ping absolute inline-flex h-full w-full rounded-full bg-none border-error border-2 border-solid"}),r("span",{class:"right-0 relative inline-flex rounded-full h-3 w-3 bg-error"})])],-1),W=r("div",{class:"text-right mr-5 text-4xl font-extrabold mb-5 tracking-widest text-first drop-shadow-xl"},"Barang dan Jasa",-1),X=r("div",{class:"text-lg tracking-wide leading-7"},"adalah kegiatan Pengadaan Barang / Jasa oleh Kementerian / Lembaga / Perangkat Daerah yang dibiayai oleh APBN/APBD yang prosesnya sejak identifikasi kebutuhan, sampai dengan serah terima hasil pekerjaan.",-1),Z=[H,W,X],ae={__name:"Index",props:{procurements:{type:Object},groupedProc:{type:Object},width:{type:Number,default:200},height:{type:Number,default:300}},setup(c){const u=c;B.register(C,j,N,T,S);function w(e){for(var t="",s=e.toString().split("").reverse().join(""),o=0;o<s.length;o++)o%3==0&&(t+=s.substr(o,3)+".");return"Rp. "+t.split("",t.length-1).reverse().join("")}function k(e){var t=[];for(let a=9;a<11;a++)console.log(e[a]),a>9?t[1]&&e[a]?t[1]=t[1]+e[a].length:e[a]&&t.push(e[a].length):e[a]?t.push(e[a].length):t.push(0);return t}const l=V({preview:[],start:null,end:null,month:null,year:null,error:"",error2:"",show:0}),f=["Pembuatan Dokumen","Kontrak Selesai"],y={labels:f,datasets:[{label:"Total",backgroundColor:["rgb(207,250,254, 0.4)","rgb(255,255,152, 0.3)","rgb(186,230,253, 0.2)","rgb(165,243,252, 0.3)","rgb(103,232,249, 0.3)","rgb(255,255,152, 0.6)","rgb(34,211,238, 0.3)","rgb(56,189,248, 0.4)"],borderColor:["rgb(207,250,254, 0.9)","rgb(255,231,138, 0.6)","rgb(186,230,253, 0.4)","rgb(165,243,252, 0.4)","rgb(103,232,249, 0.4)","rgb(255,231,138, 0.6)","rgb(34,211,238, 0.4)","rgb(56,189,248, 0.4)"],borderWidth:2,borderRadius:5,data:k(u.groupedProc)}]},P={responsive:!0,maintainAspectRatio:!1,scales:{y:{ticks:{beginAtZero:!0,callback:function(e){if(e%1===0)return e}},title:{text:"Total",display:!0}},x:{ticks:{}}},plugins:{tooltip:{callbacks:{title:function(e){return f[e[0].dataIndex]},label:function(e){return"Total : "+e.formattedValue},afterFooter:function(){return"Klik untuk melihat"}}}},parsing:{xAxisKey:"id"},onClick:(e,t)=>{if(l.preview=null,t[0].index+9>=10)for(let s=10;s<11;s++)u.groupedProc[s]&&u.groupedProc[s].forEach(o=>l.preview.push(o));else l.preview=u.groupedProc[t[0].index+9];l.show=1}},D=[{text:"Tanggal",value:"date",sortable:!0},{text:"Nama",value:"name",sortable:!0},{text:"Nomor Akun",value:"account",sortable:!0},{text:"Nilai HPS",value:"total",sortable:!0},{text:"aksi",value:"aksi"}];return(e,t)=>{const s=v("Vue3Lottie"),o=v("EasyDataTable");return h(),E(L,null,{default:i(({loading:b})=>[n(s,{animationData:d(A),height:450,width:700},null,8,["animationData"]),r("div",$,[r("div",z,[n(m,{title:"Status Pengadaan","width-size":"100",class:""}),n(p,null,{default:i(()=>[n(d(I),{"chart-options":P,"chart-data":y,width:c.width,height:c.height},null,8,["width","height"])]),_:1})]),d(l).preview.length>0?(h(),x("div",O,[r("div",F,[n(m,{title:"Daftar Pengadaan","width-size":"100"}),r("button",{onClick:t[0]||(t[0]=()=>d(l).preview=null),class:"btn btn-sm text-first bg-slate-200 border-none hover:text-white hover:bg-first font-bold"},"X")]),n(p,null,{default:i(()=>[n(o,{headers:D,items:d(l).preview,"table-class-name":"customize-table",sortBy:"status",sortType:"asc","rows-per-page":5,maxPaginationNumber:10,"buttons-pagination":""},{"item-date":i(({date:a})=>[g(_(d(R)(a).format("DD-MM-yy")),1)]),"item-total":i(({total:a})=>[g(_(w(a)),1)]),"item-aksi":i(({id:a})=>[n(d(K),{onClick:q=>b(),href:e.route("kontrak.procurement.show",a),class:"btn btn-xs text-first bg-slate-200 border-none hover:text-white hover:bg-first font-bold"},{default:i(()=>[J]),_:2},1032,["onClick","href"])]),_:2},1032,["items"])]),_:2},1024)])):(h(),x("div",M,Z))])]),_:1})}}};export{ae as default};
