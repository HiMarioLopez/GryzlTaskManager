<!-- What this page currently does (4.12.2018)
     - Creates a new user in the database for enetered values.
     - Also creates entry in Privileges table, defaults to public.
-->

<!-- What this page need (4.12.2018)
     - Not use root, also forgot to add that to @todo on login.php
-->

<?php

  require 'functions.php';

  // @todo: Don't use root
  $link = mysqli_connect("localhost","root", "", "Gryzl");

  if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
  }

  $username = $_POST["username"];
  $password = $_POST["password"];
  $email = $_POST["email"];

  $username = sanatize($link, $username);
  $password = sanatize($link, $password);
  $email = sanatize($link, $email);

  $username = strtolower($username);
  $email = strtolower($email);

  if (isset($username)){
    $usr_qry = "INSERT INTO Users (usr_ID, usr_Email, usr_Password) VALUES ( '" . $username . "' , '" . $email . "' , '" . $password . "');";
    $pri_qry = "INSERT INTO Privileges VALUES ('pb', '" . $username . "');";
    
    if (mysqli_query($link, $usr_qry) && mysqli_query($link, $pri_qry)) {
      
      setGryzlCookie("current_user", $username);
      header('Location: ../home.php');
      
    } else {
      printf("Registration unsuccessful. Has this username/email already been used?");
    }
  }

  mysqli_free_result($result);
  mysqli_close($link);
  exit();

?>