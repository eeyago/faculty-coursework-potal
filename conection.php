<?php
$con = mysql_connect("localhost","root","12345");
if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  }

mysql_select_db("studentinfo", $con);
?>
