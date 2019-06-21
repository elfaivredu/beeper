<?php
/**
 * Created by PhpStorm.
 * User: elfaivredu
 * Date: 27/03/2019
 * Time: 12:13
 */

namespace App\Src;

use App\Src\Response\Response;
use App\Src\Request\Request;
use App\Src\Route\Route;
use App\Src\ServiceContainer\ServiceContainer;

class App
{
    const GET = "GET";
    const POST = 'POST';
    const PUT = 'PUT';
    const DELETE = 'DELETE';

    /**
     * @var array
     */
    private $routes = array();

    /**
     * @var statusCode
     */
    private $statusCode;

    /**
     * @var ServiceContainer;
     * Contientl'instace de servicecontainer
     */
    private $serviceContainer;

    // recupere une reference de szervice container
    public function __construct(ServiceContainer $serviceContainer)
    {
        $this->serviceContainer = $serviceContainer;
    }

    //va permettre de recuperer serviceconteiner
    /**
     * Retrieve a service from the service container
     *
     * @param string $serviceName Name of the service to retrieve
     *
     * @return mixed
     */
    public function getService(string $serviceName){
         return $this->serviceContainer->get($serviceName);
    }

    /**
     * Set a service in the service container
     *
     * @param string $serviceName Name of the service to set
     *
     * @param $assigned Value of the service to set
     */
    public function setService(string $serviceName, $assigned){
        $this->serviceContainer->set($serviceName, $assigned);
    }
    //pas besoin du unset actuellement du coup pas implementer

    //pas de constructeur car pas besoin
    //permet de definir des rout en fonction d'une certaine pattern et ensuite la fonction qui doit etre appele e fonction du pattern
    /**
     * Creates a route for HTTP verb GET
     *
     * @param string $pattern
     * @param callable $callable
     * @return App $this
     */
    public function get(string $pattern, callable $callable)
    {
        //self::GET ->verifie si bon argumeent envoye/recupere constante au sein de la classe
        $this->registerRoute(self::GET, $pattern, $callable);

        return $this;
    }

    /**
     * Creates a route for POST
     *
     * @param string $pattern
     * @param callable $callable
     * @return $this
     */
    public function post(string $pattern, callable $callable)
    {
        //self::POST ->verifie si bon argumeent envoye/recupere constante au sein de la classe (creer)
        $this->registerRoute(self::POST, $pattern, $callable);

        return $this;
    }

    public function put(string $pattern, callable $callable)
    {
        //self::POST ->verifie si bon argumeent envoye/recupere constante au sein de la classe( modifie)
        $this->registerRoute(self::PUT, $pattern, $callable);

        return $this;
    }

    public function delete(string $pattern, callable $callable)
    {
        //self::POST ->verifie si bon argumeent envoye/recupere constante au sein de la classe
        $this->registerRoute(self::DELETE, $pattern, $callable);

        return $this;
    }

    //donction run va permettre de lancer le rooteur
    // ?-> definis si valuer est null (ici) au nieau du tableau, si celle ci est null il renvois la valeur a sa droite (ici self::GET)
    /**
     * Check with route to use inside the router
     *
     * @throws HttpException
     */
    public function run(Request $request = null)
    {
        if($request === null){
            $request = Request::createFromGlobals();
        }
        $method = $request->getMethod();
        $uri = $request->getUri();
        foreach ($this->routes as $route) {
            if ($route->match($method, $uri)) {  //si marche alors lance un processus au sein de notre classe
                return $this->process($route, $request);
            }
        }

        throw new \Exception('No routes available for this uri');
    }

    /**
     * Process route
     *
     * @param Route $route
     * @throws HttpException
     */
    private function process(Route $route, Request $request)
    {
        try{
            $arguments = $route->getArguments();
            array_unshift($arguments, $request);
            $content = call_user_func_array($route->getCallable(), $arguments);
            if($content instanceof Response) {
                $content->send();
                return;
            }

            $response = new Response($content, $this->statusCode ?? 200);
            $response->send();
        } catch (\Exception $e){
            throw $e;
        }

    }

    //[] = new... -> va venir creer un nouvle element au sein du tableau
    //ici pas forcement acces a route( il faut le require once associé )
    /**
     * Create a route in the routes array
     *
     * @param string $method
     * @param string $pattern
     * @param callable $callable
     */
    private function registerRoute(string $method, string $pattern, callable $callable)
    {
        $this->routes[] = new Route($method, $pattern, $callable);
    }


    private function modifyRoute(string $method, string $pattern, callable $callable){
        $this->routes[] = new Route($method, $pattern, $callable);

    }

    private function deleteRoute(string $method, string $pattern, callable $callable){
        $this->routes[] = new Route($method, $pattern, $callable);

    }
}