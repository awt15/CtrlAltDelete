<?php
if (!session_is_registered('loginid') || !session_is_registered('username'))
{
	// user is not logged in.
    if (isset($_POST['cmdlogin']))
    {
        // retrieve the username and password sent from login and create md5-hash
        $u = strip_tags($_POST['username']);
        $p = md5(strip_tags($_POST['password']));
        //Look for the user in the database.
        $query = sprintf("SELECT loginid FROM login WHERE username = '%s' AND password = '%s' LIMIT 1;",
            mysql_real_escape_string($u), mysql_real_escape_string($p));
        $result = mysql_query($query);
        // If the database returns a 0 as result we know the login information is incorrect.
        // If the database returns a 1 as result we know  the login was correct and we proceed.
        // If the database returns a result > 1 there are multple users
        // with the same username and password, so the login will fail.
        if (mysql_num_rows($result) != 1)
        {
            // invalid login information
            echo "Wrong username or password!";
            //show the loginform again.
            include "loginform.php";
        } else {
            // Login was successfull
            $row = mysql_fetch_array($result);
            // Save the user ID for use later
            $_SESSION['loginid'] = $row['loginid'];
              // Save the username for use later
            $_SESSION['username'] = $u;
            show_userbox();
        }
    } else {
    	 // User is not logged in and has not pressed the login button
    	 // so we show him the loginform
        include "login.html";
    }

} else {
	 // The user is already loggedin, so we show the userbox.
    show_userbox();
}
?>
