<?php

$dirPre = '../classes/';
$dirPost = '.class.php';
$indexPage = "../index.php";

include $dirPre . 'db' . $dirPost;
include $dirPre . 'sql' . $dirPost;
include $dirPre . 'user' . $dirPost;

$user = new User();
$user->closeDbConnection();
session_start();
session_unset();
session_destroy();
header("Location: " . $indexPage);
exit();