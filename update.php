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

/** 
 * @author Bob S. <Tips@TechnoWizardBob.com>
 * @copyright Copyright (c) 2022, Bob S.
 * @license MIT
 */

require "db.inc.php";

if (! $loggedin) {
  echo "Please log in!";
  exit;
}


$name = $_POST['hname'] ?? false;
$href = $_POST['href'] ?? false;
$id = (int) $_GET['id'] ?? 0;
$delete = $_POST['delete'] ?? "false";
$private = $_POST['private'] ?? "false";
$desc = $_POST['desc'] ?? "";
$cat = $_POST['cat'] ?? 0;

if ($name === false || $href === false || $id == 0) {

    try {
        $sql = "SELECT id, category FROM cats";
        $query = $pdo->query($sql);
        $f = $query->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo $e->getMessage();
    }

    try {
        $sql = "SELECT link_name, link_href, private, description, cat_id FROM links WHERE link_id=:id";
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
            <select id="cat" name="cat">
            <option>Select Cat</option>    
<?php
            foreach($f as $q) {
                $sel = ($row['cat_id'] == $q['id']) ? "selected" : "";
                echo "<option value=\"{$q['id']}\" {$sel}> {$q['category']}</option>";
            }
?>            
            </select>

            <label for="name">Enter Name of Link</label>
            <input type="text" name="hname" id="hname" value="<?= $row['link_name'] ?>" maxlength="25"/>
            <label for="href">Hyperlink</label>
            <input type="text" name="href" id="href" value="<?= $row['link_href'] ?>" maxlength="255"/>
            <label for="desc">Description</label>
            <input type="text" name="desc" id="desc" value="<?= $row['description'] ?>" maxlength="255" />
            <br/>
            <label for="delete">Delete It</label>
            <input type="checkbox" name="delete" id="delete" value="true" />
            <label for="private">Mark as private</label>
            <input type="checkbox" name="private" id="private" value="true" <?= ($row['private'] === "true") ? "checked='checked'" : "" ?> />
            <br/><br/>
            <input type="submit" />
        </form>        
    <?php
} else {
  $_SESSION['last'] = false;
  $_SESSION['last_modified_time'] = time();

  if ($delete === "true") {
      try {
        $sql = "DELETE FROM links WHERE link_id=:id LIMIT 1";
        $pdostmt = $pdo->prepare($sql);
        if (! $pdostmt === false) {
            $pdostmt->execute(["id"=>$id]);
        }
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
  } else {
      try {
        $sql = "UPDATE links SET link_name=:name, link_href=:href, private=:private, description=:desc, cat_id=:cat WHERE link_id=:id LIMIT 1";
        $pdostmt = $pdo->prepare($sql);
        if (! $pdostmt === false) {
            $pdostmt->execute(["id"=>$id, "name"=>$name, "href"=>$href, "private"=>$private, "desc"=>$desc, "cat"=>$cat]);
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
