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
if($_SESSION['user']['is_admin']) {
    header("Location: admin_1/dashboard.php");
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
<!doctype html>
<html>
<head>
    <meta charset="utf-8" />
    <title>Dashboard</title>
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
        <li role="presentation"><a href="request_leave.php">Request a Leave</a></li>
        <li role="presentation"><a href="see_all_leaves.php">My approved Leaves</a></li>
        <li role="presentation"><a href="pending_leaves.php">My pending Leaves</a></li>
        <li role="presentation"><a href="notifications.php">Notice Board</a></li>
        <li role="presentation"><a href="calender.php">Calender</a></li>
    </ul>

            <?php
            $mysqli = dbConnect();
            $ptr = $_SESSION['user']['person_id'];
			$fn = $_SESSION['user']['first_name'];
			$ln = $_SESSION['user']['last_name'];
			$un = $_SESSION['user']['username'];
			?>
			
    <!-- MAIN CONTAINER -->
        <div class="col-md-12">
          <h2> <span class="glyphicon glyphicon-user"></span> Profile <span style="padding-left: 70%;"><a href="updaterecords.php" class="btn btn-warning"> <span class="glyphicon glyphicon-cog"></span> Edit Profile </a> </span></h2>
<div>
          <div id="profile-info" class="jumbotron" style="float:left;">
            <dl class="dl-horizontal profile" style="padding-right: 510px;">
              <dt>Person Id</dt> <dd><?php echo $ptr ?></dd>
              <dt>First Name</dt> <dd class="first-name"><?php echo $fn ?></dd>
              <dt>Last Name</dt> <dd class="last-name"><?php echo $ln ?></dd>
              <dt>Username</dt> <dd class="username" style="text-transform:none;"><?php echo $un?></dd>
             </dl>
          </div>
<div id="imgContainer" >
  <form enctype="multipart/form-data" action="image_upload_demo_submit.php" method="post" name="image_upload_form" id="image_upload_form">
<?php
$mysqli = dbConnect();
$query = 'SELECT * from `person` WHERE person_id = '.$_SESSION['user']['person_id'].' ';
$result = $mysqli->query($query);
$row = mysqli_fetch_row($result);
if ($result->num_rows)
echo "<div id=\"imgArea\"><img src=".$row[8]." height=\"150\" width=\"150\">";
else
echo "<div id=\"imgArea\"><img src=\"avatars/default.jpg\" height=\"150\" width=\"150\">";
?>
      <div id="imgChange"><span>Change Photo</span>
        <input type="file" accept="image/*" name="image_upload_file" id="image_upload_file" style="width: 85px;">
    <input name="submit" type="submit" value="Upload" style="padding-left: 6px;"/>
  </form>
</div>

</div>
        </div>
        <!-- VIEW ENDS -->
    <!-- SCRIPTS -->
    <script src="bower_components/jquery/dist/jquery.min.js"></script>
    <script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="assets/js/handlers.js"></script>
    <script src="assets/js/views.js"></script>
    <script src="assets/js/service.js"></script>
    <script src="assets/js/profile.js"></script>
    <script src="js/jquery.min.js"></script>
    <script src="js/moment.min.js"></script>
    <script src="js/calender.js"></script>
    <script src="js/fullcalendar.min.js"></script>
    <script src="js/dashboard.js"></script>
</body>
</html>

