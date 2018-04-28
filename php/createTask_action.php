<?php

  require 'functions.php';

  $link = connectToServer();

  $tas_ID = $_POST["taskname"];
  $tas_Priority = $_POST["priority"];
  $tas_Category = $_POST["category"];
  $tas_Progress = $_POST["progress"];
  $tas_DueDate = $_POST["duedate"];

  $tas_ID = sanatize($link, $tas_ID);
  $is6Months = checkDate6Month($tas_DueDate);

  $tas_DueDate = strtotime($tas_DueDate);
  $tas_DueDate1 = date('Y-m-d H:i:s', $tas_DueDate);
  $date = time();

  $justDate = date('Y-m-d', $tas_DueDate);
  $qry = "CALL countHighPrior( '$justDate', '" . $_COOKIE['current_user'] . "')";

  $result = mysqli_query($link, $qry);
  $row = mysqli_fetch_array($result);

  if ($is6Months){
    if ($row[0] >= 3) {

      clearStoredResults($link);
      if($tas_Priority == 'h') {

        $qry = "SELECT tas_ID FROM Tasks WHERE tas_usr_ID=\"" .$_COOKIE['current_user'] ."\" AND date(tas_DueDate) ='$justDate' AND tas_Priority='h' ORDER BY tas_CreationDate DESC LIMIT 1";
        $result = mysqli_query($link, $qry);
        $row = mysqli_fetch_array($result);
        
        $qry = "UPDATE Tasks SET tas_Priority='m' WHERE tas_ID='$row[0]'";
        clearStoredResults($link);
        mysqli_query($link, $qry);
        
      } else if($tas_Priority == 'm') {
        $qry = "SELECT tas_ID FROM Tasks WHERE tas_usr_ID=\"" .$_COOKIE['current_user'] ."\" AND date(tas_DueDate) ='$justDate' AND tas_Priority='m' ORDER BY tas_CreationDate DESC LIMIT 1";
        $result = mysqli_query($link, $qry);
        $row = mysqli_fetch_array($result);
        
        $qry = "UPDATE Tasks SET tas_Priority='l' WHERE tas_ID='$row[0]'";
        clearStoredResults($link);
        mysqli_query($link, $qry);
        
      }
    }
      
      clearStoredResults($link);
      $currentDate = date('Y-m-d H:i:s', time());
      $qry = "CALL createTask( '$tas_ID', '$tas_Category', '$tas_DueDate1', '$tas_Priority', '$tas_Progress', '" . $_COOKIE['current_user'] . "', '$currentDate'); ";
      $qry .= "CALL createProgTask ('$tas_ID', '" . $_COOKIE['current_user'] . "', '$tas_Category')";
      
      setGryzlCookie("current_task", $tas_ID);
      setGryzlCookie("current_category", $tas_Category);
      
      $result = mysqli_multi_query($link, $qry);
      
      if($result) {
        if ($_POST['Submit'] == "Assign Groups?")
           header('Location: ../addgrouptotask.php');
        elseif ($_POST['Submit'] == "Create Task without Groups")
          redirectHome();
        
      }
  } else {
    // TODO: Display Error Message!
    echo "Due Date can only be 6 months in the future!";
    header('Location: ../createTask.php');
    exit();
 }

?>