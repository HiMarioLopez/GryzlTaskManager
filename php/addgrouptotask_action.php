<?php
  require 'functions.php';

  $link = connectToServer();

  $group = $_POST["newGroup"];
  $group = sanatize($group);

  echo "$group h";

  $qry = "CALL addGroup2Task('" . $_COOKIE["current_task"] . "', '". $group . "');";
  
  if (mysqli_query($link, $qry) === TRUE){
    if($_POST['tonext'] == "Add another group")
       header('Location: ../addgrouptotask.php');
    else if ($_POST['tonext'] == "Add this group only")
       redirectHome();
  } else
    echo "error: group not added";
  exit();
?>