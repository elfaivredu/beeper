<?php

namespace Model\Gateway;

use App\Src\App;

class TweetGateway
{
    /**
     * @var \PDO
     */
    private $conn;

    private $id;

    private $post;

    private $author;

    private $author_id;

    private $date;


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
    public function getPost()
    {
        return $this->post;
    }

    /**
     * @param mixed $tweet
     */
    public function setPost($post): void
    {
        $this->post = $post;
    }

    /**
     * @return mixed
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * @return mixed
     */
    public function getAuthorId()
    {
        return $this->author_id;
    }

    /**
     * @param mixed $author_id
     */
    public function setAuthorId($author_id): void
    {
        $this->author_id = $author_id;
    }

    /**
     * @return mixed
     */
    public function getDate()
    {
        return $this->date;
    }


    public function __construct(App $app)
    {
        $this->conn = $app->getService('database')->getConnection();
    }

    public function insert() : void{
        $date = date('c');
        $author = $_SESSION['id'];

        $query = $this->conn->prepare('INSERT INTO tweet (post, date, user_id) VALUES (:post, :date, :author)');
        $executed = $query->execute([
            ':post' => $this->post,
            ':author' => $author,
            ':date' => $date
        ]);

        if(!$executed) throw new \Error('Insert Failed');

        $this->id = $this->conn->lastInsertId();
    }

    public function hydrate(Array $element)
    {
        $this->id = $element['tweet_id'];
        $this->post = $element['post'];
        if(isset($element['login']))$this->author = $element['login'];
        $this->author_id = $element['user_id'];
        $this->date = $element['date'];
    }

    public function delete() : void{
        if(!$this->id) throw new \Error('Instance does not exist in base');

        $query = $this->conn->prepare('DELETE FROM tweet WHERE tweet_id = :id');
        $executed = $query->execute([
            ':id' => $this->id
        ]);

        if(!$executed) throw new \Error('Delete Failed');
    }

    public function update() : void{
        if(!$this->id) throw new \Error('Instance does not exist in base');

        $query = $this->conn->prepare('UPDATE tweet SET post = :post WHERE tweet_id = :id');
        $executed = $query->execute([
            ':post' => $this->post,
            ':id' => $this->id,
        ]);

        if(!$executed) throw new \Error('Update Failed');
    }









}