import{_ as y}from"./Master.1f615f96.js";import{_ as v}from"./Container.dd8793cc.js";import{_ as g}from"./Header1.119769ea.js";import{_ as o}from"./Label.e165355e.js";import{_ as P}from"./index.fb6969b9.js";import{h as S,i as N,o as c,c as m,w as i,d as t,a as s,t as a,e as l,g as r,b as d,L as _,j as k,f as w}from"./app.df3260cc.js";import{h as $}from"./moment.9709ab41.js";const j={class:"flex"},B={class:"text-sm mb-10 text-gray-500"},C={class:"flex"},Y={class:"flex justify-between"},D={class:"flex"},K=t("div",{class:"mx-3 text-first"},"I",-1),R=t("div",{class:"mx-3 text-first"},"I",-1),T={class:"flex"},A={key:0,class:"mx-3 text-first"},I={class:"flex"},z=w("Unggah Gambar"),M=w("Buat HPS"),V=w("Lihat Item"),H={class:"ml-5"},U=t("div",{class:"divider"},null,-1),L={class:"flex flex-wrap"},J={class:"flex flex-col basis-1/2"},O={class:"font-bold text-lg tracking-wider"},q={class:"font-bold text-sm tracking-wider"},E={class:"ml-5 flex flex-col"},G={class:"font-bold text-lg tracking-wider"},F={class:"font-bold text-sm tracking-wider"},Q={class:"flex flex-col basis-1/2 mt-10"},W={class:"font-bold text-lg tracking-wider"},X={class:"font-bold text-sm tracking-wider"},Z={class:"ml-5 flex flex-col mt-10"},ee={class:"font-bold text-lg tracking-wider"},te={class:"font-bold text-sm tracking-wider"},se={key:0,class:"flex-auto flex flex-col ml-5"},oe={class:"font-bold text-lg tracking-wider"},ae={class:"font-bold text-lg tracking-wider"},ce={class:"font-bold text-lg tracking-wider"},re={key:0,class:"flex mt-10 w-12/12"},le={key:0,class:""},ne={class:"font-bold text-lg tracking-wider"},ie={key:1,class:"mt-5"},ue={class:"font-bold text-lg tracking-wider"},de={key:2,class:"mt-5"},me={class:"font-bold text-lg tracking-wider"},fe={key:3,class:"mt-5"},he={class:"font-bold text-lg tracking-wider"},ve={key:4,class:"mt-5"},xe={class:"font-bold text-lg tracking-wider"},ge={class:""},be={class:"font-bold text-lg tracking-wider"},ke={key:0,class:"mt-5"},_e={class:"font-bold text-lg tracking-wider"},we={key:1,class:"mt-5"},pe={class:"font-bold text-lg tracking-wider"},ye={class:"mt-5"},Pe={class:"font-bold text-lg tracking-wider"},Se={class:""},Ne={class:"font-bold text-lg tracking-wider"},$e={key:0,class:"mt-5"},je={class:"font-bold text-lg tracking-wider"},Be={key:1,class:"mt-5"},Ce={class:"font-bold text-lg tracking-wider"},Ye={class:"mt-5"},De={class:"font-bold text-lg tracking-wider"},Ke={class:""},Re={class:"font-bold text-lg tracking-wider"},Te={key:0,class:"mt-5"},Ae={class:"font-bold text-lg tracking-wider"},Je={__name:"Show",props:{procurement:{type:Object,required:!0}},setup(e){const f=S(()=>N().props.value.auth.user),p=u=>$(u,"YYYY-MM-DD h:mm:ss a").format("DD-MM-YYYY");function n(u){for(var b="",h=u.toString().split("").reverse().join(""),x=0;x<h.length;x++)x%3==0&&(b+=h.substr(x,3)+".");return"Rp. "+b.split("",b.length-1).reverse().join("")}return(u,b)=>(c(),m(y,null,{default:i(({loading:h})=>[t("div",j,[s(g,{title:e.procurement.name,widthSize:"100",class:"mb-5"},null,8,["title"]),s(P,{status:e.procurement.status},null,8,["status"])]),t("p",B,a(e.procurement.description),1),t("div",C,[s(v,{class:"justify-between w-9/12"},{default:i(()=>[t("div",Y,[t("div",null,[t("div",D,[s(o,{value:"Kategori "+e.procurement.category},null,8,["value"]),K,s(o,{value:"Tahun Anggaran "+e.procurement.year},null,8,["value"]),R,s(o,{value:"Unit "+e.procurement.unit},null,8,["value"])]),t("div",T,[s(o,{value:"Nomor Akun "+e.procurement.account},null,8,["value"]),e.procurement.rup_code?(c(),l("div",A,"I")):r("",!0),e.procurement.rup_code?(c(),m(o,{key:1,value:"Kode RUP "+e.procurement.rup_code},null,8,["value"])):r("",!0)]),s(o,{value:"diajukan pada "+p(e.procurement.timeline.rab_submitted)},null,8,["value"])]),t("div",I,[e.procurement.status==1?(c(),m(d(_),{key:0,onClick:x=>h(),href:u.route("unit.procurement.edit",e.procurement.id),class:"btn bg-first border-first"},{default:i(()=>[z]),_:2},1032,["onClick","href"])):e.procurement.status==5&&d(f).role==4?(c(),m(d(_),{key:1,onClick:x=>h(),href:u.route("hps.procurement.edit",e.procurement.id),class:"btn bg-first border-first"},{default:i(()=>[M]),_:2},1032,["onClick","href"])):e.procurement.status>=2?(c(),m(d(_),{key:2,onClick:x=>h(),href:u.route("item.show",e.procurement.id),class:"btn bg-first border-first"},{default:i(()=>[V]),_:2},1032,["onClick","href"])):r("",!0),t("div",H,[k(u.$slots,"file",{loading:h})])])]),U,t("div",L,[t("div",J,[s(o,{value:"Pelaksana"}),t("p",O,a(e.procurement.executor.executor),1),t("p",q,a(e.procurement.executor.executor_id),1)]),t("div",E,[s(o,{value:"Penanggung Jawab"}),t("p",G,a(e.procurement.executor.person_responsible),1),t("p",F,a(e.procurement.executor.person_responsible_id),1)]),t("div",Q,[s(o,{value:"Pejabat Pembuat Komitmen (PPK)"}),t("p",W,a(e.procurement.executor.ppk.name),1),t("p",X,a(e.procurement.executor.ppk.identity_type)+". "+a(e.procurement.executor.ppk.identity_number),1)]),t("div",Z,[s(o,{value:"Bendahara Pengeluaran"}),t("p",ee,a(e.procurement.executor.treasurer),1),t("p",te,a(e.procurement.executor.treasurer_id),1)])]),k(u.$slots,"comment")]),_:2},1024),d(f).role>2?(c(),l("div",se,[d(f).role!=3&&d(f).role!=5?(c(),m(v,{key:0,class:"mb-5"},{default:i(()=>[s(o,{value:"Nilai RAB"}),t("p",oe,a(n(e.procurement.budget_plan.total)),1)]),_:1})):r("",!0),e.procurement.estimate&&d(f).role<6?(c(),m(v,{key:1,class:"mb-5"},{default:i(()=>[s(o,{value:"Nilai HPS"}),t("p",ae,a(n(e.procurement.estimate.total)),1)]),_:1})):r("",!0),e.procurement.contract&&d(f).role<6&&d(f).role!=4?(c(),m(v,{key:2},{default:i(()=>[s(o,{value:"Nilai Penawaran"}),t("p",ce,a(n(e.procurement.contract.offer)),1)]),_:1})):r("",!0)])):r("",!0),k(u.$slots,"default")]),d(f).role<3?(c(),l("div",re,[s(v,{class:"flex flex-col w-4/12"},{default:i(()=>[s(g,{title:"Tim UKPBJ",widthSize:"50",class:"mb-5"}),e.procurement.executor.siren_approval?(c(),l("div",le,[s(o,{value:"Verifikasi RAB"}),t("p",ne,a(e.procurement.executor.siren_approval.name),1)])):r("",!0),e.procurement.executor.siren_reject?(c(),l("div",ie,[s(o,{value:"Penolakan RAB"}),t("p",ue,a(e.procurement.executor.siren_reject.name),1)])):r("",!0),e.procurement.executor.hps?(c(),l("div",de,[s(o,{value:"PIC HPS"}),t("p",me,a(e.procurement.executor.hps.name),1)])):r("",!0),e.procurement.executor.pp?(c(),l("div",fe,[s(o,{value:"PP"}),t("p",he,a(e.procurement.executor.pp.name),1)])):r("",!0),e.procurement.executor.contract?(c(),l("div",ve,[s(o,{value:"PIC Kontrak"}),t("p",xe,a(e.procurement.executor.contract.name),1)])):r("",!0)]),_:1}),s(v,{class:"flex flex-col w-3/12 ml-5"},{default:i(()=>[s(g,{title:"Nilai RAB",widthSize:"50",class:"mb-5"}),t("div",ge,[s(o,{value:"Sub total"}),t("p",be,a(n(e.procurement.budget_plan.sub_total)),1)]),e.procurement.budget_plan.ppn?(c(),l("div",ke,[s(o,{value:"PPN 11%"}),t("p",_e,a(n(e.procurement.budget_plan.ppn)),1)])):r("",!0),e.procurement.budget_plan.overheat?(c(),l("div",we,[s(o,{value:"overheat"}),t("p",pe,a(n(e.procurement.budget_plan.overheat)),1)])):r("",!0),t("div",ye,[s(o,{value:"Total"}),t("p",Pe,a(n(e.procurement.budget_plan.total)),1)])]),_:1}),e.procurement.status>5?(c(),m(v,{key:0,class:"flex flex-col w-3/12 ml-5"},{default:i(()=>[s(g,{title:"Nilai HPS",widthSize:"50",class:"mb-5"}),t("div",Se,[s(o,{value:"Sub Total"}),t("p",Ne,a(n(e.procurement.estimate.sub_total)),1)]),e.procurement.estimate.ppn?(c(),l("div",$e,[s(o,{value:"PPN 11%"}),t("p",je,a(n(e.procurement.estimate.ppn)),1)])):r("",!0),e.procurement.estimate.overheat?(c(),l("div",Be,[s(o,{value:"Overheat ("+e.procurement.estimate.overheat_percentage+"%)"},null,8,["value"]),t("p",Ce,a(n(e.procurement.estimate.overheat)),1)])):r("",!0),t("div",Ye,[s(o,{value:"Total"}),t("p",De,a(n(e.procurement.estimate.total)),1)])]),_:1})):r("",!0),e.procurement.contract?(c(),m(v,{key:1,class:"flex flex-col w-3/12 ml-5"},{default:i(()=>[s(g,{title:"Data Kontrak",widthSize:"50",class:"mb-5"}),t("div",Ke,[s(o,{value:"Nilai Penawaran"}),t("p",Re,a(n(e.procurement.contract.offer)),1)]),e.procurement.contract.days?(c(),l("div",Te,[s(o,{value:"Masa Pengerjaan"}),t("p",Ae,a(e.procurement.contract.days)+" hari",1)])):r("",!0)]),_:1})):r("",!0)])):r("",!0),k(u.$slots,"extra-info",{loading:h})]),_:3}))}};export{Je as _};
