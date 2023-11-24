<?php

// Configuración
$from = 'Demo contact form <borgognoni.damian@gmail.com>';
$sendTo = 'Test contact form <borgognoni.damian@gmail.com>';
$subject = 'New message from contact form';
$fields = array('name' => 'Name', 'subject' => 'Subject', 'email' => 'Email', 'message' => 'Message');
$okMessage = 'Contact form successfully submitted. Thank you, we will get back to you soon!';
$errorMessage = 'There was an error while submitting the form. Please try again later.';

// Procesar el formulario
try {
    // Verificar si es una solicitud POST
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Recopilar los datos del formulario
        $emailText = "You have a new message from the contact form\n=============================\n";

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
            throw new \Exception('Unable to send email.');
        }
    } else {
        throw new \Exception('Invalid request');
    }
} catch (\Exception $e) {
    $responseArray = array('type' => 'danger', 'message' => $errorMessage, 'error' => $e->getMessage());
}

// Responder a la solicitud Ajax
if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
    header('Content-Type: application/json');
    echo json_encode($responseArray);
} else {
    // No imprimir mensajes en la página web
    // echo $responseArray['message'];
}
?>

