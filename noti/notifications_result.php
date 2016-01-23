<?php
session_start();
require_once('../php/funcs.php');
require_once('../php/db.php');
if(!isset($_SESSION['user']) || !isset($_SESSION['user']['username'])) {
  header('Location: ../index.php');
  die();
}
?>
<!doctype html>
<html>
  <head>
    <title> Dashboard </title>
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
    $sql = 'SELECT * FROM notifications';
		$mysqli = dbConnect();
	$result = $mysqli->query($sql);
	 if(isset($_GET['textinput']) && is_numeric($_GET['textinput'])) {
     // get the image from the db
	  $sql = 'SELECT * FROM notifications where id='.$_GET['textinput'].'';
		$mysqli = dbConnect();
	$result = $mysqli->query($sql);
        if ($result->num_rows) {
		$row = mysqli_fetch_row($result);
		echo "Notice_Id: ".$row[0]."<br>Subject: ".$row[1]."<br>Date_Issued: ".$row[3]."<br>Signature :".$row[4]."<br>";
		$pdfWithPath="content/".$row[2];
		$thumb=basename($row[2],".pdf").".jpg";
		echo"<p><a href=\"$pdfWithPath\"><img height=\"300\" width=\"300\" src=\"contentimage/$thumb\" alt=\"\" /></a></p>";
	 }	
	 else
	 {
		echo "<script>
		alert('Invalid Notice ID');
		window.location.href='notifications.php';
		</script>";
	 }
 }
 else {
     echo 'Please use a real id number';
 }
	?>
  </body>
</html>
