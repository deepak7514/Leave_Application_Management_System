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

    <button class="btn btn-primary" type="button">
        Notification_Number <span class="badge"><?php echo $tempnum;  ?></span>
    </button>




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


<input type="button"  style = "color: blueviolet;font-family: cursive;font-size: 20px" value="BACK" class="homebutton" id="btnHome"
       onClick="document.location.href='dashboard_admin.php'" />


</body>
</html>
