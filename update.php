<!-- Connection for the database -->

<?php

$servername = "localhost";
$username = "root";
$password = "";
$database = "notes";

// variable for the alert

$insert = false;

// creating a connection

$conn = mysqli_connect($servername, $username, $password, $database);

// die if not connected

if (!$conn) {
    die("Sorry you failed to connect the database " . mysqli_connect_error());
}



if(isset($_GET['update_id']))
{
    $id = $_GET['update_id'];

    $update_sql = "UPDATE items SET name='$title', description='$desc' WHERE id='$id'";
    $result = mysqli_query($conn, $update_sql);

    if($result)
    {
        echo "Record is deleted successfully!";
        // header("Location: /php_crud/index.php");
        // return redirect('/php_crud/index.php');
    }
    else{
        die(mysqli_error($conn));
    }
}

?>