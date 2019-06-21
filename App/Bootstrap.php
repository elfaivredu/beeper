<?php

namespace App;

use App\Src\App;
use App\Routing;
use App\Src\ServiceContainer\ServiceContainer;
use Database\Database;
use Controller\ControllerBase;
use Model\Finder\UserFinder;

$container = new ServiceContainer();
$app = new App($container); //on fait passer le service  conainer a l'app
// dans un 1er temps initialise la classe app et ensuite envoie vers fichier correspondant
//va definir point d'entree dans publi et par default il s'appelle index

//on va définir nos services
$app->setService('database', new Database( 
    getenv('MYSQL_ADDON_HOST'), 
    getenv('MYSQL_ADDON_DB'), 
    getenv('MYSQL_ADDON_USER'), 
    getenv('MYSQL_ADDON_PASSWORD'), 
    getenv('MYSQL_ADDON_PORT')
));

$app->setService('UserFinder', new UserFinder($app));

$app->setService( 'render', function (String $template, Array $params = []) {
    if ($template === '404') {
        header("HTTP/1.0 404 Not Found");
    }
    ob_start();
    include __DIR__ . '/../view/' . $template . '.php';
    ob_end_flush();
    die();
});


$routing = new Routing($app);
$routing->setup();

return $app;
