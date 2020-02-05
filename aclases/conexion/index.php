<?php 
class conexion
{
	private static $servidor="(local)";
	private static $uid="sa";
	private static $pwd="12345678";
	private static $databaseName="factSQL";

	private $keyX = NULL;
	private $errorConexion = "";

	public function __construct($clave) {
    	$this->keyX = $clave;
	}
	
	private function generarConexion(){
		if (!empty($this->keyX)){
			return 1;
		}else{
			return 0;
		}
	}
	
	public function abrirConexion(){
		try{
			if($this->generarConexion() == 1){
				$connectionInfo = array( "UID"=>self::$uid,
				"PWD"=>self::$pwd,
				"Database"=> self::$databaseName,
				 "Characterset" => "UTF-8");
				$m_conexion = sqlsrv_connect(self::$servidor, $connectionInfo); 
				if($m_conexion){
					return $m_conexion;
				}else{
					return null;
				}
			}else{
				return null;
			}
		}catch (Exception $e){
			$this->errorConexion.= "<center>Fallo al conectar a SqlServer: ".sqlsrv_errors()."</center>";
			$this->errorConexion.= "<center>Tipo de fallo: ".$e."</center>";
		}
	}

	public function ObtenerError(){
		return $this->errorConexion;
	}

	public function consulta($conexion, $consulta){
		return sqlsrv_query($conexion, $consulta);
	}

	public function consultaBuffer($conexion, $consulta){
		return sqlsrv_query($conexion, $consulta, array(), array("Scrollable"=>"buffered"));
	}

	public function numeroFilas($retorno){
		return sqlsrv_num_rows($retorno);
	}

	public function retornarBuffer($retorno){
		sqlsrv_next_result($retorno);
		sqlsrv_fetch($retorno);
		return sqlsrv_get_field($retorno, 0);
	}

	/*Consulta con parametros fijos*/
	public function consultaPAParam($conexion, $proce_alma, $param){
		return sqlsrv_query($conexion, $proce_alma, $param);
	}

	public function consultaPAParamBu($conexion, $proce_alma, $param){
		return sqlsrv_query($conexion, $proce_alma, $param, array("Scrollable"=>"buffered"));
	}

	public function consultaPAVoid($conexion, $proce_alma){
		return sqlsrv_query($conexion, $proce_alma);
	}

	/*Consulta con parametros dinamicos*/
	//para ejecutarse esta función requiere de sqlsrv_execute(return)
	public function consultaPreparada($conexion, $proce_alma, $param){
		return sqlsrv_prepare($conexion, $proce_alma, $param);
	}

	/*PROCEDIMIENTO ALMACENADO ERROR*/
	public function evaluarMensajeRaise($retorno){
		return sqlsrv_next_result($retorno);
	}

	public function obtenerMensajeRaise($mensaje){
		return (sqlsrv_errors() != null ?  explode("|", sqlsrv_errors()[0]["message"])[1] : $mensaje);
	}

	/*PROCEDIMIENTO ALMACENADO ERROR*/

	public function retornarLista($retorno){
		return sqlsrv_fetch_array($retorno, SQLSRV_FETCH_NUMERIC);
	}

	public function retornarListAsoc($retorno){
		return sqlsrv_fetch_array($retorno, SQLSRV_FETCH_ASSOC);
	}

	public function liberarRetorno($retorno){
		sqlsrv_free_stmt($retorno);
		return;
	}

	public function cerrarConexion($conexion){
		sqlsrv_close($conexion); 
		return;
	}
}
?>