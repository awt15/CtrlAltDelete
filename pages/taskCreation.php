<?php
    session_start();
    $blank = "";
    if($_POST['project'] != "" && $_POST['dueDate']!="" && $_POST['priority'] != "" && $_POST['title'] != "" && $_POST['assignee'] != "" && $_POST['taskDescript'])
    {
        $project = $_POST['project'];
        $duedate = $_POST['dueDate'];
        $priority = $_POST['priority'];
        $title = $_POST['title'];
        $assignee = $_POST['assignee'];
        $taskDescript = $_POST['taskDescript'];

        $connection = mysqli_connect("localhost", "root", "", "cen4020");
            
        if ($connection == false)
        {
            echo "Connection Failed!";
            die();
        }
            
        else
        {
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
            }
            else
            {
                header("Location: createTask.php");
                exit;
            }
        }
        
    }
    else
    {
        header("Location: createTask.php");
        exit;
    }
?>