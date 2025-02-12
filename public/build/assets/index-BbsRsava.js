import{_ as f}from"./AuthenticatedLayout-D5lz5BQL.js";import{Q as v,p as k,q as m,f as r,a,u as i,w as n,F as g,o as d,Z as C,b as t,j as p,d as h,l as w,t as l,c as U,g as B}from"./app-l7-T_QVc.js";import"./ApplicationLogo-Dn1V6JC9.js";import"./_plugin-vue_export-helper-DlAUqK2U.js";const N={class:"py-12"},E={class:"max-w-7xl mx-auto sm:px-6 lg:px-8"},M={class:"bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg"},P={class:"p-6 text-gray-900 dark:text-gray-100"},V={id:"contenido_principal"},q={class:"col-md-12",style:{"margin-top":"10px"}},R={class:"box box-default",style:{border:"1px solid #574B90","min-height":"35px"}},S={class:"col-md-12"},F={class:"box box-default",style:{border:"1px solid #0c0c0c"}},$={class:"max-w-7xl mx-auto sm:px-6 lg:px-8",style:{padding:"10px"}},j={style:{height:"100%",overflow:"auto"}},z={class:"table table-bordered table-condensed table-striped",style:{width:"100%"}},A={style:{"text-align":"center"}},D={style:{"text-align":"center"}},L={style:{"text-align":"center"}},Q={style:{"text-align":"center"}},T={style:{"text-align":"center"}},Z={class:"my-4"},G={class:"text-lg font-medium text-gray-900 dark:text-gray-100"},W={__name:"index",setup(H){const y=v(),x=k(y.props.ratings);return(s,e)=>{const _=m("pagination"),b=m("modal");return d(),r(g,null,[a(i(C),{title:"Ratings"}),a(f,null,{header:n(()=>e[2]||(e[2]=[t("h2",{class:"text-xl font-semibold leading-tight text-gray-800"}," Ratings ",-1)])),default:n(()=>[t("div",null,[t("div",N,[t("div",E,[t("div",M,[t("div",P,[t("section",V,[t("div",q,[t("div",R,[a(i(p),{href:s.route("admin.ratings.create"),method:"get",as:"button"},{default:n(()=>e[3]||(e[3]=[h(" Crear Rating")])),_:1},8,["href"])])]),t("div",S,[t("div",F,[t("div",$,[t("div",j,[t("table",z,[e[5]||(e[5]=t("thead",null,[t("th",{colspan:"5"})],-1)),e[6]||(e[6]=t("thead",{style:{"background-color":"#dff1ff"}},[t("th",{style:{"text-align":"center"}},"Nro"),t("th",{style:{"text-align":"center"}},"Usuario"),t("th",{style:{"text-align":"center"}},"Producto"),t("th",{style:{"text-align":"center"}},"Puntuacion"),t("th",{style:{"text-align":"center"}},"Acción")],-1)),t("tbody",null,[(d(!0),r(g,null,w(x.value,o=>{var u,c;return d(),r("tr",{key:o.id},[t("td",A,l(o.id),1),t("td",D,l(((u=o.user)==null?void 0:u.name)||"Sin usuario"),1),t("td",L,l(((c=o.producto)==null?void 0:c.nombre)||"Sin producto"),1),t("td",Q,l(o.puntuacion),1),t("td",T,[a(i(p),{href:s.route("admin.ratings.destroy",o),method:"delete",as:"button"},{default:n(()=>e[4]||(e[4]=[h(" Eliminar ")])),_:2},1032,["href"])])])}),128))])])])]),t("div",Z,[a(_,{"current-page":s.currentPage,"total-pages":s.totalPages,onChange:s.loadUsers},null,8,["current-page","total-pages","onChange"])])])])])])])])]),s.showModal?(d(),U(b,{key:0,onClose:s.closeModal},{header:n(()=>[t("h2",G," ¿Estás seguro que deseas eliminar al usuario "+l(s.modalUser.name)+"? ",1)]),body:n(()=>e[7]||(e[7]=[t("p",{class:"mt-1 text-sm text-gray-600 dark:text-gray-400"}," Una vez que se elimine, todos sus recursos y datos serán eliminados permanentemente. ",-1)])),footer:n(()=>[t("button",{onClick:e[0]||(e[0]=(...o)=>s.closeModal&&s.closeModal(...o)),class:"btn btn-secondary"},"Cancelar"),t("button",{onClick:e[1]||(e[1]=o=>s.deleteUser(s.modalUser.id)),class:"btn btn-danger"},"Eliminar Usuario")]),_:1},8,["onClose"])):B("",!0)])]),_:1})],64)}}};export{W as default};
