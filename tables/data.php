<!DOCTYPE html>
<html>
<head>
	<title></title>
	<link rel="stylesheet" type="text/css" href="bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="dataTables.bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="jquery.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="buttons.dataTables.min.css">
</head>
<body>
	<div>
		<table id="example" class="display nowrap" cellspacing="0" width="100%">
        <thead>
                <tr>
                  <th>Cliente</th>
                  <th>Ciudad</th>
                  <th>Tipo de Canal</th>
                          <th>Nombre del Canal</th>
                  <th>Nombre Punto de Venta</th>
                  <th>Registró</th>
                </tr>
                </thead>
                <tbody>
                <?php 
                
                    require_once("../conexion/conexion.php");

                    //Se crea nuevo objeto de la clase conexion
                    $cnn = new conexion();
                    $conn=$cnn->conectar();
                    
                    $sql = "SELECT IdPdV, Cliente, Ciudad, TipoCanal,NombreCanal, NombrePdV, UserSave FROM puntosdeventa";
                    
                    $result = mysqli_query($conn, $sql);
                    
                    if ($result){
                        
                        while ($row = mysqli_fetch_array($result)){
                            echo '<tr>
                              <td>'. ($row['Cliente']) .'</td>
                              <td>'. ($row['Ciudad']) .'</td>
                              <td>'. ($row['TipoCanal']) .'</td>
                              <td>'. ($row['NombreCanal']) .'</td>
                              <td>'. $row['IdPdV'] .' - '. ($row['NombrePdV']) .'</td>
                              <td>'. $row['UserSave'] .'</td>
                            </tr>';
                        }
                    }
                ?>
                
                </tbody>
                <tfoot>
                <tr>
                  <th>Cliente</th>
                  <th>Ciudad</th>
                  <th>Canal</th>
                          <th>Nombre del Canal</th>
                  <th>Nombre Punto de Venta</th>
                  <th>Registró</th>
                </tr>
                </tfoot>
    </table>
	</div>

    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://cdn.datatables.net/1.10.13/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.2.3/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.2.3/js/buttons.flash.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js"></script>
    <script src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/pdfmake.min.js"></script>
    <script src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.2.3/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.2.3/js/buttons.print.min.js"></script>

    <script type="text/javascript">
        $(document).ready(function() {
            $('#example').DataTable( {
                dom: 'Bfrtip',
                buttons: [
                    'copy', 'csv', 'excel', 'pdf', 'print'
                ]
            } );
        } );
    </script>
</body>
</html>