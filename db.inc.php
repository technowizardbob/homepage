<?php

/** 
 * @author Bob S. <Tips@TechnoWizardBob.com>
 * @copyright Copyright (c) 2022, Bob S.
 * @license MIT
 */

require "session.php";

// Convert the string to ASCII, ignoring any non-ASCII characters
$ascii_only = mb_convert_encoding($username, 'ASCII', 'UTF-8');

if (str_contains($ascii_only, ':') || str_contains($ascii_only, '..')) {
   echo "Invalid name!"; // File System Stream or Up level Attack!
   exit;
}

// Strip out non a-z chrs
$name = preg_replace('/[^a-z]/', '', strtolower($ascii_only));
$name = str_replace("..", "", ucfirst($name));
$file = "{$name}_sql_lite3.db";

$exists = (file_exists(__DIR__."/".$file)) ? true : false;

if ($exists === false) {
  echo "Please have the admin create you an account!";
  exit;
}


try {
  $pdo = new PDO("sqlite:{$file}");
} catch (PDOException $e) {
  echo $e->getMessage();
}

if (isset($_GET['migrate'])) {

  try {
    $sql = "ALTER TABLE links ADD cat_id INTEGER;";
    $pdo->query($sql);
  } catch (PDOException $e) {
    echo $e->getMessage();
  }
  try {
    $sql = "ALTER TABLE links ADD description TEXT;";
    $pdo->query($sql);
  } catch (PDOException $e) {
    echo $e->getMessage();
  }

  try {
    $sql = "CREATE TABLE IF NOT EXISTS cats (
            id   INTEGER PRIMARY KEY AUTOINCREMENT,      
            category TEXT    NOT NULL
      );";
    $pdo->query($sql);
  } catch (PDOException $e) {
    echo $e->getMessage();
  }

  exit;
}


if (isset($_GET['new'])) {
  try {
    $sql = "CREATE TABLE IF NOT EXISTS links (
            link_id   INTEGER PRIMARY KEY AUTOINCREMENT,
            link_name TEXT    NOT NULL,
            link_href TEXT    NOT NULL,
            cat_id INTEGER,
            description TEXT,
            private TEXT      NULL
      );";
    $pdo->query($sql);
  } catch (PDOException $e) {
    echo $e->getMessage();
  }

  try {
    $sql = "CREATE TABLE IF NOT EXISTS cats (
            id   INTEGER PRIMARY KEY AUTOINCREMENT,      
            category TEXT    NOT NULL
      );";
    $pdo->query($sql);
  } catch (PDOException $e) {
    echo $e->getMessage();
  }

  try {
    $sql = "CREATE TABLE IF NOT EXISTS pwd (
            id   INTEGER PRIMARY KEY AUTOINCREMENT,      
            password TEXT    NOT NULL
      );";
    $pdo->query($sql);
  } catch (PDOException $e) {
    echo $e->getMessage();
  }

  try {
    $sql = "SELECT COUNT(*) AS c FROM pwd LIMIT 2";
    $stmt = $pdo->query($sql);
    if ($stmt) {
      $c = $stmt->fetch(PDO::FETCH_ASSOC);
      if ($c["c"] > 0) {
   	  echo "Password Already Set!";
          exit;
      }
    }
  } catch (PDOExeception $e) {
    echo $e->getMessage();
  } 

  try {
    $sql = "INSERT INTO pwd (password) VALUES (:pwd)";
    $pdostmt = $pdo->prepare($sql);
    if ($pdostmt === false) {
       echo "Unable to create password!";
       exit;
    }
    $pdostmt->execute(["pwd"=> password_hash("Temp", PASSWORD_BCRYPT)]);
  } catch (PDOException $e) {
    echo $e->getMessage();
  }
  echo "Password set to: Temp";  
  
}


function is_pwd(string $pwd): bool {
try {
    $sql = "SELECT password FROM pwd WHERE id=1";
    $pdostmt = $GLOBALS['pdo']->prepare($sql);
    if ($pdostmt === false ) {
      return (empty($pwd)) ? true : false;
    }
    $pdostmt->execute();
    $row = $pdostmt->fetch(PDO::FETCH_ASSOC);
} catch (\PDOException $e) {
  return false;
}  
  return password_verify($pwd, $row['password']);
}
