<?php
if ($_SERVER['REQUEST_METHOD']=='POST'){ // condition will only execute the statements it contains if the form has been submitted
  require('connect_db.php'); // open database connection
  $errors = array(); //initilize an array for error messages
  if (empty($_POST['Name'])) // if name field is empty
    {$errors[] = 'Please, enter your name.';} //store error message 
  else
    {$Name = mysqli_real_escape_string($dbc, trim($_POST['Name']));} // else store its value in a variable
  if (empty($_POST['Surname'])) // if surname field is empty
    {$errors[] = 'Please, enter your surname.';} //store error message
  else
    {$Surname = mysqli_real_escape_string($dbc, trim($_POST['Surname']));}// else store its value in a variable
  if (empty($_POST['Email'])) // if email field is empty
    {$errors[] = 'Please, enter your valid email.';} //store error message
  else
    {$Email= mysqli_real_escape_string($dbc, trim ($_POST['Email']));} // else store its value in a variable
  if (empty($_POST['Login'])) // if login field is empty
    {$errors[] = 'Please, enter your user name.';} //store error message
  else
    {$Login = mysqli_real_escape_string($dbc, trim($_POST['Login']));} // else store its value in a variable
  if (empty($_POST['Password'])) // if password field is empty
    {$errors[] = 'Please, enter your password.';} //store error message
  else
    {$Password = mysqli_real_escape_string($dbc, trim($_POST['Password']));} // else store its value in a variable
    $Status = $_POST['Status'];
    $Subject = $_POST['Subject'];
    $Grade = $_POST['Grade'];
  if (empty($_POST['Telephonenum'])) // if telephone number field is empty
    {$errors[] = 'Please, enter your telephone number.';} //store error message
  else
    {$Telephonenum = mysqli_real_escape_string($dbc, trim($_POST['Telephonenum']));} // else store its value in a variable
  if (empty($errors)){
    $q = "SELECT UserID FROM users WHERE Email='$Email'";
    $r = mysqli_query($dbc,$q);
  if ( mysqli_num_rows($r) !=0) // if the email address is already registered in the ‘users’ database table
    { $errors[] = 'Email address already registered.';} //store error message
}
if (empty($errors)){
  $q = "INSERT INTO users (Name, Surname, Email, Login, Password, Status, Subject, Grade, Telephonenum)
  VALUES ('$Name','$Surname','$Email', '$Login', MD5('$Password'), '$Status', '$Subject', '$Grade', '$Telephonenum')"; // insert and store input data in the ‘users’ database table; MD5 encryption
  if ($dbc->query($q) === TRUE) // if registration succeeds
    {echo "Entered data successfully!";} //message
  else {echo "Error: " . $q . "<br>" . $dbc->error;} // else error message
  mysqli_close($dbc); //close the database connection
  exit(); // exit the script
}
else{
  echo '<h1>Error!</h1>
    <p id="err_msg">The following error(s) occured:<br>'; // error messages when registration cannot be completed
  foreach ($errors as $msg){
    echo" -$msg<br>";
  }
  echo 'Please, try again.</p>';
  mysqli_close($dbc); // close the database connection
  }
}
?>
