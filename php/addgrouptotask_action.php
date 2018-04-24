<?php
  require 'functions.php';

  $link = connectToServer();

  $group = $_POST["newGroup"];
  $group = sanatizeNoSpecial($link, $group);  
  $group = strtolower($group);

  $qry = "CALL addGroup2Task('" . $_COOKIE["current_task"] . "', '" . $_COOKIE["current_category"] . "', '" . $_COOKIE["current_user"] . "', '" . $group . "')";

  if (mysqli_query($link, $qry) === TRUE){
    if($_POST['tonext'] == "Add another group")
       header('Location: ../addgrouptotask.php');
    else if ($_POST['tonext'] == "Add this group only")
       redirectHome();
  } else
    echo "error: group not added";
  exit();
?>