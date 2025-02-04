<?php
include('include/settings.php');

function ClearErrors()
{
	//reg
	$_SESSION['name_error'] = "";
	$_SESSION['mail_error'] = "";
	$_SESSION['pass_error'] = "";
	$_SESSION['message'] = "";

	$_SESSION['key_error'] = "";

	$_SESSION['AG_title'] = "";
	$_SESSION['AG_description'] = "";
	$_SESSION['AG_release_date'] = "";
	$_SESSION['GA_title_error'] = "";
}

function GetGames()
{
	$db = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
	$query = "SELECT * FROM game";
	$result = $db->query($query);
	return $result;
}

function GetGame($id_game)
{
	$db = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);

	$sql = "SELECT * FROM game 
			WHERE id_game = ? 
			LIMIT 1";

	$stmt = $db->prepare($sql);
	$stmt->bind_param("i", $id_game);
	$stmt->execute();
	$result = $stmt->get_result();

	if ($result->num_rows <= 0) {
		return null;
	}

	$stmt->close();
	$db->close();
	return $result->fetch_assoc();
}

function DisplayError($error_name)
{
	return isset($_SESSION[$error_name]) ? "<span style='color: red;'>" . $_SESSION[$error_name] . "</span>" : '';
}

function DisplayColoredMessage($error_name, $color)
{
	if (isset($_SESSION[$error_name]) && strlen($_SESSION[$error_name]) > 0) {

		return "
            <span style='
                color: " . $color . "; 
				margin-top: 20px;
                background-color: #d7f6c0; 
                padding: 10px; 
                border: 1px solid black; 
                border-radius: 5px; 
                font-weight: bold; 
                display: inline-block;
			'>" . $_SESSION[$error_name] . "</span>";

	}

	return '';
}

function checkname($username)
{
	if (strlen($username) < 4 || strlen($username) > 32) {
		$_SESSION['name_error'] = "Username must be at least 4 characters long";
		return false;
	}

	// username format
	if (!preg_match("/^[a-zA-Z0-9_-]+$/", $username)) {

		$_SESSION['name_error'] =
			"Username must consist of letters and numbers only";
		return false;
	}

	$db = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
	$sql = "SELECT * FROM user WHERE username = ?";
	$stmt = $db->prepare($sql);
	$stmt->bind_param('s', $username);
	$stmt->execute();
	$result = $stmt->get_result();

	// name already exists
	if ($result->num_rows > 0) {
		$_SESSION['name_error'] = "Name is already in use";
		return false;
	}

	$stmt->close();
	$db->close();
	return true;
}

function checkmail($mail)
{
	if (!filter_var($mail, FILTER_VALIDATE_EMAIL)) {
		$_SESSION['mail_error'] =
			"Incorrect email format";
		return false;
	}

	$db = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
	$sql = "SELECT * FROM user WHERE email = ?";
	$stmt = $db->prepare($sql);
	$stmt->bind_param('s', $mail);
	$stmt->execute();
	$result = $stmt->get_result();

	// email already exists
	if ($result->num_rows > 0) {
		$_SESSION['mail_error'] = "Email already in use";
		return false;
	}

	$stmt->close();
	$db->close();
	return true;
}

function CheckPassRegister($pwd)
{
	// too short
	if (strlen($pwd) < 4) {
		$_SESSION['pass_error'] =
			"Password length must be at least 4 characters long";
		return false;
	}

	return true;
}

function checkPasswordConfirmation($pwd, $pwd_conf)
{
	if ($pwd !== $pwd_conf) {
		$_SESSION['pas2_error'] =
			"Password confirmation doesn't match";
		return false;
	}

	return true;
}

function PassHash($password)
{
	return substr(hash('sha256', $password), 5, 32);
}

function RegisterUser($user, $pass, $userid, $role, $mail)
{
	include('include/settings.php');
	$db = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);

	$userid = md5(uniqid($user));
	$pass = PassHash($pass);
	$role = $user_roles['user'];

	$stmt = $db->prepare("INSERT INTO user 
						(username, password, id_user, role, email) 
						VALUES (?, ?, ?, ?, ?)");
	$stmt->bind_param("sssis", $user, $pass, $userid, $role, $mail);

	$stmt->execute();
	$_SESSION['message'] = "Registration successful!";
}

function CheckNameLogin($username)
{
	$db = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
	$sql = "SELECT * FROM user WHERE username = ?";
	$stmt = $db->prepare($sql);
	$stmt->bind_param('s', $username);
	$stmt->execute();
	$result = $stmt->get_result();

	// name doesn't exists
	if ($result->num_rows <= 0) {
		$_SESSION['name_error'] = "No such user";
		return false;
	}

	$stmt->close();
	$db->close();
	return true;
}

function GetLogin($username, $password)
{
	$db = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);

	$sql = "SELECT * FROM user 
	WHERE username = ? AND password = ? 
	LIMIT 1";

	$stmt = $db->prepare($sql);
	$stmt->bind_param("ss", $username, $password);
	$stmt->execute();
	$result = $stmt->get_result();

	// wrong password
	if ($result->num_rows <= 0) {
		$_SESSION['pass_error'] = "Incorrect password";
		return null;
	}

	$user = $result->fetch_assoc();

	// Check if the user is banned
	if ($user['role'] == USER_ROLES[ROLE_BANNED]) {
		$_SESSION['name_error'] = "This account is banned.";
		return null;
	}

	$stmt->close();
	$db->close();
	return $user;
}

function UpdateLastLogin($id_user)
{
	$db = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);

    $sql = "UPDATE user SET last_login_date = NOW() WHERE id_user = ?";

	$stmt = $db->prepare($sql);
	$stmt->bind_param("s", $id_user);
	$stmt->execute();

	$stmt->close();
	$db->close();
}

function GetAvailableGameKeys($id_game)
{
	$db = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);


	$sql = "SELECT gk.*, COUNT(*) AS stock, s.shop_title
            FROM game_key gk
            JOIN shop s ON gk.id_seller = s.id_user
            WHERE gk.id_game = ?
            AND gk.status = 'available'
            GROUP BY gk.price, gk.id_seller, gk.platform
            ORDER BY gk.price ASC, gk.id_key ASC";

	$stmt = $db->prepare($sql);
	$stmt->bind_param("i", $id_game);
	$stmt->execute();
	$result = $stmt->get_result();

	$stmt->close();
	$db->close();
	return $result;
}

function IsInCart($id_user, $id_key)
{
	$db = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);

	$sql = "SELECT COUNT(*) AS count FROM cart_items 
            WHERE id_user = ? AND id_key = ?";

	$stmt = $db->prepare($sql);
	$stmt->bind_param("si", $id_user, $id_key);
	$stmt->execute();
	$result = $stmt->get_result();
	$row = $result->fetch_assoc();

	$stmt->close();
	$db->close();

	return $row['count'] > 0;
}

function AddToCart($id_user, $id_key)
{
	$db = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);

	$sql = "INSERT INTO cart_items (id_user, id_key) VALUES (?, ?)";

	$stmt = $db->prepare($sql);
	$stmt->bind_param("si", $id_user, $id_key);
	$stmt->execute();

	$stmt->close();
	$db->close();
}

function GetCart($id_user)
{
	$db = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);

	$sql = "SELECT 
			gk.*, 
			g.title 
			FROM cart_items c 
			JOIN game_key gk ON c.id_key = gk.id_key 
			JOIN game g ON g.id_game = gk.id_game 
			WHERE c.id_user = ?;";

	$stmt = $db->prepare($sql);
	$stmt->bind_param("s", $id_user);
	$stmt->execute();
	$result = $stmt->get_result();

	$cart = [];
	while ($row = $result->fetch_assoc()) {
		$cart[] = $row;
	}

	$stmt->close();
	$db->close();

	return $cart;
}

function CheckAvailibility($id_key)
{
	$db = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);

	$sql = "SELECT * FROM game_key WHERE id_key = ? 
			AND status = 'available'
			LIMIT 1";

	$stmt = $db->prepare($sql);
	$stmt->bind_param("i", $id_key);
	$stmt->execute();

	$stmt->store_result();
	$is_available = $stmt->num_rows > 0;

	$stmt->close();
	$db->close();

	return $is_available;
}

function CheckOut($id_user, $keys, $total_price)
{
	if (!ReduceBalance($id_user, $total_price)) {
		$_SESSION["checkout_error"] = "Not enough balance for purchase.";
		return false;
	}

	foreach ($keys as $key) {
		$info = GetKeySellInfo($key);
		AddBalance($info["id_seller"], $info["price"]);
	}

	MarkKeys($keys, 'sold');
	MakeOrder($id_user, $keys, $total_price);
	return true;
}

function GetBalance($id_user)
{
	$db = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);

	$sql = "SELECT balance 
			FROM user 
			WHERE id_user = ?";

	$stmt = $db->prepare($sql);
	$stmt->bind_param("s", $id_user);
	$stmt->execute();
	$result = $stmt->get_result()->fetch_assoc();

	$stmt->close();
	$db->close();

	return $result['balance'];
}

function ReduceBalance($id_user, $amount)
{
	// check
	$balance = GetBalance($id_user);
	if ($amount > $balance) {
		return false;
	}

	// reduce
	$db = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);

	$sql = "UPDATE user 
	        SET balance = balance - ? 
	        WHERE id_user = ?";

	$stmt = $db->prepare($sql);
	$stmt->bind_param("ds", $amount, $id_user);
	$stmt->execute();
	$stmt->close();
	$db->close();

	return true;
}

function AddBalance($id_user, $amount)
{
	// add
	$db = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);

	$sql = "UPDATE user 
	        SET balance = balance + ? 
	        WHERE id_user = ?";

	$stmt = $db->prepare($sql);
	$stmt->bind_param("ds", $amount, $id_user);
	$stmt->execute();
	$stmt->close();
	$db->close();

	return true;
}

function GetKeySellInfo($id_key)
{
	$db = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);

	$sql = "SELECT price, id_seller FROM game_key 
			WHERE id_key = ?";

	$stmt = $db->prepare($sql);

	$stmt->bind_param("i", $id_key);
	$stmt->execute();
	$result = $stmt->get_result();

	$stmt->close();
	$db->close();
	return $result->fetch_assoc();
}

function MarkKeys($keys, $status)
{
	$db = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);

	$sql = "UPDATE game_key 
            SET status = ? 
            WHERE id_key = ?";

	$stmt = $db->prepare($sql);

	foreach ($keys as $id_key) {
		$stmt->bind_param("si", $status, $id_key);
		$stmt->execute();
	}

	$stmt->close();
	$db->close();
}

function MakeOrder($id_user, $keys, $total_price)
{
	// order
	$db = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);

	$sql = "INSERT INTO game_order 
			(id_user, price) 
			VALUES (?, ?)";

	$stmt = $db->prepare($sql);
	$stmt->bind_param("sd", $id_user, $total_price);
	$stmt->execute();

	$id_order = $db->insert_id;
	$stmt->close();

	// keys in order
	$sql = "INSERT INTO keys_in_order 
			(id_key, id_order) 
			VALUES (?, ?)";

	$stmt = $db->prepare($sql);
	foreach ($keys as $id_key) {
		$stmt->bind_param("ii", $id_key, $id_order);
		$stmt->execute();
	}

	$stmt->close();
	$db->close();
}

function ClearCart($id_user)
{
	$db = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);

	$sql = "DELETE FROM cart_items 
			WHERE id_user = ?";

	$stmt = $db->prepare($sql);
	$stmt->bind_param("s", $id_user);
	$stmt->execute();

	$stmt->close();
	$db->close();
}

function RemoveFromCart($id_user, $id_key)
{
	$db = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);

	$sql = "DELETE FROM cart_items 
			WHERE id_user = ? 
			AND id_key = ?";

	$stmt = $db->prepare($sql);
	$stmt->bind_param("si", $id_user, $id_key);
	$stmt->execute();

	$stmt->close();
	$db->close();
}

function FindReplacement($id_key)
{
	$db = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);

	$sql = "SELECT id_key 
			FROM game_key 
			WHERE STATUS = 'available' 
			AND id_game = (SELECT id_game FROM game_key WHERE id_key = ?)
			AND price = (SELECT price FROM game_key WHERE id_key = ?)
			AND platform = (SELECT platform FROM game_key WHERE id_key = ?)
			AND id_seller = (SELECT id_seller FROM game_key WHERE id_key = ?) 
			LIMIT 1";

	$stmt = $db->prepare($sql);
	$stmt->bind_param("iiii", $id_key, $id_key, $id_key, $id_key);
	$stmt->execute();
	$result = $stmt->get_result();

	$stmt->close();
	$db->close();
	return $result->fetch_assoc();
}

function GetUserHistory($id_user)
{
	$db = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);

	$sql = "SELECT o.id_order, o.order_date, o.price, k.id_key, g.title, gk.price as gk_price 
        FROM game_order o
        JOIN keys_in_order k ON o.id_order = k.id_order
        JOIN game_key gk ON k.id_key = gk.id_key
		JOIN game g ON g.id_game = gk.id_game 
        WHERE o.id_user = ?
        ORDER BY o.order_date DESC";

	$stmt = $db->prepare($sql);
	$stmt->bind_param("s", $id_user);
	$stmt->execute();
	$result = $stmt->get_result();

	$purchases = [];
	while ($row = $result->fetch_assoc()) {
		$purchases[] = $row;
	}

	$stmt->close();
	$db->close();

	return $purchases;
}

function GetUserKeys($id_user)
{
	$db = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);

	$sql = "SELECT gk.id_key, g.title, gk.code, gk.platform, go.order_date, go.id_order 
			FROM game_key gk 
			JOIN keys_in_order kio ON gk.id_key = kio.id_key 
			JOIN game g ON g.id_game = gk.id_game 
        	JOIN game_order go ON kio.id_order = go.id_order 
        	WHERE go.id_user = ?
			ORDER BY go.order_date DESC";

	$stmt = $db->prepare($sql);
	$stmt->bind_param("s", $id_user);
	$stmt->execute();
	$result = $stmt->get_result();

	$stmt->close();
	$db->close();

	return $result;
}

function GetSellerKeys($id_user)
{
	$db = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);

	$sql = "SELECT gk.id_key, g.title, gk.code, gk.platform, gk.status, gk.price, 
			u.username, go.order_date, go.id_order 
			FROM game_key gk 
			JOIN game g ON g.id_game = gk.id_game 
        	LEFT JOIN keys_in_order kio ON kio.id_key = gk.id_key 
        	LEFT JOIN game_order go ON kio.id_order = go.id_order 
			LEFT JOIN user u ON go.id_user = u.id_user 
			WHERE gk.id_seller = ? 
			ORDER BY go.order_date DESC, g.title, gk.platform, gk.status";

	$stmt = $db->prepare($sql);
	$stmt->bind_param("s", $id_user);
	$stmt->execute();
	$result = $stmt->get_result();

	$stmt->close();
	$db->close();

	return $result;
}

function SearchForGames($search)
{
	$db = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);

	$sql = "SELECT g.*, 
               (SELECT MIN(gk.price) 
                FROM game_key gk 
                WHERE gk.id_game = g.id_game 
                  AND gk.status = 'available') AS price 
        FROM game g
        WHERE g.title LIKE ?";


	$stmt = $db->prepare($sql);
	$search = "%" . $search . "%";
	$stmt->bind_param("s", $search);
	$stmt->execute();
	$result = $stmt->get_result();

	$stmt->close();
	$db->close();

	return $result;
}

function GetUserInfoFromName($username)
{
	$db = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);

	$sql = "SELECT username, email, role, last_login_date, creation_date FROM user 
			WHERE username = ? 
			LIMIT 1";

	$stmt = $db->prepare($sql);
	$stmt->bind_param("s", $username);
	$stmt->execute();
	$result = $stmt->get_result();

	$stmt->close();
	$db->close();
	return $result->fetch_assoc();
}

function GetShopInfoFromId($id_user)
{
	$db = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);

	$sql = "SELECT * FROM shop 
			WHERE id_user = ? 
			LIMIT 1";

	$stmt = $db->prepare($sql);
	$stmt->bind_param("s", $id_user);
	$stmt->execute();
	$result = $stmt->get_result();

	$stmt->close();
	$db->close();
	return $result->fetch_assoc();
}

function GetShopReviews($id_user)
{
	$db = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);

	$sql = "SELECT sr.*, u.username
			FROM shop_ratings sr 
			JOIN user u ON u.id_user = sr.id_user 
			WHERE id_seller = ? 
			ORDER BY review_date DESC";

	$stmt = $db->prepare($sql);
	$stmt->bind_param("s", $id_user);
	$stmt->execute();
	$result = $stmt->get_result();

	$stmt->close();
	$db->close();
	return $result;
}

function GetStarAverage($id_user)
{
	$db = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);

	$sql = "SELECT AVG(rating) AS stars FROM shop_ratings 
            WHERE id_seller = ?";

	$stmt = $db->prepare($sql);
	$stmt->bind_param("s", $id_user);
	$stmt->execute();
	$result = $stmt->get_result();

	$average = null;
	if ($row = $result->fetch_assoc()) {
		$average = $row['stars'];
	}

	$stmt->close();
	$db->close();
	return $average;
}

function HasBought($id_user, $id_seller)
{
	$db = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);

	$sql = "SELECT COUNT(*) as count 
            FROM game_order go 
			JOIN keys_in_order kio ON go.id_order = kio.id_order 
			JOIN game_key gk ON kio.id_key = gk.id_key 
			WHERE go.id_user = ? AND gk.id_seller = ? ";


	$stmt = $db->prepare($sql);
	$stmt->bind_param("ss", $id_user, $id_seller);
	$stmt->execute();
	$result = $stmt->get_result()->fetch_assoc();

	$stmt->close();
	$db->close();

	return $result['count'] > 0;
}

function SubmitShopReview($id_seller, $id_user, $rating, $review = null)
{
	$db = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);

	$sql = "INSERT INTO shop_ratings (id_user, id_seller, rating, review_text) 
				VALUES (?, ?, ?, ?)";

	$stmt = $db->prepare($sql);
	$stmt->bind_param("ssis", $id_user, $id_seller, $rating, $review);
	$stmt->execute();

	$stmt->close();
	$db->close();
}

function HasReviewed($id_user, $id_seller)
{
	$db = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);

	$sql = "SELECT COUNT(*) as count 
            FROM shop_ratings 
			WHERE id_user = ? AND id_seller = ?";


	$stmt = $db->prepare($sql);
	$stmt->bind_param("ss", $id_user, $id_seller);
	$stmt->execute();
	$result = $stmt->get_result()->fetch_assoc();

	$stmt->close();
	$db->close();

	return $result['count'] > 0;
}

function GetAllUsersExcept($id_user)
{
	$db = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);

	$sql = "SELECT *  
            FROM user 
			WHERE id_user != ?";

	$stmt = $db->prepare($sql);
	$stmt->bind_param("s", $id_user);
	$stmt->execute();
	$result = $stmt->get_result();

	$stmt->close();
	$db->close();

	return $result;
}


function UpdateRole($new_role, $id_user)
{
	$db = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);

	$sql = "UPDATE user 
	        SET role = ? 
	        WHERE id_user = ?";

	$stmt = $db->prepare($sql);
	$stmt->bind_param("ii", $new_role, $id_user);
	$stmt->execute();
	$stmt->close();
	$db->close();

	return true;
}

function GetUser($id_user)
{
	$db = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);

	$sql = "SELECT * 
            FROM user 
			WHERE id_user = ?";

	$stmt = $db->prepare($sql);
	$stmt->bind_param("s", $id_user);
	$stmt->execute();
	$result = $stmt->get_result();

	$stmt->close();
	$db->close();

	return $result->fetch_assoc();
}

function CreateShop($id_user, $shop_name)
{
	if (HasShop($id_user))
		return false;

	$db = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);

	$sql = "INSERT INTO shop (id_user, shop_title) VALUES (?, ?)";

	$stmt = $db->prepare($sql);
	$stmt->bind_param("ss", $id_user, $shop_name);
	$stmt->execute();

	$stmt->close();
	$db->close();

	return true;
}

function HasShop($id_user)
{
	$db = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);

	$sql_check = "SELECT COUNT(*) AS count FROM shop WHERE id_user = ?";
	$stmt_check = $db->prepare($sql_check);
	$stmt_check->bind_param("s", $id_user);
	$stmt_check->execute();

	$result = $stmt_check->get_result();
	$row = $result->fetch_assoc();
	$stmt_check->close();
	$db->close();

	return $row['count'] > 0;
}

function SuspendUserCodes($id_user)
{
	$db = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);

	$sql = "UPDATE game_key 
            SET status = ? 
            WHERE id_seller = ? 
            AND status = ?";

	$stmt = $db->prepare($sql);

	$status_old = STATUS_SUSPENDED;
	$status_new = STATUS_AVAILABLE;

	$stmt->bind_param("sss", $status_old, $id_user, $status_new);
	$stmt->execute();

	$stmt->close();
	$db->close();
}

function UnsuspendUserCodes($id_user)
{
	$db = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);

	$sql = "UPDATE game_key 
            SET status = ? 
            WHERE id_seller = ? 
            AND status = ?";

	$stmt = $db->prepare($sql);

	$status_old = STATUS_AVAILABLE;
	$status_new = STATUS_SUSPENDED;

	$stmt->bind_param("sss", $status_old, $id_user, $status_new);
	$stmt->execute();

	$stmt->close();
	$db->close();
}

function isDeletable($id_user)
{
	$db = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);

	$sql = "SELECT 
            (SELECT balance FROM user WHERE id_user = ?) AS balance,
            (SELECT COUNT(*) FROM game_order WHERE id_user = ?) AS orders_count,
            (SELECT role FROM user WHERE id_user = ?) AS role
    ";

	$stmt = $db->prepare($sql);
	$stmt->bind_param("sss", $id_user, $id_user, $id_user);
	$stmt->execute();

	$result = $stmt->get_result()->fetch_assoc();

	$stmt->close();
	$db->close();

	// Check the conditions: no balance, no orders, and role is 'user' or 'banned'
	return (
		$result['balance'] == 0 &&
		$result['orders_count'] == 0 &&
		in_array($result['role'], [ROLE_USER, ROLE_BANNED])
	);
}

function DeleteUser($id_user)
{
	ClearCart($id_user);
	DeleteRatings($id_user);

	$db = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);

	$sql = "DELETE FROM user WHERE id_user = ?";

	$stmt = $db->prepare($sql);
	$stmt->bind_param("s", $id_user);
	$stmt->execute();

	$stmt->close();
	$db->close();
}

function DeleteRatings($id_user)
{
	$db = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);

	$sql = "DELETE FROM shop_ratings WHERE id_user = ?";

	$stmt = $db->prepare($sql);
	$stmt->bind_param("s", $id_user);
	$stmt->execute();

	$stmt->close();
	$db->close();
}

function BanUser($id_user)
{
	$role = USER_ROLES[ROLE_BANNED];

	SuspendUserCodes($id_user);
	UpdateRole($role, $id_user);
}

function GetAllGames()
{
	$db = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
	$sql = "SELECT id_game, title FROM game";
	$result = $db->query($sql);
	$games = [];

	while ($row = $result->fetch_assoc()) {
		$games[] = $row;
	}

	$db->close();
	return $games;
}

function AddGameKey($id_seller, $id_game, $platform, $price, $code)
{
	$db = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);

	$sql = "INSERT INTO game_key (id_seller, id_game, platform, price, code, status) 
            VALUES (?, ?, ?, ?, ?, ?)";

	$status = STATUS_AVAILABLE;
	$stmt = $db->prepare($sql);
	$stmt->bind_param("sisdss", $id_seller, $id_game, $platform, $price, $code, $status);
	$stmt->execute();

	$stmt->close();
	$db->close();
}

function KeyExists($code, $platform)
{
	$db = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);

	$sql = "SELECT COUNT(*) AS count 
			FROM game_key 
			WHERE code = ? 
			AND platform = ?";

	$stmt = $db->prepare($sql);
	$stmt->bind_param("ss", $code, $platform);
	$stmt->execute();
	$result = $stmt->get_result();
	$row = $result->fetch_assoc();

	$stmt->close();
	$db->close();

	return $row['count'] > 0;
}

function TitleExists($title)
{
	$db = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);

	$sql = "SELECT COUNT(*) AS count 
			FROM game 
			WHERE title = ?";

	$stmt = $db->prepare($sql);
	$stmt->bind_param("s", $title);
	$stmt->execute();
	$result = $stmt->get_result();
	$row = $result->fetch_assoc();

	$stmt->close();
	$db->close();

	return $row['count'] > 0;
}

function AddGame($title, $description, $release_date)
{
	$db = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);

	$sql = "INSERT INTO game (title, description, release_date) 
			VALUES (?, ?, ?)";

	$stmt = $db->prepare($sql);
	$stmt->bind_param("sss", $title, $description, $release_date);
	$stmt->execute();
	$stmt->close();
	$db->close();
}

function GetGamesLimited($limit, $offset)
{
	$db = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
	// $sql = "SELECT * FROM games LIMIT $limit OFFSET $offset";
	$sql = "SELECT * FROM game LIMIT ? OFFSET ?";

	$stmt = $db->prepare($sql);
	$stmt->bind_param("ii", $limit, $offset);
	$stmt->execute();
	$result = $stmt->get_result();

	$stmt->close();
	$db->close();

	return $result;
}


function GetTotalGames()
{
	$db = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
	$sql = "SELECT COUNT(*) AS total FROM game";

	$stmt = $db->prepare($sql);
	$stmt->execute();
	$result = $stmt->get_result();
	$row = $result->fetch_assoc();

	$stmt->close();
	$db->close();

	return $row['total'];
}