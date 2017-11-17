<?php
// Database settings
define("HOST", "localhost"); // default:localhost
define("DBUSER", "dbusername");// Database user
define("PASS", "dbpassword"); // Database password
define("DB", "dbname"); // Database name

//Makes the mysql connection
$conn = mysql_connect(HOST, DBUSER, PASS);
if (!$conn)
{
    die('Could not connect !<br />Please contact the site\'s administrator.');
}
$db = mysql_select_db(DB);
if (!$db)
{
    die('Could not connect to database !<br />Please contact the site\'s administrator.');
}
?>
