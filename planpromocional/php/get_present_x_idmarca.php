<?php

  	require_once("../../conexion/conexion.php");

	//Se crea nuevo objeto de la clase conexion
	$cnn = new conexion();
	$conn=$cnn->conectar();

		$selectOptionMarca = "";

		echo $selectOptionMarca;

		if (isset($_GET['IdMarca'] )){
		
			$IdMarca = $_GET['IdMarca'];

			//$SQL= "SELECT * FROM puntosdeventa WHERE UserSave = '$idp'";
			$sql = "SELECT IdPresentacion, CodCafeSoluble, Descripcion FROM planpromo_presentaciones WHERE IdMarca = $IdMarca ORDER BY Descripcion";

			$result = mysqli_query($conn, $sql);

			if (($result->num_rows) > 0) {

				while( $row2 = mysqli_fetch_array($result)){

	  				$selectOptionMarca = $selectOptionMarca . "<option value='". $row2['IdPresentacion'] . "- " . ($row2['Descripcion']) ."'>" . ($row2['Descripcion']) ."- ". $row2['CodCafeSoluble'] . "</option>";	
				}	

			}	

			else{

				$selectOptionMarca = $selectOptionMarca . "<option value='0' disabled >No Disponible para este marca</option>";	
			
			}

			//$selectOptionMarca = $selectOptionMarca . '</select>';
			echo $selectOptionMarca;
		}
		else{
			echo "<option value='0' disabled >ha ocurrido un error (no parametros)</option>";
		}
?>