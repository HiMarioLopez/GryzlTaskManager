<?php
  require 'functions.php';
  
  $link = connectToServer();

  $groupName = $_POST["groupname"];
  $groupName = strtolower($groupName);
  $groupName = sanatize($link, $groupName);

  // @TODO: STORED PROCEDURE
  $qry = "INSERT INTO Groups VALUES ( '". $groupName . "', '". $_COOKIE["current_user"] . "', 'a');";
  if (mysqli_query($link, $qry) === TRUE) {
    // @TODO: STORED PROCEDURE
    $qry = "INSERT INTO Group_Members VALUES ('" . $groupName . "', '" . $_COOKIE["current_user"] . "');";
    if(mysqli_query($link, $qry) == TRUE) {
      setGryzlCookie("currGroupName", $groupName);
      header('Location: ../addmemstogroup.php');
      exit;
    } else
      echo "Error: " . $qry . "<br>" . $link->error;
  } else
      echo "Error: " . $qry . "<br>" . $link->error;
?>
