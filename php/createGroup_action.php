<!-- What this page currently does (4.12.2018)
     - inserts group into the database
     - sets the currGroupName cookie
     - sends to add members to group
-->

<!-- What this page need (4.12.2018)
     - guard against malicious queries
-->

<?php
  require 'functions.php';
  
  $link = connectToServer();

  $groupName = $_POST["groupname"];
  $groupName = strtolower($groupName);
  $groupName = sanatize($link, $groupName);

  $qry = "INSERT INTO Groups VALUES ( '". $groupName . "', '". $_COOKIE["current_user"] . "', 'a');";
  if (mysqli_query($link, $qry) === TRUE) {
    $qry = "INSERT INTO Group_Members VALUES ('" . $groupName . "', '" . $_COOKIE["current_user"] . "');";
    if(mysqli_query($link, $qry) == TRUE) {
      setGryzlCookie("currGroupName", $groupName);
      header('Location: ../addmemstogroup.html');
      exit;
    } else {
      echo "Error: " . $qry . "<br>" . $link->error;
    }
  } else {
      echo "Error: " . $qry . "<br>" . $link->error;
  }
?>
