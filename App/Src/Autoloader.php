<?php

//definit lenamespace de autoloader
namespace App\Src; //chemin du fichier

class Autoloader
{
    //va permettre d'enregistrer la fonction autoload
    /**
     * met en place les différents autolaoder de l'app php
     */
    public static function register(){
        spl_autoload_register(array(__CLASS__, 'autoload'));
    }

    //va contenir autoload, argument = class qui va etre chargé
    //recuperation des elements du namespace
    //puis application de la fct string tolower a ces elements
    //recupere cle du dernier element du namespca
    // ucfisrtst = met en capital
    //apres reconstruir la chaine -> il va inserer un slash entrz chaque item pour faire chaine de charactere
    public static function autoload(string $class){
        $namespace = explode('\\', $class);
        $class = implode('/', $namespace);
        require_once $_SERVER['DOCUMENT_ROOT'] . '/' . $class . '.php';
    }
}