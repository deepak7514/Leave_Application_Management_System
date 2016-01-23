<?php
session_start();
require_once('php/funcs.php');
require_once('php/db.php');
if(!isset($_SESSION['user']) || !isset($_SESSION['user']['username'])) {
  header('Location: index.php');
  die();
}
?>
<!doctype html>
<html> 
  <head>
    <meta charset="utf-8" />
    <title>Dashboard</title>
	<link rel="stylesheet" href="css/divisions.css"/>
    <link rel="stylesheet" href="css/bootstrap.min.css"/>
	<link rel='stylesheet' href='css/fullcalendar.min.css' />
    <link rel='stylesheet' href='css/notify.css' />
  </head>
  <body>
<?php
    $mysqli = dbConnect();
    $sql = "SELECT Notification_number FROM person where person_id =".$_SESSION['user']['person_id'];
    $result = $mysqli->query($sql);
    $row = $result->fetch_assoc();
    $tempnum=$row["Notification_number"];
    ?>

<nav class="navbar navbar-inverse"   style="color:white">
    <h1> <span class="glyphicon glyphicon-send"></span> Welcome to Leave Application System, <?php echo $_SESSION['user']['first_name'] ?><a style="color: rgb(0, 0, 0) ! important; padding-left: 117px;" href="dashboard.php?seen=<?php echo md5(1);?>"><span class="glyphicon glyphicon-bell"><span class="badge"><?php echo $tempnum; ?></span></span></a> <small style="padding-left: 117px; font-size: 34px;"> <a href="php/logout.php" >Logout</a></small></h1>
</nav>
  <div class="container">
  <ul class="nav nav-tabs">
        <li role="presentation" ><a href="dashboard.php">Home</a></li>
        <li role="presentation"><a href="request_leave.php">Request a Leave</a></li>
        <li role="presentation"><a href="see_all_leaves.php">My approved Leaves</a></li>
        <li role="presentation"><a href="pending_leaves.php">My pending Leaves</a></li>
        <li role="presentation" class="active"><a href="notifications.php">Notice Board</a></li>
        <li role="presentation"><a href="calender.php">Calender</a></li>
    </ul>
	</div>
   
    <form action="notifications_result.php" class="form-inline"  role="form" method="GET">
		<div class="control-group text-center" >
		<div class="controls text-center">
		<br/><br/><br/>
		<div class="form-group" style="text-align:center">
		<label>Enter Notice ID</label>
		<input type='text' id="textinput" style="width:100%; height:40px; overflow:auto" name="textinput" placeholder="Enter the Notice-ID" class="form-control" rows="1">
		</div>
		<br><br>
	    	<input id="button" name="Submit" value="Submit" class="btn btn-primary" type="submit" style="padding-left: 1%;  width: 13.5%;">
		</div>
	    </div>
		</form>
		<?php
        $sql = 'SELECT * FROM notifications';
		$mysqli = dbConnect();
	$result = $mysqli->query($sql);
        if ($result->num_rows) {
			echo "<br>";
            echo "<h1 class=\"heading\"><b>"."List of notices:"."</b></h1>";
			echo "<br><br><div id=\"gallery\">";

			$row = mysqli_fetch_row($result);
			while ($row)
			{
				echo "<div class=\"imgwrap image-wrap\" style=\"float:left\">";
				$pdfWithPath="admin_1/content/".$row[2];
				echo "<a href=\"$pdfWithPath\"><p class=\"imgdesc\">Notice_Id: ".$row[0]." Subject: ".$row[1]." Date_Issued: ".$row[3]." Signature :".$row[4]."</p></a>";
				$thumb=basename($row[2],".pdf").".jpg";
				echo"<div class=\"image\"><a href=\"$pdfWithPath\"><img height=\"300\" width=\"300\" src=\"admin_1/contentimage/$thumb\" alt=\"\" /></a></div>";
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
		</div>
		
 </body>
</html>
