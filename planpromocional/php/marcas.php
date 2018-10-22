<?php

  	require_once("../../conexion/conexion.php");

	//Se crea nuevo objeto de la clase conexion
	$cnn = new conexion();
	$conn=$cnn->conectar();

		$selectOptionMarca = "";

		echo $selectOptionMarca;

		if (isset($_GET['idProducto'] )){
		
			$idp = $_GET['idProducto'];

			//$SQL= "SELECT * FROM puntosdeventa WHERE UserSave = '$idp'";
			$sql = "SELECT IdMarca, Descripcion FROM planpromo_marcas";// WHERE IdProducto = $idp";

			$result = mysqli_query($conn, $sql);

			if (($result->num_rows) > 0) {

				while( $row2 = mysqli_fetch_array($result)){

	  				$selectOptionMarca = $selectOptionMarca . "<option value='". $row2['IdMarca'] ."'>" . ($row2['Descripcion']) . "</option>";	
				}	

			}	

			else{

				$selectOptionMarca = $selectOptionMarca . "<option value='0' disabled >No Disponible para este producto (Agregue una marca nueva)</option>";	
			
			}

			//$selectOptionMarca = $selectOptionMarca . '</select>';
			echo $selectOptionMarca;
		}
		else{
			echo "<option value='0' disabled >ha ocurrido un error (no parametros)</option>";
		}
?>