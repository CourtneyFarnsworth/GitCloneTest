<?php
    
    require_once ("db/dbLoginFavorites.php");
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
    
    /* Connecting to the database */
    $db_connection = new mysqli($host, $user, $password, $database);
    if ($db_connection->connect_error) {
        die($db_connection->connect_error);
    } else {
        //echo "Connection to database established<br>";
    }
    
    /* Setting up query */
    $query = "insert into " . $table . " values(\"{$_SESSION['email']}\", \"{$_SESSION['pets'][$_SESSION['start']]['dogName']}\")";
echo $query;

    /* Executing query */
    $result = $db_connection->query($query);

    if (!$result) {
        
        /* Failed to insert favorite pet */
        die("Insertion failed: " . $db_connection->error . $body);
        // header("Location:PetProfile.php");
    } else {
        
        /* Sucessfully inserted favorite Pet */
        header("Location:PetProfile.php");
    }
    
    /* Closing connection */
    $db_connection->close();
?>