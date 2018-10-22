<?php

require("class.phpmailer.php");
require("class.smtp.php");

// Valores enviados desde el formulario
if (!isset($_POST["txtNombre"]) || !isset($_POST["txtEmail"]) || !isset($_POST["txtMensaje"])) {
    die("Es necesario completar todos los datos del formulario");
}

$nombre = $_POST["txtNombre"];

$email = $_POST["txtEmail"];

$mensaje = $_POST["txtMensaje"];

$Fecha = date("Y-m-d H:i:s");

$destinatario = "soporte-sis@grupovalor.com.ni";


// Datos de la cuenta de correo utilizada para enviar v�a SMTP
$smtpHost = "mail.ideay.net.ni";  // Dominio alternativo brindado en el email de alta 
$smtpUsuario = "soporte-sis@grupovalor.com.ni";  // Mi cuenta de correo
$smtpClave = "Gv123456*";  // Mi contraseña




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


$mail->From = $email; // Email desde donde env�o el correo.
$mail->FromName = $nombre;
$mail->AddAddress($destinatario); // Esta es la direcci�n a donde enviamos los datos del formulario

$mail->Subject = "Formulario desde el Sitio Web"; // Este es el titulo del email.
$mensajeHtml = nl2br($mensaje);
//$mail->MsgHTML(file_get_contents('../../tables/ReporteAsistenciaDiaria_1.php?IdUsuario=6&NivelAcceso=1&IdCliente=1'));

$mail->Body = "
<html> 
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

<h1>Recibiste un nuevo mensaje desde el formulario de contacto</h1>

<p>Informacion enviada por el usuario de la web:</p>
<p><a href='http://www.grupovalor.com.ni/admin/tables/ReporteAsistenciaDiaria_1.php?IdUsuario=6&NivelAcceso=1&IdCliente=1'>Ver reporte completo</a></p>
<p>nombre: {$nombre}</p>
<p>email: {$email}</p>
<p>mensaje: {$mensaje}</p>
<p>Fecha: {$Fecha}</p>

<table>
  <tr>
    <th>Nombre</th>
    <th>Hora</th> 
    <th>Lugar</th>
  </tr>
  <tr>
    <td>Jill</td>
    <td>Smith</td>
    <td>50</td>
  </tr>
  <tr>
    <td>Eve</td>
    <td>Jackson</td>
    <td>94</td>
  </tr>
  <tr>
    <td>John</td>
    <td>Doe</td>
    <td>80</td>
  </tr>
</table>

</body> 


</html>

<br />"; // Texto del email en formato HTML
$mail->AltBody = "{$mensaje} \n\n "; // Texto sin formato HTML
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
    echo "El correo fue enviado correctamente.";
} else {
    echo "Ocurrió un error inesperado.";
}
?>