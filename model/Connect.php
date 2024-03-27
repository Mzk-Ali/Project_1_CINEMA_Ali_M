<?php

namespace Model;

// Classe abstraite car on va pas l'instancier, on utilisera seulement la méthode
abstract class Connect{

    const HOST  = "localhost";
    const DB    = "cinema_ali";
    const USER  = "root";
    const PASS  = "";

    public static function seConnecter() {
        try 
        {
            // "\" devant PDO signifie que PDO est une classe native et non du projet
            return new \PDO("mysql:host=".self::HOST.";dbname=".self::DB.";charset=utf8", self::USER, self::PASS);
        }
        catch (\PDOException $ex) 
        {
            return $ex->getMessage();
        }
    }

}
