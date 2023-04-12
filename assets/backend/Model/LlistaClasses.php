<?php 

class LlistaClasses{

    public static function getClasses(){

        $json_content = json_decode(file_get_contents(dirname(dirname(__FILE__)).'/database/JSON/classes.json'));

        $filtreTutors = array_filter($json_content, function($item) {
            return !strpos($item->usuari, '.');
        });

        $filtreAlumnes = array_filter($json_content, function($item) {
            return strpos($item->usuari, '.');
        });

        $llistaClasses = array();
        foreach ($filtreTutors as $usuari) {
            $tutor = new Usuari($usuari->usuari,$usuari->nomCognoms,$usuari->cicle,$usuari->curs,$usuari->grup, $usuari->imatge);
            $classe = new Classe($usuari->cicle, $usuari->curs, $usuari->grup, $tutor);

            $alumnes = array_filter($filtreAlumnes, function($alumne) use($tutor){
                return $alumne->cicle === $tutor->getCicle() && $alumne->curs === $tutor->getCurs() && $alumne->grup === $tutor->getGrup();
            });

            $alumnes = array_map(function($element){
                return new Usuari($element->usuari,$element->nomCognoms,$element->cicle,$element->curs,$element->grup, $element->imatge);
            },$alumnes);

            $classe->setAlumnes($alumnes);
            
            array_push($llistaClasses, $classe);
        }
        
        return $llistaClasses;
    }
}

?>