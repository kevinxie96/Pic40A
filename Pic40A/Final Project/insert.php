#!/usr/local/bin/php
<?php

function get_hour_string($timestamp)
{
	return date("g.ia", $timestamp);
}

date_default_timezone_set('America/Los_Angeles');

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

$person = $_POST['person'];
$date = $_POST['date'];
$start_time = $_POST['start_time'];
$end_time = $_POST['end_time'];
$event_title = $_POST['event_title'];
$event_details = $_POST['event_details'];
$lower_bound = $_POST['lower_bound'];
$upper_bound = $_POST['upper_bound'];
$bigdate = explode('-', $date);
$smalldate = explode(':', $start_time);
$smalldate1 = explode(':', $end_time);

$switch = 0;

$final_date_id = mktime(intval($smalldate[0]),0,0,intval($bigdate[0]),intval($bigdate[1]),intval($bigdate[2])); // start time timestamp
if ($final_date_id < $lower_bound || $final_date_id > $upper_bound)
{
	$switch = 3;
}
$final_date_id1 = mktime(intval($smalldate1[0]),0,0,intval($bigdate[0]),intval($bigdate[1]),intval($bigdate[2])); // end time timestamp

$final_date_title = mktime(intval($smalldate[0]),intval($smalldate[1]),0,intval($bigdate[0]),intval($bigdate[1]),intval($bigdate[2])); // start time timestamp for the calendar dialog title
$final_date_title1 = mktime(intval($smalldate1[0]),intval($smalldate1[1]),0,intval($bigdate[0]),intval($bigdate[1]),intval($bigdate[2])); // end time timestamp for the calendar dialog title


$height = ($final_date_title1 - $final_date_title)/3600;
$view_start_time = get_hour_string($final_date_title);// start time for the calendar dialog title
$view_end_time = get_hour_string($final_date_title1);// end time for the calendar dialog title


$sql = "INSERT INTO $table ($field1, $field2, $field3, $field4, $field5, $field6, $field7, $field8, $field9) VALUES ('$person','$event_title','$event_details',$final_date_id,'$view_start_time','$view_end_time', $smalldate[1], $height, $switch)";
$result = $db->query($sql);

print "$person,$event_title,$event_details,$final_date_id,$view_start_time,$view_end_time,$smalldate[1],$height,$switch";
 ?>
