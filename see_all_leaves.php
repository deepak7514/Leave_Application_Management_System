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
    <title> Dashboard </title>
    <meta charset="utf-8"/>
	<link href="./css/bootstrap.min.css" rel="stylesheet" media="screen">
    <link href="./css/bootstrap-datetimepicker.min.css" rel="stylesheet" media="screen">

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
        <li role="presentation" class="active"><a href="see_all_leaves.php">My approved Leaves</a></li>
        <li role="presentation"><a href="pending_leaves.php">My pending Leaves</a></li>
        <li role="presentation"><a href="notifications.php">Notice Board</a></li>
        <li role="presentation"><a href="calender.php">Calender</a></li>
    </ul>
   
	<?php    
    $sql = 'SELECT * FROM `leaves_taken` where person_id='.$_SESSION['user']['person_id'];
	$mysqli = dbConnect();
	$result = $mysqli->query($sql);
	
	echo '<br/><br/><br/>';
	echo '<table class="table table-striped"><tr><th>start_date</th><th>end_date</th><th>leave_type</th></tr>';
	$row=mysqli_fetch_row($result);
     if($row){
		while($row=mysqli_fetch_row($result)){ 
		echo '<tr><td>';
		echo $row[1];
		echo '</td><td>';
		echo $row[2];
		echo '</td><td>';
		echo $row[3];
		echo '</td></tr>';
		}
		echo '</table>';
	 }
	 
	 else
	 {
		echo "You have not taken any leaves!";
	 }
 	?>
	</div>
  </body>
</html>
