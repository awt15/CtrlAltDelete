<?php
    session_start();
    $blank = "";
    if($_POST['projectID'] != "" && $_POST['dueDate']!="" && $_POST['priority'] != "" && $_POST['title'] != "" && $_POST['assignee'] != "" && $_POST['taskDescript'])
    {
        $project = $_POST['projectID'];
        $duedate = $_POST['dueDate'];
        $priority = $_POST['priority'];
        $title = $_POST['title'];
        $assignee = $_POST['assignee'];
        $taskDescript = $_POST['taskDescript'];
        $user = $_SESSION['username'];
        $abr = strtoupper(substr($title, 0, 3));
        
        $connection = mysqli_connect("localhost", "root", "", "cen4020");
            
        if ($connection == false)
        {
            echo "Connection Failed!";
            die();
        }
            
        else
        {
            $result = mysqli_query($connection, "SELECT permissions FROM belongto WHERE username='$user' AND projectID='$project'");
            
            if(mysqli_num_rows($result) != 0)
            {
                $row = mysqli_fetch_row($result);
                if ($row[0] == 1)
                {
                    $insert = mysqli_query($connection, "INSERT INTO tasks (dueDate, username, projectID, taskDescription, priority, status, title, abbreviation) VALUES ('$duedate', '$user', $project, '$taskDescript', '$priority', 1, '$title', '$abr')");
                    if ($insert)
                    {
                        $getname = mysqli_query($connection, "SELECT projectName FROM projects WHERE projectID=$project");
                        $res = mysqli_fetch_row($getname);
                        $pname = $res[0];
                        header("Location: viewProject.php?var=".urlencode($pname));
                        exit;
                    }
                }     
            }
            else
            {
                header("Location: createTask.php");
                exit;
            }
        }
        
    }

    header("Location: createTask.php");
    exit;
?>