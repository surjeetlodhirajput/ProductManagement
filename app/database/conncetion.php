<?php
$host="localhost";
$user="root";
$password="";
$db_name="product";
$conn=new MYSQLi($host,$user,$password,$db_name);
if($conn->connect_error)
{
die("database connection failure".$conn->connection_status);
}

?>