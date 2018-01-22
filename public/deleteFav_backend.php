<?php
    
    require_once ("db/dbLoginFavorites.php");
    session_start();

    /* Get dogName to be deleted passed in by link in MyPets.php */
    if(isset($_GET["data"])) {
        $dogName = $_GET["data"];
    }

    /* Go to login button incase of database error */
    if (isset($_POST['goToIndex'])) {
        header("Location: index.php");
    }
    
    $body = <<<EOBODY
    <form action="$_SERVER[PHP_SELF]" method="post">
        <input type="submit" name="goToIndex" value="Return to Log In" /><br><br>
    </form>
EOBODY;
    
    /* Connecting to the database */
    $db_connection = new mysqli($host, $user, $password, $database);
    if ($db_connection->connect_error) {
        die($db_connection->connect_error);
    } else {
        //echo "Connection to database established<br>";
    }
    
    /* Setting query */
    $query = "delete from " . $table . " where dogName =\"$dogName\"";
   

    /* Executing query */
    $result = $db_connection->query($query);
    if (!$result) {   
       
        /* Failed error message with button to login */
        die("Delete failed: " . $db_connection->error . $body);
    
    } else {
        
        /* Delete sucessful */
        /* Go to refresh all the user fields then MyPets */
        header("Location:loadUsersPets_backend.php");
    }
    
    /* Closing connection */
    $db_connection->close();
?>