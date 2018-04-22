<?php
  require 'functions.php';

  $link = connectToServer();

  $group = $_POST["newGroup"];
  $group = sanatize($group);

  // @TODO: STORED PROCEDURE
  $qry = "INSERT INTO Task_Groups (tgr_tas_ID, tgr_gro_ID) VALUES ('" . $_COOKIE["current_task"] . "', \"$group\")";
  
  if (mysqli_query($link, $qry) === TRUE){
    if($_POST['tonext'] == "Add another group")
       header('Location: ../addgrouptotask.php');
    else if ($_POST['tonext'] == "Add this group only")
       redirectHome();
  } else
    echo "error: YOUR SHIT BROKE";
  exit();
?>