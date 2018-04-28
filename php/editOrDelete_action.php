<?php
  require 'functions.php';

if ($_POST['action'] && $_POST['id']) {
	// Editing a group!  
	if ($_POST['action'] == 'Edit') {
    $groupName = $_POST['id'];
    
    $link = connectToServer();
    $groupName = sanatize($link, $groupName);
    setGryzlCookie("current_group", $groupName);
    
    header("Location: ./editGroup.php");
    exit();
    
	// Deleting a group!
  } else if($_POST['action'] == 'Delete') {
    $link = connectToServer();
    $groupName = $_POST['id'];
    $groupName = sanatize($link, $groupName);
    
    $qry = "CALL deleteFromGroups ('$groupName')";
    
    if(mysqli_query($link, $qry))
      redirectHome();
    else
      echo "Error: " . $qry . "<br>" . $link->error;
    
    exit();
  }
}