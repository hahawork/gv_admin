<?php  

	
	require_once ("../../conexion/conexion.php");
	$cnn = new conexion();
	$conn = $cnn -> conectar();


	$data = array();

	$filtro = $_REQUEST['IdCanal'];

		$SQL = "SELECT NombrePdV, IdPdV FROM puntosdeventa where TipoCanal = " . $filtro;
		$Result = mysqli_query ($conn, $SQL);

		$row_cnt = $Result -> num_rows;
		$i = 1;
		$contenido = "";

		$contenido = $contenido . "{\"data\":[";
		if ($Result) {
			
			if ( $row_cnt > 0 ) {
				
				while ($row = mysqli_fetch_array($Result)) {
					$contenido = $contenido . "[\"" . ($row['NombrePdV']) . "\",\"". $row['IdPdV'] ."\"]";
					if ($i < $row_cnt) {
						$contenido = $contenido . ",\n";
					}
					$i = $i + 1; 
				}

				$contenido = $contenido . "]}";

				$fileLocation = getenv("DOCUMENT_ROOT") . "/admin/planpromocional/puntosdeventa.txt";
				  /*r: sólo lectura. El fichero debe existir.
					w: se abre para escritura, se crea un fichero nuevo o se sobreescribe si ya existe.
					a: añadir, se abre para escritura, el cursor se situa al final del fichero. Si el fichero no existe, se crea.
					r+: lectura y escritura. El fichero debe existir.
					w+: lectura y escritura, se crea un fichero nuevo o se sobreescribe si ya existe.
					a+: añadir, lectura y escritura, el cursor se situa al final del fichero. Si el fichero no existe, se crea.
					t: tipo texto, si no se especifica "t" ni "b", se asume por defecto que es "t"
					b: tipo binario.*/
				$file = fopen($fileLocation,"w"); 

				if ($file == false) {
				  	# code...
				}
				else{
					$content = $contenido;
					fwrite($file,$content);
					fclose($file);
				}
			}
			else{

				$contenido = $contenido . "[\"No hay para este Canal\",\"0\"]";
				$contenido = $contenido . "]}";
				$fileLocation = getenv("DOCUMENT_ROOT") . "/admin/planpromocional/puntosdeventa.txt";
				$file = fopen($fileLocation,"w"); 
				if ($file == false) {
				  	# code...
				}
				else{
					$content = $contenido;
					fwrite($file,$content);
					fclose($file);
				}
			}
		}
	
?>