<?php
$page_title = 'Login';
if (isset ($errors) && !empty($errors)) // condition test that will display any error messages if they exist 
{
	echo '<p id="err_msg">Oops! There was a problem:<br>';
	foreach ($errors as $msg)
	{
		echo "- $msg<br>";
	}
	echo 'Please try again or
		<a href="Index2.php">Register</a></p>'; // provide hyperlink back to the registration page when the login attempt fails
	}
?>
The second file is login_tools.php. The main property of its code is to validate login attempts and load a new page when it is needed.
<?php 
function load($page='Index.php')  
	{
	$url = 'http://'.$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF']); // build a URL string of protocol, current domain and directory
	$url = rtrim($url,'/\\'); //removing any trailing slashes from the URL string 
	$url .='/'. $page; // add a forward slash 
	header("Location:$url"); 
	exit();
	}
	function validate($dbc, $username='' ,$pwd='' ) 
	{
		$errors = array(); // initialize an array for error messages
	
	if (empty($username)) // if user name field is empty
	{$errors[] ='Enter your user name address.';} // store error message
	else
	{$e = mysqli_real_escape_string($dbc, trim($username));} // store its value in a variable
	if (empty($pwd)) // if password field is empty
	{$errors[]='Enter your password.';} // store error message
	else
		{$p = mysqli_real_escape_string($dbc, trim($pwd));} // store its value in a variable
	if (empty($errors)) 
	{           
		$q= "SELECT UserID, Name, Surname
		FROM users
		WHERE Login='$e'
		AND Password = MD5('$p')";	
	$r = mysqli_query($dbc, $q);
	if(mysqli_num_rows($r)==1)
	{
		$row = mysqli_fetch_array ($r, MYSQLI_ASSOC);
		return array (true, $row);	//return the UserID, Name and Surname to the user, if the login attempt succeeds	
	} 
	else
		{$errors[] = 'Email address and password not found.';} // store error message, if the username and password are not found in the database table
	}
	return array(false,$errors);} ?> // return the list of error messages to the user if the login attempt fails
The third file is login_action.php which has the code to create session for the user to log in. When a login attempt succeeds, the script set user details from the database as session data. 
<?php
session_start();
if ($_SERVER['REQUEST_METHOD']== 'POST')
	{
		require ('connect_db.php'); // open the database connection
		require ('login_tools.php'); // make login tools available	
	list ($check, $data) =
		validate($dbc, $_POST['Login'], $_POST['Password']); // get the associated user details of UserID, Name and Surname
	if ($check)
	{
		session_start();
		
		$_SESSION[ 'UserID'] = $data[ 'UserID']; //set UserID as session data
		$_SESSION[ 'Name'] = $data[ 'Name']; //set Name as session data
		$_SESSION[ 'Surname'] = $data[ 'Surname']; //set Surname as session data 		
		load ( 'Index4.php'); // load user’s home page
	}
		else {$errors = $data;}// store  error message
		mysqli_close($dbc); // close data base connection
		include ('Index3.php');	?>	
The fourth file that is used in login process is user’s home page. 
	<?php 
session_start();
	if(!isset($_SESSION['UserID']))
		{
			require('login_action.php'); // redirect the browser to the login page if the user is not already logged in
		}
	echo" 
	{$_SESSION['Name']} {$_SESSION['Surname']} // the name and the surname of the logged in user
	</h2></p>";
	
	echo'<p>
	<a href="goodbye.php"><h3>Logout</h3></a> // hyperlink to log out page
	</p>';?>
<?php
	echo" 
	<p <font color=#003300><h2> You are now logged in,
	{$_SESSION['Name']} {$_SESSION['Surname']}! // confirm the named user is logged in
	</h2></font></p>";?>
//The last file goodbye.php is for user’s logging out. This destroys all session data so the user cannot access to the home page without logging in again.
	<?php
session_start();
if(!isset($_SESSION['UserID']))
{require ('login_tools.php'); load();}//redirect the browser to the login page if the user is not already logged in
$page_title = 'Goodbye';
$_SESSION = array(); // clear existing session variables
session_destroy(); // end the session
echo'<h1> Goodbye!</h1>
<p>You are now logged out.</p>
<p><a href="Index1.php">Main page</a></p>'; ?> // hyper link to the main page
