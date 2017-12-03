<?php
    session_start();
    if (!isset($_SESSION['username']))
    {
        header("Location: login.php");
        exit;
    }
    
    $pid = $_GET['pid'];
    $user = $_SESSION['username'];
    $connection = mysqli_connect("localhost", "root", "", "cen4020");
        if ($connection == false)
        {
            echo "Connection Failed!";
            die();
        }
    
    $results = mysqli_query($connection, "DELETE FROM belongto WHERE projectID='$pid' AND username='$user'");
    $results = mysqli_query($connection, "DELETE FROM changes WHERE projectID='$pid' AND username='$user'");
    $results = mysqli_query($connection, "DELETE FROM comments WHERE projectID='$pid' AND username='$user'"); 
    $results = mysqli_query($connection, "DELETE FROM tasks WHERE projectID='$pid' AND username='$user'");

    header("Location: myProject.php");
    exit;
?>