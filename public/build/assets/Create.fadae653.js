import{_ as f}from"./Master.6e78ae6a.js";import{u as b,o as v,c as x,w as u,a,d as s,b as e,t as r}from"./app.35366383.js";import{_ as w}from"./Container.fd7110e0.js";import{_ as V}from"./Header1.57f707b5.js";import{_ as n}from"./Label.23df5a7a.js";import{_ as i}from"./Input.d1f1fc38.js";import{N as y}from"./Notification.a0596bc5.js";import"./sweetalert2.all.995333e0.js";const k={class:"flex mt-5"},h={class:"mt-1 w-4/12"},g={class:"text-sm text-error mt-1 mb-5"},U=s("datalist",{id:"categoryList"},[s("option",{value:"PT"}),s("option",{value:"CV"})],-1),C={class:"mt-1 w-full ml-10"},$={class:"text-sm text-error mt-1 mb-5"},N={class:"text-sm text-error mt-1 mb-5"},P={class:"text-sm text-error mt-1 mb-5"},B={class:"flex"},S={class:"w-4/12"},T={class:"text-sm text-error mt-1 mb-5"},D={class:"w-full ml-10"},E={class:"text-sm text-error mt-1 mb-5"},F={class:"flex"},K={class:"mt-1 w-4/12"},L={class:"text-sm text-error mt-1 mb-5"},j={class:"w-full ml-10"},z={class:"text-sm text-error mt-1 mb-5"},A={class:"flex justify-end mt-10"},G=["onClick"],X={__name:"Create",setup(J){const m=y(),t=b({name:"",npwp:"",entity:"",address:"",province:"",regency:"",bank:"",account:""}),c=d=>{t.post(route("supplier.store"),{onSuccess:o=>m("success","Berhasil menambah data supplier "+t.name),onError:o=>m("error","Gagal menambah data supplier"),onStart:o=>{d(),t.clearErrors()},onFinish:()=>d()})};let p=function(){window.history.back()};return(d,o)=>(v(),x(f,null,{default:u(({loading:_})=>[a(w,{class:"w-6/12"},{default:u(()=>[a(V,{title:"Tambah Data Supplier",widthSize:"100"}),s("div",k,[s("div",h,[a(n,{value:"Jenis Perusahaan"}),a(i,{id:"entity",type:"text",class:"w-full",modelValue:e(t).entity,"onUpdate:modelValue":o[0]||(o[0]=l=>e(t).entity=l),list:"categoryList",status:e(t).errors.entity},null,8,["modelValue","status"]),s("div",g,r(e(t).errors.entity),1),U]),s("div",C,[a(n,{value:"Nama"}),a(i,{id:"nama",class:"w-full",type:"text",modelValue:e(t).name,"onUpdate:modelValue":o[1]||(o[1]=l=>e(t).name=l),status:e(t).errors.name},null,8,["modelValue","status"]),s("div",$,r(e(t).errors.name),1)])]),a(n,{value:"NPWP"}),a(i,{id:"npwp",type:"text",class:"mt-1 block w-full",modelValue:e(t).npwp,"onUpdate:modelValue":o[2]||(o[2]=l=>e(t).npwp=l),status:e(t).errors.npwp},null,8,["modelValue","status"]),s("div",N,r(e(t).errors.npwp),1),a(n,{value:"Alamat"}),a(i,{id:"alamat",type:"text",class:"mt-1 block w-full",modelValue:e(t).address,"onUpdate:modelValue":o[3]||(o[3]=l=>e(t).address=l),status:e(t).errors.address},null,8,["modelValue","status"]),s("div",P,r(e(t).errors.address),1),s("div",B,[s("div",S,[a(n,{value:"Provinsi"}),a(i,{id:"Province",type:"text",class:"mt-1 block w-full",modelValue:e(t).province,"onUpdate:modelValue":o[4]||(o[4]=l=>e(t).province=l),status:e(t).errors.province},null,8,["modelValue","status"]),s("div",T,r(e(t).errors.province),1)]),s("div",D,[a(n,{value:"Kota / Kabupaten"}),a(i,{id:"regency",type:"text",class:"mt-1 block w-full",modelValue:e(t).regency,"onUpdate:modelValue":o[5]||(o[5]=l=>e(t).regency=l),status:e(t).errors.regency},null,8,["modelValue","status"]),s("div",E,r(e(t).errors.regency),1)])]),s("div",F,[s("div",K,[a(n,{value:"Bank"}),a(i,{id:"bank",type:"text",class:"mt-1 block w-full",modelValue:e(t).bank,"onUpdate:modelValue":o[6]||(o[6]=l=>e(t).bank=l),status:e(t).errors.bank},null,8,["modelValue","status"]),s("div",L,r(e(t).errors.bank),1)]),s("div",j,[a(n,{value:"Rekening"}),a(i,{id:"account",type:"text",class:"mt-1 block w-full",modelValue:e(t).account,"onUpdate:modelValue":o[7]||(o[7]=l=>e(t).account=l),status:e(t).errors.account},null,8,["modelValue","status"]),s("div",z,r(e(t).errors.account),1)])]),s("div",A,[s("button",{onClick:o[8]||(o[8]=l=>e(p)()),class:"btn text-first bg-slate-200 border-none hover:text-white hover:bg-first font-bold"},"Cancel"),s("button",{onClick:l=>c(_),class:"btn border-first modal-button bg-first ml-3"},"Tambah",8,G)])]),_:2},1024)]),_:1}))}};export{X as default};
