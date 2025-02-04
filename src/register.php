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

    <p class="under-header">Account registration</p>
    <div id="box">
        <form action="proc_register.php" method="post" id="text1">

            <label for="username">Username:</label>
            <input type="text" id="username" name="username" maxlength="32" required
                value="<?php echo isset($_SESSION['username']) ? htmlspecialchars($_SESSION['username']) : ''; ?>">
            <?php echo DisplayError('name_error'); ?>

            <label for="e-mail">Email:</label>
            <input type="text" id="email" name="email" maxlength="50" required
                value="<?php echo isset($_SESSION['email']) ? ($_SESSION['email']) : ''; ?>">
            <?php echo DisplayError('mail_error'); ?>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" maxlength="32" required>
            <?php echo DisplayError('pass_error'); ?>

            <label for="password_confirm">Password confirmation:</label>
            <input type="password" id="password_confirm" name="password_confirm" maxlength="32" required>
            <?php echo DisplayError('pas2_error'); ?>

            <input type="submit" value="Sign up">
        </form>
    </div>

    <?php include('include/footer.php'); ?>
</body>

<?php ClearErrors(); ?>

</html>