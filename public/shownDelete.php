<?php
	
	use google\appengine\api\cloud_storage\CloudStorageTools;
	$my_bucket = "mtoys-167102.appspot.com";
	$image_file = "gs://${my_bucket}/one.PNG";
	
	//$image_url = CloudStorageTools::getImageServingUrl($image_file);
	
	$image_url = "https://storage.googleapis.com/${my_bucket}/two.PNG";
	

	
	
	
	
?>



<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
	</head>
	<body>
		<img src="<?php echo $image_url; ?>" alt="">
		
	</body>
	
	
</html>