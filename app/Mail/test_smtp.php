<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require __DIR__ . '/../../vendor/autoload.php';

$mail = new PHPMailer(true);

try {
    // Configuración del servidor
    $mail->isSMTP();
    $mail->Host = 'tecnoweb.org.bo'; // Servidor de correo saliente
    $mail->SMTPAuth = false;         // Sin autenticación según la imagen
    $mail->Port = 25;                // Puerto de envío (Servidor saliente)

    // Datos del remitente
    $mail->setFrom('grupo001sa@tecnoweb.org.bo', 'grupo01sa'); // Dirección de correo y nombre opcional

    // Destinatarios
    $mail->addAddress('kevin.tecno.uagrm@gmail.com', 'Nombre del Destinatario'); // Correo del destinatario

    // Contenido del correo
    $mail->isHTML(true); // Habilitar contenido HTML
    $mail->Subject = 'Asunto del correo';
    $mail->Body = '<h1>Hola!</h1><p>Este es un mensaje enviado desde PHP usando PHPMailer.</p>';
    $mail->AltBody = 'Este es un mensaje enviado desde PHP usando PHPMailer (texto plano).';

    // Enviar el correo
    $mail->send();
    echo 'El correo ha sido enviado correctamente.';
} catch (Exception $e) {
    echo "Error al enviar el correo: {$mail->ErrorInfo}";
}
