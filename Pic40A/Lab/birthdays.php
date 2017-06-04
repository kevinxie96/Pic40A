#!/usr/local/bin/php

<?php date_default_timezone_set('America/Los_Angeles'); ?>
<?php print '<?xml version="1.0" encoding="utf-8" ?>'; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>My First PHP Embedded Page</title>
</head>
<body>
<p>
<?php
$year1 = 1996;
$ts = mktime(0,0,0,1,8,$year);

echo "<table border=1>";
echo "<tr><th>Dates</th><th>Days of Week</th></tr>";
for($add = 0; $add < 22; $add++)
{
	echo "<tr><td>", date('n/j/Y', $ts), "</td><td>", date('l', $ts), "</td></tr>";
    $year += 1;
	$ts = mktime(0,0,0,1,8,$year);
}
echo "</table><br>";

echo "Just for Fun: Birthdays until 2040";
echo "<table border=1>";
echo "<tr><th>Dates</th><th>Days of Week</th></tr>";
$year1 = 1996;
for($add = 0; $add < 45; $add++)
{
	echo "<tr><td>", date('n/j/Y', $ts), "</td><td>", date('l', $ts), "</td></tr>";
    $year1 += 1;
	$ts = mktime(0,0,0,1,8,$year1);
}
echo "</table>";
?>
</p>
</body>
</html>