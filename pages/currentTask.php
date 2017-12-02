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
                        <!-- ONLY FOR PEOPLE WHO ARE PROJECT MANAGERS --> 
                        <li>
                            <a href="createTask.php"><i class="fa fa-tasks fa-fw"></i> Create a New Task</a>
                        </li>

                        <li>
                            <a href="currentTask.php"><i class="fa fa-bars fa-fw"></i> My Tasks</a>
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-clock-o fa-fw"></i> Timeline</a>
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-search fa-fw"></i> Search</a>
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
                    <h1 class="page-header">My Tasks</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="panel panel-default">
                <div class="panel-body">
                
                <div class = "row">
                    <form class = "col-lg-offset-9 col-lg-3" name="sortby" action="" method="post">
                        <select name="sortoption"> <?php $sort = $_POST['sortoption']; ?>
                           <option value="datecreated" <?php if ($sort == 'datecreated') echo 'selected="selected"'; ?> >Date Created</option>
                           <option value="status" <?php if ($sort == 'status') echo 'selected="selected"'; ?> >Status</option>
                           <option value="priority" <?php if ($sort == 'priority') echo 'selected="selected"'; ?> >Priority</option>
                           <option value="duedate" <?php if ($sort == 'duedate') echo 'selected="selected"'; ?> >Due Date</option>
                        </select>
                        <input type="submit" value="Sort" />
                    </form>
                </div>
                
                    <div class="row">
                        <div class="col-sm-12">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Project Name</th>
                                        <th>Task</th>
                                        <th>Priority</th>
                                        <th>Status</th>
                                        <th>Due Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        $user = $_SESSION['username'];
                                        $connection = mysqli_connect("localhost", "root", "", "cen4020");
                                        $results = mysqli_query($connection, "SELECT taskID, priority, username, status, abbreviation, projectID, dueDate FROM tasks WHERE username='$user'");
                                        if ($sort == 'status'){
                                        $results = mysqli_query($connection, "SELECT taskID, priority, username, status, abbreviation, projectID, dueDate FROM tasks WHERE username='$user'ORDER BY status ASC");
                                        }
                                        if ($sort == 'priority'){
                                            $results = mysqli_query($connection, "SELECT taskID, priority, username, status, abbreviation, projectID, dueDate FROM tasks WHERE username='$user' ORDER BY priority DESC");
                                        }
                                        if ($sort == 'duedate'){
                                            $results = mysqli_query($connection, "SELECT taskID, priority, username, status, abbreviation, projectID, dueDate FROM tasks WHERE username='$user' ORDER BY dueDate ASC");
                                        }
                                        
                                        if(mysqli_num_rows($results) != 0)
                                        {
                                            while($row = mysqli_fetch_row($results))
                                            {
                                                $tid = $row[0];
                                                $priority = $row[1];
                                                $uname = $row[2];
                                                $status = $row[3];
                                                $abb = $row[4];
                                                $pid = $row[5];
                                                $due = $row[6];

                                                $asnameL = mysqli_query($connection,"SELECT first, last FROM users WHERE username = '$uname'");
                                                $asname = mysqli_fetch_row($asnameL);
                                                $fname = $asname[0];
                                                $lname = $asname[1];
                                                
                                                $findprojname = mysqli_query($connection, "SELECT projectName FROM projects WHERE projectID='$pid'");
                                                $res = mysqli_fetch_row($findprojname);
                                                $pname = $res[0];
                                                echo "<tr>";
                                                echo "<td><a href='viewProject.php?var=$pname'>$pname</a></td>";
                                                echo "<td>";
                                                echo "<a href='viewTask.php?var=$tid'>$abb-$tid</a>";
                                                echo "</td>";

                                                echo "<td>";
                                                
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

                                                echo "</td>";
                                                echo "<td>";
                                                if($status == 1)
                                                {
                                                    echo "Not Started";
                                                }
                                                elseif($status == 2)
                                                {
                                                    echo "In progress";
                                                }
                                                else
                                                {
                                                    echo "Completed";
                                                }
                                                echo "</td>";
                                                echo "<td>$due</td>";
                                                echo "</tr>";

                                            }
                                        }
                                        else
                                        {
                                            echo "<tr><td>No Tasks</td>";
                                            echo "<td>N/A</td>";
                                            echo "<td>N/A</td>";
                                            echo "<td>N/A</td></tr>";
                                        }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                     </div>
                </div>
            </div>
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
