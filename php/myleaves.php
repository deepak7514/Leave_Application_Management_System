<?php
session_start();
require_once('funcs.php');
require_once('db.php');
if(!isset($_SESSION['user']) || !isset($_SESSION['user']['username'])) {
  header('Location: index.php');
  die();
}

$mysqli = dbConnect();
$query = 'SELECT leave_type as title, start_date as start, end_date as end FROM `leaves_taken` WHERE `person_id` = ' . ($_SESSION['user']['person_id']) .'';

$result = $mysqli->query($query);

if($result->num_rows>0){
	$data = [];
	while($row = $result->fetch_assoc()) {
		$data[] = $row;
	}
	respond(false, "got it", $data);
}
?>
	