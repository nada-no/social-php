<?php

class UserModel
{



    /**
     * Configuration for database connection
     *
     */
    private $pdo;
    private $host       = "mysql";
    private $username   = "root";
    private $password   = "secret";
    private $dbname     = "social";
    // private $dsn        = "mysql:host=$host;dbname=$dbname";
    private $options    = array(
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

    //METHODS

    //Add a new user to the database and return its id
    public function storeUser(string $email, string $pass): int
    {

        // global $connection;

        //check if theres another account with the same email
        if (!is_null($this->getIdFromEmail($email))) {
            throw new Exception('Email already exists');
        }

        //add new account
        // Insert query template 
        $query = 'INSERT INTO users (email, pass, user_enabled) VALUES (:email, :pass, :user_enabled)';

        // Password hash 
        $hash = password_hash($pass, PASSWORD_DEFAULT);

        // Values array for PDO 
        $values = array(':email' => $email, ':pass' => $hash, ':user_enabled' => 1);

        try {
            $res = $this->pdo->prepare($query);
            $res->execute($values);
        } catch (PDOException $e) {
            /* If there is a PDO exception, throw a standard exception */
            // throw new Exception('Database query error');
            echo $e;
        }

        //Return the new ID 
        return $this->pdo->lastInsertId();
    }

    /* Returns the account id having $email as email, or NULL if it's not found */
    public function getIdFromEmail(string $email): ?int
    {
        /* Global $pdo object */
        // global $connection;

        /* Initialize the return value. If no account is found, return NULL */
        $id = NULL;

        /* Search the ID on the database */
        $query = 'SELECT email FROM users WHERE (email = :email)';
        $values = array(':email' => $email);

        try {
            $res = $this->pdo->prepare($query);
            $res->execute($values);
        } catch (PDOException $e) {
            /* If there is a PDO exception, throw a standard exception */
            throw new Exception('Database query error: ' . $e);
        }

        $row = $res->fetch(PDO::FETCH_ASSOC);

        /* There is a result: get it's ID */
        if (is_array($row)) {
            $id = intval($row['email'], 10);
        }

        return $id;
    }

    public function login(string $email, string $pass): bool
    {
        // global $connection;
        $email = trim($email);
        $pass = trim($pass);

        /* Look for the account in the db. Note: the account must be enabled (account_enabled = 1) */
        $query = 'SELECT * FROM users WHERE (email = :email) AND (user_enabled = 1)';

        /* Values array for PDO */
        $values = array(':email' => $email);

        /* Execute the query */
        try {
            $res = $this->pdo->prepare($query);
            $res->execute($values);
        } catch (PDOException $e) {
            /* If there is a PDO exception, throw a standard exception */
            throw new Exception('Database query error: ' . $e);
        }

        $row = $res->fetch(PDO::FETCH_ASSOC);

        if (is_array($row)) {
            if (password_verify($pass, $row['pass'])) {
                // Authentication succeeded. 

                /* Register the current Sessions on the database */
                $this->registerLoginSession(intval($row['id'], 10),$email);

                /* Finally, Return TRUE */
                return TRUE;
            }
        }

        /* If we are here, it means the authentication failed: return FALSE */
        return FALSE;
    }

    public function registerLoginSession($idUser,$email)
    {
        // global $connection;

        /* Check that a Session has been started */
        if (session_status() == PHP_SESSION_ACTIVE) {

            /* 	Use a REPLACE statement to:
			- insert a new row with the session id, if it doesn't exist, or...
			- update the row having the session id, if it does exist.*/
            $query = 'REPLACE INTO user_sessions (session_id,user_id,login_time) VALUES (:session_id, :user_id, NOW())';
            $values = array(':sessionid' => session_id(), ':user_id' => $idUser);

            try {
                $res = $this->pdo->prepare($query);
                $res->execute($values);
            } catch (PDOException $e) {
                /* If there is a PDO exception, throw a standard exception */
                throw new Exception('Database query error' . $e);
            }
        }
    }

    // public function sesionLogin(): bool
    // {

    //     // global $connection;

    //     //check if the current session is logged in
    //     $query = 'SELECT * FROM user_sessions,users where (session_id = :session_id) and (login_time >= (NOW() - INTERVAL 7 DAY)) AND (user_id = users.id) ' .
    //         'AND (users.user_enabled = 1)';
    //     $values = array(':session_id' => session_id());

    //     try {
    //         $res = $this->pdo->prepare($query);
    //         $res->execute($values);
    //     } catch (PDOException $e) {
    //         /* If there is a PDO exception, throw a standard exception */
    //         throw new Exception('Database query error');
    //     }

    //     $row = $res->fetch(PDO::FETCH_ASSOC);

    //     if (is_array($row)) {
            // /* Authentication succeeded. Set the class properties (id and name) and return TRUE*/
            // $this->id = intval($row['user_id'], 10);
            // $this->email = $row['email'];
            // $this->auth = TRUE;

    //         // header("Location: dashboard.html");
    //         return TRUE;
    //     }

    //     /* If we are here, the authentication failed */
    //     return FALSE;
    // }
}
