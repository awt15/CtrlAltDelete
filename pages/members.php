<!DOCTYPE html>
<html lang="en">

<?php
    session_start();
    if (!isset($_SESSION['username']))
    {
        header("Location: login.php");
        exit;
    }
?>

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>CtrlAltDelete</title>

    <!-- Bootstrap Core CSS -->
    <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="../vendor/metisMenu/metisMenu.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="../dist/css/sb-admin-2.css" rel="stylesheet">

    <!-- Morris Charts CSS -->
    <link href="../vendor/morrisjs/morris.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="../vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <!-- CUSTOM CSS -->
    <link href="../customcss/custom.css" rel="stylesheet">
</head>

<body>

    <div id="wrapper">

        <!-- Navigation -->
        <nav class="navbar navbar-default navbar-static-top fixedtop" role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="index.php">Ctrl Alt Delete</a>
            </div>
            <!-- /.navbar-header -->

            <ul class="nav navbar-top-links navbar-right">
                <!-- /.dropdown -->
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-user fa-fw"></i> <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                        <li><a href="account.php"><i class="fa fa-user fa-fw"></i> User Profile</a>
                        </li>
                        <li class="divider"></li>
                        <li><a href="login.php"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
                        </li>
                    </ul>
                    <!-- /.dropdown-user -->
                </li>
                <!-- /.dropdown -->
            </ul>
            <!-- /.navbar-top-links -->

            <div class="navbar-default sidebar fixed" role="navigation">
                <div class="sidebar-nav navbar-collapse">
                    <ul class="nav" id="side-menu">
                        <li>
                            <a href="index.php"><i class="fa fa-dashboard fa-fw"></i> Dashboard</a>
                        </li>
                        <li>
                            <a href="myProject.php"><i class="fa fa-folder-open fa-fw"></i> My Projects</a>
                        </li>
                        <li>
                            <a href="myTask.php"><i class="fa fa-bars fa-fw"></i> My Tasks</a>
                        </li>
                        <li>
                            <a href="timeline.php"><i class="fa fa-clock-o fa-fw"></i> Timeline</a>
                        </li>
                        <li>
                            <a href="search.php"><i class="fa fa-search fa-fw"></i> Search</a>
                        </li>
                    </ul>
                </div>
                <!-- /.sidebar-collapse -->
            </div>
            <!-- /.navbar-static-side -->
        </nav>
        <br/>
        <br/>
        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Members</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="panel panel-default">
                    <div class="list-group">
                        <?php
                            $connection = mysqli_connect("localhost", "root", "", "cen4020");
                            $project = $_GET['proj'];
                            $results = mysqli_query($connection, "SELECT username FROM belongto WHERE projectID = '$project'");
                            while($row = mysqli_fetch_row($results))
                            {
                                $uname = $row[0];
                                $asnameL = mysqli_query($connection,"SELECT first, last FROM users WHERE username = '$uname'");
                                $asname = mysqli_fetch_row($asnameL);
                                $fname = $asname[0];
                                $lname = $asname[1];
                                echo "<a href='account.php?user=$uname' class='list-group-item'>$fname $lname</a>";
                            }
                            mysqli_close($connection);
                        ?>
                    </div>

                    <div class="col-lg-12">
                        <h1 class="page-header">Recommended</h1>
                        <!-- Advanced Function -->
                         <table class="table">
                                <thead>
                                    <tr>
                                        <th>Username</th>
                                        <th>Tasks in Projects with Common Members</th>
                                    </tr>
                                </thead>
                                <tbody>
                        <?php
                            $connection = mysqli_connect("localhost", "root", "", "cen4020");
                            $highestCount= 0;
                            $highestUser = "";
                            $secondHighest = 0;
                            $secondUser = "";
                            $thirdHighest = 0;
                            $thirdUser = "";
                            $noUsers = True;
                            
                            $results = mysqli_query($connection, "SELECT username FROM belongto WHERE projectID = '$project'");
                            while ($row = mysqli_fetch_row($results))
                            {
                                $user = $row[0];
                                $findOtherUsers = mysqli_query($connection, "SELECT DISTINCT username FROM belongto WHERE projectID IN (SELECT projectID FROM belongto WHERE username='$user') AND username NOT IN (SELECT username FROM belongto WHERE projectID = '$project')");
                                while ($newrow = mysqli_fetch_row($findOtherUsers))
                                {
                                    $noUsers = False;
                                    $newUser = $newrow[0];
                                    if ($newUser == $highestUser || $newUser == $secondUser || $newUser == $thirdUser)
                                    {
                                        continue;
                                    }
                                    
                                    $findTaskCount = mysqli_query($connection, "SELECT COUNT(DISTINCT taskID) FROM tasks WHERE username='$newUser' AND projectID IN (SELECT projectID FROM belongto WHERE username='$user')");
                                    $taskCount2 = mysqli_fetch_row($findTaskCount);
                                    $taskCount = $taskCount2[0];
                                    
                                    if ($taskCount > $highestCount)
                                    {
                                        $thirdHighest = $secondHighest;
                                        $thirdUser = $secondUser;
                                        $secondHighest = $highestCount;
                                        $secondUser = $highestUser;
                                        
                                        $highestCount = $taskCount;
                                        $highestUser = $newUser;
                                    }
                                    else if ($taskCount > $secondHighest)
                                    {
                                        $thirdHighest = $secondHighest;
                                        $thirdUser = $secondUser;
                                        $secondHighest = $taskCount;
                                        $secondUser = $newUser;
                                    }
                                    else if($taskCount > $thirdHighest)
                                    {
                                        $thirdHighest = $taskCount;
                                        $thirdUser = $newUser;
                                    }
                                }
                            }
                            
                            if ($highestCount != 0)
                            {
                                echo "<tr><td><a href='account.php?user=$highestUser'>$highestUser</a></td><td>$highestCount</td></tr>";
                                if ($secondHighest != 0)
                                {
                                    echo "<tr><td><a href='account.php?user=$secondUser'>$secondUser</a></td><td>$secondHighest</td></tr>";
                                    
                                    if($thirdHighest != 0)
                                    {
                                        echo "<tr><td><a href='account.php?user=$thirdUser'>$thirdUser</a></td><td>$thirdHighest</td></tr>";
                                    }
                                }
                            }
                            else
                            {
                                echo "<tr><td>No recommended users found!</td><td>Join projects with other users for this feature to work!</td></tr>";
                            }
                        ?>
                        </tbody>
                        </table>
                    </div>
            </div>
        </div>
    <!-- /#wrapper -->

    <!-- jQuery -->
    <script src="../vendor/jquery/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="../vendor/bootstrap/js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="../vendor/metisMenu/metisMenu.min.js"></script>

    <!-- Morris Charts JavaScript -->
    <script src="../vendor/raphael/raphael.min.js"></script>
    <script src="../vendor/morrisjs/morris.min.js"></script>
    <script src="../data/morris-data.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="../dist/js/sb-admin-2.js"></script>

</body>

</html>