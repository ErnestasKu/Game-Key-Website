<?php
include('include/head.html');
include('include/functions.php');
?>

<?php
session_start();
if (isset($_SESSION['id_login'])) {
    header("Location: index.php");
    exit();
}
?>

<body>
    <?php include('include/header.php'); ?>
    <p class="under-header">Account login</p>

    <div id="box">
        <form action="proc_login.php" method="post" id="text1">

            <label for="username">Username:</label>
            <input type="text" id="username" name="username" maxlength="30"
                value="<?php echo isset($_SESSION['username']) ? $_SESSION['username'] : ''; ?>">
            <?php echo DisplayError('name_error'); ?>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" maxlength="32">
            <?php echo DisplayError('pass_error'); ?>

            <input type="submit" value="Log in">
        </form>
    </div>

    <?php include('include/footer.php'); ?>
</body>

</html>