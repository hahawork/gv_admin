<?php

  header('Content-Type: text/html; charset=UTF-8'); 

  $FechaIni = isset($_POST['txtFechaDesde']) ? $_POST['txtFechaDesde'] : null;
  $FechaFin = isset($_POST['txtFechaHasta']) ? $_POST['txtFechaHasta'] : null;  

    require_once("../conexion/conexion.php");
      //Se crea nuevo objeto de la clase conexion
      $cnn = new conexion();
      $conn=$cnn->conectar();

      $sql = '';

      if (isset($_POST['btnConsultar'])) {

          $sql = "SELECT ua.idAsistencia, u.NombreUsuario, ifnull( pv.NombrePdV,'Ver Descripcion') as NombrePdV , 
            (ua.CantGastosMovim + ua.CantGastosMovimTaxi + ua.CantGastosAlim + ua.CantGastosHosped + ua.CantGastosVario) as CantGastosMovim, ua.FechaRegistro, ua.Observacion 
            FROM usuario_asistencia as ua INNER JOIN usuario as u 
            on u.idUsuario = ua.idUsuario LEFT JOIN puntosdeventa as pv 
            on pv.IdPdV = ua.IdPdV WHERE ua.FechaRegistro BETWEEN '$FechaIni' AND DATE_ADD('$FechaFin', INTERVAL 1 DAY) ORDER BY ua.FechaRegistro desc";
      }
      else{
        $sql = "SELECT ua.idAsistencia, u.NombreUsuario, ifnull( pv.NombrePdV,'Ver Descripcion') as NombrePdV , 
        (ua.CantGastosMovim + ua.CantGastosMovimTaxi + ua.CantGastosAlim + ua.CantGastosHosped + ua.CantGastosVario) as CantGastosMovim, ua.FechaRegistro, ua.Observacion 
        FROM usuario_asistencia as ua INNER JOIN usuario as u 
        on u.idUsuario = ua.idUsuario LEFT JOIN puntosdeventa as pv 
        on pv.IdPdV = ua.IdPdV ORDER BY ua.FechaRegistro desc";
      }

      function getResult(){

        global $conn;
        global $sql;
        $result = mysqli_query($conn, $sql);
          mysqli_query($conn, "SET NAMES 'utf8'");
          if ($result){
            
            while ($row = mysqli_fetch_array($result)){
              echo '<tr>
                <td><a href="asistencia-detalles.php?idAsistencia='.$row['idAsistencia'].' target="_blank">'. $row['idAsistencia'] .'</a></td>
                <td style="width:160px;">'. ($row['NombreUsuario']) .'</td>
                <td>'. ($row['NombrePdV']).'</td>
                <td> C$'. $row['CantGastosMovim'] .'</td>
                <td style="width:160px;">'. $row['FechaRegistro'] .'</td>
                <td>'. ($row['Observacion']) .'</td>
              </tr>';
            }
          }
      }

?>


<!DOCTYPE html>
<html>
<head>

  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
  <link rel="stylesheet" href="../plugins/datatables/dataTables.bootstrap.css">
  <link rel="stylesheet" href="../dist/css/AdminLTE.min.css">
  <link rel="stylesheet" href="../dist/css/skins/_all-skins.min.css">

</head>
<body>
    <section class="content">
        <div class="box">
          

			<form method="post" action="asistencia.php">
				<div class=" col-xl-12 col-md-12 col-xs-12">
					<div class="col-xl-4 col-md-2 col-xs-1">

					</div>
            <div class="col-xl-4 col-md-8 col-xs-12">
						<span>Desde: </span>
						<input type="date" width="50px" name="txtFechaDesde" placeholder="dd/mm/yyyy" value="<?php echo $FechaIni; ?>" min="2016-11-28" max="<?php echo  date("Y-m-d") ?>">
						<span>Hasta: </span>
						<input type="date" width="50px" name="txtFechaHasta" placeholder="dd/mm/yyyy" value="<?php echo $FechaFin; ?>" min="2016-11-28" max="<?php echo  date("Y-m-d") ?>">
						<input type="submit" name="btnConsultar" value="Consultar" class="btn btn-primary">
					</div>
					<div class="col-xl-4 col-md-2 col-xs-1">
					</div>
				</div>
			</form>
            <!-- /.box-header -->
            <div class="box-body">
				<table id="example" class="table table-bordered table-striped">
					<thead>
						<tr>
							<th>Id</th>
							<th>Supervisor</th>
							<th>Nombre Punto de Venta</th>
							<th>Total Gastos</th>
							<th>Fecha y Hora</th>
							<th>Observación</th>
						</tr>
					</thead>
					<tbody>
            <div id="refresh"> 
						<?php 
							getResult();
						?>
            </div>
					</tbody>
				</table>
      </div>
            <!-- /.box-body -->
		</div>
        <!-- /.box -->
    </section>
    <!-- /.content -->

<!-- jQuery 2.2.3 -->
<script src="../plugins/jQuery/jquery-2.2.3.min.js"></script>
<!-- Bootstrap 3.3.6 -->
<script src="../bootstrap/js/bootstrap.min.js"></script>
<!-- DataTables -->
<script src="../plugins/datatables/jquery.dataTables.min.js"></script>

<script src="../plugins/datatables/dataTables.bootstrap.min.js"></script>
<!-- SlimScroll -->
<script src="../plugins/slimScroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="../plugins/fastclick/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="../dist/js/app.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="../dist/js/demo.js"></script>
<!-- page script -->

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>


<script>
  $(function () {
    $('#example').DataTable({
      "paging": true,
      "lengthChange": true,
      "searching": true,
      "ordering": true,
      "info": true,
      "autoWidth": true
    });
  });
</script>
<script type="text/javascript">

      var table = $('#example').DataTable( {
          ajax: "data.json"
      } );
       
      setInterval( function () {
          table.ajax.reload(); // user paging is not reset on reload
      }, 30000 );


 </script>
</body>
</html>
