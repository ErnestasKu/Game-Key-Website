<?php
define("DB_SERVER", "localhost");
define("DB_USER", "root");
define("DB_PASS", "");
define("DB_NAME", "gamestoredb");

// user profiles
$user_roles = array(
	"admin" => "1",
	"user" => "2",
	"seller" => "3",
	"banned" => "4"
);

const USER_ROLES = array(
    "admin" => "1",
    "user" => "2",
    "seller" => "3",
    "banned" => "4"
);

define("ROLE_ADMIN", "admin");
define("ROLE_USER", "user");
define("ROLE_SELLER", "seller");
define("ROLE_BANNED", "banned");

define("STATUS_AVAILABLE", "available");
define("STATUS_SOLD", "sold");
define("STATUS_EXPIRED", "expired");
define("STATUS_SUSPENDED", "suspended");
?>