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
        <li role="presentation"><a href="request_leave.php">Request a Leave</a></li>
        <li role="presentation"><a href="see_all_leaves.php">My approved Leaves</a></li>
        <li role="presentation"><a href="pending_leaves.php">My pending Leaves</a></li>
        <li role="presentation"><a href="notifications.php">Notice Board</a></li>
        <li role="presentation"><a href="calender.php">Calender</a></li>
    </ul>
    <h3 style = "font-size : 30px">DISPLAY UPDATE RECORD</h3>
<form action="records_show_update.php"method="post">
<fieldset>

	<div class="control-group" >
	<label class="control-label" style="padding-right: 12px;font-size: 16px;" for="textinput">First Name</label>
	<div class="controls" style="display: inline ! important;">
	<input class="form-control" type="text" id="textinput"  name="first_name" placeholder="First_name" class="input-xsmall" value="<?php echo $_SESSION['user']['first_name'];?>" style="width: 275px; display: inline; margin-bottom: 20px; margin-left: 17px;" />
	</div>
	</div>

	<div class="control-group" >
	<label class="control-label" style="padding-right: 12px;font-size: 16px;" for="textinput">Last Name</label>
	<div class="controls" style="display: inline ! important;">
	<input class="form-control" type="text" id="textinput"  name="last_name" placeholder="Last_name" class="input-xsmall" value="<?php echo $_SESSION['user']['last_name'];?>" style="width: 275px; display: inline; margin-bottom: 20px; margin-left: 17px;" />
	</div>
	</div>

	<div class="control-group text-center">
	<div class="controls text-center" style="display: inline ! important;  padding-right: 77%;">
	<input id="button" class="btn btn-primary" name="submit" value="Update Record" class="input-small" type="submit" >
	</div>
	</div>
</fieldset>
</form>
</div>

</body>
</html>
