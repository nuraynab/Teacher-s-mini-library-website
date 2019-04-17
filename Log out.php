<?php
session_start();
if(!isset($_SESSION['UserID']))
{require ('login_tools.php'); load();}
$page_title = 'Goodbye';
$_SESSION = array();
session_destroy();
echo'<h1> Goodbye!</h1>
<p>You are now logged out.</p>
<p><a href="Index1.php">Main page</a></p>'; ?>
