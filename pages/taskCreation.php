<?php
    session_start();
    if (!isset($_SESSION['username']))
    {
        header("Location: login.php");
        exit;
    }
    
    date_default_timezone_set('America/New_York');
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
        $connection = mysqli_connect("localhost", "root", "", "cen4020");
            
        if ($connection == false)
        {
            echo "Connection Failed!";
            die();
        }
         
        else
        {
            $findName = mysqli_query($connection, "SELECT projectName FROM projects WHERE projectID='$project'");
            $namerow = mysqli_fetch_row($findName);
            $pname = $namerow[0];
            $abr = strtoupper(substr($pname, 0, 3));
            $checkAdmin = mysqli_query($connection, "SELECT permissions FROM belongto WHERE username='$user' AND projectID='$project'");
            
            if(mysqli_num_rows($checkAdmin) != 0)
            {
                $row = mysqli_fetch_row($checkAdmin);
                if ($row[0] == 1)
                {
                    $checkAss = mysqli_query($connection, "SELECT permissions FROM belongto WHERE username='$assignee' AND projectID='$project'");

                    if(mysqli_num_rows($checkAss) != 0)
                    {
                        $insert = mysqli_query($connection, "INSERT INTO tasks (dueDate, username, projectID, taskDescription, priority, status, title, abbreviation) VALUES ('$duedate', '$assignee', $project, '$taskDescript', '$priority', 1, '$title', '$abr')");
                        $tid = mysqli_query($connection, "SELECT taskID FROM tasks WHERE username = '$user' AND projectID = '$project' AND title = '$title' AND taskDescription = '$taskDescript'");
                        $tidrow = mysqli_fetch_row($tid);
                        $task = $tidrow[0];

                        if ($insert)
                        {
                            $getname = mysqli_query($connection, "SELECT projectName FROM projects WHERE projectID=$project");
                            $res = mysqli_fetch_row($getname);
                            $pname = $res[0];

                            $today = date("Y-m-d H:i:s");
                            $change = mysqli_query($connection, "INSERT INTO changes (changeID, changeType, projectID, taskID, timestamp, username) VALUES (NULL, 2, '$project', '$task', '$today', '$user')");

                            header("Location: viewProject.php?var=".urlencode($pname));
                            exit;
                        }
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