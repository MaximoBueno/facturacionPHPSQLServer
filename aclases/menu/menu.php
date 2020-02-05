<?php
require($ruta."aclases/conexion/index.php");
class menu{
    public function __construct() {	}

    public function getMenuUsuario($usuario = 0, $ruta){
        $miconexion  = new conexion("protected");

        $proce_alma = "{call getMenuUsuario(?)}";
        $param = array(array($usuario, SQLSRV_PARAM_IN));

        $conexion = $miconexion->abrirConexion();
        $retorno = $miconexion->consultaPAParam($conexion, $proce_alma, $param);
        $info = "";
        $escribir = "";
        $norepetir = "";
        $indicador = 0;
        if($retorno != false){
            while($fila = $miconexion->retornarListAsoc($retorno)){
                if($norepetir != $fila['id_menu_padre']){
                    if($indicador == 1){
                        $escribir .='</ul></li>';
                        $indicador = 0;
                    }
                    $escribir .= '<li class="fiList">
                                    <a class="btnList" onclick="desplega(\'uListMenu'.$fila['id_menu_padre'].'\');">
                                        <div class="d-flex">
                                            <i class="text-warning fa fa-columns iconMenu mr-1"></i>
                                            <h5 class="text-warning m-0 textMenu">'.$fila['menu_padre_des'].'</h5>
                                        </div>
                                    </a>
                                    <ul class="ulistMenu noneCustom" id="uListMenu'.$fila['id_menu_padre'].'">';
                    $norepetir = $fila['id_menu_padre'];
                    $indicador = 1;
                }

                if($fila['estado'] == 1){
                    $escribir .= '<a href="'.$ruta.$fila['ruta'].'" class="my-cursor-vista-habi" title="Habilitado">
                                    <li class="listMenu">
                                        <h6 class="text-white m-0 textMenu">'.$fila['menu_hijo_des'].'</h6>
                                    </li>
                                </a>';
                }else{
                    $escribir .= '<a href="#" class="my-cursor-vista-desha" title="Deshabilitado">
                                    <li class="listMenu">
                                        <h6 class="text-white m-0 textMenu my-cursor-vista-desha">'.$fila['menu_hijo_des'].'</h6>
                                    </li>
                                </a>';
                }           
            }
            $info = $escribir.'</ul></li>';
        }else{
            $info = "Menú vacio.";
        }
        $miconexion->cerrarConexion($conexion);
        return $info;
    }

    public function getMenuUsuarioNS($usuario = 0, $ruta){
        $miconexion  = new conexion("protected");

        $proce_alma = "{call getMenuUsuario(?)}";
        $param = array(array($usuario, SQLSRV_PARAM_IN));

        $conexion = $miconexion->abrirConexion();
        $retorno = $miconexion->consultaPAParam($conexion, $proce_alma, $param);
        $info = "";
        $escribir = "";
        $norepetir = "";
        $indicador = 0;
        if($retorno != false){
            while($fila = $miconexion->retornarListAsoc($retorno)){
                if($norepetir != $fila['id_menu_padre']){
                    if($indicador == 1){
                        $escribir .='</ul></li>';
                        $indicador = 0;
                    }
                    $escribir .= '<li class="darkerli my-menu-ns active">
                                    <a href="javascript:void(0);">
                                        <i class="fa fa-desktop my-fa my-fa-lg"></i>
                                        <span class="nav-text">'.$fila['menu_padre_des'].'</span>
                                    </a>
                                    <ul class="my-sub-menu-ns">';
                    
                    
                    $norepetir = $fila['id_menu_padre'];
                    $indicador = 1;
                }

                if($fila['estado'] == 1){
                    $escribir .= '<li>
                                    <a href="'.$ruta.$fila['ruta'].'" class="my-cursor-vista-habi" title="Habilitado">
                                        <span class="">'.$fila['menu_hijo_des'].'</span>
                                    </a>
                                </li>';
                }else{
                    $escribir .= '<li>
                                    <a href="javascript:void(0);" class="my-cursor-vista-desha" title="Deshabilitado">
                                        <span class="">'.$fila['menu_hijo_des'].'</span>
                                    </a>
                                </li>';
                }           
            }
            $info = $escribir.'</ul></li>';
        }else{
            $info = "Menú vacio.";
        }
        $miconexion->cerrarConexion($conexion);
        return $info;
    }
}
?>