<?php

    require_once "db/dbLoginFavorites.php";
    require_once("support.php");
    session_start();
    
    /* Go to login button incase of database error */
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
        //echo "Connection to database established<br>";
    }
    
    /* Setting query */
    $query = "select * from " . $table . " where email= " . "\"{$_SESSION['email']}\"";
    
    /* Executing query */
    $result = $db_connection->query($query);
    if (!$result) {
       
       /* Failed to load users favs */
        die("Retrieval failed: " . $db_connection->error);
    
    } else {
        /* Sucessful load of users favs */
        
        /* Number of rows found */
        $num_rows = $result->num_rows;
        
        if ($num_rows === 0) {
            /* In the case the user has no favs unset the Session array and go to MyPets.php */
            unset($_SESSION['myfavs']);
            header("Location:MyPets.php");
        
        } else {

            /* Reset the users favs array */
            unset($_SESSION['myfavs']);
            $_SESSION['myfavs'][]=array();
            
            /* Load pet names of user favs */
            $i = 0;
            for ($row_index = 0; $row_index < $num_rows; $row_index++) {
                $result->data_seek($row_index);
                $row = $result->fetch_array(MYSQLI_ASSOC);
                
		          /* Retrieve user results and set sessions */
                $_SESSION['myfavs'][$i]['dogName']   = $row['dogName'];
                
                $i++;
            }

            /*---------for backend testing: iterate through pets---------*/ 
            // for ($i = 0; $i < count($_SESSION['myfavs']); $i++){
            //             echo $_SESSION['myfavs'][$i]['dogName'];
            //             echo "<br>";
            // }
            /*-----------------------------------------------------------*/

            /* Go to loadFavPics_backend to get petPics for favs */
            header("Location:loadFavPics_backend.php");

        }
    }

    /* Freeing memory */
    $result->close();
    
    /* Closing connection */
    $db_connection->close();
  
?>