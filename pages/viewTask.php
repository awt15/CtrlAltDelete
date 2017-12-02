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
                        <li><a href="#"><i class="fa fa-gear fa-fw"></i> Settings</a>
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
                        <!-- ONLY FOR PEOPLE WHO ARE PROJECT MANAGERS --> 
                        <li>
                            <a href="createTask.php"><i class="fa fa-tasks fa-fw"></i> Create a New Task</a>
                        </li>
                        <li>
                            <a href="currentTask.php"><i class="fa fa-bars fa-fw"></i> Current Tasks</a>
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
                    <?php
                    $tid = $_GET['var'];
                    $connection = mysqli_connect("localhost", "root", "", "cen4020");
                    $namelist = mysqli_query($connection, "SELECT title, projectID, abbreviation, priority, dueDate, username, taskDescription FROM tasks WHERE taskID = '$tid'");
                    $nameL = mysqli_fetch_row($namelist);
                    $title = $nameL[0];
                    $pid = $nameL[1];
                    $abb = $nameL[2];
                    $priority = $nameL[3];
                    $due = $nameL[4];
                    $uname = $nameL[5];

                    $asnameL = mysqli_query($connection,"SELECT first, last FROM users WHERE username = '$uname'");
                    $asname = mysqli_fetch_row($asnameL);
                    $fname = $asname[0];
                    $lname = $asname[1];

                    $descript = $nameL[6];
                    $projectlist = mysqli_query($connection, "SELECT projectName FROM projects WHERE projectID = '$pid'");
                    $projectL = mysqli_fetch_row($projectlist);
                    $project = $projectL[0];
                    $formatted_project = urlencode($project);

                    $taskstatus = mysqli_query($connection, "SELECT status FROM tasks WHERE taskID = '$tid'");
                    $taskrow = mysqli_fetch_row($taskstatus);
                    $status = $taskrow[0];

                    echo "<h1 class='page-header'>";
                    echo "<a href=viewProject.php?var=$formatted_project>$project</a>/";
                    echo "$abb-$tid: $title</h1>";

                    ?>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-4">
                    <label for="priority">Priority:</label>
                    <?php
                    echo "<div>";
                    if($priority == 1)
                    {
                        echo "<i class='fa fa-angle-up fa-fw'></i>";
                    }
                    elseif ($priority == 2)
                    {
                        echo "<i class='fa fa-angle-double-up fa-fw'></i>";
                    }
                    else
                    {
                        echo "<i class='fa fa-arrow-up fa-fw'></i>";
                    }
                    echo "</div>";
                    ?>
                </div>
                <div class="col-sm-4">
                    <label for="dueDate">Due Date:</label>
                    <div><?php echo "$due"?></div>
                </div>
                <div class="col-sm-4">
                    <label for="assignee">Assignee:</label>
                    <div><?php echo "$fname $lname"?></div>
                </div>
            </div>
            </br>
            <div class="row">
                <div class="col-sm-12">
                    <label for="description">Task Description:</label>
                    <div><?php echo "$descript" ?></div>
                </div>
            </div>
            </br>
            <div class="row">
                <div class="col-sm-offset-9 col-sm-2">
                    <?php
                        if ($uname == $_SESSION['username'])
                        {
                            if ($status == 1){
                                echo "<a href='changeStatus.php?stat=1&var=$tid' onclick=changeColor class='btn btn-success btn-block'>Start Task</a>";
                            }
                            else if ($status == 2){
                                echo "<a href='changeStatus.php?stat=2&var=$tid' class='btn btn-danger btn-block'>Complete Task</a>";
                            }
                            else if ($status == 3){
                                echo "<button class='btn btn-basic btn-block disabled'>Completed</button>";
                            }
                        }
                    ?>
                    
                </div>
            </div>
            <div class="row">
                <?php
                    echo"
                    <form action = 'comment.php?var=$tid' method = 'post' style='font-size: 120%;''>
                        <div class='form-group'>
                            <label for='comment'>Comment:</label>
                            <textarea class='form-control' rows='5' id='comment' name='comment' required='required'></textarea>
                        </div>
                        <div class='col-sm-offset-9 col-sm-2'>
                            <button class='btn btn-primary btn-block' type = 'submit'>Comment</button>
                        </div>
                    </form>";
                ?>
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
