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
 * @author Robert Strutts <Robert@TryingToScale.com>
 * @copyright Copyright (c) 2022, Robert Strutts.
 * @license MIT
 */

require "db.inc.php";

$name = $_POST['hname'] ?? false;
$href = $_POST['href'] ?? false;
$private = $_POST['private'] ?? "false";

if ($name === false || $href === false) {
    ?>
        <form method="POST">
            <label for="private">Mark as private</label>
            <input type="checkbox" name="private" id="private" value="true" checked="checked" />
          |
            <label for="name">Enter Name of Link</label>
            <input type="text" name="hname" id="hname" maxlength="25"/>
            <label for="href">Hyperlink</label>
            <input type="text" name="href" id="href" maxlength="255" placeholder="https://" />
            <input type="submit" />
        </form>        
    <?php
} else {

    try {
        $sql = "INSERT INTO links (link_name, link_href, private) VALUES (:name, :href, :private)";
        $pdostmt = $pdo->prepare($sql);
        if (! $pdostmt === false) {
            $pdostmt->execute(["name"=>$name, "href"=>$href, "private"=>$private]);
        }
    } catch (PDOException $e) {
        echo $e->getMessage();
    }

    echo "<a href=\"index.php\">Back to Home Page</a>";
}
?>
    </body>
</html>    
