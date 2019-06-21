<?php

//on va passer par namespace pour enlever require once ( namespace suivit du/des dossiers)
namespace App;

use Controller\TweetController;
use Controller\UserController;
use App\Src\App;
use Model\Finder\UserFinder;


class Routing
{
    private $app;

    /**
     * Routing constructor.
     * @param App $app
     */
    public function __construct(App $app)
    {
        $this->app = $app;
    }

    public function setup(){
        $user = new UserController($this->app);
        $tweet = new TweetController($this->app);

        $this->app->get('/', [$user, 'ConnectionHandler']);

        $this->app->post('/handleConnection', [$user, 'ConnectionDBHandler']);

        $this->app->get('/inscription', [$user, 'InscriptionHandler']);

        $this->app->post('/handleInscription', [$user, 'InscriptionDBHandler']);

        $this->app->get('/user/(\w+)', [$user, 'ProfileHandler']);

        $this->app->get('/handleDisconnection', [$user, 'DisconnectionDBHandler']);

        $this->app->get('/updateProfile', [$user, 'UpdateHandler']);

        $this->app->post('/handleUpdateProfile',[$user, 'UpdateDBHandler']);

        $this->app->get('/delete', [$user, 'DeleteHandler']);

        $this->app->get('/profilePublic/(\d+)', [$user, 'profilePublicHandler']);

        $this->app->post('/search', [$user, 'searchDBHandler']);

        $this->app->get('/homepage', [$tweet, 'homepageHandler']);

        $this->app->get('/tweets', [$tweet, 'tweetsHandler']);

        $this->app->post('/handleCreate', [$tweet, 'createTweetDBHandler']);

        $this->app->get('/deleteTweet/(\d+)', [$tweet, 'DeleteTweetHandler']);

        $this->app->get('/updateTweet/(\d+)', [$tweet, 'updateTweetHandler']);

        $this->app->post('/handleUpdateTweet/(\d+)', [$tweet, 'updateTweetDBHandler']);

        $this->app->post('/handleAddFollow',[$user, 'addFollower' ]);

        $this->app->post('/handleSuppFollow',[$user, 'suppFollower' ]);

    }

}