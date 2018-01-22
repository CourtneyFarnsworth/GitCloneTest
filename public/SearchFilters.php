<!DOCTYPE html>
<html>
  
  <head>
    <title>Search Filters</title>
    <!-- My External CSS file link-->
    <link rel="stylesheet" href="css/searchfilters.css">
    <!-- This file is has the cdns -->
    <?php include 'components/head.html';?>
  </head>
  
  <body>
    <!-- this file is the nav bar -->
    <?php include 'components/nav.html';?>
    
    <!-- Page title -->
    <h3 style="color: #303b4f; font-weight: normal; text-align: center; padding:15px;">     Search Filters
    </h3>

    <!-- Content -->
    <form action="loadSearch_backend.php" enctype="multipart/form-data" method="post">
    <div style="text-align: center;">
      
      <div style="display: inline-block; text-align: left;">
        <div class="card">
          <div class="card-body">
            <form action="loadSearch_backend.php" method="post">
              
              <p><b>Distance:</b></p>
              <section class="range-slider2">
                <span class="rangeValues2"></span>
                <input name="distance" value="500" min="0" max="3000" step="10" type="range">
              </section>
              
              <div class="form-group">
                <label><b>Breed:</b></label><br>
                <!-- this file is for smart fields it has all the breeds in it -->
                <?php include 'components/breedsInputSearch.html';?>
              </div><br>
              
              <div class="radio-inline">
                <label for="radio-inline"><b>Gender:</b></label><br>
                <label><input type="radio" value="Male" id="gender" name="gender">Male</label>
                <label><input type="radio" value="Female" id="gender" name="gender">Female</label>
              </div><br>
              
              <p><b>Age:</b></p>
              <section class="range-slider">
                <span class="rangeValues"></span>
                <input name="ageLow" value="0" min="0" max="25" step="1" type="range">
                <input name="ageHigh" value="25" min="0" max="25" step="1" type="range">
              </section>
              
              </form>
            </div>
          </div>
        </div><br><br>
        
        <input type="submit" class="btn btn-default btn-lg" id="search" value ="Search">
      </form>
    </div><br>
    
    <!-- JS for sliders -->
    <script  src="js/slider.js"></script>
  </body>
</html>