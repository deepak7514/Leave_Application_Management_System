<?php
session_start();
require_once('php/funcs.php');
require_once('php/db.php');
if(!isLoggedIn()) {
  header('Location: dashboard.php');
  die();
}
?>
<!doctype html>

<html>
<head>
<meta charset="utf-8" />
<title>Calender</title>
<link rel="stylesheet" href="css/divisions.css">
<link rel="stylesheet" href="css/bootstrap.min.css"/>
<link rel='stylesheet' href='css/fullcalendar.min.css' />
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
        <li role="presentation" class="active"><a href="dashboard.php">Home</a></li>
        <li role="presentation"><a href="user_details.php">View User Details</a></li>
        <li role="presentation"><a href="pending.php">Pending Leaves</a></li>
        <li role="presentation"><a href="notice1.php">Add Notice</a></li>
        <li role="presentation"><a href="notifications.php">Notifications</a></li>
    </ul>
           

<div class="container">
    
  <ul class="nav nav-tabs">
  <li role="presentation" class="active"><a href="calender.php">Calender</a></li>
  </ul>
  </div>
  <div id ="cal">
  <h1 style="text-align:center">My Leaves</h1>
  <a href="dashboard.php" class="back">Back</a>
  </div>
  <div class="div1" id="leave-calendar"></div>
  <script src="js/jquery.min.js"></script>
  <script src='js/moment.min.js'></script>
  <script src='js/fullcalendar.min.js'></script>
  <script src="js/dashboard.js"></script>
  </body>
</html>
