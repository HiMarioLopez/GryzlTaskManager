<?php
  require 'functions.php';

  $link = connectToServer();

  // @todo: STORED PROCEDURE
  $qry = "INSERT INTO Task_Groups (tgr_tas_ID, tgr_gro_ID) VALUES ('" . $_COOKIE["currTaskName"] . "', '" . $_POST["newGroup"] . "');";
  
  if (mysqli_query($qry, $link) === TRUE){
    
    if($_POST['tonext'] == "Add another group")
       header('Location: ./addgrouptotask.html');
    
    else if ($_POST['tonext'] == "Add this group only"){
       redirectHome();
      
  } else
    echo "error: " . mysqli_query($qry, $link)->error_log;
  exit();
?>