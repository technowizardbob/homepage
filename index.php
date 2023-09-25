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
 * @author Bob S. <Tips@TechnoWizardBob.com>
 * @copyright Copyright (c) 2022, Bob S.
 * @license MIT
 */

if ($loggedin) {
  echo '<a href="insert.php">Add new Link</a> | <a href="index.php?edit=true">Edit Links</a> | ';
  echo '<a href="update_cat.php?edit=true">Edit categories</a> | ';
  echo '<a href="change_pwd.php?name='.$username.'">Change Password</a> | ';
  echo '<a href="logout.php">Log out</a>';
} else {
  echo '<a href="login.php?name='.$username.'">Log In</a>';
}
?>
    <ul>
<?php

$hide = ($loggedin) ? "" : " WHERE private=\"false\" ";

function get_cat(int $id): string {
  try {
    $sql = "SELECT category FROM cats WHERE id=:id LIMIT 1";
    $pdostmt = $GLOBALS['pdo']->prepare($sql);
    $pdostmt->execute(["id"=>$id]);
    $r = $pdostmt->fetch(\PDO::FETCH_ASSOC);
    if (empty($r['category'])) {
      return "Misc.";
    }
    return (string) $r['category'];
  } catch (\PDOException $e) {
    echo $e->getMessage();
  }
}

try {
    $sql = "SELECT cat_id, link_id, link_name, link_href, `description` FROM links {$hide} ORDER BY link_name ASC";
    $pdostmt = $pdo->prepare($sql);
    $pdostmt->execute();
    $a = [];
    while($r = $pdostmt->fetch(\PDO::FETCH_ASSOC)) {
      $cid = $r['cat_id']; 
      unset($r['cat_id']);
      $a[$cid][] = $r;
    }
} catch (\PDOException $e) {
    echo $e->getMessage();
}

$edit = $_GET['edit'] ?? false;

foreach($a as $id=>$data) {
  echo "<h4>" . get_cat($id) . "</h4>";
  foreach($data as $row) {
	    $edit_row = ($edit === false) ? "</li>": "<a href=\"update.php?id={$row['link_id']}\">(Edit)</a></li>";
      echo "<li>| &nbsp; <a href=\"{$row['link_href']}\" title=\"{$row['description']}\" target=\"_blank\">{$row['link_name']}</a> {$edit_row} &nbsp; ";
  }
}

?>
    </ul>
  </body>
</html>  
