<!-- What this page currently does (4.12.2018)
     - inserts group into the database
     - sets the currGroupName cookie
     - sends to add members to group
-->

<!-- What this page need (4.12.2018)
     - guard against malicious queries
-->

<?php
  // todo: Don't use root
  $link = mysqli_connect("localhost","root", "", "Gryzl");

  $groupName = $_POST["groupname"];
  $qry = "INSERT INTO Groups (gro_ID, gro_ownerID, gro_status) VALUES ( '". $groupName . "', '". $_COOKIE["currUser"] . "', 'a');";

  if (mysqli_query($link, $qry) === TRUE) {
    $cookie_name = "currGroupName";
    setcookie($cookie_name, $groupName);
    header('Location: ../addmemstogroup.html');
    exit;
  } else {
      echo "Error: " . $qry . "<br>" . $link->error;
  }
?>
