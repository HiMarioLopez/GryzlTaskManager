<?php

  require 'functions.php';

  $link = connectToServer();

  $username = $_POST["username"];
  $password = $_POST["password"];
  $email = $_POST["email"];

  $username = sanatize($link, $username);
  $password = sanatize($link, $password);
  $email = sanatize($link, $email);

  $password_hash = password_hash($password, PASSWORD_DEFAULT);

  $username = strtolower($username);
  $email = strtolower($email);

  if (isset($username)){
    $usr_qry = "INSERT INTO Users (usr_ID, usr_Email, usr_Password) 
                VALUES ( '" . $username . "' , '" . $email . "' , '" . $password_hash . "');";
    $pri_qry = "INSERT INTO Privileges VALUES ('pb', '" . $username . "');";
    
    if (mysqli_query($link, $usr_qry) && mysqli_query($link, $pri_qry)) {
      
      setGryzlCookie("current_user", $username);
      header('Location: ../home.php');
      
    } else {
      echo "<h1>Registration unsuccessful. Has this username/email already been used? <br></h1>";
    
      // Redirect button
      // This is using some scrappy JavaScript embeded into my PHP code...
      echo "<button id=\"myBtn\">Back to registration page!</button>" .
            "<script>" .
            "var btn = document.getElementById('myBtn');" .
            "btn.addEventListener('click', function() {" .
            "document.location.href = '../register.html';" .
            "});" .
            "</script>";
    }
  }

  mysqli_close($link);
  exit();

?>