<?php 

class LlistaUsuaris{

    protected static $llistaUsuaris = array();

    public static function getUsuaris(){
        $llistaUsuaris = json_decode(file_get_contents(dirname(dirname(__FILE__)).'/database/JSON/classes.json'));

        return $llistaUsuaris;
    }
}

?>