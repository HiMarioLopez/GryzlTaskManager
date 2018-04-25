<?php

  require 'functions.php';

  $link = connectToServer();

  $username = $_POST["username"];
  $password = $_POST["password"];
  $email = $_POST["email"];
  
  $username = strtolower($username);
  $email = strtolower($email);

  $username = sanatizeNoSpecial($link, $username);
  $password = sanatize($link, $password);
  $email = sanatize($link, $email);

  $password_hash = password_hash($password, PASSWORD_DEFAULT);

  $usr_qry = "CALL adduser( '". $username . "', '" . $email . "', '" . $password_hash."' )";
  $priv_qry = "CALL assignpriv( '" . $username . "' )";

  //removed privliges becasuse i think the table got dropped
  if (mysqli_query($link, $usr_qry) && mysqli_query($link, $priv_qry)) {
    
    setGryzlCookie("current_user", $username);
    setGryzlCookie("current_user_privileges", 'pb');
    header('Location: ../home.php');

  } else {
    // TODO: Change this to HTML. Make it look good. idk
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

  mysqli_close($link);
  exit();

?>