<?php
  require 'functions.php';
  
  if (isset($_POST["actions"])){
    if ($_POST["actions"] === "Home"){
      redirectHome();
    } else if ($_POST["actions"] === "Logout") {
      header("Location: ../login.html");
      exit();
    }
  } else {
  
    $link = connectToServer();

    $groupName = $_POST["groupname"];
    $groupName = strtolower($groupName);
    $groupName = sanatize($link, $groupName);

    // @TODO: STORED PROCEDURE
    $qry = "CALL createGroup ( '". $groupName . "', '". $_COOKIE["current_user"] . "');";
    if (mysqli_query($link, $qry) === TRUE) {
      // @TODO: STORED PROCEDURE
      $qry = "CALL addMems2Group ('" . $groupName . "', '" . $_COOKIE["current_user"] . "');";
      if(mysqli_query($link, $qry) == TRUE) {
        setGryzlCookie("currGroupName", $groupName);
        header('Location: ../addmemstogroup.php');
        exit;
      } else
        echo "Error: " . $qry . "<br>" . $link->error;
    } else
        echo "Error: " . $qry . "<br>" . $link->error;
  }
?>
