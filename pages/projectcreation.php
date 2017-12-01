<?php
    session_start();
    if (!isset($_SESSION['username']))
    {
        header("Location: login.php");
        exit;
    }
    
    $blank = "";
    if($_POST['projectName'] != "" && $_POST['details']!="" && $_POST['projectKey'] != "" && $_POST['confirmProjectKey'] != "")
    {
        $name = $_POST['projectName'];
        $details = $_POST['details'];
        $key1 = $_POST['projectKey'];
        $key2 = $_POST['confirmProjectKey'];
        
        if ($key1 == $key2)
        {
            $connection = mysqli_connect("localhost", "root", "", "cen4020");
            
            if ($connection == false)
            {
                echo "Connection Failed!";
                die();
            }
            
            else
            {
                date_default_timezone_set('EST');
                $date = date("Y-m-d");
                $result = mysqli_query($connection, "INSERT INTO `projects` (`projectID`, `projectName`, `projectStart`, `projectDescription`, `projectKey`) VALUES (NULL, '$name', '$date', '$details', MD5('$key1'))");
                if($result)
                {
                    $getID = mysqli_query($connection, "SELECT projectID FROM projects WHERE projectName='$name' AND projectDescription='$details' AND projectKey=md5('$key1')");
                    $rows = mysqli_fetch_row($getID);
                    $ID = $rows[0];
                    $user = $_SESSION['username'];
                    $result = mysqli_query($connection, "INSERT INTO belongto (username, projectID, permissions) VALUES ('$user', $ID, 1)");
                    mysqli_close($connection);
                    header("Location: myProject.php");
                    exit;
                }
                else
                {
                    header("Location: createProject.php");
                    exit;
                }
            }
        }
    }
    
    header("Location: createProject.php");
    exit;
?>