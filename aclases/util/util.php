<?php
class util{
    public function __construct() {}

    public function getEstrellasAcceso($seguridad, $eventos = null){
        $estrellas = "";
        switch ($seguridad){
            case 1:
                $estrellas.='<a href="#" onclick="'.(($eventos != null) ? $eventos[0] : "").'" class="my-start-ico-defa my-vista-con-permi" title="Ver"></a>';
                $estrellas.='<a href="#" onclick="'.(($eventos != null) ? $eventos[1] : "").'" class="my-start-ico-defa my-vista-sin-permi" title="Editar"></a>';
                $estrellas.='<a href="#" onclick="'.(($eventos != null) ? $eventos[2] : "").'" class="my-start-ico-defa my-vista-sin-permi" title="Eliminar"></a>';
            break;
            case 2:
                $estrellas.='<a href="#" onclick="'.(($eventos != null) ? $eventos[0] : "").'" class="my-start-ico-defa my-vista-con-permi" title="Ver"></a>';
                $estrellas.='<a href="#" onclick="'.(($eventos != null) ? $eventos[1] : "").'" class="my-start-ico-defa my-vista-con-permi" title="Editar"></a>';
                $estrellas.='<a href="#" onclick="'.(($eventos != null) ? $eventos[2] : "").'" class="my-start-ico-defa my-vista-sin-permi" title="Eliminar"></a>';
            break;
            case 3:
                $estrellas.='<a href="#" onclick="'.(($eventos != null) ? $eventos[0] : "").'" class="my-start-ico-defa my-vista-con-permi" title="Ver"></a>';
                $estrellas.='<a href="#" onclick="'.(($eventos != null) ? $eventos[1] : "").'" class="my-start-ico-defa my-vista-con-permi" title="Editar"></a>';
                $estrellas.='<a href="#" onclick="'.(($eventos != null) ? $eventos[2] : "").'" class="my-start-ico-defa my-vista-con-permi" title="Eliminar"></a>';
            break;
            default:
                $estrellas.='<a href="#" onclick="'.(($eventos != null) ? $eventos[0] : "").'" class="my-start-ico-defa my-vista-sin-permi" title="Ver"></a>';
                $estrellas.='<a href="#" onclick="'.(($eventos != null) ? $eventos[1] : "").'" class="my-start-ico-defa my-vista-sin-permi" title="Editar"></a>';
                $estrellas.='<a href="#" onclick="'.(($eventos != null) ? $eventos[2] : "").'" class="my-start-ico-defa my-vista-sin-permi" title="Eliminar"></a>';
            break;
        }
        return $estrellas;
    }

    /*In the future this will be implemented (or more later)*/
    public function getAccionVista($estado, $eventos = null){
        $acciones = "";
        switch ($estado){
            case 0:
                $acciones.= '<span class="badge badge-secundary border border-dark my-pre-success mt-1" 
                                title="Estado" onclick="'.(($eventos != null) ? $eventos[0] : "").'">
                                <i class="fa fa-check"></i>
                            </span>
                            <span class="badge badge-secundary border border-dark my-pre-danger mt-1 mr-1" 
                                title="Borrar" onclick="'.(($eventos != null) ? $eventos[1] : "").'">
                                <i class="fa fa-times"></i>
                            </span>';
            break;
            case 1:
                $acciones.= '<span class="badge badge-success my-vista-estado mt-1" 
                                title="Estado" onclick="'.(($eventos != null) ? $eventos[0] : "").'">
                                <i class="fa fa-check"></i>
                            </span>
                            <span class="badge badge-danger my-vista-del mt-1 mr-1" 
                                title="Borrar" onclick="'.(($eventos != null) ? $eventos[1] : "").'">
                                <i class="fa fa-times"></i>
                            </span>';
            break;
            default:
                $acciones.= '<span class="badge badge-success" title="Activar">
                                <i class="fa fa-upload"></i>
                            </span>
                            <span class="badge badge-danger mx-1" title="Borrar">
                                <i class="fa fa-times"></i>
                            </span>';
            break;
        }
        return $acciones;
    }
}
?>