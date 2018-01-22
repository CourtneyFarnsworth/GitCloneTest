<!DOCTYPE html>
<html>
	<head>
		<title>Pet Profile</title>
		<!-- My External CSS file link-->
		<link rel="stylesheet" href="css/petprofile.css">
		<!-- This file is has the CDNs -->
    	<?php include 'components/head.html';?>
	</head>
	<body>
		
		<!-- This file is the nav bar -->
    	<?php include 'components/nav.html';?>

		<!-- php to set the pets name, image, and distance -->
		<?php
		session_start();

		/* Used in <a href> to send data to move through pets */
		$next = "next";
		$prev = "prev";

		/* Get data field "prev or next" from <a href> in PetProfile */
    	if(isset($_GET["data"])) {
        	$data = $_GET["data"];
    		
    		/* Move through the pets 'carosel style' based user clicked link */
    		if ($data == "next") {
				if ($_SESSION['start']== count($_SESSION['pets'])-1){
					$_SESSION['start'] = 0;
				} else {
					$_SESSION['start']++;
				}	
			}
			if ($data == "prev") {
				if ($_SESSION['start']==0){
					$_SESSION['start'] = count($_SESSION['pets'])-1;
				}else {
					$_SESSION['start']--;
				}	
			}
    	}
		
		/* In the case no pets found in database */
		if (!isset($_SESSION['pets'][0])){
			echo "<div class=\"containter\" style=\"padding:20px\"><br><h2>There are no pets currently available for adoption with the selected search fields.</h2></div>";
		}else{

			
			/* Sets pet name image and distance based on pointer in find a pet array */
			$name = $_SESSION['pets'][$_SESSION['start']]['dogName']; 
			$image = '<img class="img-responsive perfect-fit" alt="Main Pet Pic" src="data:image/jpeg;base64,'.base64_encode( $_SESSION['pets'][$_SESSION['start']]['petPic'] ).'"/>';
			$distance = $_SESSION['pets'][$_SESSION['start']]['distance']; 
			
		
/* Content */
$content = <<<EOBODY
<!-- Page title -->
    <h3 style="color: #303b4f; font-weight: normal; text-align: center; padding-top:15px;">Find a Pet
    </h3>

	<div class="container-fluid">
		<div class="petPic row">
			<div class="myArrows col-lg-3 col-md-2 col-sm-2 col-xs-1">
				<a href="PetProfile.php?data=$prev" class="previous">&#8249;</a>
			</div>
			<div class="mainPetPic col-lg-6 col-md-8 col-sm-8 col-xs-8">
				$image
			</div>
			
			<div class="myArrows col-lg-3 col-md-2 col-sm-2 col-xs-1">
				<a href="PetProfile.php?data=$next" class="next">&#8250;</a>
			</div>
		</div>
		<div class="row petInfo">
			<div class="myArrows col-lg-3 col-md-2 col-sm-2 col-xs-1"></div>
			<div class="col-lg-4 col-md-5 col-sm-5 col-xs-8">
				<ul>
					<li><h4>$name</h4></li>
					<li id="miles">Distance: <span>$distance</span> miles</li>
				</ul>
			</div>
			
			<div class="heart col-lg-2 col-md-3 col-sm-3 col-xs-2">
				<a href="insertFavorite_backend.php"><button type="button" class="btn btn-default btn-lg" id="heart">
					<span class="fa fa-heart" aria-hidden="true"></span>
				</button></a>
				
				<a href="PetProfileInfo.php"><button type="button" class="btn btn-default btn-lg" id="info">
					<span class="fa fa-info-circle" aria-hidden="true"></span>
				</button></a>
			</div>
			<div class="myArrows col-lg-3 col-md-2 col-sm-2 col-xs-1"></div>
		</div>
	</div>
EOBODY;

	/* Display the pets profile */
	echo $content;

}

?>
<!-- Back to HTML -->	
	</body>
</html>