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
                        <li><a href="logout.php"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
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
                    <h1 class="page-header">Welcome, <?php echo $_SESSION['first']; ?></h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-6">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <i class="fa fa-clock-o fa-fw"></i> Responsive Timeline
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <ul>
                                        <!-- MAKE IT POSSIBLE TO CLICK ON PEOPLES NAME -->
                                        <?php
                                            $counter = 0;
                                            $user = $_SESSION['username'];
                                            $connection = mysqli_connect("localhost", "root", "", "cen4020");
                                            $findProjects = mysqli_query($connection, "SELECT projectID FROM belongto WHERE username='$user'");
                                            $numrows = mysqli_num_rows($findProjects);
                                            $i = 0;
                                            while ($row = mysqli_fetch_row($findProjects))
                                            {
                                                if ($i == 0)
                                                {
                                                    $statement = $row[0];
                                                }
                                                
                                                else
                                                {
                                                    $statement .= " OR projectID=$row[0]"; 
                                                }
                                                
                                                $i = $i + 1;
                                            }
                                            $results = mysqli_query($connection, "SELECT * FROM changes WHERE projectID=$statement ORDER BY timestamp DESC");
                                            if (mysqli_num_rows($results) != 0)
                                            {
                                                while($row = mysqli_fetch_row($results))
                                                {
                                                    $cid = $row[0];

                                                    $findUser = mysqli_query($connection, "SELECT username FROM changes WHERE changeID='$cid'");
                                                    $userRow = mysqli_fetch_row($findUser);
                                                    $user = $userRow[0];

                                                    $findTask = mysqli_query($connection, "SELECT taskID FROM changes WHERE changeID='$cid'");
                                                    $taskRow = mysqli_fetch_row($findTask);
                                                    $task = $taskRow[0];

                                                    $findAbr = mysqli_query($connection, "SELECT abbreviation FROM tasks WHERE taskID='$task'");
                                                    $abrRow = mysqli_fetch_row($findAbr);
                                                    $abr = $abrRow[0];

                                                    $changeType= mysqli_query($connection, "SELECT changeType FROM changes WHERE changeID='$cid'");
                                                    $typeRow = mysqli_fetch_row($changeType);
                                                    $type = $typeRow[0];

                                                    $findDate= mysqli_query($connection, "SELECT timestamp FROM changes WHERE changeID='$cid'");
                                                    $dateRow = mysqli_fetch_row($findDate);
                                                    $date = $dateRow[0];

                                                    $findLeaderName= mysqli_query($connection, "SELECT first, last FROM users WHERE username='$user'");
                                                    $leaderRow = mysqli_fetch_row($findLeaderName);
                                                    $leaderFirst = $leaderRow[0];
                                                    $leaderLast = $leaderRow[1];

                                                    $counter += 1;

                                                    echo "<div class='panel panel-default'>";
                                                    echo "<div class='panel-body'>";

                                                    if ($type == 1){
                                                        echo "<strong><a href='account.php?user=$user'>$leaderFirst $leaderLast</a> commented on </strong>";
                                                        echo "<a href=viewTask.php?var=$task>$abr-$task</a>";
                                                    }

                                                    else if ($type == 2){
                                                        echo "<strong><a href='account.php?user=$user'>$leaderFirst $leaderLast</a> created a task </strong>";
                                                        echo "<a href=viewTask.php?var=$task>$abr-$task</a>";
                                                    }

                                                    else if ($type == 3){
                                                        echo "<strong><a href='account.php?user=$user'>$leaderFirst $leaderLast</a> started working on </strong>";
                                                        echo "<a href=viewTask.php?var=$task>$abr-$task</a>";
                                                    }

                                                    else if ($type == 4){
                                                        echo "<strong><a href='account.php?user=$user'>$leaderFirst $leaderLast</a> completed </strong>";
                                                        echo "<a href=viewTask.php?var=$task>$abr-$task</a>";
                                                    }

                                                    $phpdate = strtotime($date);
                                                    $newtime = date('g:iA', $phpdate);
                                                    $newdate = date('l, F d', $phpdate);
                                                    echo "<br>";
                                                    echo "<font size='2'>$newtime • $newdate</font>";
                                                    echo "</div>";
                                                    echo "<div class='row'>";
                                                    echo "<div class='col-sm-offset-8 col-sm-2'>";
                                                    echo "</div>";
                                                    echo "</div>";
                                                    echo "</div>";
                                                    if ($counter == 5){
                                                        break;
                                                    }
                                                }
                                            }
                                         ?>

                            </ul>
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <div class="col-lg-6">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-bell fa-fw"></i> Assigned Tasks
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="list-group">
                                <ul class="list-group-item">
                                    <i class="fa fa-arrow-up fa-fw"></i> <strong> High Priority Task </strong>
                                    </span>
                                        <?php
                                            $connection = mysqli_connect("localhost", "root", "", "cen4020");
                                            $results = mysqli_query($connection, "SELECT * FROM tasks WHERE username='$_SESSION[username]' AND priority=3 AND status <> 3 ORDER BY dueDate");
                                            while($row = mysqli_fetch_row($results))
                                            {
                                                echo "<a href='viewTask.php?var=$row[0]' class='list-group-item'> $row[8]-$row[0] $row[7]</a>";
                                            }    
                                        ?>
                                </ul>
                                <ul class="list-group-item">
                                    <i class="fa fa-angle-double-up fa-fw"></i> <strong> Medium Priority Task </strong>
                                    </span>
                                        <?php
                                            $connection = mysqli_connect("localhost", "root", "", "cen4020");
                                            $results = mysqli_query($connection, "SELECT * FROM tasks WHERE username='$_SESSION[username]' AND priority=2 AND status <> 3 ORDER BY dueDate");
                                            while($row = mysqli_fetch_row($results))
                                            {
                                                echo "<a href='viewTask.php?var=$row[0]' class='list-group-item'> $row[8]-$row[0] $row[7]</a>";
                                            }    
                                        ?>
                                </ul>
                                <ul class="list-group-item">
                                    <i class="fa fa-angle-up fa-fw"></i> <strong> Low Priority Task </strong>
                                    </span>
                                    <?php
                                            $connection = mysqli_connect("localhost", "root", "", "cen4020");
                                            $results = mysqli_query($connection, "SELECT * FROM tasks WHERE username='$_SESSION[username]' AND priority=1 AND status <> 3 ORDER BY dueDate");
                                            while($row = mysqli_fetch_row($results))
                                            {
                                                echo "<a href='viewTask.php?var=$row[0]' class='list-group-item'> $row[8]-$row[0] $row[7]</a>";
                                            }    
                                        ?>
                                </ul>
                            </div>
                        </div>
                        <!-- /.panel-body -->
                    </div>
                </div>
                <!-- /.col-lg-6 -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /#page-wrapper -->

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
