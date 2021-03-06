<?php
require_once('php/funcs.php');
if(isLoggedIn()) {
  header('Location: dashboard.php');
  die();
}
?>
<!doctype html>
<html> 
  <head>
    <meta charset="utf-8" />
    <title>LeaveApp</title>
    <link rel="stylesheet" href="css/bootstrap.min.css"/>
  </head>
  <body>
  <nav class="navbar navbar-inverse"   style="color:white">
  <h1> <span class="glyphicon glyphicon-send"></span> Welcome to Leave Application System </h1>
      
  </nav> 
  
      <div class="container-fluid">
    
	  <div class="col-md-6">
        <h4> Login </h4>
        <form id="login-form" action="php/login.php" method="post">
          <div class="form-group">
            <label> Username </label>
            <input class="form-control" type="text" name="username" placeholder="Enter your username">
          </div>
          <div class="form-group">
            <label> Password  </label>
            <input class="form-control" type="password" name="password" placeholder="Enter your password">
          </div>
          <div class="message alert"> </div>
          <button class="btn btn-primary"> Log In </button>
        </form>
      </div>
      <div class="col-md-6">
        <h4> Signup </h4>
        <form id="signup-form" action="php/signup.php" method="post">
          <div class="form-group">
            <label> Username </label>
            <input class="form-control" type="text" name="username" placeholder="Enter your username">
          </div>
          <div class="form-group">
            <label> Password </label>
            <input class="form-control" type="password" name="password" placeholder="Enter your password">
          </div>
          <div class="form-group">
            <label> First Name </label>
            <input class="form-control" type="text" name="first_name" placeholder="Enter your first name">
          </div>
          <div class="form-group">
            <label> Last Name </label>
            <input class="form-control" type="text" name="last_name" placeholder="Enter your last name">
          </div>
          <div class="message alert"></div>
          <button class="btn btn-default"> Sign Up </button>
        </form>
      </div>
    </div>
    <script src="js/jquery.min.js"></script>
    <script src="js/register.js"></script>
  </body>
</html>
