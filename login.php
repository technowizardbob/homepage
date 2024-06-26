<?php

/** 
 * @author Bob S. <Tips@TechnoWizardBob.com>
 * @copyright Copyright (c) 2022, Bob S.
 * @license MIT
 */

require "db.inc.php";

if (! isset($_GET['name'])) {
  echo "Error!";
  exit;
}

$pwd = $_POST['pwd'] ?? false;

if ($pwd === false) {
?>
<form method="POST">
  <label for="pwd">Password</label> 
  <input type="password" id="pwd" name="pwd" />

  <label for="private">Private PC</label> 
  <input type="checkbox" id="private" name="private" value="true" checked />
  
  <input type="submit" value="Login" />
</form>
<?php
} else {
  $success = is_pwd($pwd);  
  if ($success) {
    $_SESSION['username'] = $username;
    $_SESSION['last'] = $username;
    $_SESSION['cat'] = true;
    $_SESSION['links'] = true;
    $_SESSION['last_modified_time'] = time();
  
    if ($_POST['private'] == "true") {
        setcookie("home", $username, strtotime( '+30 days' ) );
    }
    echo "Success!";
    echo '<br/> <br/><hr><a href="index.php">Home Page</a>';
  } else {
    echo "Bad Password";
  }
}
