<?php
include_once 'Model.php';

class PostModel extends Model{

    //METHODS
    public function getAll(){
        //create the query
        $query='SELECT * FROM posts JOIN users ON posts.author = users.id';

        //execute the query
        try {
            $res = $this->pdo->prepare($query);
            $res->execute();
        } catch (PDOException $e) {
            throw new Exception($e);
        }

        $row = $res->fetchAll();


        return $row;
    }

    public function storePost() {
        //create the query
        $query = 'INSERT INTO posts (content,date_posted,author) VALUES (:content, NOW(), :author)';
        //prepare the values
        $values = array(':content'=>$_POST['post'], ':author'=> $this->getUserFromSession(session_id()));       
        //execute the query
        try {
            $res = $this->pdo->prepare($query);
            $res->execute($values);
            
        } catch (PDOException $e) {
            throw new Exception($e);
        }

        //Return the new ID 
        return $this->pdo->lastInsertId();
    }



}