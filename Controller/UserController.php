<?php


namespace Controller;

use Controller\ControllerBase;
use App\src\App;
use Model\Finder\UserFinder;
use Model\Gateway\UserGateway;
use App\Src\Request\Request;

class UserController extends ControllerBase
{
    public function __construct(App $app)
    {
        parent::__construct($app);
    }

    public function InscriptionHandler(Request $request)
    {
        $render = $this->app->getService('render');
        $render('inscription');
    }

    public function InscriptionDBHandler(Request $request){
        try{
            $account = [
                'login' => $request->getParameters('login'),
                'email' => $request->getParameters('email'),
                'password' => $request->getParameters('mdp'),
                'birthday' => $request->getParameters('dateNaissance'),
                'gender' => $request->getParameters('genre')



            ];

            if ($account['login'] && $account['email'] && $account['password'] && $account['birthday'] && $account['gender'] && $request->getParameters('mdp2'))
            {
                if ($this->app->getService('UserFinder')->VerifyLogin($account));
                else {
                    $e = "This login is already used";
                    $render = $this->app->getService('render');
                    $render ('inscription', ['error' => $e]);
                }

                if ($this->app->getService('UserFinder')->VerifyEmail($account));
                else {
                    $e = "This email is already used";
                    $render = $this->app->getService('render');
                    $render ('inscription', ['error' => $e]);
                }

                if (strstr($account['email'], '@'));
                else {
                    $e = "Please use a proper email";
                    $render = $this->app->getService('render');
                    $render ('inscription', ['error' => $e]);
                }

                if ($account['password'] == $request->getParameters('mdp2'));
                else
                    {
                        $e = "The passwords are different";
                        $render = $this->app->getService('render');
                        $render ('inscription', ['error' => $e]);
                    }
            }else
                {$e = "Please fill in all fields";
                    $render = $this->app->getService('render');
                    $render ('inscription', ['error' => $e]);
                }

            $this->app->getService('UserFinder')->inscription($account);
            $render = $this->app->getService('render');
            $a = "Votre inscription est reussie";
            $render ('connection',['valid' => $a]);



        }catch (Exception $e) {
            $e = "Error during the inscription";
            $render = $this->app->getService('render');
            $render ('inscription', ['error' => $e]);
        }
    }

    public function ConnectionHandler(Request $request)
    {
        $render = $this->app->getService('render');
        $render('connection');
    }

    public function ConnectionDBHandler(Request $request)
    {
        try {
            $account = [
                'login' => $request->getParameters('login'),
                'password' => $request->getParameters('mdp')
            ];

            if ($this->app->getService('UserFinder')->verifyLogin($account))
            {
                $e = "This login isn't used";
                $render = $this->app->getService('render');
                $render ('connection', ['error' => $e]);
            }

            if (!$this->app->getService('UserFinder')->VerifyPassword($account))
            {
                $e = "This password is wrong";
                $render = $this->app->getService('render');
                $render ('connection', ['error' => $e]);
            }
            $account = $this->app->getService('UserFinder')->connect($account);
            if(session_status ()==1) session_start();
            $_SESSION = [
                'id' => $account->getId(),
                'login' => $account->getLogin(),
                'email' => $account->getEmail(),
                'birthday' => $account->getBirthday(),
                'gender' => $account->getGender()

            ];
            $render = $this->app->getService('render');
            $a = "Votre connexion est reussie";
            $render ('homepage',['valid' => $a]);

        } catch (Exception $e) {
            $e = "Error during the connection";
            $render = $this->app->getService('render');
            $render ('connection', ['error' => $e]);
        }
    }

    public function ProfileHandler(Request $request, $id) {
        $account = $this->app->getService('UserFinder')->profile($id);
        $render = $this->app->getService('render');
        $render('user', ['account'=>$account]);
    }

    public function DisconnectionDBHandler(){
        if (session_status()==1) session_start();
        $_SESSION = array();
        unset($_SESSION);

        session_destroy();
        $render = $this->app->getService('render');
        $render('connection');
    }

    public function UpdateHandler(Request $request)
    {
        $account = $this->app->getService('UserFinder')->profile($_SESSION['id']);
        $render = $this->app->getService('render');
        $render('updateProfile', ['account' => $account]);
    }

    public function UpdateDBHandler(Request $request){
        try{
            $account = [
                'id' => $_SESSION['id'],
                'login' => $request->getParameters('login'),
                'email' => $request->getParameters('email'),
                'password' => $request->getParameters('mdp'),
                'birthday' => $request->getParameters('dateNaissance'),
                'gender' => $request->getParameters('genre'),
            ];
            if ($account['login'] && $account['email'] && $account['password'] && $account['birthday'] && $account['gender'] && $request->getParameters('mdp2')) {
                if ($account['login'] != $_SESSION['login'] && !$this->app->getService('UserFinder')->verifyLogin($account))
                {
                    $e = "This login is already used";
                    $render = $this->app->getService('render');
                    $render ('updateProfile', ['error' => $e]);
                }

                if ($account['email'] != $_SESSION['email'] && !$this->app->getService('UserFinder')->verifyEmail($account)) {
                    $e = "This email is already used";
                    $render = $this->app->getService('render');
                    $render ('updateProfile', ['error' => $e]);
                }

                if ($account['email'] != $_SESSION['email'] && !strstr($account['email'], '@')) {
                    $e = "Please use a proper email";
                    $render = $this->app->getService('render');
                    $render ('updateProfile', ['error' => $e]);
                }
            }

            else
                {
                $e = "Please fill in one field";
                $render = $this->app->getService('render');
                $render ('updateProfile', ['error' => $e]);
                }

            $this->app->getService('UserFinder')->update($account);

            $_SESSION = [
                'id' => $account['id'],
                'login' => $account['login'],
                'email' => $account['email'],
                'birthday' => $account['birthday'],
                'gender' => $account['gender']

            ];

            $render = $this->app->getService('render');
            $a = "Les modifications ont été effectuée";
            $render ('user',['valid' => $a]);

        }catch (Exception $e) {
            $e = "Error during the update";
            $render = $this->app->getService('render');
            $render ('updateProfile', ['error' => $e]);
        }
    }

    public function DeleteHandler(Request $request)
    {
        try
        {
            $account = [
            'id' => $_SESSION['id']
        ];

        $this->app->getService('UserFinder')->delete($account);
        $render = $this->app->getService('render');
        $render ('inscription');

    } catch (Exception $e) {
            $render = $this->app->getService('render');
            $render ('profile');

        }

    }

    public function profilePublicHandler(Request $request, int $id){
        if(!$id){
            $render = $this->app->getService('render');
            $render ('404');
        }

        $member = $this->app->getService('UserFinder')->findProfilePublic($id);
        $tweets = $this->app->getService('UserFinder')->findAllTweets();
        $render = $this->app->getService('render');
        $render ('profilePublic', ["member"=>$member, "tweets" =>$tweets]);
    }

    public function searchDBHandler(Request $request){
        $members = $this->app->getService('UserFinder')->search($request->getParameters('recherche'));
        $render = $this->app->getService('render');
        $render ('search', ["recherche" => $request->getParameters('recherche'),"members"=>$members]);
    }


    public function addFollower(Request $request){
        $id = $request->getParameters('follow_id');
        $this->app->getService('UserFinder')->follow($id);
        $member = $this->app->getService('UserFinder')->findProfilePublic($id);
        $tweets = $this->app->getService('UserFinder')->findAllTweets();
            $render = $this->app->getService('render');
            $render ('profilePublic', ["member"=>$member, "tweets" => $tweets]);
    }

    public function suppFollower(Request $request){
        $id = $request->getParameters('follow_id');
        $this->app->getService('UserFinder')->unfollow($id);

        $member = $this->app->getService('UserFinder')->findProfilePublic($id);
        $tweets = $this->app->getService('UserFinder')->findAllTweets();
            $render = $this->app->getService('render');
            $render ('profilePublic', ["member"=>$member, "tweets" => $tweets]);
    }


}