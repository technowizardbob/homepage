<?php

/** 
 * @author Robert Strutts <Robert@TryingToScale.com>
 * @copyright Copyright (c) 2022, Robert Strutts.
 * @license MIT
 */

function grab_raw_post_data(int $Kibibytes = 500, int $params = 600): false|array {
	$stream = fopen('php://input', 'r');
	$i = 0;
	$post_data = '';
	while (!feof($stream)) {
		$i++; // 500 Kibibytes = 512 Kilobytes or .512Megabytes or Half 1MB
		$post_data .= fread($stream, 1024); // 1Kibibytes = 1024 Bytes = 8192 Bits = 1 Loop
		// Limit Data to 65KB, 64 Loops = 65536 characters
		// 8192 Bits × 500 Loops = 4096000 Bits = 512KB = 524288 characters
		if ($i > $Kibibytes) { 
			fclose($stream);
			return false;
		}   
	}
	fclose($stream);
	
	$count_params = substr_count($post_data, "&");
	if ($count_params > $params) {
		return false;
	}
	parse_str($post_data, $data_array);
	unset($post_data);
	return $data_array;
}

function grab_raw_get_data(int $Kibibytes = 500, int $params = 600): false|array {
	if (!filter_has_var(INPUT_SERVER, "QUERY_STRING")) {
		return false;
	}
	if (strlen($_SERVER["QUERY_STRING"]) > $Kibibytes) {
		return false;
	}
	$get_data_raw = filter_input(INPUT_SERVER, "QUERY_STRING", FILTER_UNSAFE_RAW);
	if (empty($get_data_raw)) {
		return false;
	}
	$count_params = substr_count($get_data_raw, "&");
	if ($count_params > $params) {
		return false;
	}
	parse_str($get_data_raw, $get_data_array);
	unset($get_data_raw);
	return $get_data_array;
}

if (count($_GET) < 1) {
	$_GET = grab_raw_get_data(64, 8);
}

if (count($_POST) < 1) {
	$_POST = grab_raw_post_data(64, 8);
}

session_start();

$user = $_SESSION['username'] ?? false;
if ($user === false) {
    $user = $_COOKIE['home'] ?? false;
}
$loggedin = ($user === false || empty($user)) ? false : true;

$man = $_GET['name'] ?? false;

$username = ($loggedin) ? $user : $man; 
