<?php

  	require_once("../../conexion/conexion.php");

	//Se crea nuevo objeto de la clase conexion
	$cnn = new conexion();
	$conn=$cnn->conectar();


	if (isset($_GET['IdCanal'] )){
	
		$idc = $_GET['IdCanal'];

		$sql = "SELECT * FROM `puntosdeventa` inner join Departamentos on Departamentos.IdDepartamento = puntosdeventa.Departamento  WHERE EsPdV = 1 AND TipoCanal = $idc ";

		$result = mysqli_query($conn, $sql);

		if (($result->num_rows) > 0) {

			while ($row = mysqli_fetch_array($result)){

				echo '<tr>	                
	                <td> '. ($row['NombreDepto'] ." - " . $row['NombrePdV']) .'</td>
	                <td> '. $row['IdPdV'] .'</td>
	              </tr>';
			}
		}
		else{
			
		}
	}
?>