#!/usr/local/bin/php -d display_errors=STDOUT
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
    
$table = "votes";
$field1 = "yes";
$field2 = "no";

//create table if not exists    
$sql= "CREATE TABLE IF NOT EXISTS $table (
$field1 int(9),
$field2 int(9)
)";
$result = $db->query($sql);

//get everything from $table
$sql = "SELECT * FROM $table";
//store in $result
$result = $db->query($sql);

//convert $result to an array $record
$record = $result->fetchArray();
//this array $record now has 2 entries
$yes = $record[$field1];
$no = $record[$field2];

//this variable is from vote.html
$yes_no = $_GET['vote'];

//update $table, $yes and $no depending on $yes_no
if ($yes_no == "yes")
{
	$yes++;
}
else if ($yes_no == "no")
{
	$no++;
}

$sql = "UPDATE $table SET $field1=$yes, $field2=$no";
$result = $db->query($sql);

print "$yes,$no";
 ?>