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
        <?php
                    $pname = $_GET['title'];
                    echo "<h1 class='page-header'>$pname</h1>";
                echo "</div>";
            echo "</div>";
            echo "<form style='font-size:120%;'>";
                $abb = strtoupper(substr($pname, 0, 3));
                $user = $_SESSION['username'];
                $connection = mysqli_connect("localhost", "root", "", "cen4020");
                
                $results = mysqli_query($connection, "SELECT projectID FROM projects WHERE projectName='$pname'");
                while($rows = mysqli_fetch_row($results))
                {
                    $testpid = $rows[0];
                    $userinproj = mysqli_query($connection, "SELECT permissions FROM belongto WHERE username='$user' AND projectID=$testpid");
                    if(mysqli_num_rows($userinproj) != 0)
                    {
                        $pid = $testpid;
                        $permrow = mysqli_fetch_row($userinproj);
                        $perm = $permrow[0];
                    }
                }
                
                echo "<div class='form-group'>";
                echo "<label for='projectName'>Project Name:</label>";
                echo "<a href='viewProject.php?var=$pname'>$pname</a>";
                echo "</div>";
                echo "<div class='form-group'>";
                    echo "<label for='projectID'>Project ID: </label>";
                    echo "$pid";
                echo "</div>";
                echo "<div class='form-group'>";
                    echo "<label for='abbreviation'>Project Abbreviation:</label>";
                    echo "$abb";
                echo "</div>";
                ?>
            </form>
            <div class="row">
            <?php                    
                
                //Only show these buttons if the user is admin of project
                 if ($perm != 0)
                 {
                    echo "<div class='col-sm-offset-6 col-sm-2'>";
                        echo "<a class='btn btn-lg btn-danger btn-block' type = 'submit' href='changeproject.php?pid=$pid'>Delete Project</a>";
                    echo "</div>";
                    echo "<div class='col-sm-2'>";
                        echo "<a class='btn btn-lg btn-primary btn-block' type = 'submit' href='viewProject.php'>Save</a>";
                    echo "</div>";
                        echo "<div class='col-sm-2'>";
                        echo "<a class='btn btn-lg btn-default btn-block' type = 'submit' href='viewProject.php?var=$pname'>Cancel</a>";
                    echo "</div>";
                 }
                 else
                 {
                     echo "<div class='col-sm-offset-8 col-sm-2'>";
                     echo "<a class='btn btn-lg btn-default btn-block' type = 'submit' href='viewProject.php?var=$pname'>Cancel</a>";
                 }
            ?>
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
