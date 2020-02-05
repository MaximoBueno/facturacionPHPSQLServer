<?php
session_start();
$info = "";
    if(isset($_POST['datoLista']) && $_POST['datoLista'] != NULL
        && isset($_POST['mi_cliente']) && $_POST['mi_cliente'] != NULL){

        if($_POST['datoLista'] == "" || $_POST['mi_cliente'] ==  ""){
            $info = "Falta ingresar datos";
        }else{
            require("./../model/pagoCreacion.php");
            $miPagoCreacion = new pagoCreacion();
    
            $datoLista = $_POST['datoLista'];
            $mi_cliente = str_replace("CL", "", $_POST['mi_cliente']);
            $ndato = count($datoLista);

            $mxml = '<root>';
            for($i = 0;  $i < $ndato; $i++){
				$mxml.='<pension cod="'.$datoLista[$i][0].'" num ="'.$datoLista[$i][1].'" con = "'.$datoLista[$i][2].'" pre="'.$datoLista[$i][3].'"></pension>';
            }
            $mxml .='</root>';

            //$info = $mxml;
            $datos = $miPagoCreacion->regPagoServicio($mxml, $mi_cliente);
            if($datos != false){
                $_SESSION['ns_my_imprimir'] = $datos;
                $info = "255";
            }else{
                $_SESSION['ns_my_imprimir'] = "00000000";
                $info = $datos;
            }
        }
    }else{
        $info = "No tienes acceso.";
    }
echo $info;
?>