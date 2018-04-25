<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Add Group</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
  <link rel="stylesheet" type="text/css" href="../css/style.css">
  <link rel="stylesheet" type="text/css" href="../css/tablestyles.css">
  <link href="https://fonts.googleapis.com/css?family=Roboto+Condensed" rel="stylesheet">
</head>

<body>
  
   <div class="container-fluid bg">
    <div class="d-flex p-4">
      <div class="card mx-auto my-auto bg-dark text-light">
        <div class="card-body">
          <h4 class="card-title">Remove a Group</h4>
          <h5>Please enter the name of the group.</h5>
          <div class="form-group">
          <h3>Remove groups from the tasks "<?php echo $_COOKIE["current_task"] ?>"</h3>
            <form action="./removeGroups_action.php" method="post">
              <label for="gname">Group Name:</label> 
              <input id="gname" class="form-control" type="text" name="toRemove" maxlength="50"><br></p>
              <input class="btn" type="submit" value="Remove Another Group">
            </form>
            <br><button class="btn btn-outline-success my-2 my-sm-0" id="home_button" type="submit">Go Back Home</button>
            <script>
              var btn = document.getElementById('home_button');
              btn.addEventListener('click', function() {
                var value = Cookies.get('current_user_permissions');
                console.log(value);
                if(value === "ad") document.location.href = '../adminhome.php';
                else document.location.href = '../home.php';
              });
            </script>
            <h3><br>Groups Tagged:</h3>

            <?php
              include_once 'functions.php';

              $link = connectToServer();

              $qry = "SELECT tgr_gro_ID GroupName, gro_ownerID Owner 
                      FROM Task_Groups INNER JOIN Groups ON gro_ID=tgr_gro_ID WHERE tgr_tas_ID='" . $_COOKIE["current_task"] . "'";
              $result = mysqli_query($link, $qry);

              if(mysqli_num_rows($result) > 0) {
                echo "<table class=\"table table-hover table-dark table-striped\"> <thead class=\"thead-light\"><tr> 
                <th scope=\"col\">GroupName</th> 
                <th scope=\"col\">Owner</th> 
                </thead></tr>";

                // Output data of each row
                while($row = mysqli_fetch_assoc($result)) {
                  echo "<tr><td scope=\"row\">" . $row["GroupName"] .
                  "</td><td scope=\"row\">" . ucwords($row["Owner"]) .
                  "</td></tr>";
                }
                echo "</table>";
                } else {
                echo "<table class=\"table table-dark\"> <tr><td>None!</td></tr> </table>";
              }

              mysqli_free_result($result);
              mysqli_close($link);
            ?>

          </div>
          <!-- Form Group -->
        </div>
        <!-- Card Body -->
      </div>
      <!-- Card -->
    </div>
    <!-- Flex Box -->
  </div>
  <!-- Container -->
  
</body>

<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/js-cookie@2/src/js.cookie.min.js"></script>  

</html>