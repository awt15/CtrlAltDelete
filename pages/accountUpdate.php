<?php
    session_start();
    if (isset($_POST['firstName']) ||  isset($_POST['lastName']) || isset($_POST['emailAddress']) || isset($_POST['currentPassword']) || isset($_POST['newPassword']) || isset($_POST['confirmnewPassword']))
    {
        $var1 = $_POST['firstName'];
        $var2 = $_POST['lastName'];
        $var3 = $_POST['emailAddress'];

        $var4 = $_POST['currentPassword'];
        $var5 = $_POST['newPassword'];
        $var6 = $_POST['confirmnewPassword'];

        $connection = mysqli_connect("localhost", "root", "", "cen4020");

        $usernameCopy = $_SESSION['username'];
        $passhashCopy = $_SESSION['passhash'];
        if ($connection == false)
        {
            echo "Connection Failed!";
            die();
        }
            
        if ($var1 == null)
        {
            
        }
        else
        {
            $test1 = mysqli_query($connection, "UPDATE users SET first='$var1' WHERE username='$usernameCopy'");
            $_SESSION['first'] = $var1;
            
        }

        if ($var2 == null)
        {
            
        }
        else
        {
            $test2 = mysqli_query($connection, "UPDATE users SET last='$var2' WHERE username='$usernameCopy'");
            $_SESSION['last'] = $var2;
        }

        if ($var3 == null)
        {

        }
        else
        {
            $test3 = mysqli_query($connection, "UPDATE users SET email='$var3' WHERE username='$usernameCopy'");
            $_SESSION['email'] = $var3;
        }
        if ($var4 != null)
        {
            if (md5($var4) == $passhashCopy) 
            {
                if (md5($var5) == md5($var6))
                {
                    $newPassHash = md5($var5);
                    $test3 = mysqli_query($connection, "UPDATE users SET passhash='$newPassHash' WHERE username='$usernameCopy'");
                    $_SESSION['passhash'] = $newPassHash;

                    header("refresh:3, url=account.php");
                    //echo "<script type='text/javascript'>alert('Password successfully updated.')</script>";
                    echo "Password successfully updated, redirecting back to account page.";
                    exit;

                }
                else
                {
                    header("refresh:3; url=updateAccount.php");
                    //echo "<script type='text/javascript'>alert('Error: New password entered don't match.')</script>";
                    echo "Error: New password entered doesn't match, redirecting back to edit account page.";
                    exit;
                }
            }
            else
            {
                header("refresh:3; url=updateAccount.php");
                //echo "<script type='text/javascript'>alert('Error: User entered in wrong password.')</script>";
                echo "Error: User entered in wrong current password, redirecting back to edit account page.";
                exit;
            }
        }
        mysqli_close($connection);
        header("Location: account.php");
        exit;

    }
?>