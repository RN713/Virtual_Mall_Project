<?php
#$link=mysqli_connect(host:"localhost",user:"root",passwors:"");
$link=mysqli_connect("localhost","root","");
mysqli_select_db($link,"ccc457");
$con=mysqli_connect("localhost","root"," ","ccc457");
if(mysqli_connect_error())
{
    echo "faild to connect to MYSQL : ".mysqli_connect_error();
}
?>
