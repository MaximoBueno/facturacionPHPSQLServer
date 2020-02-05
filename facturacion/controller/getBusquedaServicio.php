<?php
$info = "";
    if(isset($_POST['valor'])  && $_POST['valor'] != NULL ){
        require("./../model/pagoCreacion.php");
        $miPagoCreacion = new pagoCreacion();
        $nombre = $_POST['valor'];
        $datos = $miPagoCreacion->getBusquedaServicio($nombre);
        if($datos != false){
            $escribir = "";
            foreach ($datos as $fila) {
                $escribir.= '<tr ondblclick="getPagoServicio(this)" id="mBS'.$fila[1].'" 
                                    class="getListaPointer" title="'.$fila[2].'">
                                <td class="d-none" >SE'.$fila[1].'</td>
                                <td class="text-center" >'.$fila[0].'</td>
                                <td class="text-center" >'.$fila[2].'</td>
                                <td class="text-center"  >'.$fila[3].'</td>
                            </tr>';
            }
            $info = $escribir;
        }else{
            $info = '<tr><td colspan="3" class="text-center">Servicio vacio.</td></tr>';
        }
    }else{
        $info = "No tienes acceso x";
    }
echo $info;
?>