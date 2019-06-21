<?php

namespace Model\Finder;

use App\Src\App;
use Model\Gateway\TweetGateway;
use Model\Gateway\UserGateway;
use Model\Finder\FinderInterface;

if(session_status()==1) session_start();

class UserFinder implements FinderInterface
{
    /**
     * @var \PDO
     */
    private $conn;

    /**
     * @var App
     */
    private $app;

    public function __construct(App $app)
    {
        $this->app = $app;
        $this->conn = $this->app->getService('database')->getConnection();
    }

    public function inscription($infos) : void {
        $account = new UserGateway($this->app);
        $account->setLogin(htmlspecialchars($infos['login']));
        $account->setEmail(htmlspecialchars($infos['email']));
        $account->setPassword(sha1($infos['password']));
        $account->setBirthday(($infos['birthday']));
        $account->setGender(($infos['gender']));


        $account->insert();

    }

    public function verifyLogin($infos){
        $query = $this->conn->prepare('SELECT login FROM user WHERE login = :login ');
        $query->execute([':login' => $infos['login']]); // Exécution de la requête
        $element = $query->fetch(\PDO::FETCH_ASSOC);

        if ($element['login'] == htmlspecialchars($infos['login']))
        {
            return false;
        }
        else return true;
    }

    public function verifyEmail($infos){
        $query = $this->conn->prepare('SELECT email FROM user WHERE email = :email ');
        $query->execute([':email' => $infos['email']]); // Exécution de la requête
        $element = $query->fetch(\PDO::FETCH_ASSOC);

        if ($element['email'] == htmlspecialchars($infos['email']))
        {
            return false;
        }
        else return true;
    }

    public function VerifyPassword($infos){
        $query = $this->conn->prepare('SELECT password FROM user WHERE login = :login ');
        $query->execute([':login' => $infos['login']]); // Exécution de la requête
        $element = $query->fetch(\PDO::FETCH_ASSOC);
        if ($element['password'] == sha1($infos['password']))
            return false;
        else return true;
    }


    public function connect($infos){
        $query = $this->conn->prepare('SELECT user_id, login, email, password, birthday, gender FROM user WHERE login = :login ');
        $query->execute([':login' => $infos['login']]); //Execution de la requete

        $element = $query->fetch(\PDO::FETCH_ASSOC);
        if($element === null) return null;

        $account = new UserGateway($this->app);
        $account->hydrate($element);

        return $account;
    }

    public function profile($id){
        $query = $this->conn->prepare('SELECT user_id, login, email, password, birthday, gender, date  FROM user WHERE user_id = :id ');
        $query->execute([':id' => $id]); // Exécution de la requête
        $element = $query->fetch(\PDO::FETCH_ASSOC);

        if($element === null) return null;

        $account = new UserGateway($this->app);
        $account->hydrate($element);

        return $account;
    }

    public function update(Array $infos){
        $account = $this->profile($infos['id']);
        $account->setLogin(htmlspecialchars($infos['login']));
        $account->setPassword(sha1($infos['password']));
        $account->setEmail(htmlspecialchars($infos['email']));
        $account->setBirthday($infos['birthday']);
        $account->setGender($infos['gender']);
        $account->update();

        return $account;
    }

    public function delete(Array $infos) : void
    {
        $account = $this->profile($infos['id']);
        $account->delete();
    }

    public function findProfilePublic($id)
    {
        $query = $this->conn->prepare('SELECT user_id, login, birthday, gender FROM user WHERE user_id = :id');
        $query->execute([':id' => $id]); // Exécution de la requête
        $element = $query->fetch(\PDO::FETCH_ASSOC);

        if($element === null) return null;

        $member = new UserGateway($this->app);
        $member->hydratePublic($element);

        return $member;
    }

    public function search($searchString) {
        $query = $this->conn->prepare('SELECT user_id, login, birthday, gender  FROM user WHERE  login like :search ORDER BY login');
        $query->execute([':search' => '%' . $searchString .  '%']); // Exécution de la requête
        $elements = $query->fetchAll(\PDO::FETCH_ASSOC);

        if(count($elements) === 0) return null;

        $members = [];
        $member = null;
        foreach ($elements as $element){
            $member = new UserGateway($this->app);
            $member->hydratePublic($element);

            $members[] = $member;
        }

        return $members;
    }

    public function saveTweet($infos) : void {
        $tweet = new TweetGateway($this->app);
        $tweet->setPost(htmlspecialchars($infos['post']));
        $tweet->getAuthor();
        $tweet->getDate();

        $tweet->insert();
    }

    public function findAllTweets(){

        $query = $this->conn->prepare('SELECT tweet.tweet_id, tweet.post, user.login, tweet.date, tweet.user_id FROM tweet LEFT JOIN user ON tweet.user_id = user.user_id ORDER BY tweet.date'); // Création de la requête + utilisation order by pour ne pas utiliser sort
        $query->execute(); // Exécution de la requête
        $elements = $query->fetchAll(\PDO::FETCH_ASSOC);

        if(count($elements) === 0) return null;

        $tweets = [];
        $tweet = null;
        foreach ($elements as $element){
            $tweet = new TweetGateway($this->app);
            $tweet->hydrate($element);
            $tweets[] = $tweet;
        }
        return $tweets;
    }

    public function findOneTweet($tweet_id)
    {
        $query = $this->conn->prepare('SELECT tweet_id, post, date, user_id FROM tweet WHERE tweet_id = :id'); // Création de la requête + utilisation order by pour ne pas utiliser sort
        $query->execute([':id' => $tweet_id]); // Exécution de la requête
        $element = $query->fetch(\PDO::FETCH_ASSOC);
        if($element === null) return null;

        $tweet = new TweetGateway($this->app);
        $tweet->hydrate($element);

        return $tweet;
    }

    public function deleteTweet(Array $infos) : void {
        $tweet = $this->findOneTweet($infos['tweet_id']);
        $tweet->delete();
    }

    public function updateTweet(Array $infos) : void {
        $tweet = $this->findOneTweet($infos['tweet_id']);
        $tweet->setPost(htmlspecialchars($infos['post']));
        $tweet->update();
    }

    public function follow($id){
        $query = $this->conn->prepare('SELECT following_id, profile_id FROM follow WHERE following_id = :following_id AND profile_id = :profile_id');
        $query->execute([':profile_id' => $_SESSION['id'],
            ':following_id' => $id]);
        $elements = $query->fetch(\PDO::FETCH_ASSOC);

        if($elements == null){
            $query = $this->conn->prepare('INSERT INTO follow(profile_id, following_id) VALUES (:profile_id, :following_id)');
            $query->execute([':profile_id' => $_SESSION['id'],
                ':following_id' => $id]);
            $query->fetch(\PDO::FETCH_ASSOC);
        }
    }

    public function unfollow($id)
    {
        $query = $this->conn->prepare('DELETE FROM  follow WHERE profile_id = :profile_id AND following_id = :following_id)');
        $query->execute([':profile_id' => $_SESSION['id'],
            ':following_id' => $id]);
        $query->fetch(\PDO::FETCH_ASSOC);
    }


}