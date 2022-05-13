<?php

class Category
{
    //DB stuff
    private $conn;

    //Properties
    public $id;
    public $category_name;
    public $created_at;

    // constructor with DB
    public function __construct($db)
    {
        $this->conn = $db;
    }

    //Get Categories
    public function readCategories(){
        $query = 'SELECT 
        c.name as category_name,
        c.id,
        c.created_at
        FROM
           categories as c
            ORDER BY
                c.created_at DESC';
        $statement = $this->conn->prepare($query);
        $statement->execute();
        return $statement;
    }

    //Get Single Categories
    public function readSingleCategories(){
        $query = 'SELECT 
        c.name as category_name,
        c.id,
        c.created_at
        FROM
           categories as c
           WHERE c.id = :category_id LIMIT 0,1';
        $statement = $this->conn->prepare($query);
        $statement->bindValue(':category_id',$this->id);
        $statement->execute();


        $row = $statement->fetch(PDO::FETCH_ASSOC);

        //Set properties
        $this->category_name = $row['category_name'];
    }


    //create
    public function createCategory(){
        //create query
        $query = 'INSERT INTO categories
                SET
                name = :category_name';
        $statement = $this->conn->prepare($query);

        //clean data
        $this->category_name = htmlspecialchars(strip_tags($this->category_name));

        $statement->bindValue(':category_name',$this->category_name);

        //execute query
        if($statement->execute()){
            return true;
        }

        printf("Error %s.\n", $statement->error);
        return false;
    }

    //update
    public function updateCategory(){
        //create query
        $query = 'UPDATE categories
                SET
                name = :category_name
                WHERE id=:category_id';
        $statement = $this->conn->prepare($query);

        //clean data
        $this->category_name = htmlspecialchars(strip_tags($this->category_name));

        $statement->bindValue(':category_name',$this->category_name);

        //execute query
        if($statement->execute()){
            return true;
        }

        //Print error if something goes wrong
        printf("Error %s.\n", $statement->error);
        return false;
    }

    //update single category
    public function updateSinglePost(){
        $query = 'UPDATE categories
                SET
                name = :category_name
                WHERE id =:category_id';
        $statement = $this->conn->prepare($query);

        //clean data
        $this->category_name = htmlspecialchars(strip_tags($this->category_name));

        $statement->bindValue(':category_name',$this->category_name);
        $statement->bindValue(':category_id',$this->id);
        

        //execute query
        if($statement->execute()){
            return true;
        }

        //Print error if something goes wrong
        printf("Error %s.\n", $statement->error);
        return false;
    }
    //delete
    public function deleteCategory(){
        //create query
        $query = 'DELETE FROM categories WHERE id = :category_id';
        $statement = $this->conn->prepare($query);

        //clean data
        $this->id = htmlspecialchars(strip_tags($this->id));
        $statement->bindValue(':category_id',$this->id);


        //execute query
        if($statement->execute()){
            return true;
        }

        //Print error if something goes wrong
        printf("Error %s.\n", $statement->error);
        return false;

    }
}