<?php
  require_once('funcs.php');
  require_once('db.php');
  //init();

  session_start();
if(!isset($_SESSION['user']) || !isset($_SESSION['user']['username'])) {
  header('Location: index.php');
  die();
}

$leave_id = $_GET['leave_id'];
$approve = $_GET['approve'] == '1'? true: false;

$mysqli = dbConnect();
if($approve)
$query = 'UPDATE `pending_requests` set `status` = TRUE WHERE leave_id = '.$leave_id;
else $query = 'Delete from 	`pending_requests` WHERE leave_id = '.$leave_id;
	   
$result = $mysqli->query($query);
	die(json_encode(['error' => $result?false:true]));

