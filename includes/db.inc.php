<?php
$dBServername = "localhost";
$dBUsername = "root";
$dBPassword = "";
$dBName = "iex";

$connection
= mysqli_connect($dBServername, $dBUsername, $dBPassword, $dBName);

if(!$connection) {
    die("Connection Failed: " . mysqli_connect_error());
}