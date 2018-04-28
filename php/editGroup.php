<?php
  require 'functions.php';
  $groupName = $_COOKIE["current_group"];

  // TODO: Stored Procedure
  $qry = "CALL chooseGroups('". $groupName . "')";
    
  $link = connectToServer();
  $result = mysqli_query($link, $qry);
    
  $row = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title>Edit Group</title>
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
          <h3 class="card-title">You're currently editing <?php echo stripslashes(ucwords($groupName)); ?></h3>
          <h5 class="card-title">What Do You Want to Change? </h5>
          <h5 class="card-title">Leave field blank if you wish to leave an attribute unchanged.</h5>
          <div class="form-group">
            <form action="./submitGroupEdits.php" method="POST">
              <label for="gname">Group Name:</label> 
              <input class="form-control" type="text" name="gro_ID" maxlength="50" placeholder="<?php echo $row["gro_ID"]; ?>" </input><br>
              <br>
              <label for="gown">Group Owner:</label>
              <input class="form-control" type="text" name="gro_ownerID" maxlength="20" placeholder="<?php echo $row["gro_ownerID"]; ?>" </input><br>
              <br>
              <label for="gstat">Group Status: </label>
              <input class="form-control" type="text" name="gro_Status" maxlength="1" placeholder="<?php echo $row["gro_Status"]; ?>" </input><br>
              <br>
              <input class="btn" type="hidden" name="old_groupName" value="<?php echo stripslashes($groupName); ?>">
              <input class="btn" type="Submit" name="Submit1" value="Confirm Changes">
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
            <h5><br>Current Members:</h5>

            <?php

            $link = connectToServer();

            // TODO: Stored Procedure
            $qry = "SELECT grm_usr_ID Name FROM Group_Members WHERE grm_gro_ID='$groupName' AND grm_gro_ID!=\"". $_COOKIE["current_user"] ."\"";
            $result = mysqli_query($link, $qry);

            if(mysqli_num_rows($result) > 0) {
              echo "<table class=\"table table-hover table-dark table-striped\"> <tr>  <thead class=\"thead-light\">
              <th>User Name</th> 
              <th>Remove?</th> 
              </tr></thead>";

              // Output data of each row
              while($row = mysqli_fetch_assoc($result)) {
                echo "<tr><td>" . $row["Name"] .

                // This chunk of HTML allows us to edit or delete selected entries from the database
                "<form action=\"./editGroupUsers.php\" method=\"POST\">" .
                  "</td><td>" .
                  "<input class=\"btn\" type=\"submit\" name=\"action\" value=\"Remove\"/>" .
                  "</td>" .
                  "<input type=\"hidden\" name=\"name\" value=\"" . $row["Name"] . "\"/>" .
                  "<input type=\"hidden\" name=\"group\" value=\"" . $groupName . "\"/>" .
                "</form>" .

                "</td></tr>";
              }
              echo "</table>";
              } else {
              echo "<table class=\"table table-hover table-dark table-striped\"> <tr><td>None!</td></tr> </table>";
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
  
<script src="https://cdn.jsdelivr.net/npm/js-cookie@2/src/js.cookie.min.js"></script>  
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
  
</html>

