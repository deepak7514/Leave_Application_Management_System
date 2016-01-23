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
<html xmlns="http://www.w3.org/1999/html">
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
        <li role="presentation"><a href="user_details.php">View User Details</a></li>
        <li role="presentation" class="active"><a href="pending.php">Pending Leaves</a></li>
        <li role="presentation"><a href="notice1.php">Add Notice</a></li>
        <li role="presentation"><a href="notifications.php">Notifications</a></li>
    </ul>
           
   



    <?php
    $mysqli = dbConnect();
    $query = 'SELECT * FROM `pending_requests` WHERE status = FALSE';
    $result = $mysqli->query($query);
    if(!$result){
        echo "DataBase error";
    } else {
		echo '<h4 align="center">Following are the pending leaves<h4>';
        if ($result->num_rows > 0) {
			echo '<table class="table table-striped"><tr><th>Person id</th><th>Leave type</th><th>Start Date</th><th>End date</th><th>Other data</th><th>Approve/Reject</th></tr>';
            while($row = $result->fetch_assoc()) {
                echo "<div id='p".$row['person_id']."'> <tr><td>" . $row["person_id"]. "</td> <td> " . $row["leave_type"]. " </td><td>" . $row["start_date"] . " </td><td> " . $row["end_date"].  " </td><td>" . $row["other_data"].
                    " </td><td><button class='btn btn-sm btn-info' onclick='sendRequest(\"p".$row['person_id']."\",".$row['leave_id'].",1)'><span class='glyphicon glyphicon-ok'></span> Approve </button> ".
                    "<button class='btn btn-sm btn-danger' onclick='sendRequest(\"p".$row['person_id']."\",".$row['leave_id'].",0)'><span class='glyphicon glyphicon-remove'></span>  Reject </button></td></tr><br></div>";
            }
			echo '</table>';
        }
        else{
            echo "<br/></br><h3 align=\"center\">No pending requests!</hr>";
        }

    }
    ?>
    <?php
    echo '</p>';
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

