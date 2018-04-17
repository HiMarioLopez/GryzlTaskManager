<?php

  function sanatize($link, $input) {
    $input = mysqli_real_escape_string($link, $input);
    $input = strip_tags($input);
    $input = htmlentities($input);
    $input = htmlspecialchars($input);
    return $input;
  }

  function setGryzlCookie($cookie_name, $username) {
      unset($_COOKIE[$cookie_name]);
      setcookie($cookie_name, $username, time() +  (86400 * 30), "/");
      echo "Cookie has been set! " . $_COOKIE[$cookie_name];
  }

  // @todo: don't use root
  function connectToServer() {
    $link = mysqli_connect("localhost","root", "", "Gryzl");
    
    if (mysqli_connect_errno()) {
			printf("Connect failed: %s\n", mysqli_connect_error());
			exit();
		}
    
    return $link;
  }

?>