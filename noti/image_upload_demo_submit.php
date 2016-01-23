<?php
session_start();
require_once('../php/funcs.php');
require_once('../php/db.php');
if(!isset($_SESSION['user']) || !isset($_SESSION['user']['username'])) {
  header('Location: ../index.php');
  die();
}
if(!isLoggedIn()) {
  header('Location: ../dashboard.php');
  die();
}
if($_SESSION['user']['is_admin']) {
	header("Location: ../dashboard_admin.php");
}
?>
<?php
include('./functions.php');
/*defined settings - start*/
ini_set("memory_limit", "99M");
ini_set('post_max_size', '20M');
ini_set('max_execution_time', 600);
define('IMAGE_DIR', './avatars/');
define('IMAGE_SIZE', 250);
/*defined settings - end*/

if(isset($_FILES['image_upload_file'])){
	$output['status']=FALSE;
	set_time_limit(0);
	$allowedImageType = array("image/gif",   "image/jpeg",   "image/pjpeg",   "image/png",   "image/x-png"  );
	
	if ($_FILES['image_upload_file']["error"] > 0) {
		$output['error']= "Error in File";
	}
	elseif (!in_array($_FILES['image_upload_file']["type"], $allowedImageType)) {
		$output['error']= "You can only upload JPG, PNG and GIF file";
	}
	elseif (round($_FILES['image_upload_file']["size"] / 1024) > 4096) {
		$output['error']= "You can upload file size up to 4 MB";
	} else {
		/*create directory with 777 permission if not exist - start*/
		createDir(IMAGE_DIR);
		/*create directory with 777 permission if not exist - end*/
		$path[0] = $_FILES['image_upload_file']['tmp_name'];
		$file = pathinfo($_FILES['image_upload_file']['name']);
		$fileType = $file["extension"];
		$desiredExt='jpg';
		$fileNameNew = $_SESSION['user']['first_name']."_".$_SESSION['user']['last_name']."_".time().".$desiredExt";
		$path[1] = IMAGE_DIR.$fileNameNew;
		
		if (move_uploaded_file($path[0], $path[1])) {
				$output['status']=TRUE;
				$output['image']= $path[1];
				$mysqli = dbConnect();
				$query = 'UPDATE `person` set `avatar_path` = \''.$path[1].'\' WHERE person_id = \''.$_SESSION['user']['person_id'].'\' ';
				$result = $mysqli->query($query);
				//die(json_encode(['error' => $result?false:true]));
				if($result->num_rows)
				echo "Successfully updated profile photo";
				else
				echo "Error in changing profile photo";
				header('Location: ../dashboard.php');
		}
	}
	//echo json_encode($output),$query,$_SESSION['user']['person_id'];
}
?>	
