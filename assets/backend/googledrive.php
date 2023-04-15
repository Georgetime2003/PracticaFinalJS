<?php
use Google\Client;
use Google\Service\Drive;

session_start();

//Variable de la folderid on ha de pujar les imatges i a partir del correu de servei proporcionat amb el fitxer JSON
$folderID = '147KzkT9sb9xv0Xn9Ea7Lhox2QHPWpcCM';

require_once 'google-drive/vendor/autoload.php';
$post = json_decode(file_get_contents('php://input'), true);
putenv('GOOGLE_APPLICATION_CREDENTIALS=./database/JSON/credencials.json');
$rutaCarpeta = './database/images/' . $post['classe'];
//Comprovem si existeix la carpeta

if (!file_exists($rutaCarpeta)) {
    echo json_encode(array('error' => 'No existeix la carpeta'));   
	exit; 
}
$carpetaid = createFolder($post['classe'],$folderID);
//Passar totes les imatges de la carpeta a google drive
$files = scandir($rutaCarpeta);
foreach ($files as $file) {
	if ($file != '.' && $file != '..') {
		$file = $rutaCarpeta . '/' . $file;
		pujarFitxer($file, $carpetaid);
	}
}

function comprovarCarpetaDrive($id) {
    $client = new Google_Client();
    $client->useApplicationDefaultCredentials();
    $client->setScopes(['https://www.googleapis.com/auth/drive']);
    $driveService = new Google\Service\Drive($client);

    $optParams = array(
    'fields' => $id
    );
    try {
    $file = $driveService->files->get($id, $optParams);
    } catch (Google_Service_Exception $e) {
        if ($e->getCode() == 404) {
            return false;
        } else {
            return true;
        }
    }
}
echo json_encode(array('success' => 'S\'ha pujat correctament a google drive, revisa el teu compte de google drive'));


function createFolder($identificador, $idDesti){
    try {
        $client = new Google_Client();
        $client->useApplicationDefaultCredentials();
        $client->setScopes(['https://www.googleapis.com/auth/drive']);
        $service = new Google\Service\Drive($client);
        $fileMetadata = new Google\Service\Drive\DriveFile(array(
            'name' => $identificador,
            'mimeType' => 'application/vnd.google-apps.folder',
            'parents' => array($idDesti)
        ));
        unset($fileMetadata->exportLinks);
        $file = $service->files->create($fileMetadata, array(
            'fields' => 'id'));
        //Donem permisos al correu de la session
        $userPermission = new Google\Service\Drive\Permission(array(
            'type' => 'user',
            'role' => 'writer',
            'emailAddress' => $_SESSION['email']
        ));
        return $file->id;


    }catch(Exception $e) {
       echo "Error Message: ".$e;
    }
}

function pujarFitxer($file, $idCarpeta){
	try {
		$client = new Google_Client();
        $client->useApplicationDefaultCredentials();
        $client->setScopes(['https://www.googleapis.com/auth/drive']);
        $service = new Google\Service\Drive($client);
        $fileMetadata = new Google\Service\Drive\DriveFile(array(
            'name' => basename($file),
            'parents' => array($idCarpeta)
        ));
        $content = file_get_contents($file);
        unset($fileMetadata->exportLinks);
        $file = $service->files->create($fileMetadata, array(
            'data' => $content,
            'mimeType' => 'image/jpeg',
            'uploadType' => 'multipart',
            'fields' => 'id'));
        return $file->id;

	}catch(Exception $e) {
	   echo "Error Message: ".$e;
	}
}
?>