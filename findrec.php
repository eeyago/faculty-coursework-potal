
<?php
$course=$_GET['course'];
$link = mysql_connect('localhost', 'root', '12345'); //changet the configuration in required
if (!$link) {
    die('Could not connect: ' . mysql_error());
}
mysql_select_db('studentinfo');
$query="select subid,subname from subject where courseid=$course";
$result=mysql_query($query);

?>
<select name="subject">
<option>Select Subject</option>
<?php while($row=mysql_fetch_array($result)) { ?>
<option value='<?php echo $row['subid']; ?>'><?php echo $row['subname']; ?></option>
<?php } ?>
</select>
