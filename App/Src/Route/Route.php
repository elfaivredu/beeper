<?php
/**
 * Created by PhpStorm.
 * User: elfaivredu
 * Date: 27/03/2019
 * Time: 11:18
 */

namespace App\Src\Route;

class Route
{
    // va permettre de definir la methode http avec laquelle le root est definis
    //string en référence
    /**
     * @var string
     */
    private $method;


    //donne au root son caractere spé et unique
    //identifieroot par rapport a uri
    /**
     * @var string
     */
    private $pattern;


    //fonction a appeler si l'uri correspond a la pattern
    /**
     * @var callable
     */
    private $callable;

    //argument envoyer a la fonctin
    //array = tableau
    /**
     * @var array
     */
    private $arguments;

    //permet bone mise en plavce de la classe et regle premier parametre
    /**
     * Route constructor.
     * @param string $method
     * @param string $pattern
     * @param callable $callable
     */
    public function __construct(string $method, string $pattern, callable $callable)
    {
        $this->method = $method;
        $this->pattern = $pattern;
        $this->callable = $callable;
        $this->arguments = array();
    }

    //est cde que route correspond au pattern de la route qui est envoyé
    public function match(string $method, string $uri)
    {
        if($this->method != $method)
        {
            return false;
        }

        if(preg_match($this->compilePattern(), $uri, $this->arguments))
        {
           array_shift($this->arguments);

           return true;
        }

        return false;
    }

    //permet de récupérer tous elements au sein de la fonctuon
    /**
     * @return string
     */
    public function getMethod(): string
    {
        return $this->method;
    }

    /**
     * @return string
     */
    public function getPattern(): string
    {
        return $this->pattern;
    }

    /**
     * @return callable
     */
    public function getCallable(): callable
    {
        return $this->callable;
    }

    /**
     * @return array
     */
    public function getArguments(): array
    {
        return $this->arguments;
    }


    //sprintf = remplace un elemùent au sein de la chaine de caractere -> va afficher %s
    //definis comment on a construit notre route au sein de l'instance
    private function compilePattern()
    {
        return sprintf('#^%s$#', $this->pattern);
    }

}