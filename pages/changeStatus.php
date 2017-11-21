<?php
    session_start();
    $connection = mysqli_connect("localhost", "root", "", "cen4020");
    if ($connection == false)
        {
            echo "Connection Failed!";
            die();
        }
    else{
    	$status = $_GET['stat'];
    	$tid = $_GET['var'];
    	$pidList = mysqli_query($connection, "SELECT projectID FROM tasks WHERE taskID = '$tid'");
    	$pidL = mysqli_fetch_row($pidList);
    	$pid = $pidL[0];
    	$findProjectInfo = mysqli_query($connection, "SELECT projectName FROM projects WHERE projectID = '$pid'");
        $projectRow = mysqli_fetch_row($findProjectInfo);
        $pname = $projectRow[0];
    	if ($status == 1){
    		$sql = mysqli_query($connection, "UPDATE tasks SET status = 2 WHERE taskID = '$tid'");
    	}
    	else if ($status == 2){
    		$sql = mysqli_query($connection, "UPDATE tasks SET status = 3 WHERE taskID = '$tid'");
    	}

    }
    header("Location: viewProject.php?var=$pname");


?>    