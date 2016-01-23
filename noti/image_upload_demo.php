<?php
session_start();
require_once('../php/funcs.php');
require_once('../php/db.php');

?>

<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Image upload and generate thumbnail using ajax in PHP</title>
<link href="./css/style.css" rel="stylesheet">
</head>

<body>

<div id="imgContainer">
  <form enctype="multipart/form-data" action="image_upload_demo_submit.php" method="post" name="image_upload_form" id="image_upload_form">
<?php
$mysqli = dbConnect();
$query = 'SELECT * from `person` WHERE person_id = '.$_SESSION['user']['person_id'].' ';
$result = $mysqli->query($query);
$row = mysqli_fetch_row($result);
if ($result->num_rows)
echo "<div id=\"imgArea\"><img src=".$row[8]." >";
else
echo "<div id=\"imgArea\"><img src=\"avatars/default.jpg\">";
?>
      <div id="imgChange"><span>Change Photo</span>
        <input type="file" accept="image/*" name="image_upload_file" id="image_upload_file">
    <input name="submit" type="submit" value="Upload notice" />
  </form>
</div>
</body>
</html>
