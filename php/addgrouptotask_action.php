<?php
  require 'functions.php';

  if(isset($_POST["newGroup"])) {
    
    $link = connectToServer();

    $group = $_POST["newGroup"];
    $group = sanatizeNoSpecial($link, $group);  
    $group = strtolower($group);

    $qry = "CALL addGroup2Task('" . $_COOKIE["current_task"] . "', '" . $_COOKIE["current_category"] . "', '" . $_COOKIE["current_user"] . "', '" . $group . "')";

    mysqli_query($link, $qry);
    
  }

  header('Location: ../addgrouptotask.php');
  exit();
?>