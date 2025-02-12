import{_}from"./AuthenticatedLayout-D5lz5BQL.js";import{Q as f,p as v,q as m,f as d,a as n,u as i,w as a,F as u,o as l,Z as C,b as e,j as g,d as p,l as k,t as r,c as w,g as U}from"./app-l7-T_QVc.js";import"./ApplicationLogo-Dn1V6JC9.js";import"./_plugin-vue_export-helper-DlAUqK2U.js";const B={class:"py-12"},N={class:"max-w-7xl mx-auto sm:px-6 lg:px-8"},E={class:"bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg"},M={class:"p-6 text-gray-900 dark:text-gray-100"},V={id:"contenido_principal"},q={class:"col-md-12",style:{"margin-top":"10px"}},S={class:"box box-default",style:{border:"1px solid #574B90","min-height":"35px"}},D={class:"col-md-12"},F={class:"box box-default",style:{border:"1px solid #0c0c0c"}},P={class:"max-w-7xl mx-auto sm:px-6 lg:px-8",style:{padding:"10px"}},$={style:{height:"100%",overflow:"auto"}},j={class:"table table-bordered table-condensed table-striped",style:{width:"100%"}},z={style:{"text-align":"center"}},A={style:{"text-align":"center"}},L={style:{"text-align":"center"}},Q={style:{"text-align":"center"}},T={class:"my-4"},Z={class:"text-lg font-medium text-gray-900 dark:text-gray-100"},O={__name:"index",setup(G){const h=f(),c=v(h.props.comentarios),y=s=>{console.log(s),c.value=s.props.comentarios};return(s,t)=>{const x=m("pagination"),b=m("modal");return l(),d(u,null,[n(i(C),{title:"Comentarios"}),n(_,null,{header:a(()=>t[2]||(t[2]=[e("h2",{class:"text-xl font-semibold leading-tight text-gray-800"}," Comentarios ",-1)])),default:a(()=>[e("div",null,[e("div",B,[e("div",N,[e("div",E,[e("div",M,[e("section",V,[e("div",q,[e("div",S,[n(i(g),{href:s.route("admin.comentarios.create"),method:"get",as:"button"},{default:a(()=>t[3]||(t[3]=[p(" Crear Comentario")])),_:1},8,["href"])])]),e("div",D,[e("div",F,[e("div",P,[e("div",$,[e("table",j,[t[5]||(t[5]=e("thead",null,[e("th",{colspan:"5"})],-1)),t[6]||(t[6]=e("thead",{style:{"background-color":"#dff1ff"}},[e("th",{style:{"text-align":"center"}},"Nro"),e("th",{style:{"text-align":"center"}},"Usuario"),e("th",{style:{"text-align":"center"}},"Comentario"),e("th",{style:{"text-align":"center"}},"Acción")],-1)),e("tbody",null,[(l(!0),d(u,null,k(c.value,o=>(l(),d("tr",{key:o.id},[e("td",z,r(o.id),1),e("td",A,r(o.user.name),1),e("td",L,r(o.descripcion),1),e("td",Q,[n(i(g),{onSuccess:y,href:s.route("admin.comentarios.destroy",o),method:"delete",class:"bg-red-500 text-white p-2 rounded",as:"button"},{default:a(()=>t[4]||(t[4]=[p(" Eliminar")])),_:2},1032,["href"])])]))),128))])])])]),e("div",T,[n(x,{"current-page":s.currentPage,"total-pages":s.totalPages,onChange:s.loadUsers},null,8,["current-page","total-pages","onChange"])])])])])])])])]),s.showModal?(l(),w(b,{key:0,onClose:s.closeModal},{header:a(()=>[e("h2",Z," ¿Estás seguro que deseas eliminar al usuario "+r(s.modalUser.name)+"? ",1)]),body:a(()=>t[7]||(t[7]=[e("p",{class:"mt-1 text-sm text-gray-600 dark:text-gray-400"}," Una vez que se elimine, todos sus recursos y datos serán eliminados permanentemente. ",-1)])),footer:a(()=>[e("button",{onClick:t[0]||(t[0]=(...o)=>s.closeModal&&s.closeModal(...o)),class:"btn btn-secondary"},"Cancelar"),e("button",{onClick:t[1]||(t[1]=o=>s.deleteUser(s.modalUser.id)),class:"btn btn-danger"},"Eliminar Usuario")]),_:1},8,["onClose"])):U("",!0)])]),_:1})],64)}}};export{O as default};
