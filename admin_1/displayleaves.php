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

<?php
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

<nav class="navbar navbar-inverse"   style="color:white; border-radius:0px;padding:0px 20px 5px">
    <h1> <span class="glyphicon glyphicon-send"></span> Welcome to Admin Dashboard, <?php echo $_SESSION['user']['first_name'] ?>| <small> <a href="php/logout.php" >Logout</a></small></h1>
</nav>
<div class="container">

    <ul class="nav nav-tabs">
        <li role="presentation"><a href="dashboard.php">Home</a></li>
        <li role="presentation" class="active"><a href="user_details.php">View User Details</a></li>
        <li role="presentation"><a href="pending.php">Pending Leaves</a></li>
        <li role="presentation"><a href="notice1.php">Add Notice</a></li>
        <li role="presentation"><a href="notifications.php">Notifications</a></li>
    </ul>
           
<div class="container">

    <?php
    $mysqli = dbConnect();
    $a = $_POST["person_id"];
    $sql = "SELECT Notification_number FROM person where person_id = $a";
    $result = $mysqli->query($sql);
    $row = $result->fetch_assoc();
    $tempnum=$row["Notification_number"];
    ?>


    <p  style="font-size: 30px; padding-top: 52px;" align="center" ><strong>LEAVE RECORDS</strong><br/></br>
    <table class="table table-striped" align="center">
        <tr>
            <td width="20" style = "font-size : 20px">ID</td>
            <td width="120" style = "font-size : 20px">START DATE</td>
            <td width="120" style = "font-size : 20px">END DATE</td>
            <td width="160" style = "font-size : 20px">TYPE</td>
        </tr>




        <?php
    $mysqli = dbConnect();
    $a = $_POST["person_id"];
    //echo $a;

    $flagcheck=0;
    $sql = "SELECT * FROM leaves_taken where person_id = $a";
    if ($result = mysqli_query($mysqli, $sql))
    {
        while ($row = mysqli_fetch_row($result))
        {
            $flagcheck=1;

        echo"<tr>";
            echo"<td>";
            echo $row[0];
            echo"</td>";
            echo"<td>";
            echo $row[1];
            echo"</td>";
            echo"<td>";
            echo $row[2];
            echo"</td>";
            echo"<td>";
            echo $row[3];
            echo"</td>";
        echo "</tr>";
          //  echo '<p style ="color : blue;font-size:20px">ID - '. $row[0] . ' START DATE - ' . $row[1] . ' END DATE - ' . $row[2]. ' TYPE - ' . $row[3] . '</p>' ;
            //echo "</tr>";
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

<script>
    function sendRequest(divId, leaveId, approve) {
        $.ajax ({
            url : 'php/serve_application.php',
            data : { leave_id : leaveId, approve : approve },
            dataType : 'json',
            success : function(r) {
                alert(!r.error);
                $('#'+divId).hide('slow');
            }
        });
    }
</script>




</body>
</html>
