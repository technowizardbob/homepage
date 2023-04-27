<?php

/** 
 * @author Robert Strutts <Robert@TryingToScale.com>
 * @copyright Copyright (c) 2022, Robert Strutts.
 * @license MIT
 */

require "db.inc.php";

$pwd = $_POST['pwd'] ?? false;

if ($loggedin) {

  if ($pwd === false) {  
?>
<form method="POST">
  <label for="pwd">New Password</label> 
  <input type="password" id="pwd" name="pwd" />
  <input type="submit" value="Change" />
</form>
<?php
  } else {
    
    try {
        $sql = "UPDATE pwd SET password=:pwd WHERE id=1";
        $pdostmt = $pdo->prepare($sql);
        if ($pdostmt !== false) {
            $s = $pdostmt->execute(["pwd"=> password_hash($pwd, PASSWORD_BCRYPT)]);
            if ($s) {
              echo "Success";
              echo '<br/> <br/><hr><a href="index.php">Home Page</a>';
            } else {
              echo "Failed!";
            }
            
        } else {
          echo "Failed!";
        }
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
  
  }  
}
