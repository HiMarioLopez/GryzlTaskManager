<?php

require 'functions.php';

$link = connectToServer();

$groupToRemove = $_POST["toRemove"];
$groupToRemove = sanatize($link, $groupToRemove);

// TODO: Stored Procedure
$qry = "DELETE FROM Task_Groups WHERE tgr_gro_ID='$groupToRemove'";

if(mysqli_query($link, $qry))
  header("Location: ./removeGroups.php");
else
  echo "Error: " . $qry . "<br>" . $link->error;
  
exit();

?>