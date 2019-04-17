<?php
	require('connect_db.php'); // open connection to the database
$date =time () ; // get current date
$day = date('d', $date) ; // put the day in variable
$month = date('m', $date) ; // put the month in variable
$year = date('Y', $date) ;  // put the year in variable
$to = mysql_query("SELECT Email FROM loans WHERE Date_of_returning ='$date'"); // query to the ‘loans’ table
if (mysqli_num_rows($to) > 0) 
{
			while( $myrow = mysqli_fetch_assoc($to)) 
				{
					echo $myrow["Email"];
					$message="Hello! Please, return a book to the mini library (Room 311). Thank you!"; //the text of the message
$from="vpodust@mail.ru"; // the email of the     sender 
$subject="The online mini library"; // the subject of the message			
$headers="From:< vpodust@mail.ru>”; //the header of the message
					mail($myrow["Email"], $subject, $message, $headers); // send emails directly from a script
				}
}
?>
