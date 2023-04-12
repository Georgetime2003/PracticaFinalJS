<?php 

class Classe implements JsonSerializable{

    protected $cicle;
    protected $curs;
    protected $grup;
    protected $tutor;
    protected $alumnes = array();

    // Constructor
    public function __construct($cicle, $curs, $grup, $tutor)
    {
        $this->cicle = $cicle;
        $this->curs = $curs;
        $this->grup = $grup;
        $this->tutor = $tutor;
    }

    // Getters
    public function gettutor(){
        return $this->tutor;
    }

    public function getalumnes(){
        return $this->alumnes;
    }

    public function getCicle(){
        return $this->cicle;
    }

    public function getCurs(){
        return $this->curs;
    }
    
    public function getGrup(){
        return $this->grup;
    }

    // Setters
    public function setCicle($cicle){
        $this->cicle = $cicle;
    }

    public function setCurs($curs){
        $this->curs = $curs;
    }
    
    public function setGrup($grup){
        $this->grup = $grup;
    }

    public function setTutor($tutor){
        $this->tutor = $tutor;
    }

    public function setAlumnes($alumnes){
        $this->alumnes = $alumnes;
    }

    public function addAlumne($alumne){
        array_push($this->alumnes, $alumne);
    }

    // Funció de la interficie JsonSerializable perque l'objecte sigui convertible a json
    public function jsonSerialize()
    {
        return [
            "cicle" => $this->cicle,
            "curs" => $this->curs,
            "grup" => $this->grup,
            "tutor" => $this->tutor,
            "alumnes" => $this->alumnes
        ];
    }
}

?>