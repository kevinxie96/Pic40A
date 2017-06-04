#!/usr/local/bin/php
<?php print '<?xml version="1.0" encoding="utf-8" ?>'; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN"
"http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Assignment 6</title>
<link rel="stylesheet" type="text/css" href="calendar.css" />
</head>
<body>
<?php
date_default_timezone_set('America/Los_Angeles');

$database = "dbkevinxie96.db";          

try  
{     
     $db = new SQLite3($database);
}
catch (Exception $exception)
{
    echo '<p>There was an error connecting to the database!</p>';

    if ($db)
    {
        echo $exception->getMessage();
    }
        
}


function get_hour_string($timestamp)
{
	return date("g.00a", $timestamp);
}


function get_events($person, $timestamp)
{
	global $db;
	$table = "event_table";
	$field1 = "name";
	$field2 = "time_stamp";
	$field3 = "event_title";
	$field4 = "event_message";
	$future = $timestamp + 3600;
	$result = $db->query("SELECT $field3, $field4 FROM $table WHERE $field1='$person' AND $field2>=$timestamp AND $field2< $future");
	$my_array = array();
	while($record = $result->fetchArray())
	{
		$insert = "$record[$field3]: $record[$field4]<br/>";
		array_push($my_array, $insert);
	}
	return implode("", $my_array);
}

$timestamp = (isset($_GET['time_stamp']))?$_GET['time_stamp']:time();
$hours_to_show = 12;

echo "<div class='container'>";
echo "<h1>My Family Schedule for " . date("D, F j, Y, g:i a", $timestamp) . " </h1>";
echo "<table id='event_table'>";
echo "	<tr> 
		<th class='hr_td_'> &#160; </th> <th class='table_header'>Kevin Xie</th><th class='table_header'>Yifang Yan</th><th class='table_header'>Jianye Xie</th>
	</tr>";

for($i = 0; $i <= $hours_to_show; $i++)
{
	if ($i % 2 == 0)
	{
		echo "<tr class='even_row'>";
	}
	else 
	{
		echo "<tr class='odd_row'>";
	}
	$td_time = $timestamp + $i*60*60;
	$row_time = get_hour_string($td_time);
	$finding_time = $td_time - ($td_time % 3600);
	echo "<td class='hr_td'>$row_time</td><td>" . get_events('Kevin Xie', $finding_time) . "</td><td>" . get_events('Yifang Yan', $finding_time) .  "</td><td>" . get_events('Jianye Xie', $finding_time) . "</td></tr>";
}

echo "</table>";
$increment = 12*60*60;
$future = $timestamp + $increment;
$before = $timestamp - $increment;
echo"<div>
<form id='prev' method='get' action='calendar2.php'>
	<p>
	<input type='hidden' name='time_stamp' value='$before' />
	<input type='submit' value='Previous Twelve Hours'/>
	</p>
</form>

<form id='next' method='get' action='calendar2.php'>
	<p>
	<input type='hidden' name='time_stamp' value='$future' />
	<input type='submit' value='Next Twelve Hours'/>
	</p>
</form>

<form id='today' method='get' action='calendar2.php'>
	<p>
	<input type='submit' value='Today'/>
	</p>
</form>
</div>";

echo "</div>";
?>
</body>
</html>