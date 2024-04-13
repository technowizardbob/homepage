<?php

/** 
 * @author Bob S. <Tips@TechnoWizardBob.com>
 * @copyright Copyright (c) 2022, Bob S.
 * @license MIT
 */

function bust(): string {
	$unique_param = time(); // or any other unique identifier like a random string
	return "?bust=$unique_param";
}

function diable_cache() {
	header("Cache-Control: no-cache, no-store, must-revalidate"); // HTTP 1.1.
	header("Pragma: no-cache"); // HTTP 1.0.
	header("Expires: Sat, 26 Jul 1997 05:00:00 GMT"); // Proxies.
	if (!isset($_GET['bust'])) {
		header("Location: ". bust());
		exit;
	}
}

function cache() {
	$etag = '"' . $GLOBALS['username'] . '"';
	header("Cache-Control: max-age=3600"); // Cache for 1 hour
	header('ETag: ' . $etag); // Set ETag header
	$srv_http_if_none_match = filter_input(INPUT_SERVER, 'HTTP_IF_NONE_MATCH');
	/* Check whether browser had sent a HTTP_IF_NONE_MATCH request header
	 * If HTTP_IF_NONE_MATCH is same as the generated ETag => content is the same as browser cache
	 * So send a 304 Not Modified response header and exit
	 */
	$last_modified_time = $_SESSION['last_modified_time'] ?? false;
	if ($last_modified_time !== false && isset($_SERVER['HTTP_IF_MODIFIED_SINCE']) && strtotime($_SERVER['HTTP_IF_MODIFIED_SINCE']) >= $last_modified_time) {
		$modified = false;
	} else {
		$modified = true;
	}

	if ( $modified == false && $srv_http_if_none_match == $etag ) {
		header('HTTP/1.1 304 Not Modified', true, 304);
		exit();
	}
	if ($last_modified_time !== false) {
		header('Last-Modified: ' . gmdate('D, d M Y H:i:s', $last_modified_time) . ' GMT');
	}
}

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
