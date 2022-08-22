
<?php
//TODO delete old image if exists
//TODO beautify the error messages
	$target_dir = "../resources/img/logos/";
	$target_file = $target_dir . basename($_FILES["image"]["name"]);
	$uploadOk = 1;
	$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
	$now = time();
	$rand = rand(1,255);
	$new_file_name = md5($rand.$now.$rand);

	$new_file = $target_dir . $new_file_name. "." . $imageFileType;

	// Check if image file is a actual image or fake image
	if(isset($_POST["submit"])) {
	$check = getimagesize($_FILES["image"]["tmp_name"]);
	if($check !== false) {
		//echo "File is an image - " . $check["mime"] . ".";
		$uploadOk = 1;
	} else {
		echo "File is not an image.";
		$uploadOk = 0;
	}
	}

    //disabled as only one shield can be there for one convention. to save space, replace the old one
	// // Check if file already exists
	// //TODO Replace with while to generate new name until not used anymore
	// if (file_exists($new_file)) {
	// echo "Sorry, file already exists.";
	// $uploadOk = 0;
	// }

	// Check file size
	if ($_FILES["image"]["size"] > 5000000) {
	echo "Sorry, your file is too large.";
	$uploadOk = 0;
	}

	// Allow certain file formats
	if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
	&& $imageFileType != "gif" ) {
	echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
	$uploadOk = 0;
	}

	// Check if $uploadOk is set to 0 by an error
	if ($uploadOk == 0) {
	echo "Sorry, your file was not uploaded.";
	// if everything is ok, try to upload file
	} else {
	if (move_uploaded_file($_FILES["image"]["tmp_name"], $new_file)) {
		
        $data['tr_convention_icon']         = $new_file_name.".".$imageFileType;
        $data['tr_convention_modify_id']    = $_SESSION['tr_user_id'];
        $data['tr_convention_modify_ts']    = time();

        $where = array();
        $wh['col'] = "tr_convention_id";
        $wh['typ'] = "=";
        $wh['val'] = $_POST['convention_id'];
        array_push($where, $wh);

        $query		= "Wappenschild hochladen";
        $db_result 	= db_update("tr_convention", $data, $where);

        $convention_id = htmlspecialchars($_POST['convention_id']);
        include("admin_convention_edit.php");


	
	} else {
		echo "Sorry, there was an error uploading your file.";
	}
	}


?>
