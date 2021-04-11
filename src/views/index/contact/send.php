<?php

$message = (object)array('type' => '', 'content' => '');

// TODO: Implement code to using phpMailer.



if (empty($data['csrfIsValid'])) {
    $message->type = "error";
    $message->content = "Error 403 Forbidden : Erreur d'envoie du message.";
} elseif (empty($data['captchaIsHuman'])) {
    $message->type = "error";
    $message->content = "Veuillez répondre correctement à la question.";
} elseif (
    !empty($sent->lastName) &&
    !empty($sent->firstName) &&
    !empty($sent->email)
) {
    $subject = isset($sent->subject) ? $sent->subject : 'Envoyer depuis ' . $_SERVER['HTTP_HOST'];
    /* Construction du message */
    $messageBody = '<div class="primary">Bonjour, <br /><br />';
    $messageBody .= 'Ce mail a été envoyé par : '
        . $sent->lastName . ' ' . $sent->firstName
        . '<br />Voici le message qui vous est adressé : '
        . '<br />********** Subject **********'
        . '<br />' . $subject
        . '<br />********** ' . $_SERVER['HTTP_HOST'] . ' **********'
        . '<p>' . (empty($sent->content) ? '' : $sent->content) . '</p>'
        . '<br />********** ' . $_SERVER['HTTP_HOST'] . ' **********' . '</div>';

    $message->type = "success";
    $message->content = "Success :The message has been sent.";

}

include('form.php');


