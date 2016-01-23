<html>
  <head>
    <title>Add Notification</title>
    <meta charset="utf-8"/>
	<link href="../css/bootstrap.min.css" rel="stylesheet" media="screen">
    <link href="../css/bootstrap-datetimepicker.min.css" rel="stylesheet" media="screen">
  </head>
<body>
  <nav class="navbar navbar-inverse"   style="color:white">
  <h1> <span class="glyphicon glyphicon-send"></span> Welcome to Leave Application System, <?php echo $_SESSION['user']['first_name'] ?>| <small> <a href="php/logout.php" >Logout</a></small></h1>
  </nav> 
  <div class="container">
    <div class="col-md-3">
      <a href="request_leave.php">Request a Leave</a></br>
	  </div>
	  <div class="col-md-3">
      <a href="see_all_leaves.php">My approved Leaves</a></br>
	  </div>
	  <div class="col-md-3">
     <a href="pending_leaves.php">My pending leaves</a></br>
	 </div>
	 <div class="col-md-3">
	 <a href="notifications.php">Notice Board</a></br>
	 </div>
	 <div id="leave-calendar"></div>
</div>
<form method="post" action="notice2.php" enctype="multipart/form-data" >
<div class="control-group">
<label class="control-label" for="subject">Subject</label>
<input type="text" name="subject" required />
</div><div class="control-group">
<span><label class="control-label" for="content" style="dispay:inline;">Content</label>
<input type="file" name="content" required /></span>
</div><div class="control-group">
<label class="control-label" for="Date">Date</label>
<input type="date" name="date" required />
</div><div class="control-group">
<label class="control-label" for="signature">Signature</label>
<input type="text" name="signature" required />
</div>
<input name="submit" type="submit" value="Upload notice" />
</form>
</body>
</html>
