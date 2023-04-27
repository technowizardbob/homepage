<!DOCTYPE html>
<html lang="en-US">
  <head>
    <meta charset="utf-8">
    <base target="_top">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="language" content="english">
    <title>Home Page</title>
    <link rel="shortcut icon" href="favicon.ico">
    <style>
table, th, td {
  border:1px solid black;
}
    </style>    
  </head>
    <body>
<?php

/** 
 * @author Robert Strutts <Robert@TryingToScale.com>
 * @copyright Copyright (c) 2022, Robert Strutts.
 * @license MIT
 */

require "db.inc.php";

if (! $loggedin) {
  echo "Please log in!";
  exit;
}

    echo "<a href=\"insert_cat.php\">Add new Category</a><br/><hr>";
    try {
        $sql = "SELECT id, category FROM cats";
        $pdostmt = $pdo->prepare($sql);
        if (! $pdostmt === false) {
            $pdostmt->execute();
            $rows = $pdostmt->fetchAll(PDO::FETCH_ASSOC);
        }
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
    ?>
    <h2>Edit Categories:</h2>
<?php
        foreach($rows as $row) {
            echo "| <a href=\"edit_cat.php?id={$row['id']}\">{$row['category']}</a>\r\n";
        }
        echo "|";
?> 
<br/><br/><hr>       
<p><a href="/">Back to home</a></p>
    </body>
</html>    
