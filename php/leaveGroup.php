<?php 
  echo "Leaving!";

  require 'functions.php';

  $link = connectToServer();

  $group_ID = $_POST["id"];
  $user_ID = $_POST["uname"];

  $group_ID = sanatize($link, $group_ID);
  $user_ID = sanatize($link, $user_ID);
  
  // TODO: Stored Procedure
  $qry = "DELETE FROM Group_Members WHERE grm_gro_ID='$group_ID' AND grm_usr_ID='$user_ID'";

  if(mysqli_query($link, $qry))
    redirectHome();
  else
    echo "Error: " . $qry . "<br>" . $link->error;

  exit();
?>