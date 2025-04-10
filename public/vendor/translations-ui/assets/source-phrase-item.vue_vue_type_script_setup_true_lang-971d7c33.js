import{u as V,_ as j}from"./use-confirmation-dialog-9a866ad9.js";import{_ as z}from"./base-button.vue_vue_type_script_setup_true_lang-4041aa1c.js";import{_ as P}from"./icon-trash-a2f124e2.js";import{_ as T}from"./icon-pencil-8922e06b.js";import{d as $,r as N,D as A,n as E,o as c,h as m,f as t,b as s,w as a,t as f,p as h,c as W,u as n,a as g,W as L,P as S}from"./app-e2c1adb4.js";import{_ as U}from"./input-checkbox.vue_vue_type_script_setup_true_lang-cbb48805.js";const q={class:"w-full hover:bg-gray-100"},F={class:"flex h-14 w-full divide-x"},G={class:"flex w-12 items-center justify-center p-4"},H={class:"flex w-full items-center justify-start px-4"},J={class:"truncate rounded-md border bg-white px-1.5 py-0.5 text-sm font-medium text-gray-600 hover:border-blue-400 hover:bg-blue-50 hover:text-blue-600"},K={class:"flex w-full items-center justify-start px-4"},M={class:"w-full truncate whitespace-nowrap text-sm font-medium text-gray-600"},O={class:"grid w-36 grid-cols-2 divide-x"},Q={class:"flex flex-col p-6"},R=t("span",{class:"text-xl font-medium text-gray-700"},"Are you sure?",-1),X=t("span",{class:"mt-2 text-sm text-gray-500"}," This action cannot be undone, This will permanently delete the selected languages and all of their translations. ",-1),Y={class:"mt-4 flex gap-4"},ne=$({__name:"source-phrase-item",props:{phrase:{},selectedIds:{}},setup(v){const i=v,{loading:x,showDialog:w,openDialog:d,performAction:y,closeDialog:b}=V(),D=async e=>{await y(()=>L.delete(route("ltu.source_translation.delete_phrase",e)))},r=N(i.selectedIds.includes(i.phrase.id));return A(()=>i.selectedIds,e=>{r.value=e.includes(i.phrase.id)}),(e,o)=>{const k=U,u=S,C=T,B=P,p=z,I=j,_=E("tooltip");return c(),m("div",q,[t("div",F,[t("div",G,[s(k,{modelValue:r.value,"onUpdate:modelValue":o[0]||(o[0]=l=>r.value=l),value:e.phrase.id},null,8,["modelValue","value"])]),s(u,{href:e.route("ltu.source_translation.edit",e.phrase.uuid),class:"grid w-full grid-cols-2 divide-x"},{default:a(()=>[t("div",H,[t("div",J,f(e.phrase.key),1)]),t("div",K,[t("div",M,f(e.phrase.value),1)])]),_:1},8,["href"]),t("div",O,[h((c(),W(u,{href:e.route("ltu.source_translation.edit",e.phrase.uuid),class:"group flex items-center justify-center px-3 hover:bg-blue-50"},{default:a(()=>[s(C,{class:"size-5 text-gray-400 group-hover:text-blue-600"})]),_:1},8,["href"])),[[_,"Edit"]]),h((c(),m("button",{type:"button",class:"group flex items-center justify-center px-3 hover:bg-red-50",onClick:o[1]||(o[1]=(...l)=>n(d)&&n(d)(...l))},[s(B,{class:"size-5 text-gray-400 group-hover:text-red-600"})])),[[_,"Delete"]])]),s(I,{size:"sm",show:n(w)},{default:a(()=>[t("div",Q,[R,X,t("div",Y,[s(p,{variant:"secondary",type:"button",size:"lg","full-width":"",onClick:n(b)},{default:a(()=>[g(" Cancel ")]),_:1},8,["onClick"]),s(p,{variant:"danger",type:"button",size:"lg","is-loading":n(x),"full-width":"",onClick:o[2]||(o[2]=l=>D(e.phrase.uuid))},{default:a(()=>[g(" Delete ")]),_:1},8,["is-loading"])])])]),_:1},8,["show"])])])}}});export{ne as _};
