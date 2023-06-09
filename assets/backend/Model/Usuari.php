<?php 

class Usuari implements JsonSerializable{

    protected $usuari;
    protected $nomCognoms;
    protected $cicle;
    protected $curs;
    protected $grup;
    protected $imatge;

    // Constructor
    public function __construct($usuari, $nomCognoms, $cicle, $curs, $grup, $imatge)
    {
        $this->usuari = $usuari;
        $this->nomCognoms = $nomCognoms;
        $this->cicle = $cicle;
        $this->curs = $curs;
        $this->grup = $grup;
        $this->imatge = $imatge;
    }

    // Getters
    public function getUsuari(){
        return $this->usuari;
    }

    public function getNomCognoms(){
        return $this->nomCognoms;
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
    
    public function getImatge(){
        return $this->imatge;
    }

    // Setters
    public function setUsuari($usuari){
        $this->usuari = $usuari;
    }

    public function setNomCognoms($nomCognoms){
        $this->nomCognoms = $nomCognoms;
    }

    public function setCicle($cicle){
        $this->cicle = $cicle;
    }

    public function setCurs($curs){
        $this->curs = $curs;
    }
    
    public function setGrup($grup){
        $this->grup = $grup;
    }
    
    public function setImatge($imatge){
        $this->imatge = $imatge;
    }

    // Funció de la interficie JsonSerializable perque l'objecte sigui convertible a json
    public function jsonSerialize()
    {
        return [
            "usuari" => $this->usuari,
            "nomCognoms" => $this->nomCognoms,
            "cicle" => $this->cicle,
            "curs" => $this->curs,
            "grup" => $this->grup,
            "imatge" => $this->imatge
        ];
    }
}

?>