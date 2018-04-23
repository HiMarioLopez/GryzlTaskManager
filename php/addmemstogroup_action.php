<?php

  require 'functions.php';

  $db = connectToServer();

  $newuser = $_POST["newuser"];
  $moremems= $_POST["addmems"];

  $newuser = sanatize($db, $newuser);
  $newuser = strtolower($newuser);

  // 1st Query
  $result = $db->query("CALL doesUserExist('$newuser')");

  if($result){
       // Cycle through results
      while ($row = $result->fetch_array()){
          
          if($row[0] == 0) {
            // If user doesn't exist send them to this error page
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
            exit();
          }
      }
      // Free result set
      $result->close();
      $db->next_result();
  } else echo($db->error);

  // 2nd Query
  $result = $db->query("CALL addMems2Group ('" . $_COOKIE["currGroupName"] . "', '$newuser')");
  if($result){

    if ($moremems  == 'done')
      redirectHome();
    else
      header("Location: ../addmemstogroup.php");
    
   // Free result set
   $result->close();
   $db->next_result();
  } else echo($db->error);

  mysqli_close($db);

?>
