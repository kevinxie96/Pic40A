#!/usr/local/bin/php
<?php print '<?xml version="1.0" encoding="utf-8" ?>'; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN"
"http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Assignment 5</title>
<link rel="stylesheet" type="text/css" href="calendar.css" />
</head>
<body>
<?php
date_default_timezone_set('America/Los_Angeles');
$hours_to_show = 12;
function get_hour_string($timestamp)
{
	return date("g.00a", $timestamp);
}

echo "<div class='container'>";
echo "<h1>My Family Schedule for " . date("D, F j, Y, g:i a", time()) . " </h1>";
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
	$row_time = get_hour_string(time() + $i*60*60);
	echo "<td class='hr_td'>$row_time</td> <td> </td> <td> </td> <td></td></tr>";
}

echo "</table>";

echo "</div>";
?>
</body>
</html>