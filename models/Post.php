<?php

class Post
{
    //DB stuff
    private $conn;
    //private $table = 'post';

    //Properties
    public $id;
    public $category_id;
    public $category_name;
    public $title;
    public $body;
    public $author;
    public $created_at;

    // constructor with DB
    public function __construct($db)
    {
        $this->conn = $db;
    }

    //Get Posts
    public function readPost(){
        $query = 'SELECT c.name as category_name,
        p.id,
        p.category_id,
        p.title,
        p.body,
        p.author,
        p.created_at
        FROM
           posts as p
           LEFT JOIN
             categories as c ON p.category_id = c.id
            ORDER BY
                p.created_at DESC';
        $statement = $this->conn->prepare($query);
        $statement->execute();
        return $statement;
    }

    //Get Single Post
    public function readSinglePost(){
        $query = 'SELECT c.name as category_name,
        p.id,
        p.category_id,
        p.title,
        p.body,
        p.author,
        p.created_at
        FROM
         posts as p
        LEFT JOIN
         categories as c ON p.category_id = c.id
        WHERE p.id=:post_id
         LIMIT 0,1';
        $statement = $this->conn->prepare($query);
        $statement->bindValue(':post_id',$this->id);
        $statement->execute();

        $row = $statement->fetch(PDO::FETCH_ASSOC);

        //Set properties
        $this->title = $row['title'];
        $this->body = $row['body'];
        $this->author = $row['author'];
        $this->category_id = $row['category_id'];
        $this->category_name = $row['category_name'];
    }

    //Create Post
    public function createPost(){
        //create query
        $query = 'INSERT INTO posts
                SET
                title = :title,
                body = :body,
                author = :author,
                category_id = :category_id';
        $statement = $this->conn->prepare($query);

        //clean data
        $this->title = htmlspecialchars(strip_tags($this->title));
        $this->body = htmlspecialchars(strip_tags($this->body));
        $this->author= htmlspecialchars(strip_tags($this->author));
        $this->category_id = htmlspecialchars(strip_tags($this->category_id));

        $statement->bindValue(':title',$this->title);
        $statement->bindValue(':body',$this->body);
        $statement->bindValue(':author',$this->author);
        $statement->bindValue(':category_id',$this->category_id);

        //execute query
        if($statement->execute()){
            return true;
        }

        printf("Error %s.\n", $statement->error);
        return false;
    }

    //update post

    public function updatePost(){
        //create query
        $query = 'UPDATE posts
                SET
                title = :title,
                body = :body,
                author = :author,
                category_id = :category_id
                WHERE id=:post_id';
        $statement = $this->conn->prepare($query);

        //clean data
        $this->title = htmlspecialchars(strip_tags($this->title));
        $this->body = htmlspecialchars(strip_tags($this->body));
        $this->author= htmlspecialchars(strip_tags($this->author));
        $this->category_id = htmlspecialchars(strip_tags($this->category_id));
        $this->id = htmlspecialchars(strip_tags($this->id));

        $statement->bindValue(':title',$this->title);
        $statement->bindValue(':body',$this->body);
        $statement->bindValue(':author',$this->author);
        $statement->bindValue(':category_id',$this->category_id);
        $statement->bindValue(':post_id',$this->id);

        //execute query
        if($statement->execute()){
            return true;
        }

        //Print error if something goes wrong
        printf("Error %s.\n", $statement->error);
        return false;
    }
    //delete post
    public function deletePost(){
        //create query
        $query = 'DELETE FROM posts WHERE id = :post_id';
        $statement = $this->conn->prepare($query);

        //clean data
        $this->id = htmlspecialchars(strip_tags($this->id));
        $statement->bindValue(':post_id',$this->id);


        //execute query
        if($statement->execute()){
            return true;
        }

        //Print error if something goes wrong
        printf("Error %s.\n", $statement->error);
        return false;

    }

}