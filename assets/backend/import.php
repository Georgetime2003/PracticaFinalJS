<?php
//Obtenir dades d'un JSON.stringify
$post = file_get_contents('php://input');

//El transformem en un array
$post = json_decode($post, true);
	for ($i=0; $i < count($post); $i++) { 
		$usuari = $post[$i]['usuari'];
		$nomCognoms = $post[$i]['nomCognoms'];
		$cicle = $post[$i]['cicle'];
		$curs = $post[$i]['curs'];
		if (isset($post[$i]['grup'])) {
			$grup = $post[$i]['grup'];
		} else {
			$grup = "";
		}

		//Obtenir fitxer json del servidor
		$json = file_get_contents('./database/JSON/classes.json');
		//Guardar les dades del formulari en un array
		$alumne = array(
			'usuari' => $usuari,
			'nomCognoms' => $nomCognoms,
			'cicle' => $cicle,
			'curs' => $curs,
			'grup' => $grup,
			'imatge' => ''
		);
		//Afegir l'array a la variable json_data
		$json_result[] = $alumne;
		//Guardar el fitxer json
		file_put_contents('./database/JSON/classes.json', json_encode($json_result));
	}
echo "Success";
?>