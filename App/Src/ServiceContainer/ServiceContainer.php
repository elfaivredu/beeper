<?php

namespace App\Src\ServiceContainer;

class ServiceContainer
{
    /**
     * Get service in the container
     *
     * Contains all services of a php app
     * @var array
     */
    private $container = array(); // = tableau

    //notre classe contient 2 methode (get et set ) et peut en contenir uene 3eme
    /**
     * Create a service in the container
     *
     * @param string $serviceName Name of the service to create in the container
     * @return mixed
     */
    public function get(string $serviceName){
        //grace au servicename on va aller chercher dans le tableau le contenu qui lui correspond
        return $this->container[$serviceName];
    }

    /**
     * @param string $name Name to the service to retrieve
     * @param mixed $assigned Value associated to the service (can be any type)
     */
    public function set(string $name, $assigned){ //assigned peut etre n'importe quel valeur
        $this->container[$name] = $assigned;
    }

    /**
     * Unset a service in the container
     *
     * @param string $name Name of the service to unset in the container
     */
    public function unset(string $name){
        //enleve un element du tableau
        unset($this->container[$name]);
    }
}