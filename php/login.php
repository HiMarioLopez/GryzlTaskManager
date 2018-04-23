<?php
  include_once 'functions.php';
  
  $link = connectToServer();

  $username = $_POST["username"];
  $password = $_POST["password"];
  
  $username = sanatize($link, $username);
  $password = sanatize($link, $password);
  $username = strtolower($username);

  $query = "CALL userLoginandExist('" . $username . "')";

  $result = mysqli_query($link, $query);

  //it is breaking here - jordan
  $row = $result->fetch_assoc();
  

  if(password_verify($password, $row["usr_Password"])) {
        
    // Setting cookie to store what user is currently logged in for this session
    setGryzlCookie("current_user", $username);
    setGryzlCookie("current_user_permissions", $row["pri_type"]);
    
    // Check to see if user is an administrator or public user.
    if($row["pri_type"] == 'ad')
      header("Location: ../adminhome.php");
    else
      header("Location: ../home.php");

    } else {
        echo "<h2>Login failed! Please check username and/or password.<br></h2>";

        // Redirect button
        // This is using some scrappy JavaScript embeded into my PHP code...
        echo "<button id=\"myBtn\">Back to login!</button>" .
              "<script>" .
              "var btn = document.getElementById('myBtn');" .
              "btn.addEventListener('click', function() {" .
              "document.location.href = '../login.html';" .
              "});" .
              "</script>";
    }

  // We make sure we always close connection and free our result sets
  mysqli_free_result($result);
  mysqli_close($link);
  exit();
?>