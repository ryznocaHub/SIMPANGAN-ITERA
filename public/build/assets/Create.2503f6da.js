import{_ as V}from"./Master.83d66d13.js";import{u as v,o as d,c as P,w as c,a,b as e,d as o,t as l,e as u,H as f,F as y}from"./app.cbadd5a6.js";import{_ as k}from"./Container.3c236ea6.js";import{_ as N}from"./Header1.4d5ae8c0.js";import{_ as i}from"./Label.b7ad9dd1.js";import{_ as n}from"./Input.d60ea0ad.js";import{N as U}from"./Notification.1138f49b.js";import"./sweetalert2.all.2b313f34.js";const g={class:"text-sm text-error mt-1 mb-4"},B={class:"flex"},T={class:"mt-1 w-4/12"},h={class:"text-sm text-error mt-1 mb-4"},E=o("datalist",{id:"identityType"},[o("option",{value:"NIP"}),o("option",{value:"NPWP"})],-1),$={class:"mt-1 w-full ml-10"},S={class:"text-sm text-error mt-1 mb-4"},j={class:"text-sm text-error mt-1 mb-4"},A={class:"text-sm text-error mt-1 mb-4"},C={class:"text-sm text-error mt-1 mb-4"},I={id:"unitList"},K={class:"text-sm text-error mt-1 mb-4"},F={class:"text-sm text-error mt-1 mb-4"},L={id:"role"},H={class:"flex justify-end mt-5"},M={__name:"Create",props:{units:{type:Object,required:!0}},setup(w){const p=U(),_=["Admin","Pejabat Pembuat Komitmen (PPK)","Pejabat Pengadilan (PP)","Tim HPS","Tim Kontrak","Tim Teknis","Unit","RAB Checker"],t=v({name:"",identity_number:null,identity_type:"",email:null,role:"",unit:null,password:null,password_confirmed:null}),b=()=>{var m=_.indexOf(t.role);if(m==-1){t.setError("role","Pilih peran yang tersedia");return}if(t.identity_type!="NIP"||t.identity_type!="NPWP"){t.setError("identity_type","Pilih tipe yang tersedia");return}if(t.password!==t.password.confirmed){t.setError({password:"Password tidak sama",password_confirmed:"Password tidak sama"});return}t.role=m+1,t.post(route("admin.user.store"),{onSuccess:s=>p("success","Berhasil tambah user "+t.name),onError:s=>p("error","Gagal tambah user"),onStart:s=>t.clearErrors()})};return(m,s)=>(d(),P(V,null,{default:c(()=>[a(N,{title:"Buat Akun Baru",widthSize:"100",class:"mb-5"}),a(k,{class:"w-6/12"},{default:c(()=>[a(i,{value:"Nama"}),a(n,{type:"text",class:"mt-1 block w-full",modelValue:e(t).name,"onUpdate:modelValue":s[0]||(s[0]=r=>e(t).name=r),status:e(t).errors.name},null,8,["modelValue","status"]),o("div",g,l(e(t).errors.name),1),o("div",B,[o("div",T,[a(i,{value:"Tipe Identitas"}),a(n,{type:"text",class:"w-full",modelValue:e(t).identity_type,"onUpdate:modelValue":s[1]||(s[1]=r=>e(t).identity_type=r),status:e(t).errors.identity_type,list:"identityType"},null,8,["modelValue","status"]),o("div",h,l(e(t).errors.identity_type),1),E]),o("div",$,[a(i,{value:"Nomor Identitas"}),a(n,{class:"w-full",type:"text",modelValue:e(t).identity_number,"onUpdate:modelValue":s[2]||(s[2]=r=>e(t).identity_number=r),status:e(t).errors.identity_number},null,8,["modelValue","status"]),o("div",S,l(e(t).errors.identity_number),1)])]),a(i,{value:"Email"}),a(n,{type:"email",class:"mt-1 block w-full",modelValue:e(t).email,"onUpdate:modelValue":s[3]||(s[3]=r=>e(t).email=r),status:e(t).errors.email},null,8,["modelValue","status"]),o("div",j,l(e(t).errors.email),1),a(i,{value:"Password"}),a(n,{type:"password",class:"mt-1 block w-full",modelValue:e(t).password,"onUpdate:modelValue":s[4]||(s[4]=r=>e(t).password=r),status:e(t).errors.password},null,8,["modelValue","status"]),o("div",A,l(e(t).errors.password),1),a(i,{value:"Konfirmasi Password"}),a(n,{type:"password_confirmed",class:"mt-1 block w-full",modelValue:e(t).password_confirmed,"onUpdate:modelValue":s[5]||(s[5]=r=>e(t).password_confirmed=r),status:e(t).errors.password_confirmed},null,8,["modelValue","status"]),o("div",C,l(e(t).errors.password_confirmed),1),a(i,{value:"Asal Unit"}),a(n,{type:"text",class:"w-full",modelValue:e(t).unit,"onUpdate:modelValue":s[6]||(s[6]=r=>e(t).unit=r),list:"unitList",status:e(t).errors.unit},null,8,["modelValue","status"]),o("datalist",I,[(d(!0),u(y,null,f(w.units,r=>(d(),u("option",{key:r.id},l(r.full_name),1))),128))]),o("div",K,l(e(t).errors.unit),1),a(i,{value:"Peran pada sistem"}),a(n,{type:"text",class:"w-full",modelValue:e(t).role,"onUpdate:modelValue":s[7]||(s[7]=r=>e(t).role=r),list:"role",status:e(t).errors.role},null,8,["modelValue","status"]),o("div",F,l(e(t).errors.role),1),o("datalist",L,[(d(),u(y,null,f(_,(r,x)=>o("option",{key:x},l(r),1)),64))]),o("div",H,[o("button",{onClick:s[8]||(s[8]=r=>b()),class:"btn border-first modal-button bg-first w-3/12"},"Tambah")])]),_:1})]),_:1}))}};export{M as default};
