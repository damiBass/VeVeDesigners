<?php

// Configuración
$from = 'Demo contact form <demo@domain.com>';
$sendTo = 'Test contact form <borgognoni.damian@gmail.com>';
$subject = 'Nuevo mensaje desde el formulario de contacto';
$fields = array('name' => 'Nombre', 'subject' => 'Asunto', 'email' => 'Correo electrónico', 'message' => 'Mensaje');
$okMessage = 'El formulario de contacto se envió con éxito. Gracias, nos pondremos en contacto pronto.';
$errorMessage = 'Hubo un error al enviar el formulario. Por favor, inténtalo de nuevo más tarde.';

// Procesar el formulario
try {
    // Verificar si es una solicitud POST
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Recopilar los datos del formulario
        $emailText = "Tienes un nuevo mensaje desde el formulario de contacto\n=============================\n";

        foreach ($_POST as $key => $value) {
            if (isset($fields[$key])) {
                $emailText .= "$fields[$key]: $value\n";
            }
        }

        // Configurar los encabezados del correo
        $headers = array(
            'Content-Type: text/plain; charset="UTF-8";',
            'From: ' . $from,
            'Reply-To: ' . $from,
            'Return-Path: ' . $from,
        );

        // Enviar el correo
        if (mail($sendTo, $subject, $emailText, implode("\n", $headers))) {
            $responseArray = array('type' => 'success', 'message' => $okMessage);
        } else {
            throw new \Exception('No se pudo enviar el correo.');
        }
    } else {
        throw new \Exception('Solicitud no válida');
    }
} catch (\Exception $e) {
    $responseArray = array('type' => 'danger', 'message' => $errorMessage);
}

// Responder a la solicitud Ajax
if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
    header('Content-Type: application/json');
    echo json_encode($responseArray);
} else {
    echo $responseArray['message'];
}
?>
