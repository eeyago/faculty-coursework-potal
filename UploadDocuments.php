<?php 
/*session_start();
//echo $_SESSION["uid"];
if(isset($_SESSION["userid"]))
{
	if($_SESSION["type"]=="admin")
	{
	header("Location: dashboard.php");
	}
	else
	{	
	header("Location: UploadDocuments.php");
	}
} */
?>
<?php
session_start();
include("header.php");
include("conection.php");
include("modal.php");
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
<section id="page">
<header id="pageheader" class="normalheader">
<h2 class="sitedescription">
  </h2>
</header>

<section id="contents">

<article class="post">
  <header class="postheader">
  <h2>Upload Documents</h2>
  <p>&nbsp;</p>
  
<?php include("selectsubs.php"); ?>
  

  <p>&nbsp;</p>
  </header>
  <section class="entry">

  </section>
</article>


</section>


<?php 
if(isset($_SESSION["type"]))
{
if($_SESSION["type"]=="admin")
	{
	include("adminmenu.php");
	}
	else
	{	
	include("lecturemenu.php");
	}

}
	else
	{	
	include("lecturemenu.php");
	}

include("footer.php"); ?>