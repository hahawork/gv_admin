<?php

require_once("../conexion.php");

//Se crea nuevo objeto de la clase conexion
$cnn = new conexion();
$con=$cnn->conectar();

// array for JSON response
$response = array();
 
// check for required fields
 if (isset($_GET['IdCanal']) && isset($_GET['IdDepto']) && isset($_GET['idPuntodeVenta'])) {
   
	$IdCanal = $_GET['IdCanal'];
	$IdDepto = $_GET['IdDepto'];
	$idPuntodeVenta = $_GET['idPuntodeVenta'];
	$FechaIni = $_GET['FechaIni'];
	$FechaFin = $_GET['FechaFin'];
	
	
	$sql="SELECT * FROM `FechaVencimientoReporte` WHERE IdCanal = '$IdCanal' AND IdDepto = '$IdDepto' AND idPuntodeVenta = '$idPuntodeVenta' AND fechavencim BETWEEN '$FechaIni' AND '$FechaFin'";

  // mysql inserting a new row
	$result = mysqli_query($con,$sql);
 
   // check if row inserted or not
	if ($result) {
		
		if (($result->num_rows) > 0)
		{
			$response["filas"] = array();
	 
			while ($row = mysqli_fetch_array($result)) {
				
				$arr = array();
				$arr["idRFV"] = $row["idRFV"];
				$arr["IdCanal"] = $row["IdCanal"];
				$arr["IdDepto"] = $row["IdDepto"];
				$arr["idPuntodeVenta"] = $row["idPuntodeVenta"];
				$arr["idMarca"] = $row["idMarca"];
				$arr["idPresentacion"] = $row["idPresentacion"];				
				$arr["fechavencim"] = $row["fechavencim"];
				$arr["Cantidad"] = $row["Cantidad"];
				$arr["CantBandeo"] = $row["CantBandeo"];
				$arr["FechaRegistro"] = $row["FechaRegistro"];				
				$arr["TipoBandeo"] = ($row["TipoBandeo"]);
				
				// establece el ultimo arrar al final del JSON
				array_push($response["filas"], $arr);
			}
			
			// success
			$response["success"] = 1;
			$response["message"] =	"Se ha descargado el último reporte con éxito.";
			// mostrando el JSON response
			echo json_encode($response);		
		}
		else{
			$response["success"] = 0;
			$response["message"] = "No se encontró ningun registro.";
		}

		// echoing JSON response
		echo json_encode($response);
	}else{
		// insercion falla en la bd
			$response["success"] = 0;
			$response["message"] = "Error al intentar recuperar la información";

			// echoing JSON response
			echo json_encode($response);
	}
} else {
	// required field is missing
	$response["success"] = 0;
	$response["message"] = "No se han especificado los parámetros requeridos.";
 
	// echoing JSON response
	echo json_encode($response);
}
?>