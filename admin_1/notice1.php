<?php
session_start();
require_once('php/funcs.php');
require_once('php/db.php');
if(!isset($_SESSION['user']) || !isset($_SESSION['user']['username'])) {
  header('Location: index.php');
  die();
}
if(!isLoggedIn()) {
    header('Location: dashboard.php');
    die();
}
if($_GET['seen']=="c4ca4238a0b923820dcc509a6f75849b"){
	
	$query = 'UPDATE `person` SET Notification_number = 0 where person_id='.$_SESSION['user']['person_id'];
	$mysqli = dbConnect();
    $result = $mysqli->query($query);
    if($result){
		echo 'command executed';
	}
	else{
		echo 'No!';
	}
}

?>
<html>
  <head>
    <title>Add Notification</title>
    <meta charset="utf-8"/>
	<link href="css/bootstrap.min.css" rel="stylesheet" media="screen">
    <link href="css/bootstrap-datetimepicker.min.css" rel="stylesheet" media="screen">
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
        <li role="presentation" class="active"><a href="notice1.php">Add Notice</a></li>
        <li role="presentation"><a href="notifications.php">Notifications</a></li>
    </ul>
           
<form method="post" action="notice2.php" class="form-horizontal"  role="form" enctype="multipart/form-data" >
	<fieldset>
	<!-- Form Name -->
	<legend style="border: medium none; padding-left: 40%; font-size: 150%; padding-top: 3%; color: red;">Add Notification</legend>

	<!-- Text input-->
	<div class="control-group" >
	<label class="control-label" style="padding-right: 12px;font-size: 16px;" for="textinput">Subject</label>
	<div class="controls" style="display: inline ! important;">
	<input class="form-control" type="text" id="textinput"  name="subject" placeholder="Subject" class="input-xsmall" style="width: 275px; display: inline; margin-bottom: 20px; margin-left: 17px;" />
	</div>
	</div>


	<div class="control-group" >
	<label class="control-label" style="padding-right: 12px;font-size: 16px;" for="textinput">Content</label>
	<div class="controls" style="display: inline ! important;">
	<input class="form-control" type="file"   name="content" class="input-small" style="width: 275px; display: inline; margin-bottom: 20px; margin-left: 17px;" />
	</div>
	</div>

	<div class="form-group" style="padding-right: 53%;">
	<label for="dtp_input2" class="col-md-2 control-label" style="font-size: 16px; width: 112px;">Issue Date</label>
	<div class="input-group date form_date col-md-3" data-date="" data-date-format="dd MM yyyy" data-date-autoclose="true" data-date-todayBtn="true" data-link-field="dtp_input2" data-link-format="yyyy-mm-dd" style="width: 276px; left: -5px;">
	<input class="form-control" name = "date" size="16" type="text" value="" >
	<!--span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span-->
	<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
	</div>
	<input type="hidden" id="dtp_input2" value="" /><br/>
	</div>

	<!-- Text input-->
	<div class="control-group" >
	<label class="control-label" style="padding-right: 12px; font-size: 16px;" for="textinput">Signature</label>
	<div class="controls" style="display: inline ! important;">
	<input class="form-control" type="text" id="textinput"  name="signature" placeholder="Signature" class="input-xsmall" style="width: 275px; display: inline; margin-bottom: 20px; margin-left: 4px;" />
	</div>
	</div>

	<div class="control-group text-center">
	<div class="controls text-center" style="display: inline ! important;  padding-right: 77%;">
	<input id="button" class="btn btn-primary" name="submit" value="Upload notice" class="input-small" type="submit" >
	</div>
	</div>
</fieldset>
</form>

<script type="text/javascript" src="./jquery/jquery-1.8.3.min.js" charset="UTF-8"></script>
<script type="text/javascript" src="./bootstrap/js/bootstrap.min.js"></script>
<script type="text/javascript" src="./js/bootstrap-datetimepicker.js" charset="UTF-8"></script>
<script type="text/javascript">
    $('.form_datetime').datetimepicker({
        //language:  'fr',
        weekStart: 1,
        todayBtn:  1,
		autoclose: 1,
		todayHighlight: 1,
		startView: 2,
		forceParse: 0,
        showMeridian: 1
    });
	$('.form_date').datetimepicker({
        language:  'fr',
        weekStart: 1,
        todayBtn:  1,
		autoclose: 1,
		todayHighlight: 1,
		startView: 2,
		minView: 2,
		forceParse: 0
    });
	$('.form_time').datetimepicker({
        language:  'fr',
        weekStart: 1,
        todayBtn:  1,
		autoclose: 1,
		todayHighlight: 1,
		startView: 1,
		minView: 0,
		maxView: 1,
		forceParse: 0
    });
</script>
</body>
</html>
