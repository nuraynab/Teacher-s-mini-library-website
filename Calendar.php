<?php
$date =time () ; // get current date

$day = date('d', $date) ; // put the day in variable
$month = date('m', $date) ; // put the month in variable
$year = date('Y', $date) ; // put the year in variable

$first_day = mktime(0,0,0,$month, 1, $year) ; //determine the first day of the month

$title = date('F', $first_day) ; // get month’s name

$day_of_week = date('D', $first_day) ; //find out what day of the week the first day of the month falls on
switch($day_of_week){ 
case "Mon": $blank = 0; break; 
case "Tue": $blank = 1; break; 
case "Wed": $blank = 2; break; 
case "Thu": $blank = 3; break; 
case "Fri": $blank = 4; break; 
case "Sat": $blank = 5; break; 
case "Sun": $blank = 6; break; }//

$days_in_month = cal_days_in_month(0, $month, $year) ; // determine the number of days in current month

echo "<table border=2 width=294 BGCOLOR=#008000> "; // create table which background colour is green
echo "<tr><th colspan=7 height=35><font color=#FFFFFF size=5>  $title $year </font></th></tr>"; // create row where current month and year are written
echo "<tr><td width=46 height=35><font color=#FFFFFF><strong> Mon </strong></font></td><td width=42 height=35><font color=#FFFFFF><strong>Tue </strong></font></td><td width=42 ><font color=#FFFFFF><strong> Wed </strong></font></td><td width=42><font color=#FFFFFF><strong> Thu </strong></font></td><td width=42><font color=#FFFFFF><strong> Fri </strong></font></td><td width=42><font color=#FFFFFF><strong>Sat </strong></font></td><td width=42><font color=#FFFFFF><strong> Sun </strong></font></td></tr>";  
$day_count = 1; // count the days in the week, up to 7
echo "<tr>"; 
while ( $blank > 0 ) 
{ 	echo "<td></td>"; 
	$blank = $blank-1; 
	$day_count++; }

$day_num = 1; // set the first day of the month to 1
while ( $day_num <= $days_in_month ) // count up the days to the number of days in month 
	{if(date('d') != $day_num)
		{echo "<td height=35><font color=#FFFFFF><strong> $day_num </strong></font></td>";
	 	$day_num++;
      	 	$day_count++;} 
	else {
		echo "<td BGCOLOR=#FFFFFF><font color=#008000><strong>$day_num</strong></font></td>";
	   	$day_num++;
       		$day_count++;
   	}
	if ($day_count > 7) // start a new row every week
		{ echo "</tr><tr>"; $day_count = 1; } 
}
while ( $day_count >1 && $day_count <=7 ) 
	{ echo "<td></td>"; $day_count++; } 
echo "</tr></table>";
?>
