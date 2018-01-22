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
    
    for ($i = 0; $i < count($_SESSION['myfavs']); $i++){
    
        /* Setting query */
        $query = "select petPic from " . $table . " where dogName=\"{$_SESSION['myfavs'][$i]['dogName']}\"";
   
    
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
                /* no pictures found */
            } else {

                /* Load the users favorite pet pics into Session array */    
                for ($row_index = 0; $row_index < $num_rows; $row_index++) {
                    $result->data_seek($row_index);
                    $row = $result->fetch_array(MYSQLI_ASSOC);
                
		          /* Retrieve pet image */
                    $_SESSION['myfavs'][$i]['petPic']   = $row['petPic'];
                }

                /*---------for backend testing: iterate through pets to see loaded pictures---------*/
                // for ($i = 0; $i < count($_SESSION['myfavs']); $i++){
                //     $image = '<img style="float:left;" class="img-responsive perfect-fit" alt="Main Pet Pic" src="data:image/jpeg;base64,'.base64_encode( $_SESSION['myfavs'][$i]['petPic'] ).'"/>';
                //     echo $image;
                //     echo "<br>";
                // }
                /*----------------------------------------------------------------------------------*/

                /* Go to MyPets.php page */
                header("Location:MyPets.php");
            }
        }
    }
    
    /* Freeing memory */
    $result->close();
    
    /* Closing connection */
    $db_connection->close();
  
?>