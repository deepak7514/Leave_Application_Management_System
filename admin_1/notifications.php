<?php
session_start();
require_once('php/funcs.php');
require_once('php/db.php');
if(!isset($_SESSION['user']) || !isset($_SESSION['user']['username'])) {
  header('Location: ../index.php');
  die();
}
if(!isLoggedIn()) {
  header('Location: ../dashboard.php');
  die();
}
?>
<!doctype html>
<html> 
  <head>
    <meta charset="utf-8" />
    <title>Notifications</title>
    <link rel="stylesheet" href="css/bootstrap.min.css"/>
    <link rel='stylesheet' href='css/fullcalendar.min.css' />
    <link rel='stylesheet' href='css/notify.css' />
	<link href="css/style.css" rel="stylesheet">
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
        <li role="presentation"><a href="dashboard.php">Home</a></li>
        <li role="presentation"><a href="user_details.php">View User Details</a></li>
        <li role="presentation"><a href="pending.php">Pending Leaves</a></li>
        <li role="presentation"><a href="notice1.php">Add Notice</a></li>
        <li role="presentation" class="active"><a href="notifications.php">Notifications</a></li>
    </ul>
           
  <div class="container">
    <form action="notifications_result.php" class="form-horizontal"  role="form" method="GET">
</fieldset>
	<!-- Text input-->
	<div class="control-group" style="padding-top: 24px;">
	<label class="control-label" style="padding-right: 12px; font-size: 16px;" for="textinput">Notice ID</label>
	<div class="controls" style="display: inline ! important;">
	<input class="form-control" type="text" id="textinput"  name="textinput" placeholder="Notice ID" class="input-xsmall" style="width: 275px; display: inline; margin-bottom: 20px; margin-left: 4px;" />
	</div>
	</div>


	<div class="control-group text-center">
	<div class="controls text-center" style="display: inline ! important;  padding-right: 77%;">
	<input id="button" class="btn btn-primary" name="submit" value="Submit" class="input-small" type="submit" >
	</div>
	</div>

</fieldset>
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
