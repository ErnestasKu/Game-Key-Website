<?php
include('include/head.html');
include('include/functions.php');
include('include/popup.php');
?>

<?php
session_start();
if (!isset($_SESSION['id_login'])) {
    header("Location: login.php");
    exit();
}

$id_user = $_SESSION['id_login'];
$user = GetUser($id_user);
if (
    $user['role'] != USER_ROLES[ROLE_ADMIN] &&
    $user['role'] != USER_ROLES[ROLE_SELLER]
) {
    header("Location: index.php");
    exit();
}

$games = GetAllGames();

// key outcome message
if (isset($_SESSION['add_key_message'])) {

    echo "<script>showPopup('" . $_SESSION['add_key_message'] . "');</script>";
    unset($_SESSION['add_key_message']);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['game'], $_POST['platform'], $_POST['price'], $_POST['keys'])) {
    $game = (int) $_POST['game'];
    $platform = trim($_POST['platform']);
    $price = (float) $_POST['price'];
    $keys = array_filter(array_map('trim', explode("\n", $_POST['keys'])));

    // key validation
    foreach ($keys as $key) {
        if (strlen($key) > 25) {
            $_SESSION['key_error'] = "Codes must be up to 25 characters long.";
            header("Location: add_keys.php");
            exit();
        }

        if (KeyExists($key, $platform)) {
            $_SESSION['key_error'] = "Entered key already exists: " . $key;
            header("Location: add_keys.php");
            exit();
        }
    }

    if (count($keys) !== count(array_unique($keys))) {
        $_SESSION['key_error'] = "Duplicate codes entered.";
        header("Location: add_keys.php");
        exit();
    }

    // check before insert
    if (!empty($game) && !empty($platform) && $price > 0 && !empty($keys)) {
        foreach ($keys as $key) {
            AddGameKey($id_user, $game, $platform, $price, $key);
        }
        $_SESSION['add_key_message'] = "Keys successfully added!";
        header("Location: add_keys.php");
        exit();
    } else {
        $_SESSION['add_key_message'] = "Error. Something went while entering codes. Please try again.";
    }
}
?>

<body>
    <?php include('include/header.php'); ?>
    <p class="under-header">Add keys</p>

    <div class="form-container">
        <form method="POST">

            <!-- game -->
            <label for="game">Game title:</label>
            <select id="game" name="game" required>
                <option value="">Select Game</option>
                <?php foreach ($games as $game): ?>
                    <option value="<?php echo $game['id_game']; ?>"><?php echo htmlspecialchars($game['title']); ?></option>
                <?php endforeach; ?>
            </select>

            <!-- platform  -->
            <label for="platform">Platform:</label>
            <select id="platform" name="platform" required>
                <option value="">Select Platform</option>
                <option value="steam">Steam</option>
                <option value="epic">Epic</option>
                <option value="gog">GOG</option>
                <option value="xbox">Xbox</option>
                <option value="playstation">PlayStation</option>
            </select>

            <!-- price -->
            <label for="price">Price:</label>
            <input type="number" id="price" name="price" step="0.01" min="0" max="10000" required>

            <!-- keys -->
            <label for="keys">Keys (one per line):</label>
            <textarea id="keys" name="keys" rows="6" required></textarea>
            <?php echo DisplayError('key_error'); ?><br>

            <!-- submit -->
            <button type="submit" class="submit-btn">Add keys</button>
        </form>
    </div>
    <?php ClearErrors() ?>

    <?php include('include/footer.php'); ?>
</body>

</html>