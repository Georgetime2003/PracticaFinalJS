<?php
include("Model/LlistaUsuaris.php");
$post = json_decode(file_get_contents('php://input'));
$ibstr = $post->imatge;
//Eliminem la part de la imatge que no ens interessa
$ibstr = str_replace('data:image/png;base64,', '', $ibstr);
$ibstr = str_replace(' ', '+', $ibstr);

//Base64 to GdImage
$ib64 = base64_decode($ibstr);
$image = imagecreatefromstring($ib64);

$filePath = 'database/images/'. $post->grup . '/' .$post->usuari .'.jpg';
$bg = imagecreatetruecolor(imagesx($image), imagesy($image));
imagefill($bg, 0, 0, imagecolorallocate($bg, 255, 255, 255));
imagealphablending($bg, TRUE);
imagecopy($bg, $image, 0, 0, 0, 0, imagesx($image), imagesy($image));
imagedestroy($image);
$quality = 95;
imagejpeg($bg, $filePath, $quality);
imagedestroy($bg);
//Busquem en el json del servidor el nom de l'alumne per usuari per afegir la ruta de la imatge guardada
$llistaUsuaris = LlistaUsuaris::getUsuaris();
foreach ($llistaUsuaris as $usuari) {
	if($usuari->usuari == $post->usuari){
		$usuari->imatge = 'images/'. $post->usuari .'.jpg';
		break;
	}
}
//Guardem el json amb la nova imatge
$fp = fopen('database/JSON/classes.json', 'w');
fwrite($fp, json_encode($llistaUsuaris));
fclose($fp);
$classe = LlistaUsuaris::getUsuaris($post->grup);


echo json_encode(array(
	"status" => 'success',
	"message" => 'Imatge guardada correctament'
));
?>