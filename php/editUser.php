<?php

require 'functions.php';

if ($_POST['action'] && $_POST['id']) {
	// Editing a user!  
	if ($_POST['action'] == 'Edit') {
    
    $link = connectToServer();
    $userName = $_POST['id'];

    $qry = "CALL UserLoginandExist( '" . $userName . "')";
    $result = mysqli_query($link, $qry);
    
    $row = mysqli_fetch_assoc($result);
    
	// Deleting a user!
  } else if($_POST['action'] == 'Delete') {
    
    $link = connectToServer();
    $userName = $_POST['id'];
    
    // TODO: Stored Procedure
    $qry = "CALL deleteFromUsers ('" . $userName . "')";
    
    if(mysqli_query($link, $qry))
      redirectHome();
    else
      echo "Error: " . $qry . "<br>" . $link->error;
    
    exit();
  }
}

?>

<!DOCTYPE html>
<html>
<head>
	<title>Edit User</title>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
	<link rel="stylesheet" type="text/css" href="../css/style.css">
	<link href="https://fonts.googleapis.com/css?family=Roboto+Condensed" rel="stylesheet">
</head>
<body>
  
  <div class="container-fluid bg">
    <div class="d-flex p-4">
      <div class="card mx-auto my-auto bg-dark text-light">
        <div class="card-body">
          <h4 class="card-title">You're currently editing user <?php echo ucwords($userName); ?></h4>
          <h4 class="card-title">So What Do You Want to Change? </h4>
          <h5>Leave field blank if you wish to leave an attribute unchanged. </h5>
          <div class="form-group">
            <form action="./submitUserEdits.php" method="POST">
              <label for="uname">User Name:</label>
              <input id="uname" class="form-control" type="text" name="usr_ID" maxlength="20" <?php echo "placeholder=\"" . $userName . "\"" ?> </input><br>
              <br>
              <label for="uemail">User Email:</label>
              <input id="uemail" class="form-control" type="email" name="usr_Email" maxlength="50" <?php echo "placeholder=\"" . $row["usr_Email"] . "\"" ?> </input><br>
              <br>
              <label for="upass">User Password:</label>
              <input id="upass" class="form-control" type="text" name="usr_Password" maxlength="255" <?php echo "placeholder=\"" . $row["usr_Password"] . "\"" ?> </input><br>
              <br>
              <label for="upri">User Privilege Level:</label>
              <input id="upri" class="form-control" type="text" name="pri_type" maxlength="2" <?php echo "placeholder=\"" . $row["pri_type"] . "\"" ?> </input><br>
              <br>
                <input type="hidden" name="old_username" value="<?php echo $userName ?>">
                <input class="btn" type="Submit" name="Submit1" value="Confirm Changes">
                <input class="btn" type="Submit" name="Submit2" value="Remove Groups?">
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