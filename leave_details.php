<?php
require_once('php/funcs.php');
require_once('php/db.php');

if(!isLoggedIn()) {
    header('Location: dashboard.php');
    die();
}
if(!$_SESSION['user']['is_admin']) {
    header("Location: dashboard.php");
}
?>

<!doctype html>
<html>
<head>

    <meta charset="utf-8" />
    <title>Dashboard</title>
    <link rel="stylesheet" href="css/bootstrap.min.css"/>
    <link rel='stylesheet' href='css/fullcalendar.min.css' />
</head>

<body>
<h1>Welcome,<? php echo $_SESSION['user']['username'] ?>| <small> <a href="php/logout.php">Logout</a></small></h1>
<ul class="nav nav-tabs">
        <li role="presentation" ><a href="dashboard.php">Home</a></li>
        <li role="presentation"><a href="request_leave.php">Request a Leave</a></li>
        <li role="presentation"><a href="see_all_leaves.php">My approved Leaves</a></li>
        <li role="presentation" class="active"><a href="pending_leaves.php">My pending Leaves</a></li>
        <li role="presentation"><a href="notifications.php">Notice Board</a></li>
        <li role="presentation"><a href="calender.php">Calender</a></li>
    </ul>
   
 <?php  print_r ($_GET);
	$query = 'INSERT INTO `pending_requests` (`person_id`,`leave_type`,`start_date`,`end_date`,`other_data`) VALUES ('.
	"'".$_SESSION['user']['person_id']."',".
	"'".$_GET['radios']."',".
	"'".date('Y-m-d',strtotime($_GET['startDate']))."',".
	"'".date('Y-m-d',strtotime($_GET['endDate']))."',".
	"'".$_GET['textinput']."')";

	$mysqli = dbConnect();
	$result = $mysqli->query($query);

	if($result){
		echo "<h1>Added</h1>";
	} else {
		echo "Not added";
	}
 ?>
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
    <?php
    $mysqli = dbConnect();
    $a = $_POST["person_id"];
    $sql = "SELECT Notification_number FROM person where person_id = $a";
    $result = $mysqli->query($sql);
    $row = $result->fetch_assoc();
    $tempnum=$row["Notification_number"];
    ?>


    <button class="btn btn-primary" type="button">
        Notification_Number <span class="badge"><?php echo $tempnum;  ?></span>
    </button>




    <?php
$mysqli = dbConnect();
$a = $_POST["person_id"];
//echo $a;

$flagcheck=0;
$sql = "SELECT * FROM leaves_taken";
if ($result = mysqli_query($mysqli, $sql))
{
while ($row = mysqli_fetch_row($result))
{
    $flagcheck=1;
echo '<p style ="color : blue;font-size:20px">ID - '. $row[0] . ' START DATE - ' . $row[1] . ' END DATE - ' . $row[2]. ' TYPE - ' . $row[3] . '</p>' ;
}
}
if($flagcheck==0)
    echo '<p style ="font-size:20px"> No Previous Record</p>' ;
?>
</div>
<script src="js/jquery.min.js"></script>
<script src='js/moment.min.js'></script>
<script src='js/fullcalendar.min.js'></script>
<script src="js/dashboard.js"></script>


</body>
</html>
