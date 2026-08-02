<?php

$host = "localhost";
$user = "root";
$password = "";
$database = "SmartFleetDB";
$port = 3307;

$conn = new mysqli(
    $host,
    $user,
    $password,
    $database,
    $port
);

if ($conn->connect_error) {
    die("Database connection failed.");
}