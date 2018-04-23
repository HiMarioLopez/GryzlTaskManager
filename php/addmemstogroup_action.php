<?php

  require 'functions.php';

  $link = connectToServer();

  $newuser = $_POST["newuser"];
  $moremems= $_POST["addmems"];

  $newuser = sanatize($link, $newuser);
  $newuser = strtolower($newuser);

  $qry = "CALL doesUserExist('". $newuser . "');";
  $qry .= "CALL addMems2Group ('" . $_COOKIE["currGroupName"] . "', '" . $newuser . "')";

  if(mysqli_multi_query($link, $qry)) {
    if($result = mysqli_use_result($link)) {
      $row = mysqli_fetch_row($result);
      if($row[0] == 1) {
        if ($moremems  == 'done')
          redirectHome(); 
        else
          header("Location: ../addmemstogroup.php");    
      } else {
        
        $qry = "CALL deleteMemFromGroup('".$newuser."')";
        mysqli_query($link, $qry);
        
        echo "<h1>User not found! </h1><br>";

        // Redirect button
        // This is using some scrappy JavaScript embeded into my PHP code...
        echo "<button id=\"myBtn\">Back to add member page!</button>" .
              "<script>" .
              "var btn = document.getElementById('myBtn');" .
              "btn.addEventListener('click', function() {" .
              "document.location.href = '../addmemstogroup.php';" .
              "});" .
              "</script>";
      }
    }
  }
  mysqli_close($link);

?>
