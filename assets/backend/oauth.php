<?php
// hybridAuth Autentication
// --------------------------------------------------   
require 'hybridauth/src/autoload.php';
$config= [    
    'callback' => 'http://localhost/JS/UF4/Practica%20Final/assets/backend/oauth.php',
    'keys' => [
        'id' => '306537122507-esljbjrnvf2p5r3i5eu9h4h1o8ei94gr.apps.googleusercontent.com',
        'secret' => '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'
    ],
];


try{
    $google = new Hybridauth\Provider\Google($config);

    $google->authenticate();

    $accessToken = $google->getAccessToken();
    $userProfile = $google->getUserProfile();

    $email = $userProfile -> email; 
    $firstname = $userProfile -> firstName;

    $username = explode("@", $email);
    
    // Si el correu no forma part del domini sapalomera.cat redirigim a la pàgina inicial sense obrir sessió
    if ($username[1] !== 'sapalomera.cat') {
        header('Location: ../../index.html');
    }


    // Si el correu conté un . vol dir que és un alumne, i per tant, redirigim a la pàgina inicial sense obrir sessió
    if (strpos($username[0], '.') !== false) {
        header('Location: ../../index.html');
    } else {
        // Quan es loga algú, eliminem  les dades de sessió anteriors
        session_start();
        session_unset();
        session_destroy();

        // I iniciem una nova sessió
        session_start();
        $_SESSION['usuari'] = $username[0];
        $_SESSION['email'] = $email;
        $_SESSION['token'] = $accessToken;
        
        // i redirigirem a la pagina del admin
        header('Location: ../../admin');
    }

}catch(Exception $e){
    echo $e->getMessage();
}
