<?php

// Connection for the database

$servername = "localhost";
$username = "root";
$password = "";
$database = "notes";

// variable for the alert

$insert = false;
$update = false;
$delete = false;

// creating a connection

$conn = mysqli_connect($servername, $username, $password, $database);

// die if not connected

if (!$conn) {
    die("Sorry you failed to connect the database " . mysqli_connect_error());
}


?>