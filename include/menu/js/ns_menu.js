$(".scrollbar .my-menu-ns > a").click(function(e) {
    $(".scrollbar ul ul").slideUp(), 
    $(this).next().is(":visible") || $(this).next().slideDown(),
      e.stopPropagation();
});

/**********************
    MI MENU USUARIO
 *********************/
function abrirOpciones(){
  var my_menu_usu = document.getElementById("my-usuario-opcion"); 
  if(my_menu_usu.style.display == 'none'){
      my_menu_usu.style.display = 'block';
      window.ns_menu_opcion.is_activado = 1;
      setTimeout(function(){
          window.ns_menu_opcion.is_activado += 1;
      }, 300);
  }else{
      my_menu_usu.style.display = 'none';
      window.ns_menu_opcion.is_activado = 0;
  }
  document.getElementById("my-usuario-opcion").focus();
}

function eventoMyPagina(){
  window.onclick = function() {
      var my_menu_usu = document.getElementById("my-usuario-opcion"); 
      if((window.ns_menu_opcion.is_activado > 1)){
          my_menu_usu.style.display = 'none';
          window.ns_menu_opcion.is_activado = 0;
          
      } 
  }
}

function iniVirtualSpaceMenu(){
  window.ns_menu_opcion = {
      is_activado: 0,
      is_permitido: 0
  }
}

function rederigirInicio(direccion){
  location.href = direccion;
}

iniVirtualSpaceMenu();
eventoMyPagina();