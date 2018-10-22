<?php

//fuente en internet
//http://developando.com/blog/php-configuracion-phpmailer-para-envio-de-correos-smtp/+

if (isset($_POST["txtNombre"]) and isset($_POST["txtEmail"]) and isset($_POST["txtMensaje"])) {
    
    
    require_once '../../plugins/PHPMailer_5.2.4/class.phpmailer.php';

    try {
// Crear una nueva  instancia de PHPMailer habilitando el tratamiento de excepciones
        $mail = new PHPMailer(true);

// Configuramos el protocolo SMTP con autenticación
        $mail->IsSMTP();
        $mail->SMTPAuth = true;

// Configuración del servidor SMTP	
        $mail->Port = 465;
        $mail->Host = 'mail.ideay.net.ni';
        $mail->Username = "soporte-sis@grupovalor.com.ni";
        $mail->Password = "Gv123456*";

// Configuración cabeceras del mensaje
        $mail->From = "remite@developando.com";
        $mail->FromName = "Mi nombre y apellidos";
        $mail->AddAddress("soporte-sis@grupovalor.com.ni", "Henrry Herrera Arauz");
        //$mail->AddAddress("destino2@correo.com", "Nombre 2");
        //$mail->AddCC("copia1@correo.com", "Nombre copia 1");
        //$mail->AddBCC("copia1@correo.com", "Nombre copia 1");
        //$mail->Subject = "Asunto del correo";
// Creamos en una variable el cuerpo, contenido HMTL, del correo
        $body = "Probando los correos con un tutorial<br>";
        $body .= "hecho por <strong>Developando</strong>.<br>";
        $body .= "<font color='red'>Visitanos pronto</font>";
        $mail->Body = $body;

// Ficheros adjuntos
        //$mail->AddAttachment("misImagenes/foto1.jpg", "developandoFoto.jpg");
        //$mail->AddAttachment("files/proyecto.zip", "demo-proyecto.zip");
// Enviar el correo
        $mail->Send();
    } catch (Exception $exc) {
        echo $exc->getTraceAsString();
    }
}
 else {
    echo json_encode($exc);
}
?>