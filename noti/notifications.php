<?php
session_start();
require_once('../php/funcs.php');
require_once('../php/db.php');
if(!isset($_SESSION['user']) || !isset($_SESSION['user']['username'])) {
  header('Location: ../index.php');
  die();
}
if(!isLoggedIn()) {
  header('Location: ../dashboard.php');
  die();
}
if($_SESSION['user']['is_admin']) {
	header("Location: ../dashboard_admin.php");
}
?>
<!doctype html>
<html> 
  <head>
    <meta charset="utf-8" />
    <title>Notifications</title>
    <link rel="stylesheet" href="../css/bootstrap.min.css"/>
    <link rel='stylesheet' href='../css/fullcalendar.min.css' />
    <link rel='stylesheet' href='css/notify.css' />
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
  <div class="container">
    <form action="notifications_result.php" class="form-horizontal"  role="form" method="GET">
		<div class="controls" style="display: inline ! important; padding-left: 1%;">
		<p>Enter Notice ID</p>
		<input type='text' id="textinput" style="width:20%; height:20px;overflow:auto" name="textinput" placeholder="Placeholder" class="input-medium"rows="1">
		</div>
		<br><br>
	    <div class="control-group text-center" >
		<div class="controls text-center" style="display: inline ! important; padding-left: 0%;">
			<input id="button" name="Submit" value="Submit" class="input-xxlarge" type="submit" style="padding-left: 1%;  width: 13.5%;">
		</div>
	    </div>
		</form>
		</div>
		<?php
        $sql = 'SELECT * FROM notifications';
		$mysqli = dbConnect();
		$result = $mysqli->query($sql);
        if ($result->num_rows)
        {
			echo "<br>";
            echo "<b>"."List of notices:"."</b>";
			echo "<br><br><div id=\"gallery\">";

			$row = mysqli_fetch_row($result);
			while ($row)
			{
				echo "<div class=\"imgwrap image-wrap\" style=\"float:left\">";
				$pdfWithPath="content/".$row[2];
				echo "<a href=\"$pdfWithPath\"><p class=\"imgdesc\">Notice_Id: ".$row[0]." Subject: ".$row[1]." Date_Issued: ".$row[3]." Signature :".$row[4]."</p></a>";
				$thumb=basename($row[2],".pdf").".jpg";
				echo"<div class=\"image\"><a href=\"$pdfWithPath\"><img height=\"300\" width=\"300\" src=\"contentimage/$thumb\" alt=\"\" /></a></div>";
				echo "</div>";
				$row = mysqli_fetch_row($result);
			}
			echo "</div>";
        }
		else
		{
			echo "<script>
			alert('There are no Notices!');
			window.location.href='dashboard.php';
			</script>";
		}
	?>
</body>
</html>
