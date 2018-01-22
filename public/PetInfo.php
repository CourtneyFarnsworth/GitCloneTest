<!DOCTYPE html>
<html>
	<head>
		<title>Pet Info</title>
		<!-- My External CSS file link-->
		<link rel="stylesheet" href="css/petinfo.css">
		<!-- This file is has the CDNs -->
    	<?php include 'components/head.html';?>
	</head>
	<body>
		
		<!-- Nav Bar  -->
		<nav class="navbar navbar-expand-lg navbar-light bg-light">
			<a class="navbar-brand" href="MyPets.php"> <span class="fa fa-chevron-left" id="back" aria-hidden="true"></span> Back</a>
			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
			</button>

			<div class="collapse navbar-collapse" id="navbarSupportedContent">
				<ul class="nav navbar-nav navbar-right">
					<li class="nav-item">
						<a class="nav-link" href="MainMenu.html">Home <span class="sr-only">(current)</span></a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="loadUsersPets_backend.php">My Pets</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="SearchFilters.php">Search Filters</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="index.php">Log Out</a>
					</li>
				</ul>
			</div>
		</nav>

		<!-- Page title -->
    	<h3 style="color: #303b4f; font-weight: normal; text-align: center; padding-top:15px;">My Pet's Info</h3>

	
<!-- php to set the pets info -->	
<?php
	session_start();
	require_once "db/dbLoginPets.php";
    require_once("calculateDistance_backend.php");
  
	/* Get data field sent through link in MyPets */
    if(isset($_GET["data"])) {
        $dogName = $_GET["data"];
    
    /* Connecting to database */
    $db_connection = new mysqli($host, $user, $password, $database);
    if ($db_connection->connect_error) {
        die($db_connection->connect_error);
    } else {
        // echo "Connection to database established<br>";
    }

	/* Setting query */
    $query = "select * from " . $table . " where dogName = \"" . $dogName . "\"";	
    
    /* Executing query */
    $result = $db_connection->query($query);
    if (!$result) {

    	/* Failed */
        die("Retrieval failed: " . $db_connection->error);
    
    } else {
        /* Success */

        /* Number of rows found */
        $num_rows = $result->num_rows;
        if ($num_rows === 0) {
            
            /* No pets by that name were found in the database */
            echo "<h2>That pet could not be found in Database</h2>";
        
        } else {
            
            /* Loading found pet information */
            for ($row_index = 0; $row_index < $num_rows; $row_index++) {
                $result->data_seek($row_index);
                $row = $result->fetch_array(MYSQLI_ASSOC);
                
		      	/* Retrieve pet results and set fields */
                $email   = $row['email'];
                $name   = $row['dogName'];
                $age   = $row['age'];
                $gender = $row['gender'];
                $breed = $row['breed'];
                $specialNeeds = $row['specialNeeds'];
                $aboutPet = $row['aboutPet'];
                $petPic   = $row['petPic'];
                $zipcode  = $row['zipcode'];
                
               
            }
        }

        /* Set other fields to be displayed */
        $userEmail =$_SESSION['email'];
		$image = '<img class="img-responsive perfect-fit" alt="Main Pet Pic" src="data:image/jpeg;base64,'.base64_encode( $petPic).'"/>';
		$long = $_SESSION['pets'][$_SESSION['start']]['long'];
		$lat = $_SESSION['pets'][$_SESSION['start']]['lat'];
		$city = $_SESSION['pets'][$_SESSION['start']]['city'];
		$state = $_SESSION['pets'][$_SESSION['start']]['state'];

	}


$content = <<<EOBODY
<!-- CONTENT  -->
<div class="container-fluid" id="content">
	<div class="petPic row">
		<div class="col-lg-2 col-md-2 col-sm-1 col-xs-1"></div>
		<div class="mainPetPic col-lg-7 col-md-8 col-sm-10 col-xs-10">
			$image
		</div>
	</div>
	<div class="petInfo row">
		<div class="col-lg-2 col-md-2 col-sm-1 col-xs-1"></div>
		<div class="col-lg-8 col-md-8 col-sm-10 col-xs-10">
			<ul>
				<li><h3>$name</h3></li>
			</ul>
		</div>
	</div>
	
	<div class="petInfoDetails row">
		<div class="col-lg-2 col-md-2 col-sm-1 col-xs-1"></div>
		<div class="petTitles col-lg-7 col-md-8 col-sm-10 col-xs-10">
			<div class="card">
				<div class="card-body">
					<ul class="petList">
						<li><b>Location:</b> <span>$city, $state</span></li>

						<li><b>Age:</b> $age years</li>
						<li><b>Breed:</b>$breed</li>
						<li><b>Gender:</b> $gender</li>
						<li><b>Special Needs:</b> $specialNeeds</li>
						<hr>
						<li><b>About:</b> <span> $aboutPet</span></li>
					</ul>
				</div>
			</div>
		</div>
	</div>
	
</div>
EOBODY;
		
		/* Display all the pets information */
		echo $content;
	
	} else {

		/* No pet name was sent through the data field on MyPets.php <a href> */
		echo "Something went wrong when sending data field from My Pets Page";
	}
?>
<!-- Back to HTML -->
	</body>
</html>