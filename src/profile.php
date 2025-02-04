<?php
include('include/head.html');
include('include/functions.php');
?>

<?php
$user = "";
if (isset($_GET["p"])) {
    $user = GetUserInfoFromName($_GET["p"]);
}
?>


<body>
    <?php include('include/header.php'); ?>
    <p class="under-header">User Profile</p>

    <div class="profile-container">
        <?php if ($user): ?>
            <h1 class="profile-name"><?php echo $user['username']; ?></h1>

            <div class="profile-info">
                <!-- <p><strong>Username:</strong> <?php echo htmlspecialchars($user['username']); ?></p> -->
                <p><strong>Email:</strong> <?php echo htmlspecialchars($user['email']); ?></p>
                <p><strong>Last Login:</strong> <?php echo htmlspecialchars($user['last_login_date']); ?></p>
                <p><strong>Account Created:</strong> <?php echo htmlspecialchars($user['creation_date']); ?></p>
            </div>

        <?php else: ?>
            <p>No such user found.</p>
        <?php endif; ?>
    </div>

    <?php include('include/footer.php'); ?>
</body>

</html>