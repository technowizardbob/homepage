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

$cat = $_POST['cat'] ?? false;

if ($cat === false) {
    ?>
        <form method="POST">
            <label for="cat">Enter Name of Category</label>
            <input type="text" name="cat" id="cat" maxlength="100"/>
            <input type="submit" />
        </form>        
    <?php
} else {

    try {
        $sql = "INSERT INTO cats (category) VALUES (:cat)";
        $pdostmt = $pdo->prepare($sql);
        if (! $pdostmt === false) {
            $pdostmt->execute(["cat"=>$cat]);
        }
    } catch (PDOException $e) {
        echo $e->getMessage();
    }

    echo "<a href=\"index.php\">Back to Home Page</a>";
}
?>
    </body>
</html>    
