<?php require_once('Connections/connection.php'); ?>
<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}

$filename = "";
	if(isset($_FILES["file"]))
	{
		//$data = explode(".",$_FILES["file"]["name"]);
		//$ext = end($data);
		//echo $ext;
		//$exts = array("jpg","png","jpeg","bmp");
		if($_FILES["file"]["error"] == 0 && $_FILES["file"]["size"] < 2000000)
		{
			/*echo $_FILES["file"]["tmp_name"]."<br>";
			echo $_FILES["file"]["name"]."<br>";
			echo $_FILES["file"]["type"]."<br>";
			echo ($_FILES["file"]["size"]/1024)."<br>";*/
			move_uploaded_file($_FILES["file"]["tmp_name"],"uploads/".$_FILES["file"]["name"]);
			$filename = "uploads/".$_FILES["file"]["name"];
		}
		//echo "File Found";
	}

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO documents (CourseID, Semester, SubID, DocName, DocPath, DocType) VALUES (%s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['course'], "int"),
                       GetSQLValueString($_POST['semsester'], "int"),
                       GetSQLValueString($_POST['subject'], "int"),
                       GetSQLValueString($_POST['docName'], "text"),
                       GetSQLValueString($filename, "text"),
                       GetSQLValueString($_POST['DocType'], "text"));

  mysql_select_db($database_connection, $connection);
  $Result1 = mysql_query($insertSQL, $connection) or die(mysql_error());
}

mysql_select_db($database_connection, $connection);
$query_Recordset1 = "SELECT * FROM documents";
$Recordset1 = mysql_query($query_Recordset1, $connection) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

//session_start();
include("conection.php");

//$query="select city from subject where courseid=$courseid ";
//$result=mysql_query($query);
/*if(isset($_SESSION['coid']))
{
	$query="select city from subject where courseid=$_SESSION[coid]";
	$result=mysql_query($query);
	$result2 = mysql_query("SELECT DISTINCT courseid FROM subject where courseid=$_SESSION[coid]");
}
else
{*/
$result2 = mysql_query("SELECT DISTINCT courseid FROM subject");	
//}
?>
<script>
function getXMLHTTP() { //fuction to return the xml http object
		var xmlhttp=false;	
		try{
			xmlhttp=new XMLHttpRequest();
		}
		catch(e)	{		
			try{			
				xmlhttp= new ActiveXObject("Microsoft.XMLHTTP");
			}
			catch(e){
				try{
				xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
				}
				catch(e1){
					xmlhttp=false;
				}
			}
		}
		 	
		return xmlhttp;
	}
	
	
	
	function getCity(strURL) {		
		
		var req = getXMLHTTP();
		
		if (req) {
			
			req.onreadystatechange = function() {
				if (req.readyState == 4) {
					// only if "OK"
					if (req.status == 200) {						
						document.getElementById('subdiv').innerHTML=req.responseText;						
					} else {
						alert("There was a problem while using XMLHTTP:\n" + req.statusText);
					}
				}				
			}			
			req.open("GET", strURL, true);
			req.send(null);
		}
				
	}
</script>



<form method="POST" action="<?php echo $editFormAction; ?>" name="form1" enctype="multipart/form-data">
<table width="60%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="150"><strong>Course</strong></td>
    <td  width="150"><select name="course" onChange="getCity('findrec.php?course='+this.value)">
	<option value="">Select Course</option>
	<?php
    while($row1 = mysql_fetch_array($result2))
  {
	  $result21 = mysql_query("SELECT * FROM course where courseid=$row1[courseid]");
	echo "<option value='$row1[courseid]'>";
		  while($row11 = mysql_fetch_array($result21))
  {
	  echo $row11["coursekey"];
  }
	 echo "</option>";
  }
    ?>
        </select></td>
  </tr>
  <tr style="">
    <td height="28"><strong>Semester</strong></td>
    <td ><select name="semsester">
	<option>Select Semester</option>
	<option value="1">1st Semester</option>
	<option value="2">2nd Semester</option>
	<option value="3">3rd Semester</option>
	<option value="4">4th Semester</option>
	<option value="5">5th Semester</option>
	<option value="6">6th Semester</option>
      </select></td>
  </tr>
  <tr>
    <td><strong>Subject</strong></td>
    <td><div id="subdiv"><select name="subject">
      <option selected>Select Subject</option>
    </select></div></td>
  </tr>
  <tr style="">
    <td height="28"><strong>Document Name</strong></td>
    <td><input name="docName" type="text" /></td>
  </tr>
  <tr style="">
    <td height="28"><strong>Document</strong></td>
    <td><input name="file" type="file" /></td>
  </tr>
  <tr style="">
    <td height="28"><strong>Document Type</strong></td>
    <td ><select name="DocType">
	<option>Select Type</option>
	<option value="1">Attendance</option>
	<option value="2">Marks</option>
	<option value="3">Syllabus</option>
	<option value="4">Exam Papers</option>
      </select></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><input type="submit" name="UploadDoc" id="button" value="Submit" /></td>
  </tr>
</table>
<input type="hidden" name="MM_insert" value="form1" />
</form>
<?php
mysql_free_result($Recordset1);
?>
