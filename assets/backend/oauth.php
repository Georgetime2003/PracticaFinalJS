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
    $username = $username[0];

    if (strpos($username, '.') !== false) {
        header('Location: ../../index.html');
    } else {
        session_start();
        $_SESSION['usuari'] = $firstname;
        $_SESSION['email'] = $email;
        // i redirigirem a la pagina del admin
        header('Location: ../../admin');
    }

   
    // finalment obrirem una sessio amb aquest usuari.

}catch(Exception $e){
    echo $e->getMessage();
}
