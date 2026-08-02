<?php

session_start();

require "includes/db.php";

$username = $_POST["username"];
$password = $_POST["password"];

$stmt = $conn->prepare(
    "SELECT Password
     FROM Users
     WHERE Username = ?"
);

$stmt->bind_param("s", $username);

$stmt->execute();

$result = $stmt->get_result();

if ($result->num_rows == 1) {

    $user = $result->fetch_assoc();

    if (password_verify($password,
                        $user["Password"])) {

        $_SESSION["user"] = $username;
       $ip = $_SERVER['REMOTE_ADDR'];

$log = $conn->prepare("
INSERT INTO SecurityLog
(
    Username,
    IPAddress,
    Status
)
VALUES
(
    ?, ?, 'SUCCESS'
)
");

$log->bind_param(
    "ss",
    $username,
    $ip
);

$log->execute();

        header("Location: dashboard.php");

        exit();

    }

}

$ip = $_SERVER['REMOTE_ADDR'];

$log = $conn->prepare("
INSERT INTO SecurityLog
(
    Username,
    IPAddress,
    Status
)
VALUES
(
    ?, ?, 'FAILED'
)
");

$log->bind_param(
    "ss",
    $username,
    $ip
);

$log->execute();

header("Location: index.php?error=1");
exit();