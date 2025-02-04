<?php
session_start();
include("include/functions.php");

ClearErrors();
if (!isset($_POST['username']) || !isset($_POST['password'])) {
    header("Location: index.php");
    exit();
}

// received values
$username = $_POST['username'];
$password = $_POST['password'];

$check = true;
if (!CheckNameLogin($username))
    $check = false;

$user = GetLogin($username, PassHash($password));

if ($user == null)
    $check = false;


// --------------------------------
if (!$check) {

    header("Location: login.php");
    exit;
}
// --------------------------------

// retained values
$_SESSION['id_login'] = $user['id_user'];
$_SESSION['name_login'] = $user['username'];
// $_SESSION['mail_login'] = $user['email'];
$_SESSION['role_login'] = $user['role'];

UpdateLastLogin($user['id_user']);

ClearErrors();
header("Location: index.php");
exit();
?>