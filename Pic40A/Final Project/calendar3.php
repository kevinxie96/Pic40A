#!/usr/local/bin/php
<?php print '<?xml version="1.0" encoding="utf-8" ?>'; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN"
"http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Assignment 6</title>
<script type="text/javascript" src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
<script type="text/javascript" src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script type="text/javascript" src="calendar3.js"></script>
<link href = "https://code.jquery.com/ui/1.10.4/themes/ui-lightness/jquery-ui.css"
         rel = "stylesheet"/>
<link rel="stylesheet" type="text/css" href="calendar3.css" />
</head>
<body>

<?php
date_default_timezone_set('America/Los_Angeles');


function get_hour_string($timestamp)
{
	return date("g.00a", $timestamp);
}


$timestamp = (isset($_GET['time_stamp']))?$_GET['time_stamp']:time();
$hours_to_show = 12;
echo "<h1>My Family Schedule for " . date("D, F j, Y, g:i a", $timestamp) . " </h1>";
echo "<div class='container'>";
echo "<table id='event_table'>";
echo "	<tr> 
		<th class='hr_td_'> &#160; </th> <th class='table_header'>Kevin Xie</th><th class='table_header'>Yifang Yan</th><th class='table_header'>Jianye Xie</th>
	</tr>\n";

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
	$starting_time = $td_time - ($td_time % 3600);
	$ending_time = $starting_time + 3600;
	$js_date = date("n-j-Y", $starting_time);
	$js_start_time = date("G:00", $starting_time);
	$js_end_time = date("G:00", $ending_time);
	echo "<td class='hr_td'>$row_time</td><td id='Kevin_Xie_$starting_time' onclick='create_event(\"Kevin_Xie\", \"$js_date\", \"$js_start_time\", \"$js_end_time\")'>" . "</td><td id='Yifang_Yan_$starting_time' onclick='create_event(\"Yifang_Yan\", \"$js_date\", \"$js_start_time\", \"$js_end_time\")'>" .  "</td><td id='Jianye_Xie_$starting_time' onclick='create_event(\"Jianye_Xie\", \"$js_date\", \"$js_start_time\", \"$js_end_time\")'>" . "</td></tr>\n";
}

echo "</table>";
$increment = 12*60*60;
$future = $timestamp + $increment;
$before = $timestamp - $increment;
echo"<div>
<form id='prev' method='get' action='calendar3.php'>
	<p>
	<input type='hidden' name='time_stamp' value='$before' />
	<input class='light' type='submit' value='Previous Twelve Hours'/>
	</p>
</form>

<form id='next' method='get' action='calendar3.php'>
	<p>
	<input type='hidden' name='time_stamp' value='$future' />
	<input class='light' type='submit' value='Next Twelve Hours'/>
	</p>
</form>

<form id='today' method='get' action='calendar3.php'>
	<p>
	<input class='light' type='submit' value='Today'/>
	</p>
</form>
</div>";

echo "</div>";
?>

<!--dialog-->
<div class="stylized" id='create_event' title='Scheduling Event'>
</div>
<div id='create_dialog'></div>
</body>
</html>
