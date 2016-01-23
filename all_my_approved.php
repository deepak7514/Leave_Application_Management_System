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
  <ul class="nav nav-tabs">
        <li role="presentation" ><a href="dashboard.php">Home</a></li>
        <li role="presentation"><a href="request_leave.php">Request a Leave</a></li>
        <li role="presentation" class="active"><a href="see_all_leaves.php">My approved Leaves</a></li>
        <li role="presentation"><a href="pending_leaves.php">My pending Leaves</a></li>
        <li role="presentation"><a href="notifications.php">Notice Board</a></li>
        <li role="presentation"><a href="calender.php">Calender</a></li>
    </ul>
   
    <?php 
	$mysqli = dbConnect();
	$query = 'SELECT * FROM `pending_requests` WHERE `person_id` = ' . ($_SESSION['user']['person_id']) .' and `status` = 0';
	$result = $mysqli->query($query);
	if($result->num_rows>0){
		
	echo "<table> <tr><th>Leave ID || </th><th>Person ID || </th><th>Type Of Leave || </th><th>Start Date || </th><th>End Date</th></br></tr>"	;
	while($row = $result->fetch_assoc()) {
		echo "<tr><td>$row[leave_id]</td><td>$row[person_id]</td><td>$row[leave_type]</td><td>$row[start_date]</td><td>$row[end_date]</td></br>";
	}
	echo "</table>";
	}
	else echo "<h1>No Pending Requests</h1>";
	?>
	
  </body>
</html>
