<?php
session_start();

$conn = mysqli_connect("localhost", "root", "", "cen4020");
if ($conn == false)
{
    echo "Connection Failed!";
    die();
}

if (isset($_POST['email'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $password = md5($password);
    
    $results = mysqli_query($conn, "SELECT passhash, first, last, username FROM users WHERE email = '$email'");
    $row = mysqli_fetch_row($results);
    if ($password == $row[0])
    {
        echo "Successful Login!";
        $_SESSION['email'] = $email;
        $_SESSION['first'] = $row[1];
        $_SESSION['last'] = $row[2];
        $_SESSION['username'] = $row[3];
        header("Location: index.php");
        exit;
    }
    else
    {
        echo "Failed Login!";
        header("Location: login.php");
        exit;
    }  
    
}

else
    echo "Can't get data";

?>