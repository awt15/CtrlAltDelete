<?php
    session_start();
    if (!isset($_SESSION['username']))
    {
        header("Location: login.php");
        exit;
    }
    date_default_timezone_set('America/New_York');
    
    $connection = mysqli_connect("localhost", "root", "", "cen4020");
    if ($connection == false)
        {
            echo "Connection Failed!";
            die();
        }
    else{
        $user = $_SESSION['username'];
    	$status = $_GET['stat'];
    	$tid = $_GET['var'];
    	$pidList = mysqli_query($connection, "SELECT projectID FROM tasks WHERE taskID = '$tid'");
    	$pidL = mysqli_fetch_row($pidList);
    	$pid = $pidL[0];
    	$findProjectInfo = mysqli_query($connection, "SELECT projectName FROM projects WHERE projectID = '$pid'");
        $projectRow = mysqli_fetch_row($findProjectInfo);
        $pname = $projectRow[0];
        $stamp = date("Y-m-d H:i:s");
    	if ($status == 1){
    		$sql = mysqli_query($connection, "UPDATE tasks SET status = 2 WHERE taskID = '$tid'");
            $change = mysqli_query($connection, "INSERT INTO changes (changeID, projectID, taskID, timestamp, changetype, username) VALUES (NULL, $pid, $tid, '$stamp', 3, '$user')");
    	}
    	else if ($status == 2){
    		$sql = mysqli_query($connection, "UPDATE tasks SET status = 3 WHERE taskID = '$tid'");
            $change = mysqli_query($connection, "INSERT INTO changes (changeID, projectID, taskID, timestamp, changetype, username) VALUES (NULL, $pid, $tid, '$stamp', 4, '$user')");
    	}

    }
    header("Location: viewProject.php?var=$pname");


?>    