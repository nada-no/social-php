<?php

/**
 * Configuration for database connection
 *
 */

 $host       = "mysql";
 $username   = "root";
 $password   = "secret";
 $dbname     = "social";
 $dsn        = "mysql:host=$host;dbname=$dbname";
 $options    = array(
                 PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
               );

/**
 * Open a connection via PDO to create a
 * new database and table with structure.
 *
 */

try {
    $connection = new PDO("mysql:host=$host", $username, $password, $options);
    // $sql = file_get_contents("data/init.sql");
    // $connection->exec($sql);
    
    echo "Database and table users created successfully.";
} catch(PDOException $error) {
    echo $sql . "<br>" . $error->getMessage();
}