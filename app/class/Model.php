<?php
class Model {
    /**
     * Configuration for database connection
     *
     */
    public $pdo;
    public $host       = "mysql";
    public $username   = "root";
    public $password   = "secret";
    public $dbname     = "social";
    // private $dsn        = "mysql:host=$host;dbname=$dbname";
    public $options    = array(
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    );

    /**
     * Open a connection via PDO to create a
     * new database and table with structure.
     *
     */
    public function __construct()
    {
        try {
            $this->pdo = new PDO("mysql:host=$this->host;dbname=$this->dbname", $this->username, $this->password, $this->options);
            // $sql = file_get_contents("data/init.sql");
            // $connection->exec($sql);

            // echo "Database and table users created successfully.";
            // return $this->pdo;
        } catch (PDOException $error) {
            echo  $error->getMessage();
        }
    }

    //function to retrieve user id from sesion (and save a Model)
    public function getUserFromSession($sessionId){
        //prepare query
        $query = 'SELECT * FROM user_sessions  WHERE session_id = :idSession';
        //prepare values
        $values = array('idSession'=>$sessionId);
        //execute query
        try {
            $res = $this->pdo->prepare($query);
            $res->execute($values);
        } catch (PDOException $e) {
            throw new Exception($e);
        }
        //get the results
        $row = $res->fetch();

        return $row['user_id'];
    }
}