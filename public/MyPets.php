<!DOCTYPE html>
<html>
	<head>
		<title>Pets List</title>
		<!-- CSS for bootstrap -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css" integrity="sha384-/Y6pD6FV/Vv2HJnA6t+vslU6fwYXjCFtcEpHbNJ0lyAFsXTsjBbfaDjzALeQsN6M" crossorigin="anonymous">
		<link rel="stylesheet" href="css/mypets.css">
		<!-- CSS for gliphicons -->
		<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
		<!-- JS for bootstrap -->
		<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min.js" integrity="sha384-h0AbiXch4ZDo7tp9hKZ4TsHbi047NrKGLO3SEJAg45jXxnGIfYzk4Si90RDIqNm1" crossorigin="anonymous"></script>
		<!-- Required meta tags -->
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

		<!-- center aligns the drop down menu on nav bar -->
		<style>
			@media (max-width:767px){
   				.nav>li{
       				text-align:center;
   				}
			}
		</style>
		
		<!-- To change dog icon blue to white on hover -->
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
		<script type="text/javascript">
		function onHover(){
			$("#menuImg").attr('src', 'images/dog-icon.png');
		}
		function offHover(){
			$("#menuImg").attr('src', 'images/dog-icon-blue.png');
		}
		</script>

	</head>
	<body>
	
	<!-- This file is the nav bar -->
    <?php include 'components/nav.html';?>

    <!-- Page title -->
    <h3 style="color: #303b4f; font-weight: normal; text-align: center; padding-top:15px;">My Pets
    </h3>


		<!-- Content -->
		<div class="wrapper">
			<br><ul>
				<li onmouseover="onHover();" onmouseout="offHover();">
					<input type="checkbox" id="list-item-1" >
					<label for="list-item-1" class="first" >
    					<img id="menuImg" src="images/dog-icon-blue.png"  />
						<br><h2>My Adoptable Pets</h2>
					</label>
					<ul class="pets-list-wrapper">

<!-- php to loop through all the users adoptable pets -->
<?php 
	session_start();

	/* Incase user doesn't have any pets for adoption */
	if (!isset($_SESSION['mypets']) || count($_SESSION['mypets']) < 1){
		$listitem = "<li>No Pets</li>";
		echo $listitem;

	} else {
		/* Loop through the users pets from loadUsersPets_backend */
		for ($i = 0; $i < count($_SESSION['mypets']); $i++){

			/* Set each pets image and name for the list item below */
			$image = '<img style="float:left;" class="img-responsive perfect-fit" alt="Main Pet Pic" src="data:image/jpeg;base64,'.base64_encode( $_SESSION['mypets'][$i]['petPic'] ).'"/>';
			$name = $_SESSION['mypets'][$i]['dogName'];
           
			$listitem = <<<EOBODY
			<li>
				<div class="card">
					<div class="card-body">
						<a style="font-size: 1.5em;" href="PetInfo.php?data=$name">
							$image
							$name
						</a>
						<a href="deletePet_backend.php?data=$name" style ="float:right;">
          				<span style ="font-size:1.2em; color: #303b4f;" id="trash" class="fa fa-trash"></span>
          				</a>
					</div>
				</div>
			</li>
EOBODY;
			echo $listitem;
		}
	
	}
?>

<!-- Back to HTML -->
					</ul>
				</li>
				<li>
					<input type="checkbox" id="list-item-3">
					<label for="list-item-3" class="last"><span id="heart" class="fa fa-heart" aria-hidden="true"></span><h2>My Favorite Pets</h2></label>
					<ul class="pets-list-wrapper">

<!-- php to loop through all the users favorites -->
<?php 

	/* Incase user doesn't have any favorites */
	if (!isset($_SESSION['myfavs']) || count($_SESSION['myfavs']) < 1){
		$listitem = "<li>No Favorites</li>";
		echo $listitem;
	
	} else {
	
		/* Loop through the users fav pets from loadUsersFavs_backend */
		for ($i = 0; $i < count($_SESSION['myfavs']); $i++){

			/* Set each pets image and name for the list item below */
			$image = '<img style="float:left;" class="img-responsive perfect-fit" alt="Main Pet Pic" src="data:image/jpeg;base64,'.base64_encode( $_SESSION['myfavs'][$i]['petPic'] ).'"/>';
			$name = $_SESSION['myfavs'][$i]['dogName'];
           
			$listitem = <<<EOBODY
			<li>
				<div class="card">
					<div class="card-body">
						<a style="font-size: 1.5em;" href="PetInfo.php?data=$name">
							$image
							$name
						</a>
						<a href="deleteFav_backend.php?data=$name" style ="float:right;">
          				<span style ="font-size:1.2em; color: #303b4f;" id="trash" class="fa fa-trash"></span>
          				</a>
					</div>
				</div>
			</li>
EOBODY;
			echo $listitem;
		}
		
	}
?>
<!-- Back to HTML -->
					</ul>
				</li>
			</ul>
		</div>
	</body>
</html>