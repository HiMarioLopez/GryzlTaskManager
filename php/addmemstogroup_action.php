<?php
  
  require 'functions.php';

  $link = connectToServer();

  $newuser = $_POST["newuser"];
  $moremems= $_POST["addmems"];

  $newuser = sanatize($link, $newuser);
  $newuser = strtolower($newuser);

  $qry = "SELECT COUNT(*) FROM Users WHERE Users.usr_ID = '$newuser' GROUP BY usr_ID;";
  $result = mysqli_query($link, $qry);

  if ( $result == TRUE) {
    
    // @TODO: STORED PROCEDURE
    $qry = "INSERT INTO Group_Members (grm_gro_ID, grm_usr_ID) 
    VALUES ( '". $_COOKIE["currGroupName"]  . "', '$newuser');";
    
    if (mysqli_query($link, $qry) === TRUE) {
      if ($moremems  == 'done')
        redirectHome();
      else
        header('Location: ../addmemstogroup.php');
    } 
    exit();
  } else {
    echo "Error2: " . $qry . "<br>" . $link->error . "<br>";
    echo "User not found! <br>";
    
    // Redirect button
    // This is using some scrappy JavaScript embeded into my PHP code...
    echo "<button id=\"myBtn\">Back to add member page!</button>" .
          "<script>" .
          "var btn = document.getElementById('myBtn');" .
          "btn.addEventListener('click', function() {" .
          "document.location.href = '../addmemstogroup.php';" .
          "});" .
          "</script>";
  }
?>
