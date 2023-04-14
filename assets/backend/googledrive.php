<?php
use Google\Client;
use Google\Service\Drive;

session_start();

require_once 'google-drive/vendor/autoload.php';
$post = json_decode(file_get_contents('php://input'), true);
$rutaCarpeta = './database/images/' . $post['classe'];
//Comprovem si existeix la carpeta

if (!file_exists($rutaCarpeta)) {
    echo json_encode(array('error' => 'No existeix la carpeta'));   
	exit; 
}
createFolder($post['classe']);
//Passar totes les imatges de la carpeta a google drive
$files = scandir($rutaCarpeta);
foreach ($files as $file) {
	if ($file != '.' && $file != '..') {
		$file = $rutaCarpeta . '/' . $file;
		// pujarFitxer($file);
	}
}



function createFolder($identificador){
    try {
        $client = new Google\Client();
        $client->setAuthConfig('./database/JSON/client_secret.json');
        $client->addScope(Google\Service\Drive::DRIVE);
		$client->setAccessToken($_SESSION['token']['access_token']);
        // $redirect_uri = 'http://locahost/JS/UF4/Practica%20Final/assets/backend/googledrive.php';
        // $client->setRedirectUri($redirect_uri);
	
        

        $driveService = new Drive($client);
        $fileMetadata = new Drive\DriveFile(array(
            'name' => $identificador,
            'mimeType' => 'application/vnd.google-apps.folder'));
        $file = $driveService->files->create($fileMetadata, array(
            'fields' => 'id'));
        printf("Folder ID: %s\n", $file->id);
        return $file->id;

    }catch(Exception $e) {
       echo "Error Message: ".$e;
    }
}

// function pujarFitxer($file){
// 	try {
// 		$client = new Client();
// 		$client->useApplicationDefaultCredentials();
// 		$client->addScope(Drive::DRIVE);
// 		$driveService = new Drive($client);
// 		$fileMetadata = new Drive\DriveFile(array(
// 			'name' => basename($file)));
// 		$content = file_get_contents($file);
// 		$file = $driveService->files->create($fileMetadata, array(
// 			'data' => $content,
// 			'mimeType' => 'image/jpeg',
// 			'uploadType' => 'multipart',
// 			'fields' => 'id'));
// 		printf("File ID: %s\n", $file->id);
// 		return $file->id;

// 	}catch(Exception $e) {
// 	   echo "Error Message: ".$e;
// 	}
// }
?>