<!doctype html>
<?php

/* 
Image upload script for ng-slide, an AngularJS slideshow
This file expects to be in the ./upload directory, though you can move it as long as you change the include and upload directory.
To implement this file, change the sample user, password, database, and hostname to the info for your database,
and rename this file "index.php"
Also consider moving the images folder into a separate directory kept above the web root, for security reasons.
Martin Berlove
4/28/2016
*/

$notify = ""; // TODO improve this awful notification system.
$upload_size_limit = 8000000; // 8 MBish
$uploadOK = false; // Must pass all checks to be ok to upload.
$errorsCount = 0;

if (isset($_POST['submitFlag'])) { // If we've gotten to this script via upload
	
	require_once '../meekrodb.2.3.class.php'; // Use the MeekroDB library to simplify DB interaction.

	// Set up DB info
	DB::$user = 'db_user';
	DB::$password = 'db_pass';
	DB::$dbName = 'db_name';
	DB::$host = "db_hostname";

	// Upload info
	$upload_dir = "../images/"; // Directory TODO change on prod
	$uploadSuccess;
	//$fileType = pathinfo($target_file,PATHINFO_EXTENSION);

	// Check if image file is a actual image or fake image
	if(isset($_POST["submit"])) {
		
		foreach ($_FILES["slide"] as $slide) { // For each file selected...
			
			$upload_file = $upload_dir . basename($_FILES["slide"]["name"]); // Full file path + name to use
			
			if (file_exists($upload_file)) {
				$notify = "An image with that filename already exists.";
				$errorsCount++;
			}
			
			if ($_FILES["slide"]["size"] > $upload_size_limit) {
				$notify = "File is " . $_FILES["slide"]["size"] . " bytes. Max file size is " . $upload_size_limit . ".";
				$errorsCount++;
			}
			
			if ($errorsCount == 0) {
				
				$uploadOK = true; // This doesn't have a use yet, but if the logic gets more complicated we could have a reason to.
				
				DB::insert('ngslide', array(
					'url' => substr($upload_file,3),
					/* Title and caption don't have a use yet, but it's easy to add them in if you change the styles, etc. */
					'title' => '',//$_POST['title'],
					'caption' => ''//$_POST['caption']
				));
				
				move_uploaded_file($_FILES["slide"]["tmp_name"],$upload_file);
				
				$notify = "Your image was uploaded successfully.";
			}
			else {
				// TODO if there are errors....
			}
		}
	}
	else {
		$notify = "There was an issue uploading your file.";
	}
}
?>
<html>
	<head>
		<link rel="stylesheet" type="text/css" href="../styles.css" />
		<title>Upload Slides</title>
	</head>
	<body>
		<div id="wrapper">
			<a href="../index.html" class="backHome"><div><< return</div></a>
			<div id="notifyZone"><?php echo $notify ?></div> <!-- For notifications -->
			<form id="imageUploadForm" action="index.php" method="post" enctype="multipart/form-data">
				<input type="hidden" name="submitFlag" value="1" /> <!-- Elementary ineffective security but it guards against silly user mistakes. -->
				<input type="hidden" name="MAX_FILE_SIZE" value="<?php $upload_size_limit ?>" />
				<input type="file" name="slide" multiple />
				<!-- Title and caption don't have a use yet, but it's easy to add them in if you change the styles, etc. -->
				<!-- <input type="text" name="title" placeholder="Title..." />
				<input type="text" name="caption" placeholder="Caption (optional)..." /> -->
				<input type="submit" value="Upload" name="submit" />
			</form>
			<a href="../index.html" class="backHome"><div><< return</div></a>
		</div>
	</body>
</html>