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

if ($_SESSION['role_login'] != USER_ROLES[ROLE_ADMIN]) {
    header("Location: index.php");
    exit();
}

if (isset($_SESSION['add_game_message'])) {

    echo "<script>showPopup('" . $_SESSION['add_game_message'] . "');</script>";
    unset($_SESSION['add_game_message']);
}

if (
    $_SERVER['REQUEST_METHOD'] === 'POST' &&
    isset($_POST['title'], $_POST['description'], $_POST['release_date'])
) {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $release_date = $_POST['release_date'];

    $_SESSION['AG_title'] = $title;
    $_SESSION['AG_description'] = $description;
    $_SESSION['AG_release_date'] = $release_date;

    if (TitleExists($title)) {
        $_SESSION['GA_title_error'] = "Game title already exists.";
        header("Location: add_games.php");
        exit();
    } else {
        AddGame($title, $description, $release_date);
        $_SESSION['add_game_message'] = "Game successfully added.";
        unset($_SESSION['AG_title'], $_SESSION['AG_description'], $_SESSION['AG_release_date']);
        header("Location: add_games.php");
        exit();
    }
}

?>

<body>
    <?php include('include/header.php'); ?>
    <p class="under-header">Add games</p>


    <div class="form-container">
        <form method="POST">
            <label for="title">Game title:</label>
            <input type="text" id="title" name="title" maxlength="255"
                value="<?php echo isset($_SESSION['AG_title']) ? htmlspecialchars($_SESSION['AG_title']) : ''; ?>"
                required>
            <?php echo DisplayError('GA_title_error'); ?><br>

            <label for="description">Description:</label>
            <textarea id="description" name="description" rows="5" maxlength="500"
                required><?php echo isset($_SESSION['AG_description']) ? htmlspecialchars($_SESSION['AG_description']) : ''; ?></textarea>

            <label for="release_date">Release Date:</label>
            <input type="date" id="release_date" name="release_date"
                value="<?php echo isset($_SESSION['AG_release_date']) ? htmlspecialchars($_SESSION['AG_release_date']) : ''; ?>"
                required>

            <button type="submit" class="submit-btn">Add game</button>
        </form>
    </div>
    <?php ClearErrors() ?>

    <?php include('include/footer.php'); ?>
</body>

</html>