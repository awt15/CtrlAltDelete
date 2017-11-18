<?php
    if (isset($_POST['firstName']) &&  isset($_POST['lastName']) && isset($_POST['email']) &&  isset($_POST['username']) && isset($_POST['password1']) &&  isset($_POST['password2']))
    {
        $first = $_POST['firstName'];
        $last = $_POST['lastName'];
        $email = $_POST['email'];
        $username = $_POST['username'];
        $pass1 = $_POST['password1'];
        $pass2 = $_POST['password2'];
        
        if ($pass1 == $pass2)
        {
            $connection = mysqli_connect("localhost", "root", "", "cen4020");
            if ($connection == false)
            {
                echo "Connection Failed!";
                die();
            }
            
            $results = mysqli_query($connection, "SELECT username, email FROM users WHERE username='$username' OR email='$email'");
            if (mysqli_num_rows($results) == 0)
            {
                $pass1 = md5($pass1);
                $success = mysqli_query($connection, "INSERT INTO users (username, first, last, email, passhash) VALUES ('$username', '$first', '$last', '$email', '$pass1')");
                
                #Account ADDED!!!
                if ($success)
                {
                    mysqli_close($connection);
                    header("Location: login.php");
                    exit;
                }
            }
            
            #username or email already in  use
            else
            {
                mysqli_close($connection);
                header("Location: createaccount.php");
                exit;
            }
        }
        
        #else return to creation page
        header("Location: createaccount.php");
        exit;
        
    }
?>