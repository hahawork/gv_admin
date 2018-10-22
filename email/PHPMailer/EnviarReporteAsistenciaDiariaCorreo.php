<?php

date_default_timezone_set('America/Managua');
require("class.phpmailer.php");
require("class.smtp.php");

// Valores enviados desde el formulario
//if (!isset($_POST["idCliente"]) || !isset($_POST["idUsuario"]) || !isset($_POST["NivelAcceso"])) {
//    die("Es necesario completar todos los datos del formulario");
//}

$Fecha = date("Y-m-d H:i:s");

$destinatario = "soporte-sis@grupovalor.com.ni";

//conectar a la base de datos
require_once '../../conexion/conexion.php';
$cnn = new conexion();
$conn = $cnn->conectar();

//obtenemos los usuarios a los que le vamos a mandar el correo
$sqlDestinos = "SELECT * FROM `LoginusuarioSesion` WHERE EstadoActivo = 1 AND intRecibirCorreoAsistencias = 1";
if ($result = mysqli_query($conn, $sqlDestinos)) {
//si se obtiene al menos 1 registro.
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_array($result)) {
            $nombreDestino = $row["NombreUsuario"];
            $emailDestino = $row["EmailUC"];
            $idClient = $row["IdCliente"];
            $idUser = $row["IdUsuario"];
            $NivelAcceso = $row["NivelAcceso"];

//se consultan los usuarios que se enviaran al reporte
            $sql = "";
            if ($NivelAcceso == 1) {
                $sql = "SELECT clientes.IdCliente, `idUsuario`, `NombreUsuario`, Rol, clientes.RazonSocial "
                        . "FROM `usuario` INNER JOIN "
                        . "clientes on usuario.IdCliente = clientes.IdCliente "
                        . "WHERE EstadoActivo = 1 and MarcaAsistenciaGPS = 1 ORDER BY clientes.IdCliente, `usuario`.`NombreUsuario`";
            }
            if ($NivelAcceso == 3) {
                $sql = "SELECT `idUsuario`, `NombreUsuario`, Rol, clientes.RazonSocial "
                        . "FROM `usuario` INNER JOIN "
                        . "clientes on usuario.IdCliente = clientes.IdCliente "
                        . "WHERE usuario.IdCliente = $idClient and EstadoActivo = 1 and MarcaAsistenciaGPS = 1 ORDER BY `usuario`.`NombreUsuario`";
            }
            if ($NivelAcceso == 4) {
                $sql = "SELECT `idUsuario`, `NombreUsuario`, Rol, clientes.RazonSocial "
                        . "FROM `usuario` INNER JOIN clientes on usuario.IdCliente = clientes.IdCliente "
                        . "WHERE (usuario.idUsuario = $idUser OR usuario.idSupervisor = $idUser) AND EstadoActivo = 1 and MarcaAsistenciaGPS = 1 ORDER BY `usuario`.`NombreUsuario`";
            }

            $result1 = mysqli_query($conn, $sql);

            if ($result1) {
                if (mysqli_num_rows($result1) > 0) {

                    $body1 = "";
                    while ($row1 = mysqli_fetch_array($result1)) {

                        $date = date("Y-m-d");
                        $idcl = $row1['idUsuario'];
                        $tieneAsistencia = 0;
                        $row2 = null;

                        $consutAsistencia = "SELECT NombrePdV, date_format(FechaRegistro, '%H:%i:%s') as Hora "
                                . "FROM `usuario_asistencia` "
                                . "INNER JOIN puntosdeventa on usuario_asistencia.IdPdV = puntosdeventa.IdPdV "
                                . "WHERE idUsuario = '$idcl' and FechaRegistro LIKE '$date%' "
                                . "order BY FechaRegistro";


                        $resultAsistencia = mysqli_query($conn, $consutAsistencia);

                        if ($resultAsistencia) {
                            if (mysqli_num_rows($resultAsistencia) > 0) {
                                $tieneAsistencia = 1;
                                $row2 = mysqli_fetch_array($resultAsistencia);
                            } else {
                                $tieneAsistencia = 0;
                            }

                            $body1 .= '<tr>
                                                            <td>' . ($row1['NombreUsuario']) . " (" . ($row1['Rol']) . ')</td>
                                                            <td>' . ($row1['RazonSocial']) . '</td>
                                                            <td>' . ($tieneAsistencia == 1 ? $row2['Hora'] : "N/D") . '</td>
                                                            <td>' . ($row2['NombrePdV']) . '</td>
                                                          </tr>';
                        }
                    }
                    $body1 .= "
                </table>

                </body> 


                </html>";

                    enviarCorreo($emailDestino, $body1, $idUser, $nombreDestino);
                } else {
                    echo 'la cantidad de usuarios es cero';
                }
            } else {
                echo 'error en la consulta de usuarios' . mysqli_error($conn);
            }
        }
    } else {
        echo 'La cantidad de destinos es cero';
    }
} else {
    echo 'error consulta destinos' . mysqli_error($conn);
}

function enviarCorreo($Destino, $body1, $iduser, $nombreUsuario) {

// Datos de la cuenta de correo utilizada para enviar v�a SMTP
    $smtpHost = "mail.ideay.net.ni";  // Dominio alternativo brindado en el email de alta 
    $smtpUsuario = "soporte-sis@grupovalor.com.ni";  // Mi cuenta de correo
    $smtpClave = "Gv123456*";  // Mi contraseña

    global $Fecha;

    $body = "<html> 
<head>
<style>
table {
    width:100%;
}
table, th, td {
    border: 1px solid blue;
    border-collapse: collapse;
}
th, td {
    padding: 5px;
    text-align: left;
}
table tr:nth-child(even) {
    background-color: #eee;
}
table tr:nth-child(odd) {
   background-color: #fff;
}
table th {
    background-color: blue;
    color: white;
}
</style>
</head>
<body>

<p>Hola {$nombreUsuario}, has recibido este correo desde un sistema de generación automática con la primera marcada en el punto de venta.</p>
<p>Este correo es de caracter informativo.</p>
<p>Si no quieres recibir este correo comuníquese con nosotros.</p>
<p>Fecha generado: {$Fecha}</p>

<table>
  <tr>
    <th>Nombre</th>
    <th>Marca</th>
    <th>Hora</th> 
    <th>Lugar</th>
  </tr>";

    $body2 = $body . $body1;

    $mail = new PHPMailer();
    $mail->IsSMTP();
    $mail->SMTPAuth = true;
    $mail->Port = 587;
    $mail->IsHTML(true);
    $mail->CharSet = "utf-8";

// VALORES A MODIFICAR //
    $mail->Host = $smtpHost;
    $mail->Username = $smtpUsuario;
    $mail->Password = $smtpClave;


    $mail->From = $smtpUsuario; // Email desde donde env�o el correo.
    $mail->FromName = "Henrry Ariel Herrera Arauz";
    $mail->AddAddress($Destino); // Esta es la direcci�n a donde enviamos los datos del formulario

    $mail->Subject = "Reporte Asistencia Diaria hoy: " . date("d-m-Y"); // Este es el titulo del email.
    //$mensajeHtml = nl2br($mensaje);

    $mail->Body = $body2 . "<br />NOTA: N/D = No hay dato."; // Texto del email en formato HTML
    $mail->AltBody = "Para ver el mensaje, por favor use un visor de correo compatible con HTML! \n\n "; // Texto sin formato HTML
    // FIN - VALORES A MODIFICAR //

    $mail->SMTPOptions = array(
        'ssl' => array(
            'verify_peer' => false,
            'verify_peer_name' => false,
            'allow_self_signed' => true
        )
    );

    $estadoEnvio = $mail->Send();
    if ($estadoEnvio) {
        //echo "El correo fue enviado correctamente.";
    } else {
        //echo "Ocurrió un error inesperado.";
    }
}

?>
