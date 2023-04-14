<?php

//Obtenir dades d'un JSON.stringify
$post = json_decode(file_get_contents('php://input'));

if (!empty($post) && !empty($post->accio) && $post->accio == 'logged') {
    if (session_status() === PHP_SESSION_ACTIVE) {
        $response = array(
            "logged" => true,
            "user" => array(
                "username" => $_SESSION['usuari'],
                "email" => $_SESSION['email'],
                "token" => $_SESSION['token']
            )
        );
    } else {
        $response = array(
            "logged" => false
        );
    }
}

echo json_encode($response);

?>