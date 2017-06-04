#!/usr/local/bin/php
<?php
$database = "ajax.db";

//connect to database
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

$table = "event_table";
$field1 = "name";
$field2 = "event_title";
$field3 = "event_details";
$field4 = "time_stamp";
$field5 = "view_start_time";
$field6 = "view_end_time";
$field7 = "start_minutes";
$field8 = "height";
$field9 = "switch"; // 0 implies it fits in table, 1 implies it does not fit in table

$sql= "CREATE TABLE IF NOT EXISTS $table (
$field1 varchar(100),
$field2 varchar(100),
$field3 varchar(100),
$field4 int(12),
$field5 varchar(10),
$field6 varchar(10),
$field7 int(12),
$field8 float(12),
$field9 int(1)
)";
$result = $db->query($sql);

$lower_bound = $_POST['lower_bound'];
$upper_bound = $_POST['upper_bound'];

$sql = "SELECT * FROM $table WHERE $field4>=$lower_bound AND $field4<=$upper_bound";
$result = $db->query($sql);

$events = "";
while($record = $result->fetchArray())
{
	$events = $events . "$record[$field1],$record[$field2],$record[$field3],$record[$field4],$record[$field5],$record[$field6],$record[$field7],$record[$field8],$record[$field9]" . "-";

}
print "$events";
 ?>
