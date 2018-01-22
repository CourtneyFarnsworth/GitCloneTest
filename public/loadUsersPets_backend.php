<?php

    require_once "db/dbLoginPets.php";
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

        /* Failed to load user pets */
        die("Retrieval failed: " . $db_connection->error);
    
    } else {
        /* Sucessful load of users pets */
        
        /* Number of rows found */
        $num_rows = $result->num_rows;
        if ($num_rows === 0) {
             /* In the case the user has no pets unset the Session array and go to load users favs */
            unset($_SESSION['mypets']);
            header("Location:loadUsersFavs_backend.php");
        
        } else {

            /* Reset the users pets array */
            unset($_SESSION['mypets']);
            $_SESSION['mypets'][]=array();
            
            /* Load users pets for adoption */
            $i = 0;
            for ($row_index = 0; $row_index < $num_rows; $row_index++) {
                $result->data_seek($row_index);
                $row = $result->fetch_array(MYSQLI_ASSOC);
                
		          /* Retrieve users pets results and set sessions */
                $_SESSION['mypets'][$i]['dogName']   = $row['dogName'];
                $_SESSION['mypets'][$i]['petPic']   = $row['petPic'];
                
                $i++;
            }

          /*---------for backend testing: iterate through pets---------*/
            // for ($i = 0; $i < count($_SESSION['mypets']); $i++){
            //     echo $_SESSION['mypets'][$i]['dogName'];
            //     echo "<br>";
            // }
          /*-----------------------------------------------------------*/

            /* Go to php to load the users favorites */
            header("Location:loadUsersFavs_backend.php");
        }
    }
    
    /* Freeing memory */
    $result->close();
    
    /* Closing connection */
    $db_connection->close();
  
?>