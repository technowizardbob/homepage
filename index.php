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
        ul { list-style-type: none; line-height: 40px; margin-right: 40px;}
        ul li { display: inline; }
    </style>
  </head>
  <body style="background-color: rgb(255, 255, 255);">   
<?php require "db.inc.php"; ?>   
    
<div style="text-align: center;"><font face="Times New Roman, Times, serif"><b><font color="#cc0000" face="Courier New, Courier, mono" size="+1"><?= (! empty($username)) ? ucfirst($username) . ", " : "" ?>Welcome to your Home Page.</font></b></font></div>
<center>
<form action="https://www.duckduckgo.com/" method="get"><font face="Times New Roman, Times, serif"><b><font color="#cc0000" face="Courier New, Courier, mono" size="+1">
<input name="sourceid" value="chrome" type="hidden">
<input name="ie" value="UTF-8" type="hidden">
<input size="90" name="q"><input name="hl" value="en" type="hidden"><input name="source" value="hp" type="hidden"><input name="site" value="" type="hidden"><input value="Search" name="submit" type="submit"></font></b></font></form>
</center>
  
<?php

/** 
 * @author Robert Strutts <Robert@TryingToScale.com>
 * @copyright Copyright (c) 2022, Robert Strutts.
 * @license MIT
 */

if ($loggedin) {
  echo '<a href="insert.php">Add new Link</a> | <a href="index.php?edit=true">Edit Links</a> | ';
  echo '<a href="change_pwd.php?name='.$username.'">Change Password</a> | ';
  echo '<a href="logout.php">Log out</a>';
} else {
  echo '<a href="login.php?name='.$username.'">Log In</a>';
}
?>
    <ul>
<?php

$hide = ($loggedin) ? "" : " WHERE private=\"false\" ";

try {
    $sql = "SELECT link_id, link_name, link_href FROM links {$hide} ORDER BY link_name ASC";
    $pdostmt = $pdo->prepare($sql);
    $pdostmt->execute();
    $rows = $pdostmt->fetchAll(PDO::FETCH_ASSOC);
} catch (\PDOException $e) {
    echo $e->getMessage();
}

$edit = $_GET['edit'] ?? false;

foreach($rows as $row) {
	$edit_row = ($edit === false) ? "</li>": "<a href=\"update.php?id={$row['link_id']}\">(Edit)</a></li>";
    echo "<li>| &nbsp; <a href=\"{$row['link_href']}\" target=\"_blank\">{$row['link_name']}</a> {$edit_row} &nbsp; ";
}

?>
    </ul>
  </body>
</html>  
