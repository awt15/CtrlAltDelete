<?php
	session_start();
	if (isset($_POST['comment']))
	{
		$tid = $_GET['var'];
		$comment = $_POST['comment'];
		$user = $_SESSION['username'];

		$connection = mysqli_connect("localhost", "root", "", "cen4020");

		if($connection == false)
		{
			echo "Connection Failed!";
			die();
		}
        
        date_default_timezone_set('America/New_York');
		$today = date("Y-m-d");

		$resultsList = mysqli_query($connection, "SELECT projectID FROM tasks WHERE taskID ='$tid'");
		$resultsL = mysqli_fetch_row($resultsList);
		$proj = $resultsL[0];

		$result = mysqli_query($connection, "INSERT INTO comments (commentID, text, commentDate, username, projectID, taskID) VALUES (NULL, '$comment', '$today', '$user', '$proj', '$tid')");

		if($result)
		{
			$today = date("Y-m-d H:i:s");
			$type = 1;
			$change = mysqli_query($connection, "INSERT INTO changes (changeID, changeType, projectID, taskID, timestamp, username) VALUES (NULL, '$type', '$proj', '$tid', '$today', '$user')");

		}
		header("Location: viewTask.php?var=$tid");
		exit;
	}
?>