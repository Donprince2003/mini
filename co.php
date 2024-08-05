<?php
$host = "localhost";
$user = "don";
$password = "don";
$dbname = "mini";

$co= new mysqli($host, $user, $password, $dbname);

if ($co) 
{
    echo"hai";
}
?>