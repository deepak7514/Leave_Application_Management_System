<?php
session_start();
require_once('../php/funcs.php');
require_once('../php/db.php');
if(!isset($_SESSION['user']) || !isset($_SESSION['user']['username'])) {
  header('Location: ../index.php');
  die();
}
?>
<html>
  <head>
    <title> Notifications </title>
    <meta charset="utf-8"/>
	<link href="../css/bootstrap.min.css" rel="stylesheet" media="screen">
    <link href="../css/bootstrap-datetimepicker.min.css" rel="stylesheet" media="screen">
  </head>
<body>
  <nav class="navbar navbar-inverse"   style="color:white">
  <h1> <span class="glyphicon glyphicon-send"></span> Welcome to Leave Application System, <?php echo $_SESSION['user']['first_name'] ?>| <small> <a href="php/logout.php" >Logout</a></small></h1>
  </nav> 
  <div class="container">
    <div class="col-md-3">
      <a href="request_leave.php">Request a Leave</a></br>
	  </div>
	  <div class="col-md-3">
      <a href="see_all_leaves.php">My approved Leaves</a></br>
	  </div>
	  <div class="col-md-3">
     <a href="pending_leaves.php">My pending leaves</a></br>
	 </div>
	 <div class="col-md-3">
	 <a href="notifications.php">Notice Board</a></br>
	 </div>
	 <div id="leave-calendar"></div>
</div>
<?php
if(isset($_POST['submit']))
{
$pdfDirectory="content/";
$thumbDirectory="contentimage/";
//get the name of the file
$file_name=$_FILES['content']['name'];
$temp=explode(".",$file_name);
$extension=end($temp);
$extension=strtolower($extension);
//remove all characters from the file name other than letters, numbers, hyphens and underscores
$file_name= preg_replace("/[^A-Za-z0-9_-]/","",$file_name).".".$extension;
$file_size =$_FILES['content']['size'];
$file_tmp =$_FILES['content']['tmp_name'];

if($_FILES["content"]["error"] > 0)
{
	echo "ERROR: ". $_FILES["content"]["error"]."<br>";
}
elseif($file_size<(10*1024*1024))
{
	$newFileName = time()."_".$file_name;
	//name the thumbnail image the same as the pdf file
	$thumb=basename($newFileName,".pdf");
	if(file_exists($pdfDirectory. $newFileName))
	{
		echo $newFileName. " already exists.<br>";
	}
	else
	{
		if(move_uploaded_file($file_tmp, $pdfDirectory.$newFileName))
		{
			echo "Notice - ".$file_name." Successfully Uploaded";
			$pdfWithPath=$pdfDirectory.$newFileName;
			//add the desired extension to the thumbnail
			$thumb=$thumb.".jpg";
			//execute imageMagick's 'convert'
			exec("convert \"{$pdfWithPath}[0]\" $thumbDirectory$thumb");
			//show the image
			echo"<p><a href=\"$pdfWithPath\"><img height=\"300\" width=\"300\" src=\"contentimage/$thumb\" alt=\"\" /></a></p>";
			
			$mysqli = dbConnect();
			$query = 'INSERT INTO `notifications`(`subject`, `content`, `date`, `signature`) VALUES ("'.
			strtolower($mysqli->real_escape_string($_POST['subject'])) .'","'.
			 $newFileName.'","'.
			$_POST['date'].'","'.
			strtolower($mysqli->real_escape_string($_POST['signature'])). '")';
			$result = $mysqli->query($query);
			if($result){
			echo "<h1>Notice Added</h1>";
			} else {
			echo "Something awkward happened. Try again or wait for sometime.";
			}
			
			}
		else
		echo "Error In Uploading Content!";
	}
}

}

echo "<a href=\"notice1.php\">Add Another Notice </a>";

?>

</body>
</html>
