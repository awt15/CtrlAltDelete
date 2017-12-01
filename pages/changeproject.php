<?php
    session_start();
    if (!isset($_SESSION['username']))
    {
        header("Location: login.php");
        exit;
    }
    
    $pid = $_GET['pid'];
    $connection = mysqli_connect("localhost", "root", "", "cen4020");
        if ($connection == false)
        {
            echo "Connection Failed!";
            die();
        }
    
    $results = mysqli_query($connection, "DELETE FROM tasks WHERE projectID=$pid");
    $results = mysqli_query($connection, "DELETE FROM belongto WHERE projectID=$pid");
    $results = mysqli_query($connection, "DELETE FROM projects WHERE projectID=$pid"); 
    header("Location: myProject.php");
    exit;
?>