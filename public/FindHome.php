<?php

require_once("db/dbLoginPets.php");
require_once("support.php");

session_start();

if (isset($_POST['submit'])) {
    
    /* Set session fields for the pet being inserted to the database */    
    /* Email and zipcode are already set with login_backend.php */
    $_SESSION['petsName']= $_POST['petsName'];
    $_SESSION['age'] = $_POST['age'];
    $_SESSION['gender'] = $_POST['gender'];
    $_SESSION['breed'] = $_POST['breed'];
    $_SESSION['specialNeeds'] = $_POST['specialNeeds'];
    $_SESSION['aboutPet'] = $_POST['aboutPet'];
    
        /* Read file image into $_SESSION['petPic'] */
        if (isset($_FILES['image']) && $_FILES['image']['size'] > 0) {
            
            /* Temporary file name stored on the server */
            $tmpName = $_FILES['image']['tmp_name'];
            
            /* Read the file */
            $fp = fopen($tmpName, 'r');
            $petPic = fread($fp, filesize($tmpName));
            $_SESSION['petPic'] = addslashes($petPic);
            fclose($fp);
        
        } else {
            
            /* Error handeling */
            echo "No file was selected<br>";
        }

        /* Connecting to the database */
        $db_connection = new mysqli($host, $user, $password, $database);
        if ($db_connection->connect_error) {
            die($db_connection->connect_error);
        } else {
            //echo "Connection to database established<br>";
        }
    
        /* Setting up query */
        $query = "insert into " . $table . " values(\"{$_SESSION['email']}\", \"{$_SESSION['zipcode']}\", \"{$_SESSION['petsName']}\", \"{$_SESSION['age']}\", \"{$_SESSION['breed']}\", \"{$_SESSION['gender']}\", \"{$_SESSION['specialNeeds']}\", \"{$_SESSION['aboutPet']}\", \"{$_SESSION['petPic']}\")";
    
        /* Executing query */
        $result = $db_connection->query($query);
        if (!$result) {
            die("Insertion failed: " . $db_connection->error);
        } else {
            /* Pet insert into database successfully */
            /* Go to Main Menu */
            header("Location: MainMenu.html");
        }

        /* Closing connection */
        $db_connection->close();
    }
?>

<!-- HTML for find home -->
<head>
    <title>Find Home</title>
    <!-- My External JS file links -->
    <script src="js/findhome.js"></script>
    
    <!-- This file is has the CDNs -->
    <?php include 'components/head.html';?>
</head>
<body>

    <!-- This file has the nav bar -->
    <?php include 'components/nav.html';?>

    <!-- Page title -->
    <h3 style="color: #303b4f; font-weight: normal; text-align: center; padding:15px;">     Find a Home
    </h3>

    <!-- Content -->
    <div style="text-align: center;">
        <div style="display: inline-block; text-align: left;">
            <form action="FindHome.php" enctype="multipart/form-data" method="post">
                <fieldset>
                    <!-- Upload image -->
                    <div class="card" style="background-color: #f8f9fa;">
                        <div class="card-body">
                        <h4 class="card-title"></h4>
                        <h6 class="card-subtitle mb-2 text-muted">Upload your pet's picture</h6>

                        <input name="MAX_FILE_SIZE" value="102400" name="petPic" type="hidden">
                        <input name="image" accept="image/jpeg/png" name="petPic" type="file">
                        </div>
                    </div><br>

                    <b>Pet's Name:</b>
                    <input type="text" name="petsName" required/><br><br>
                    <b>Breed:</b>
                    <!-- This file is for smart text fields contains all the breeds -->
                    <?php include 'components/breedsInput.html';?><br><br>
                    <b>Gender:</b>&nbsp&nbsp
                    <input type="radio" name="gender" id = "Male" value="Male" />&nbsp Male&nbsp&nbsp
                    <input type="radio" name="gender" id = "Female" value="Female" />&nbsp Female<br><br>
                    <b>Age:</b>
                    <input type="number" name="age" min="1" max="20" required><br><br>
                    <b>Special Needs:</b>
                    <input type="text" name="specialNeeds"/><br><br>
                    <b>About Pet:</b><br>
                    <textarea name="aboutPet" rows="6" cols="40" required></textarea><br><br>
                    <div class="row">
                        <div class="col-md-12 col-lg-12 text-center">
                            <input type="submit" id="submit" name="submit" class="btn btn-default btn-lg" value="Add Pet" style="background: #303b4f;color: white;"/><br><br>
                        </div>
                    </div>
                </fieldset>
            </form>
        </div>
    </div>
</body>