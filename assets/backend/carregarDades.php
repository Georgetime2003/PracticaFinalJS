<?php
include("Model/LlistaUsuaris.php");
include("Model/Usuari.php");
include("Model/LlistaClasses.php");
include("Model/Classe.php");

//Obtenir dades d'un JSON.stringify
$post = json_decode(file_get_contents('php://input'));

if(!empty($post) && !empty($post->accio) && $post->accio == 'carregarDades'){
    try {
        $llistaUsuaris = LlistaUsuaris::getUsuaris();
        $response = array(
            "status" => 'success',
            "usuaris" => $llistaUsuaris
        );
    } catch (\Throwable $th) {
        $response = array(
            "status" => "error",
            "message" => $th
        );
    }
} elseif (!empty($post) && !empty($post->accio) && $post->accio == 'classes') {
    try {
        $llistaClasses = LlistaClasses::getClasses();
        $response = array(
            "status" => 'success',
            "classes" => $llistaClasses
        );
    } catch (\Throwable $th) {
        $response = array(
            "status" => "error",
            "message" => $th
        );
    }
}

echo json_encode($response);
?>