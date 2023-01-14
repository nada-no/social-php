<?php
// include '../../db_init.php';

class User
{

    //ATTRIBUTES
    private $id;
    private $email;
    private $auth;

    //CONSTRUCTOR
    public function __construct()
    {
        $this->id = null;
        $this->email = null;
        $this->auth = false;
    }

    //DESTRUCTOR
    public function __destruct()
    {
    }

    //METHODS

    //Add a new user to the database and return its id
    public function addUser(string $email, string $pass): int
    {

        global $connection;

        //check if theres another account with the same email
        if (!is_null($this->getIdFromEmail($email))) {
            throw new Exception('Email already exists');
        }

        //add new account
        // Insert query template 
        $query = 'INSERT INTO users (email, pass) VALUES (:email, :pass)';

        // Password hash 
        $hash = password_hash($pass, PASSWORD_DEFAULT);

        // Values array for PDO 
        $values = array(':email' => $email, ':pass' => $hash);

        try {
            $res = $connection->prepare($query);
            $res->execute($values);
        } catch (PDOException $e) {
            /* If there is a PDO exception, throw a standard exception */
            // throw new Exception('Database query error');
            echo $e;
        }

        //Return the new ID 
        return $connection->lastInsertId();
    }

    /* Returns the account id having $email as email, or NULL if it's not found */
    public function getIdFromEmail(string $email): ?int
    {
        /* Global $pdo object */
        global $connection;

        /* Initialize the return value. If no account is found, return NULL */
        $id = NULL;

        /* Search the ID on the database */
        $query = 'SELECT email FROM users WHERE (email = :email)';
        $values = array(':email' => $email);

        try {
            $res = $connection->prepare($query);
            $res->execute($values);
        } catch (PDOException $e) {
            /* If there is a PDO exception, throw a standard exception */
            throw new Exception('Database query error');
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

        global $connection;

        $email = trim($email);
        $pass = trim($pass);

        /* Look for the account in the db. Note: the account must be enabled (account_enabled = 1) */
        $query = 'SELECT * FROM users WHERE (email = :email) AND (user_enabled = 1)';

        /* Values array for PDO */
        $values = array(':email' => $email);

        /* Execute the query */
        try {
            $res = $connection->prepare($query);
            $res->execute($values);
        } catch (PDOException $e) {
            /* If there is a PDO exception, throw a standard exception */
            throw new Exception('Database query error' . $e);
        }

        $row = $res->fetch(PDO::FETCH_ASSOC);

        if (is_array($row)) {
            if (password_verify($pass, $row['pass'])) {

                /* Authentication succeeded. Set the class properties (id and name) */
                $this->id = intval($row['id'], 10);
                $this->email = $email;
                $this->auth = TRUE;

                /* Register the current Sessions on the database */
                $this->registerLoginSession();

                /* Finally, Return TRUE */
                return TRUE;
            }
        }

        /* If we are here, it means the authentication failed: return FALSE */
        return FALSE;
    }

    public function registerLoginSession()
    {
        global $connection;

        /* Check that a Session has been started */
        if (session_status() == PHP_SESSION_ACTIVE) {

            /* 	Use a REPLACE statement to:
			- insert a new row with the session id, if it doesn't exist, or...
			- update the row having the session id, if it does exist.*/
            $query = 'REPLACE INTO user_sessions (session_id,user_id,login_time) VALUES (:session_id, :user_id, NOW())';
            $values = array(':sessionid' => session_id(), ':user_id' => $this->id);

            try {
                $res = $connection->prepare($query);
                $res->execute($values);
            } catch (PDOException $e) {
                /* If there is a PDO exception, throw a standard exception */
                throw new Exception('Database query error' . $e);
            }
        }
    }

    public function sesionLogin(): bool
    {

        global $connection;

        //check if the current session is logged in
        $query = 'SELECT * FROM user_sessions,users where (session_id = :session_id) and (login_time >= (NOW() - INTERVAL 7 DAY)) AND (user_id = users.id) ' .
            'AND (users.user_enabled = 1)';
        $values = array(':session_id' => session_id());

        try {
            $res = $connection->prepare($query);
            $res->execute($values);
        } catch (PDOException $e) {
            /* If there is a PDO exception, throw a standard exception */
            throw new Exception('Database query error');
        }

        $row = $res->fetch(PDO::FETCH_ASSOC);

        if (is_array($row)) {
            /* Authentication succeeded. Set the class properties (id and name) and return TRUE*/
            $this->id = intval($row['user_id'], 10);
            $this->email = $row['email'];
            $this->auth = TRUE;

            // header("Location: dashboard.html");
            return TRUE;
        }

        /* If we are here, the authentication failed */
        return FALSE;
    }
}
