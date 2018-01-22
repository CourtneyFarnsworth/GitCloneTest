<?php
require_once("../support.php");

/* Attempt MySQL server connection. Assuming you are running MySQL
server with default setting (user 'root' with no password) */
$link = mysqli_connect("localhost", "root", "");
 
// Check connection
if($link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}

if (isset($_POST['drop'])){
    // Attempt drop database query execution
    $sql = "DROP DATABASE paws";
    if(mysqli_query($link, $sql)){
        echo "Database dropped successfully.<br>";
    } else{
        echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
    }
}

if (isset($_POST['setup'])){
// Attempt create database query execution
$sql = "CREATE DATABASE paws";
if(mysqli_query($link, $sql)){
    echo "Database created successfully.<br>";
} else{
    echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
}


// Attempt to use database
$sql = "use paws";
if(mysqli_query($link, $sql)){
    echo "Using database paws.<br>";
} else{
    echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
}

 /*----------------------------- vv Tables vv ----------------------------*/
// Attempt create users table query execution
$sql = "CREATE TABLE users(
    email VARCHAR(70) NOT NULL UNIQUE PRIMARY KEY,
    password VARCHAR(100) NOT NULL,
    fullname VARCHAR(100) NOT NULL,
    zipcode int NOT NULL
)";

if(mysqli_query($link, $sql)){
    echo "Users table created successfully.<br>";
} else{
    echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
}

// Attempt to set up users table login & password
$sql = "GRANT ALL ON paws.users TO dbuser@localhost IDENTIFIED BY 'goodbyeWorld'";
if(mysqli_query($link, $sql)){
    echo "Login credentials for users table established.<br>";
} else{
    echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
}

// Attempt create pets table query execution
$sql = "CREATE TABLE pets(
    email VARCHAR(70) NOT NULL,
    zipcode int NOT NULL,
    dogName VARCHAR(70) UNIQUE PRIMARY KEY,
    age int NOT NULL,
    breed VARCHAR(70) NOT NULL,
    gender VARCHAR(70) NOT NULL,
    specialNeeds VARCHAR(70) NOT NULL,
    aboutPet VARCHAR(100) NOT NULL,
    petPic longblob NOT NULL
)";

if(mysqli_query($link, $sql)){
    echo "Pets table created successfully.<br>";
} else{
    echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
}

// Attempt to set up users table login & password
$sql = "GRANT ALL ON paws.pets TO dbuser@localhost IDENTIFIED BY 'goodbyeWorld'";
if(mysqli_query($link, $sql)){
    echo "Login credentials for pets table established.<br>";
} else{
    echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
}

// Attempt create favorites table query execution
$sql = "CREATE TABLE favorites(
    email VARCHAR(70) NOT NULL,
    dogName VARCHAR(70) UNIQUE PRIMARY KEY
)";

if(mysqli_query($link, $sql)){
    echo "Favorites table created successfully.<br>";
} else{
    echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
}

// Attempt to set up users table login & password
$sql = "GRANT ALL ON paws.favorites TO dbuser@localhost IDENTIFIED BY 'goodbyeWorld'";
if(mysqli_query($link, $sql)){
    echo "Login credentials for favorites table established.<br>";
} else{
    echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
}
/*----------------------------- ^^ Tables ^^ ----------------------------*/ 

// Close connection
mysqli_close($link);
}



$body = <<<EOBODY
<body>
    <form action="$_SERVER[PHP_SELF]" method="post">
        <input type="submit" name="drop" value="Drop Database" /> 
        <input type="submit" name="setup" value="Setup Database" /><br>
    </form>
</body>
EOBODY;

echo generatePage($body, "Admin", "", "");
?>
