<?php
require_once('php/funcs.php');
require_once('php/db.php');

if(!isLoggedIn()) {
  header('Location: ../dashboard.php');
  die();
}
if(!$_SESSION['user']['is_admin']) {
  header("Location: ../dashboard.php");
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
    <div class="container" align="center">
	<br/><br/><br/><br/><br/>
   <h3 style = "font-family : Arial;font-size : 20px">DISPLAY FACULTY MEMBERS</h3>
       <form action="displayleaves.php"method="post">
               <label>Select the user whose leaves you want to see :</label> <select name="person_id" class="selectpicker" size="1">
        <?php
            mysql_connect("localhost","root","root");
            mysql_select_db("leaveapp");
            if(mysql_errno())
            die("Database Server is Offline");
            $q=mysql_query("SELECT person_id from `person` where is_admin=0");
            if(mysql_num_rows($q)){
		while($m=mysql_fetch_assoc($q))
                {
                    echo '<option value="'.$m["person_id"].'">'.$m["person_id"].'</option>';
                }
		        
            }    
        ?>
    </select>
			   <input name="SUBMIT" class="btn btn-info" type="submit" value="DISPLAY" style = "font-family: cursive;font-size: 20px"></input>
           </form>
       <?php
       echo '</p>';
       ?>
	   </div>


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
