<?php

ini_set("sendmail_path", "/usr/sbin/sendmail -t -i");

$sendTo = 'borgognoni.damian@gmail.com';
$subject = 'New message from contact form';
$fields = array('name' => 'Name', 'email' => 'Email', 'subject' => 'Subject', 'message' => 'Message');
$okMessage = 'Contact form successfully submitted. Thank you, we will get back to you soon!';
$errorMessage = 'There was an error while submitting the form. Please try again later.';

try {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $emailText = "You have a new message from the contact form\n=============================\n";

        foreach ($_POST as $key => $value) {
            if (isset($fields[$key])) {
                $emailText .= "$fields[$key]: $value\n";
            }
        }

        $headers = array(
            'Content-Type: text/plain; charset="UTF-8";',
            'From: ' . $sendTo,
            'Reply-To: ' . $sendTo,
            'Return-Path: ' . $sendTo,
        );

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

header('Content-Type: application/json');
echo json_encode($responseArray);
?>