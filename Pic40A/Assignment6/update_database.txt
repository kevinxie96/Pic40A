#!/usr/local/bin/php -d display_errors=STDOUT
<?php
  // begin this XHTML page
  print('<?xml version="1.0" encoding="utf-8"?>');
  print("\n");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN"
 "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"
      xmlns:v="urn:schemas-microsoft-com:vml">
<head>
<meta http-equiv="content-type" content="application/xhtml+xml; charset=utf-8" />
<title>PHP Example: Accessing a SQLite 3 Database using PHP</title> 
</head>
<body>
<div>
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


// define tablename and field names for a SQLite3 query to create a table in a database
$table = "event_table";
$field1 = "name";
$field2 = "time_stamp";
$field3 = "event_title";
$field4 = "event_message";

// Create the table
$sql= "CREATE TABLE IF NOT EXISTS $table (
$field1 varchar(100),
$field2 int(12),
$field3 varchar(100),
$field4 varchar(100)
)";
$result = $db->query($sql);

// Write code here to extract the name, SID and GPA from the $_GET data.

$person = $_POST['person'];
$date = $_POST['date'];
$time = $_POST['time'];
$bigdate = explode('-', $date);
$smalldate = explode(':', $time);
$final_date = mktime($smalldate[0],$smalldate[1],0,$bigdate[0],$bigdate[1],$bigdate[2]);
$event_title = $_POST['event_title'];
$event_message = $_POST['event_message'];


//  Insert a new record to your database with name = $name, sid = $SID and gpa = $GPA 
//  Create the $sql string that will accomplish this.
$sql = "INSERT INTO $table ($field1, $field2, $field3, $field4) VALUES ('$person', $final_date, '$event_title', '$event_message')";
$result = $db->query($sql);

echo "<h1>Database succesfully updated</h1>
<p><a href='calendar2.php'>Click here to see the calendar</a></p>";

$sql = "SELECT * FROM $table";
$result = $db->query($sql);

print "<table border='border'>\n";
print "  <tr>\n";
print "     <th>$field1</th>\n";
print "     <th>$field2</th>\n";
print "     <th>$field3</th>\n";
print "     <th>$field4</th>\n";
print "  </tr>\n";

// obtain the results from the SELECT query as an array holding a record
// one iteration per record for this select query
while($record = $result->fetchArray())
{  
  print "  <tr>\n";
  print "     <td>$record[$field1]</td>\n";
  print "     <td>$record[$field2]</td>\n";
  print "     <td>$record[$field3]</td>\n";
  print "     <td>$record[$field4]</td>\n";
  print "  </tr>\n";
}

print "</table>\n";
?>
</div>
</body>
</html>
