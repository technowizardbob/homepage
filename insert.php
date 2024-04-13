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

$name = $_POST['hname'] ?? false;
$href = $_POST['href'] ?? false;
$private = $_POST['private'] ?? "false";
$desc  = $_POST['desc'] ?? "";
$cat  = $_POST['cat'] ?? 0;

if ($name === false || $href === false) {

    try {
        $sql = "SELECT id, category FROM cats";
        $query = $pdo->query($sql);
    } catch (PDOException $e) {
        echo $e->getMessage();
    }

    ?>
        <form method="POST">
            <label for="private">Mark as private</label>
            <input type="checkbox" name="private" id="private" value="true" checked="checked" />
            <select id="cat" name="cat">
<?php
            foreach($query as $q) {
                echo "<option value=\"{$q['id']}\">{$q['category']}</option>";
            }
?>            
            </select>
            <label for="name">Enter Name of Link</label>
            <input type="text" name="hname" id="hname" maxlength="25"/>
            <label for="href">Hyperlink</label>
            <input type="text" name="href" id="href" maxlength="255" placeholder="https://" />
            <label for="desc">Description</label>
            <input type="text" name="desc" id="desc" maxlength="255" />
            <input type="submit" />
        </form>        
    <?php
} else {

    try {
        $sql = "INSERT INTO links (link_name, link_href, private, description, cat_id) VALUES (:name, :href, :private, :desc, :cat)";
        $pdostmt = $pdo->prepare($sql);
        if (! $pdostmt === false) {
            $pdostmt->execute(["name"=>$name, "href"=>$href, "private"=>$private, "desc"=>$desc, "cat"=>$cat]);
        }
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
    $_SESSION['last'] = false;
    echo "<a href=\"index.php".bust()."\">Back to Home Page</a>";
}
?>
    </body>
</html>    
