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
	<link href="css/style.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-inverse"   style="color:white">
    <h1> <span class="glyphicon glyphicon-send"></span> Notifications, <?php echo $_SESSION['user']['first_name'] ?>| <small> <a href="php/logout.php" >Logout</a></small></h1>
</nav>
<div class="container">
    <ul class="nav nav-tabs">
        <li role="presentation" class="active"><a href="dashboard.php">Home</a></li>
        <li role="presentation"><a href="user_details.php">View User Details</a></li>
        <li role="presentation"><a href="pending.php">Pending Leaves</a></li>
        <li role="presentation"><a href="notice1.php">Add Notice</a></li>
        <li role="presentation"><a href="notifications.php">Notifications</a></li>
    </ul><?php
    $a = $_SESSION['user']['person_id'];
    $b = $_POST["first_name"];
    $c = $_POST["last_name"];
$mysqli = dbConnect();
    $result =mysqli_query($mysqli,"UPDATE person SET first_name ='$b' WHERE person_id=$a");
$result =mysqli_query($mysqli,"UPDATE person SET last_name ='$c' WHERE person_id=$a");
$_SESSION['user']['first_name']=$b;
$_SESSION['user']['last_name']=$c;
header('Location: dashboard.php');
?>
</div>

</body>
</html>
