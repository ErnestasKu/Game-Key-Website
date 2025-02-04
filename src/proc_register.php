<?php
session_start();
include("include/functions.php");

ClearErrors();
if (
    !isset($_POST['username']) ||
    !isset($_POST['email']) ||
    !isset($_POST['password']) ||
    !isset($_POST['password_confirm'])
) {
    header("Location: index.php");
    exit();
}

// received values
$user = $_POST['username'];
$mail = $_POST['email'];
$pass = $_POST['password'];
$pass_conf = $_POST['password_confirm'];

// retained values
$_SESSION['username'] = $_POST['username'];
$_SESSION['email'] = $_POST['email'];

$check = true;
if (!checkname($user))
    $check = false;
if (!checkmail($mail))
    $check = false;
if (!CheckPassRegister($pass))
    $check = false;
if (!checkPasswordConfirmation($pass, $pass_conf))
    $check = false;
// --------------------------------
if ($check === false) {

    header("Location: register.php");
    exit;
}
// --------------------------------
RegisterUser($user, $pass, $userid, $role, $mail);

echo "<script>window.onload = function() { alert('Registration successful!'); window.location.href = 'index.php'; }</script>";
exit;

?>