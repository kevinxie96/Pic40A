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

$person = $_POST['person'];
$time_stamp = $_POST['time_stamp'];
$event_title = $_POST['event_title'];
$event_details = $_POST['event_details'];
$height = $_POST['height'];

$sql = "DELETE FROM $table WHERE $field1='$person' AND $field4=$time_stamp AND $field2='$event_title' AND $field3='$event_details' AND $field8=$height";
$result = $db->query($sql);
 ?>
