<?php
  require 'functions.php';

  $link = connectToServer();

  $newuser = $_POST["newuser"];
  $moremems = $_POST["addmems"];

  $qry = "SELECT COUNT(*) FROM Users WHERE Users.usr_ID = '" . $newuser . "' GROUP BY usr_ID;";
  $result = mysqli_query($link, $qry);

  if ( $result == TRUE) { 
    // @todo: STORED PROCEDURE
    $qry = "INSERT INTO Group_Members (grm_gro_ID, grm_usr_ID) VALUES ( '". $_COOKIE["currGroupName"]  . "', ' ". $newuser . "');";
    if (mysqli_query($link, $qry) === TRUE) {
      if ($moremems  == 'done')
        header('Location: ../home.php');
      else
        header('Location: ../home.php');
    } 
    exit();
  } else
      echo "Error2: " . $qry . "<br>" . $link->error;
?>
