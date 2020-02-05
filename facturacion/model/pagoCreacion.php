<?php
require("./../../aclases/conexion/index.php");
class pagoCreacion{

    public function __construct() { }

    public function getBusquedaServicio($nombre){
        $miconexion = new conexion("protected");
        $datos = [];
        
        $proce_alma = "{call getBusquedaServicio(?)}";
        $param = array(
            array($nombre, SQLSRV_PARAM_IN));

        $conexion = $miconexion->abrirConexion();
        $retorno = $miconexion->consultaPAParam($conexion, $proce_alma, $param);
        if($retorno != false){
            $cont = 1;
            while($fila = $miconexion->retornarListAsoc($retorno)){
                $mi_fila = array(6);
                $mi_fila[0] = $cont;
                $mi_fila[1] = $fila["id_servicio"];
                $mi_fila[2] = $fila["nombre"];
                $mi_fila[3] = $fila["precio"];
                array_push($datos, $mi_fila);
                $cont += 1;
            }
            return $datos;
        }else{
            return null;
        }
        $miconexion->cerrarConexion($conexion);
    }


    public function getBusquedaCliente($razon_social){
        $miconexion = new conexion("protected");
        $datos = [];
        
        $proce_alma = "{call getBusquedaCliente(?)}";
        $param = array(
            array($razon_social, SQLSRV_PARAM_IN));

        $conexion = $miconexion->abrirConexion();
        $retorno = $miconexion->consultaPAParam($conexion, $proce_alma, $param);
        if($retorno != false){
            $cont = 1;
            while($fila = $miconexion->retornarListAsoc($retorno)){
                $mi_fila = array(6);
                $mi_fila[0] = $cont;
                $mi_fila[1] = $fila["id_cliente"];
                $mi_fila[2] = $fila["razon_social"];
                $mi_fila[3] = $fila["ruc"];
                array_push($datos, $mi_fila);
                $cont += 1;
            }
            return $datos;
        }else{
            return null;
        }
        $miconexion->cerrarConexion($conexion);
    }

    //USUARIO REQUERIDO
    public function regPagoServicio($datoLista, $id_cliente){
        $miconexion = new conexion("protected");
        
       
        $proce_alma = "{call regPagoServicio(?,?)}";
        $param = array(
            array($datoLista, SQLSRV_PARAM_IN),
            array($id_cliente, SQLSRV_PARAM_IN));

        $conexion = $miconexion->abrirConexion();
        $retorno = $miconexion->consultaPAParam($conexion, $proce_alma, $param);
        if($retorno != false){
            $codigoImpresion = "";
            $fila = $miconexion->retornarListAsoc($retorno);
            $codigoImpresion = $fila["Imprimir"];
            return $codigoImpresion;
        }else{
            return "Fallo el registro.";
        }
        $miconexion->cerrarConexion($conexion);
    }

    
    public function imprimirBoleta($numero_boleta){
        $miconexion = new conexion("protected");
        $datos = [];
        
        $proce_alma = "{call imprimirBoleta(?)}";
        $param = array(
            array($numero_boleta, SQLSRV_PARAM_IN));

        $conexion = $miconexion->abrirConexion();
        $retorno = $miconexion->consultaPAParam($conexion, $proce_alma, $param);
        if($retorno != false){
            $cont = 1;
            while($fila = $miconexion->retornarListAsoc($retorno)){
                $mi_fila = array(7);
                $mi_fila[0] = $cont;
                $mi_fila[1] = $fila["id_venta"];
                $mi_fila[2] = $fila["id_numero_boleta"];
                $mi_fila[3] = $fila["ruc"];
                $mi_fila[4] = $fila["razon_social"];
                $mi_fila[5] = $fila["servicio"];
                $mi_fila[6] = $fila["precio"];
                $mi_fila[7] = $fila["fecha_crea"];
                array_push($datos, $mi_fila);
                $cont += 1;
            }
            return $datos;
        }else{
            return null;
        }
        $miconexion->cerrarConexion($conexion);
    }
}
?>