<?php
    session_start();
    if (!isset($_SESSION['username']))
    {
        header("Location: login.php");
        exit;
    }
    
    if (isset($_POST['projectKey']) && isset($_POST['projectID']))
    {
        $user = $_SESSION['username'];
        $pid = $_POST['projectID'];
        $pkey = $_POST['projectKey'];
        $connection = mysqli_connect("localhost", "root", "", "cen4020");
        
        if ($connection == false)
        {
            echo "Connection Failed!";
            die();
        }
        
        #make sure user isnt already in project        
        $results = mysqli_query($connection, "SELECT * FROM belongto WHERE username='$user' AND projectID='$pid'");
        $project_exists = mysqli_query($connection, "SELECT * FROM projects WHERE projectID=$pid");
        if (mysqli_num_rows($results) == 0 && mysqli_num_rows($project_exists) != 0)
        {
            $results = mysqli_query($connection, "INSERT INTO belongto (username, projectID, permissions) VALUES ('$user', $pid, 0)");
            if ($results)
            {
                header("Location: myProject.php");
                exit;
            }
        }
    }
    
    header("Location: joinProject.php");
    exit;
    
?>