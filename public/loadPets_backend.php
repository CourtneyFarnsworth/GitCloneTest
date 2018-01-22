<?php

    require_once "db/dbLoginPets.php";
    require_once("support.php");
    require_once("calculateDistance_backend.php");
    session_start();
    
      /* Go to login button incase of error */
    if (isset($_POST['goToIndex'])) {
        header("Location: index.php");
    }
    $body = <<<EOBODY
  <form action="$_SERVER[PHP_SELF]" method="post">
        <input type="submit" name="goToIndex" value="Return to Log In" /><br><br>
    </form>
EOBODY;
    
    /* Connecting with database */
    $db_connection = new mysqli($host, $user, $password, $database);
    if ($db_connection->connect_error) {
        die($db_connection->connect_error);
    } else {
        // echo "Connection to database established<br>";
    }
    
    /* Setting query */
    $query = "select * from " . $table . " where email != " . "\"{$_SESSION['email']}\"";	
    
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
            
            /* No pets found in database */
            echo "<h2>No Pets in Database with the selected search filters</h2>" . $body;
        
        } else {
            
            /* Clear previouslly uploaded pets and reset variable to reload pets */
            unset($_SESSION['pets']);
            $_SESSION['pets'][]=array();
            
            /* Loading pets info into Sessions array for PetProfile.php */
            $i =0;
            for ($row_index = 0; $row_index < $num_rows; $row_index++) {
                $result->data_seek($row_index);
                $row = $result->fetch_array(MYSQLI_ASSOC);
                
		          /* Retrieve pet results and set sessions */
                $_SESSION['pets'][$i]['email']   = $row['email'];
                $_SESSION['pets'][$i]['dogName']   = $row['dogName'];
                $_SESSION['pets'][$i]['age']   = $row['age'];
                $_SESSION['pets'][$i]['gender']   = $row['gender'];
                $_SESSION['pets'][$i]['breed']   = $row['breed'];
                $_SESSION['pets'][$i]['specialNeeds']   = $row['specialNeeds'];
                $_SESSION['pets'][$i]['aboutPet']   = $row['aboutPet'];
                $_SESSION['pets'][$i]['petPic']   = $row['petPic'];
                $_SESSION['pets'][$i]['zipcode']   = $row['zipcode'];
                
                $i++;
            }
            
            /* Set pointer in the "find a pet" array for PetProfile.php */
            $_SESSION['start']=0;


            /* Iterate through the pet array to load distance field */
            /* API call getDistance in calculateDistance_backend.php */
            for ($i = 0; $i < count($_SESSION['pets']); $i++){
                /* Returns the distance from users zipcode to pets zipcode */
                /* API only allows 100 calls per day */
                $distance = getDistance($_SESSION['zipcode'], $_SESSION['pets'][$i]['zipcode']);
                $_SESSION['pets'][$i]['distance'] = $distance;

                /* Returns the an array with long lat city state */
                /* API only allows 100 calls per day */
                $distance = getLongAndLat($_SESSION['pets'][$i]['zipcode']);
                $_SESSION['pets'][$i]['long'] = $distance['long'];
                $_SESSION['pets'][$i]['lat'] = $distance['lat'];
                $_SESSION['pets'][$i]['city'] = $distance['city'];
                $_SESSION['pets'][$i]['state'] = $distance['state'];

            }

            /* Go to Pet Profiles */
            header("Location:PetProfile.php");
        }
    }
    
    /* Freeing memory */
    $result->close();
    
    /* Closing connection */
    $db_connection->close();
  
?>