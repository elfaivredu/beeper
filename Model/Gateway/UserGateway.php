<?php

namespace Model\Gateway;

use App\Src\App;

class UserGateway
{
    /**
     * @var \PDO
     */
    private $conn;

    private $id;

    private $login;

    private $email;

    private $password;

    private $birthday;

    private $gender;

    private $follower;

    private $DateInscription;

    public function __construct(App $app)
    {
        $this->conn = $app->getService('database')->getConnection();
    }

    public function insert() : void{
        $date = date ( 'c');
        $query = $this->conn->prepare('INSERT INTO user (login, email, password, birthday, gender, date) VALUES (:login, :email, :password, :birthday, :gender, :date)');
        $executed = $query->execute([
            ':login'=> $this->login,
            ':email' => $this->email,
            ':password' => $this->password,
            ':birthday' => $this->birthday,
            ':gender' => $this->gender,
            ':date' => $date,
        ]);

        if(!$executed) throw new \Error('Insert Failed');

        $this->id = $this->conn->lastInsertId();
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }


    /**
     * @return mixed
     */
    public function getLogin()
    {
        return $this->login;
    }

    /**
     * @param mixed $login
     */
    public function setLogin($login) : void
    {
        $this->login = $login;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email) : void
    {
        $this->email = $email;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param mixed $password
     */
    public function setPassword($password) : void
    {
        $this->password = $password;
    }

    /**
     * @return mixed
     */
    public function getBirthday()
    {
        return $this->birthday;
    }

    /**
     * @param mixed birthday
     */
    public function setBirthday($birthday) :void
    {
        $this->birthday = $birthday;
    }

    /**
     * @return mixed
     */
    public function getGender()
    {
        return $this->gender;
    }

    /**
     * @param mixed gender
     */
    public function setGender($gender) :void
    {
        $this->gender = $gender;
    }


    /**
     * @return mixed
     */
    public function getDateInscription()
    {
        if(!$this->id) throw new \Error('Instance does not exist in base');

        $query = $this->conn->prepare('SELECT date FROM user WHERE id = :id');
        $executed = $query->execute([
            ':id' => $this->id
        ]);
        $element = $query->fetch(\PDO::FETCH_ASSOC);

        if(!$executed) throw new \Error('Update Failed');

        return $element;
    }

    public function update() : void{
        if(!$this->id) throw new \Error('Instance does not exist in base');

        $query = $this->conn->prepare('UPDATE user SET login = :login, email = :email, password = :password, birthday = :birthday, gender = :gender WHERE user_id = :id');
        $executed = $query->execute([
            ':login' => $this->login,
            ':email' => $this->email,
            ':password' => $this->password,
            ':birthday' => $this->birthday,
            ':gender' => $this->gender,
            ':id' => $this->id
        ]);

        if(!$executed) throw new \Error('Update Failed');
    }


    public function delete() : void
    {
        if(!$this->id) throw new \Error('Instance does not exist in base');

        $query = $this->conn->prepare('DELETE FROM user WHERE user_id = :id');
        $executed = $query->execute([
            ':id' => $this->id
        ]);

        if(!$executed) throw new \Error('Delete Failed');
    }

    public function hydrate(Array $element)
    {
        $this->id = $element['user_id'];
        $this->login = $element['login'];
        $this->email = $element['email'];
        $this->password = $element['password'];
        $this->birthday = $element['birthday'];
        $this->gender = $element['gender'];

    }

    public function hydratePublic(Array $element)
    {
        $this->id = $element['user_id'];
        $this->login = $element['login'];
        $this->birthday = $element['birthday'];
        $this->gender = $element['gender'];
    }

    public function isFollow(){
        $id = $_SESSION['id'];
        $query = $this->conn->prepare('SELECT follow_id FROM follow WHERE profile_id = :profile_id AND following_id = :following_id ');
        $query->execute([':following_id' => $this->id,
            ':profile_id' => $id]); // Exécution de la requête
        $element = $query->fetch(\PDO::FETCH_ASSOC);

        if ($element == null) return false;
        else return true;
    }
}

