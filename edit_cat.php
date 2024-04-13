<!DOCTYPE html>
<html lang="en-US">
  <head>
    <meta charset="utf-8">
    <base target="_top">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="language" content="english">
    <title>Home Page</title>
    <link rel="shortcut icon" href="favicon.ico">
  </head>
    <body>
<?php
require "db.inc.php";
/** 
 * @author Bob S. <Tips@TechnoWizardBob.com>
 * @copyright Copyright (c) 2022, Bob S.
 * @license MIT
 */

if (! $loggedin) {
  echo "Please log in!";
  exit;
}


$id = (int) $_GET['id'] ?? 0;
$cat = $_POST['cat'] ?? false;
$delete = $_POST['delete'] ?? "false";

if ($cat === false || $id == 0) {

    try {
        $sql = "SELECT category FROM cats WHERE id=:id LIMIT 1";
        $pdostmt = $pdo->prepare($sql);
        if (! $pdostmt === false) {
            $pdostmt->execute(["id"=>$id]);
            $row = $pdostmt->fetch(PDO::FETCH_ASSOC);
        }
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
    ?>
        <form method="POST">
            <label for="cat">Category</label>
            <input type="text" name="cat" id="cat" value="<?= $row['category'] ?>" maxlength="255"/>
            <br/><br/>
            <input type="submit" />
        </form>        
    <?php
} else {
  $_SESSION['cat'] = false;
  $_SESSION['last_modified_time'] = time();

  if ($delete === "true") {
      try {
        $sql = "DELETE FROM cats WHERE id=:id LIMIT 1";
        $pdostmt = $pdo->prepare($sql);
        if (! $pdostmt === false) {
            $pdostmt->execute(["id"=>$id]);
        }
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
  } else {
      try {
        $sql = "UPDATE cats SET category=:cat WHERE id=:id LIMIT 1";
        $pdostmt = $pdo->prepare($sql);
        if (! $pdostmt === false) {
            $pdostmt->execute(["cat"=>$cat, "id"=>$id]);
        }
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
  }
    echo "<a href=\"index.php".bust()."\">Back to Home Page</a>";
}
?>
    </body>
</html>    
