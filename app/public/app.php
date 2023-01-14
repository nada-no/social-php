<?php
//start session before everything else executes
session_start();

//includings
include '../';
include 'class/User.php';


$user = new User();
try
{
	$newId = $user->addUser('myNewName', 'myPassword');
}
catch (Exception $e)
{
	/* Something went wrong: echo the exception message and die */
	echo $e->getMessage();
	die();
}
echo 'The new account ID is ' . $newId;


