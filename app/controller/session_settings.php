<?php
session_start();
if ($_SESSION['lastpage'] != $_SERVER['REQUEST_URI']) {
	$_SESSION['prevpage'] = $_SESSION['lastpage'];
}
$_SESSION['lastpage'] = $_SERVER['REQUEST_URI'];
// echo $_SERVER['REQUEST_URI'];
// echo $_SERVER['QUERY_STRING'];
?>