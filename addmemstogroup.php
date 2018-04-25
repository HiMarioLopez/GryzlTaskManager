<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Add Members</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
  <link rel="stylesheet" type="text/css" href="./css/style.css">
  <link rel="stylesheet" type="text/css" href="./css/tablestyles.css">
	<link href="https://fonts.googleapis.com/css?family=Roboto+Condensed" rel="stylesheet">
</head>

<body>

  <div class="container-fluid bg">
    
<!--     Logout and Home Buttons -->
<!--   <div align="right">
    <form class="btn-group" action="./php/addmemstogroup_action.php" method="post">
      <input class="btn" type="submit" name="actions" value="Home"></input>
      <input class="btn" type="submit" name="actions" value="Logout"></input>
    </form>
  </div> -->
    
    <div class="d-flex p-4">
      <div class="card mx-auto my-auto bg-dark text-light">
        <div class="card-body">
          <h4 class="card-title">Add Group members</h4>
          <div class="form-group">
            <form action="./php/addmemstogroup_action.php" method="post">
              <label for="name">User to add:</label> 
              <input class="form-control" id="name" type="text" name="newuser" maxlength="20" required><br></p>
              <p>Would you like to add more group members? <br></p>
              <input type="radio" name="addmems" value="add"> Yes!<br>
              <input type="radio" name="addmems" value="done"> No!<br>
              <input class="btn" type="submit">
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
          </div>
          <!-- Form Group -->
        
        <h3>Users Already In Group:</h3>
  
        <!-- Display a table of all users in the database that are not  -->
        <!-- currently already in the group -->
        <?php
          include_once './php/functions.php';

          $link = connectToServer();

          // TODO: Stored Procedure
          $qry = "SELECT grm_usr_ID Name FROM Group_Members 
                  WHERE grm_gro_ID = '".$_COOKIE["currGroupName"]."'
                  AND grm_usr_ID != '".$_COOKIE["current_user"]."'";
          $result = mysqli_query($link, $qry);

          if(mysqli_num_rows($result) > 0) {
            echo "<table class=\"table table-hover table-dark table-striped\"> <tr> <thead class=\"thead-light\"> 
            <th>Name</th>
            </tr></thead>";

            // Output data of each row
            while($row = mysqli_fetch_assoc($result)) {
              echo "</td><td>" . ucwords($row["Name"]) .
              "</td></tr>";
            }
            echo "</table>";
            } else {
            echo "<table class=\"table table-hover table-dark table-striped\"> <tr><td>None!</td></tr> </table>";
          }

        mysqli_close($link);
        ?>

        <h3>Available Users:</h3>

        <!-- Display a table of all users in the database that are not  -->
        <!-- currently already in the group -->
        <?php
          include_once './php/functions.php';

          $link = connectToServer();
          
          // TODO: Stored Procedure
          $qry = "SELECT usr_ID Name FROM Users WHERE usr_ID NOT IN 
                  (SELECT grm_usr_ID FROM Group_Members 
                  WHERE grm_gro_ID='".$_COOKIE["currGroupName"]."')";

          $result = mysqli_query($link, $qry);

          if(mysqli_num_rows($result) > 0) {
            echo "<table class=\"table table-hover table-dark table-striped\"> <tr> <thead class=\"thead-light\"> 
            <th>Name</th>
            </tr></thead>";

            // Output data of each row
            while($row = mysqli_fetch_assoc($result)) {
              echo "</td><td>" . ucwords($row["Name"]) .
              "</td></tr>";
            }
            echo "</table>";
            } else {
            echo "<table class=\"table table-hover table-dark table-striped\"> <tr><td>None!</td></tr> </table>";
          }

        mysqli_close($link);
        ?>
        
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