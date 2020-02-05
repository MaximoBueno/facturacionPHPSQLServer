<?php
$info = "";
    if(isset($_POST['valor'])  && $_POST['valor'] != NULL ){
        require("./../model/pagoCreacion.php");
        $miPagoCreacion = new pagoCreacion();
        $nombre = $_POST['valor'];
        $datos = $miPagoCreacion->getBusquedaCliente($nombre);
        if($datos != false){
            $escribir = "";
            foreach ($datos as $fila) {
                $escribir.= '<tr class="my-selectable" onclick="pintarFilaSelec(this);" ondblclick="buscarFilaSelec(this);">
                                <td class="text-center">'.$fila[0].'</td>
                                <td class="d-none">CL'.$fila[1].'</td>
                                <td>'.$fila[2].'</td>
                                <td class="text-center">'.$fila[3].'</td>
                            </tr>';
            }
            $info = $escribir;
        }else{
            $info = '<tr><td colspan="3" class="text-center">Concepto vacio.</td></tr>';
        }
    }else{
        $info = "No tienes acceso x";
    }
echo $info;
?>