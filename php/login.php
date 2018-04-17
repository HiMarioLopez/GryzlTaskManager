<!-- What this page currently does (4.15.2018)
  Mario
     - Changed from natural join to inner join to suit new db schema.
     - Added check for administrator accounts vs public accounts.
     - Added correct links to new pages once you've successfully logged in.
     - Attempted to add cookie. Am I doing this right?
-->

<!-- What this page need (4.15.2018)
     - Check to see if the cookie is set correctly.
-->

<?php
  require 'functions.php';
  
  // todo: Don't use root
  $link = connectToServer();

  $username = $_POST["username"];
  $password = $_POST["password"];
  
  $username = sanatize($link, $username);
  $password = sanatize($link, $password);
  $username = strtolower($username);

  $query = "SELECT pri_type FROM Users INNER JOIN Privileges ON usr_ID = pri_usr_ID WHERE usr_ID = '" . $username . "' AND usr_Password='" . $password . "'";
  $result = mysqli_query($link, $query);
  $row = mysqli_fetch_array($result, MYSQLI_ASSOC);

  if (mysqli_num_rows($result) == 1) {
    
    setGryzlCookie("current_user", $username);
    
    if($row["pri_type"] == 'ad') {
      header("Location: ../adminhome.php");
    } else if($row["pri_type"] == 'pb') {
      header("Location: ../home.php");
    }
  } else {
    printf("Login failed! Please check username and/or password.");
  }

  /* We make sure we always close connection and free our result sets */
  mysqli_free_result($result);
  mysqli_close($link);
  exit();
?>