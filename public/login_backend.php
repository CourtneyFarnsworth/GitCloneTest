<?php

    require_once "db/dbLogin.php";
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
    
     /* Connecting to the database */
    $db_connection = new mysqli($host, $user, $password, $database);
    if ($db_connection->connect_error) {
        die($db_connection->connect_error);
    } else {
        //echo "Connection to database established<br>";
    }
    
    /* Setting feilds for query */
    $email = $_SESSION['email'];
    $pass = $_SESSION['password'];

    /* Setting query with hashed password */
    $query = "select * from " . $table . " where email=\"$email\" and password=password(\"$pass\")";	
    
    /* Executing query */
    $result = $db_connection->query($query);
    if (!$result) {

        /* Failed */
        die("Retrieval failed: " . $db_connection->error);
    
    } else {
        /* Success*/

        /* Number of rows found */
        $num_rows = $result->num_rows;
        if ($num_rows === 0) {

            /* Login Failed: That email password combo is NOT stored in the database */
            $_SESSION['successfulLogin'] = false;
            header("Location: index.php");

        } else {

            /* Login sucessful */
            for ($row_index = 0; $row_index < $num_rows; $row_index++) {
                $result->data_seek($row_index);
                $row = $result->fetch_array(MYSQLI_ASSOC);
                
		          /* Retrieve user results and set sessions */
                $_SESSION['email']   = $row['email'];
                $_SESSION['fullname']   = $row['fullname'];
                $_SESSION['zipcode']   = $row['zipcode'];
                
                /* Go to MainMenu.html */
                header("Location:MainMenu.html");
            }
        }
    }
    
    /* Freeing memory */
    $result->close();
    
    /* Closing connection */
    $db_connection->close();
  
?>