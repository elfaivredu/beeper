<?php

namespace Controller;

use Controller\ControllerBase;
use App\Src\App;
use Model\Finder\UserFinder;
use Model\Gateway\TweetGateway;
use App\Src\Request\Request;

class TweetController extends ControllerBase{

    public function __construct(App $app)
    {
        parent::__construct($app);
    }

    public function homepageHandler(Request $request){
        $tweets = $this->app->getService('UserFinder')->findAllTweets();

        $render = $this->app->getService('render');
        $render ('homepage', ['tweets' => $tweets]);
    }

    public function tweetsHandler(Request $request){
        $tweet = $this->app->getService('UserFinder')->findAllTweets();
        if (!is_array($tweet)) $tweets[] = $tweet;
        else $tweets = $tweet;
        //var_dump($tweets);
        $render = $this->app->getService('render');
        $render ('tweets', ['tweets' => $tweets]);
    }


    public function createTweetDBHandler(Request $request)
    {
        try { // on utilise un try catch pour renvoyer vers une erreur si la requête n'a pas fonctionné
            $tweet = [
                'post' => $request->getParameters('post')
            ];
            if ($tweet['post']){
                $this->app->getService('UserFinder')->saveTweet($tweet);
                $tweets = $this->app->getService('UserFinder')->findAllTweets();
                $render = $this->app->getService('render');
                $render ('tweets', ['tweets' => $tweets]);
            }
            else {$e = "Please fill in all fields";
                $render = $this->app->getService('render');
                $render('homepage', ["error"=>$e]);
            }

        } catch (Exception $e) {
            $render = $this->app->getService('render');
            $render('homepage', ["tweets" => $tweets]);
        }
    }

    public function DeleteTweetHandler(Request $request, $id)
    {
        try { // on utilise un try catch pour renvoyer vers une erreur si la requête n'a pas fonctionné
            $tweet = [
                'tweet_id' => $id
            ];


            $this->app->getService('UserFinder')->deleteTweet($tweet);
            $tweets = $this->app->getService('UserFinder')->findAllTweets();
            $a = "Le tweet a été supprimé";
            $render = $this->app->getService('render');
            $render('tweets', ["tweets" => $tweets, "valid"=>$a]);

        } catch (Exception $e) {
            $render = $this->app->getService('render');
            $render('tweets', ["tweets" => $tweets, "error" =>$e]);
        }
    }

    public function updateTweetHandler(Request $request, $id)
    {
        $tweet = $this->app->getService('UserFinder')->findOneTweet($id);

        $render = $this->app->getService('render');
        $render('updateTweet', ["tweet" => $tweet]);
    }

    public function updateTweetDBHandler(Request $request, $id)
    {
        try { // on utilise un try catch pour renvoyer vers une erreur si la requête n'a pas fonctionné
            $tweet = [
                'tweet_id' => $id,
                'post' => $request->getParameters('tweet'),
            ];


            $this->app->getService('UserFinder')->updateTweet($tweet);
            $tweets = $this->app->getService('UserFinder')->findAllTweets();
            $a = "A tweet has been update";
            $render = $this->app->getService('render');
            $render('tweets', ["tweets" => $tweets, "valid" =>$a]);

        } catch (Exception $e) {

            $render = $this->app->getService('render');
            $render('tweets', ["tweets" => $tweets, "error" =>$e]);
        }
    }



}