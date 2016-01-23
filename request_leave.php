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
        <li role="presentation" class="active"><a href="request_leave.php">Request a Leave</a></li>
        <li role="presentation"><a href="see_all_leaves.php">My approved Leaves</a></li>
        <li role="presentation"><a href="pending_leaves.php">My pending Leaves</a></li>
        <li role="presentation"><a href="notifications.php">Notice Board</a></li>
        <li role="presentation"><a href="calender.php">Calender</a></li>
    </ul>

	<div class="container">
    <form action="leave_details.php" class="form-horizontal"  role="form" method="GET">
        <fieldset>
	    <!-- Form Name -->
	    <legend style="border: medium none; padding-left: 40%; font-size: 150%; padding-top: 3%; color: red;">Leave Application</legend>
	    
	    <!-- Multiple Radios (inline) -->
	    <div class="control-group" style="padding-left: 9%;">
		<label class="control-label" for="radios">Leaves Type</label>
		<div class="controls" style="display: inline; padding-left: 1%; font-size: medium;;">
		    <input name="radios" id="radios-0" value="Sick Leave" checked="checked" type="radio">
		    Sick Leave
		    <input name="radios" id="radios-1" value="Ordinal Leave" type="radio">
		    Ordinal Leave
		    <input name="radios" id="radios-2" value="Non-sick Leave" type="radio">
		    Non-sick Leave
		    <input name="radios" id="radios-3" value="Others" type="radio">
		    Others
		</div>
	    </div>
	    
	    <div class="form-group" style="padding-top: 2%;">
                <label for="dtp_input2" class="col-md-2 control-label">Start Date</label>
                <div class="input-group date form_date col-md-3" data-date="" data-date-format="dd MM yyyy" data-date-autoclose="true" data-date-todayBtn="true" data-link-field="dtp_input2" data-link-format="yyyy-mm-dd">
                    <input class="form-control" name = "startDate" size="16" type="text" value="" >
		    <!--span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span-->
		    <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                </div>
		<input type="hidden" id="dtp_input2" value="" /><br/>
            </div>
	    
	    <div class="form-group" style="padding-top: 1%;">
                <label for="dtp_input2" class="col-md-2 control-label">End Date</label>
                <div class="input-group date form_date col-md-3" data-date="" data-date-format="dd MM yyyy" data-date-autoclose="true" data-date-todayBtn="true" data-link-field="dtp_input2" data-link-format="yyyy-mm-dd">
                    <input class="form-control" name="endDate" size="16" type="text" value="" >
		    <!--span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span-->
		    <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                </div>
		<input type="hidden" id="dtp_input2" value="" /><br/>
            </div>
            	
				
	    <!-- Text input-->
	    <div class="control-group" >
		<label class="control-label" for="textinput" style="padding-left: 3%;">Other Data</label>
		<div class="controls" style="display: inline ! important; padding-left: 1%;">

			<textarea id="textinput" style="width:80%; height:150px;overflow:auto" name="textinput" placeholder="Placeholder" class="input-xxlarge"rows="5"> </textarea>
		</div>
	    </div>
		
	    <div class="control-group text-center" style="padding-top: 3%">
		<div class="controls text-center" style="display: inline ! important; padding-left: 1%;">
			<input id="button" class="btn btn-primary" name="Submit" value="Submit" class="input-xxlarge" type="submit" style="padding-left: 1%;  width: 23.5%;">
		</div>
	    </div>
	    
        </fieldset>
    </form>
</div>

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
