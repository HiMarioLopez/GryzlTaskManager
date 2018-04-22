<?php

  require 'functions.php';

  // todo: Don't use root
  $link = connectToServer();

  $tas_ID = $_POST["taskname"];
  $tas_Priority = $_POST["priority"];
  $tas_Category = $_POST["category"];
  $tas_Progress = $_POST["progress"];
  $tas_DueDate = $_POST["duedate"];
  $oldTaskname = $_POST["old_taskname"];

  $oldTaskname = sanatize($link, $oldTaskname);
  $tas_ID = sanatize($link, $tas_ID);
  $tas_DueDate = strtotime($tas_DueDate);
  $tas_DueDate = date('Y-m-d H:i:s', $tas_DueDate);

  // Checking to see what attributes the user would like to update
  if (empty($_POST["taskname"]) && empty($_POST["duedate"])) {
  
    // Storeed Procedure
    $qry = "UPDATE Tasks SET " . 
    "tas_Priority='" . $tas_Priority . "'," .
    "tas_Category='" . $tas_Category . "'," . 
    "tas_Progress='" . $tas_Progress . "' " .
    "WHERE tas_ID='" . $oldTaskname . "'";
    
    if (mysqli_query($link, $qry) == TRUE) {
      
      header("Location: ../home.php");
      exit();
      
    } else
      echo "Error: " . $qry . "<br>" . $link->error;
  } else if (empty($_POST["taskname"]) && !empty($_POST["duedate"])) {
        
    // Stored Procedure
    $qry = "UPDATE Tasks SET " . 
    "tas_Priority='" . $tas_Priority . "'," .
    "tas_Category='" . $tas_Category . "'," . 
    "tas_Progress='" . $tas_Progress . "'," .
    "tas_DueDate='" . $tas_DueDate . "' " .
    "WHERE tas_ID=\"" . $oldTaskname . "\"";
    
    if (mysqli_query($link, $qry) == TRUE) {
      
      header("Location: ../home.php");
      exit();
    
    } else
      echo "Error: " . $qry . "<br>" . $link->error;
  } else if (empty($_POST["duedate"]) && !empty($_POST["taskname"])) {
    
    // Stored Procedure
    $qry = "UPDATE Tasks SET " . 
    "tas_ID=\"" . $tas_ID . "\"," .
    "tas_Priority='" . $tas_Priority . "'," .
    "tas_Category='" . $tas_Category . "'," . 
    "tas_Progress='" . $tas_Progress . "' " .
    "WHERE tas_ID=\"" . $oldTaskname . "\"";

    if (mysqli_query($link, $qry) == TRUE) {
      
      echo $tas_ID . "<br>";
      echo $tas_Priority . "<br>";
      echo $tas_Category . "<br>";
      echo $tas_Progress . "<br>";
      echo $oldTaskname . "<br>";
      header("Location: ../home.php");
      exit();
      
    } else
      echo "Error: " . $qry . "<br>" . $link->error;
  } else {
    
    // Stored Procedure
    $qry = "UPDATE Tasks SET " . 
    "tas_ID=\"" . $tas_ID . "\"," .
    "tas_Priority='" . $tas_Priority . "'," .
    "tas_Category='" . $tas_Category . "'," . 
    "tas_Progress='" . $tas_Progress . "'," .
    "tas_DueDate='" . $tas_DueDate . "' " .
    "WHERE tas_ID=\"" . $oldTaskname . "\"";
    
    if (mysqli_query($link, $qry) == TRUE) {
      
      echo $tas_ID . "<br>";
      echo $tas_Priority . "<br>";
      echo $tas_Category . "<br>";
      echo $tas_Progress . "<br>";
      echo $tas_DueDate . "<br>";
      echo $oldTaskname . "<br>";
      
      header("Location: ../home.php");
      exit();
      
    } else
      echo "Error: " . $qry . "<br>" . $link->error;
  } 
exit();
?>