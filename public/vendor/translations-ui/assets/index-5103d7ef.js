import{_ as R}from"./layout-dashboard.vue_vue_type_script_setup_true_lang-ce51e587.js";import{_ as J}from"./pagination.vue_vue_type_script_setup_true_lang-8ed7a73a.js";import{u as M,_ as Q}from"./use-confirmation-dialog-9a866ad9.js";import{_ as X}from"./base-button.vue_vue_type_script_setup_true_lang-4041aa1c.js";import{_ as Y}from"./icon-trash-a2f124e2.js";import{_ as Z}from"./icon-plus-4cbbfd59.js";import{_ as ee}from"./input-checkbox.vue_vue_type_script_setup_true_lang-cbb48805.js";import{_ as te}from"./input-native-select.vue_vue_type_script_setup_true_lang-ad2aa845.js";import{_ as se}from"./input-text.vue_vue_type_script_setup_true_lang-09f5c91a.js";import{_ as oe}from"./icon-arrow-right-e09bb615.js";import{d as le,r as p,v as b,D as ae,W as k,n as ne,o as r,h as f,b as s,w as a,f as e,t as C,p as h,c as g,G as ie,u as d,a as D,F as z,q as re,m as de,P as ce}from"./app-e2c1adb4.js";import{_ as ue}from"./flag.vue_vue_type_script_setup_true_lang-9a70fac7.js";import{_ as me}from"./source-phrase-item.vue_vue_type_script_setup_true_lang-971d7c33.js";import{l as _e}from"./lodash-293e1000.js";import"./icon-publish-8507a7dd.js";import"./_plugin-vue_export-helper-c27b6911.js";import"./logo-e09fccf9.js";import"./use-auth-46901eba.js";import"./transition-314b73c3.js";import"./icon-arrow-left-b70428ec.js";import"./dialog-e6df4d57.js";import"./use-input-size-6b6f86f1.js";import"./icon-pencil-8922e06b.js";const pe={class:"w-full bg-white shadow"},fe={class:"mx-auto flex w-full max-w-7xl items-center justify-between px-6 lg:px-8"},he={class:"flex w-full items-center"},ge={class:"flex w-full items-center gap-3 py-4"},ve={class:"h-5 shrink-0"},xe={class:"flex items-center space-x-2"},we=["textContent"],ye=["textContent"],be={class:"mx-auto max-w-7xl px-6 py-10 lg:px-8"},ke={class:"w-full divide-y overflow-hidden rounded-md bg-white shadow"},Ce={class:"flex w-full flex-wrap items-center justify-between gap-4 px-4 py-3 sm:flex-nowrap"},De={class:"w-full max-w-full md:max-w-sm"},ze={class:"w-full max-w-full md:max-w-sm"},Se={class:"w-full shadow-md"},Fe={class:"flex h-14 w-full divide-x"},$e={class:"flex w-12 items-center justify-center p-4"},je=e("div",{class:"grid w-full grid-cols-2 divide-x"},[e("div",{class:"flex w-full items-center justify-start px-4"},[e("span",{class:"text-sm font-medium text-gray-400"},"Key")]),e("div",{class:"flex w-full items-center justify-start px-4"},[e("span",{class:"text-sm font-medium text-gray-400"},"String")])],-1),Ve={class:"grid w-36 grid-cols-2 divide-x"},Be={class:"flex h-full"},Ie={class:"flex w-full max-w-full"},Ae=["disabled"],Ne={class:"flex flex-col p-6"},Pe=e("span",{class:"text-xl font-medium text-gray-700"},"Are you sure?",-1),Te=e("span",{class:"mt-2 text-sm text-gray-500"}," This action cannot be undone, This will permanently delete the selected phrases and all of their translations. ",-1),Le={class:"mt-4 flex gap-4"},rt=le({__name:"index",props:{phrases:{},translation:{},files:{},filter:{}},setup(S){var x,w;const n=S,c=p(((x=n.filter)==null?void 0:x.keyword)||""),u=p(((w=n.filter)==null?void 0:w.translationFile)||""),F=b(()=>n.files.map(t=>({value:t.id,label:t.nameWithExtension})));ae([c,u],_e.debounce(()=>{k.get(route("ltu.source_translation"),{filter:{keyword:c.value||void 0,translationFile:u.value||void 0}},{preserveState:!0,preserveScroll:!0,only:["phrases"]})},300));const o=p([]),{loading:$,showDialog:j,openDialog:v,performAction:V,closeDialog:B}=M(),I=async()=>{await V(()=>k.post(route("ltu.source_translation.delete_phrases"),{selected_ids:o.value},{preserveScroll:!0,onSuccess:()=>{o.value=[]}}))};function A(){o.value.length===n.phrases.data.length?o.value=[]:o.value=n.phrases.data.map(t=>t.id)}const N=b(()=>o.value.length===Object.keys(n.phrases.data).length);return(t,i)=>{const P=de,T=ue,m=ce,L=oe,E=se,W=te,G=ee,K=Z,U=Y,y=X,q=Q,H=J,O=R,_=ne("tooltip");return r(),f(z,null,[s(P,{title:"Base Language"}),s(O,null,{default:a(()=>[e("div",pe,[e("div",fe,[e("div",he,[e("div",ge,[s(m,{href:t.route("ltu.source_translation"),class:"flex items-center gap-2 rounded-md border border-transparent bg-gray-50 px-2 py-1 hover:border-blue-400 hover:bg-blue-100"},{default:a(()=>[e("div",ve,[s(T,{"country-code":t.translation.language.code,width:"w-5"},null,8,["country-code"])]),e("div",xe,[e("div",{class:"text-sm font-semibold text-gray-600",textContent:C(t.translation.language.name)},null,8,we)])]),_:1},8,["href"]),e("div",{class:"rounded-md border bg-white px-1.5 py-0.5 text-sm text-gray-500",textContent:C(t.translation.language.code)},null,8,ye)])]),h((r(),g(m,{href:t.route("ltu.translation.index"),class:"flex size-10 items-center justify-center rounded-full bg-gray-100 p-1 hover:bg-gray-200"},{default:a(()=>[s(L,{class:"size-6 text-gray-400"})]),_:1},8,["href"])),[[_,"Go back"]])])]),e("div",be,[e("div",ke,[e("div",Ce,[e("div",De,[s(E,{modelValue:c.value,"onUpdate:modelValue":i[0]||(i[0]=l=>c.value=l),placeholder:"Search by key or value",size:"md"},null,8,["modelValue"])]),e("div",ze,[s(W,{id:"translationFile",modelValue:u.value,"onUpdate:modelValue":i[1]||(i[1]=l=>u.value=l),size:"md",placeholder:"Filter by file",items:F.value},null,8,["modelValue","items"])])]),e("div",Se,[e("div",Fe,[e("div",$e,[s(G,{disabled:!t.phrases.data.length,checked:N.value,onClick:A},null,8,["disabled","checked"])]),je,e("div",Ve,[h((r(),g(m,{href:t.route("ltu.source_translation.add_source_key"),class:"group flex items-center justify-center hover:bg-blue-50"},{default:a(()=>[s(K,{class:"size-5 text-gray-400 group-hover:text-blue-600"})]),_:1},8,["href"])),[[_,"Add New Key"]]),e("div",Be,[e("div",Ie,[h((r(),f("button",{type:"button",class:ie(["relative inline-flex size-14 select-none items-center justify-center p-4 text-sm font-medium uppercase tracking-wide text-gray-400 no-underline outline-none transition-colors duration-150 ease-out",{"cursor-not-allowed":!o.value.length,"cursor-pointer":o.value.length,"hover:bg-red-50 hover:text-red-600":o.value.length,"bg-gray-50":!o.value.length}]),disabled:!o.value.length,onClick:i[2]||(i[2]=(...l)=>d(v)&&d(v)(...l))},[s(U,{class:"size-5"})],10,Ae)),[[_,o.value.length?"Delete selected":"Select phrases to delete"]])])]),s(q,{size:"sm",show:d(j)},{default:a(()=>[e("div",Ne,[Pe,Te,e("div",Le,[s(y,{variant:"secondary",type:"button",size:"lg","full-width":"",onClick:d(B)},{default:a(()=>[D(" Cancel ")]),_:1},8,["onClick"]),s(y,{variant:"danger",type:"button",size:"lg","is-loading":d($),"full-width":"",onClick:I},{default:a(()=>[D(" Delete ")]),_:1},8,["is-loading"])])])]),_:1},8,["show"])])])]),(r(!0),f(z,null,re(t.phrases.data,l=>(r(),g(me,{key:l.uuid,phrase:l,"selected-ids":o.value},null,8,["phrase","selected-ids"]))),128)),s(H,{links:t.phrases.links,meta:t.phrases.meta},null,8,["links","meta"])])])]),_:1})],64)}}});export{rt as default};
