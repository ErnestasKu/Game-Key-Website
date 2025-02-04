<?php
// session_start(); 
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>
<header class="main">
    <!-- title -->
    <div class="site-title">
        <h1><a href="index.php">Key Store</a></h1>
    </div>

    <!-- Search bar for desktop -->
    <div class="search-container-desktop">
        <form action="search.php" method="GET" class="search-form" onsubmit="return validateSearch(searchFieldDesktop)">
            <input type="text" name="s" placeholder="Search for games..." class="search-input" id="searchFieldDesktop">
            <button type="submit" class="search-button">
                <img src="images/glass2.png" alt="Search Icon" class="search-icon">
            </button>
        </form>
    </div>

    <!-- profile -->
    <div class="profile">
        <?php
        // check if user is logged in
        if (isset($_SESSION['id_login'])) {
            ?>
            <a href="profile.php?p=<?php echo ($_SESSION['name_login']); ?>" class="profile-link">
                <!-- <span><?php echo $_SESSION['name_login']; ?> ▼</span> -->
                <span><?php echo $_SESSION['name_login']; ?></span>
                <img src="images/profile-pic1.png" alt="Profile Icon" class="profile-icon">
            </a>
            <div class="dropdown-menu">

                <!-- user manager -->
                <?php if ($_SESSION['role_login'] == $user_roles[ROLE_ADMIN])
                    echo '<a href="user_manager.php">User manager</a>'; ?>

                <!-- add keys -->
                <?php if (
                    $_SESSION['role_login'] == $user_roles[ROLE_ADMIN] ||
                    $_SESSION['role_login'] == $user_roles[ROLE_SELLER]
                )
                    echo '<a href="add_keys.php">Sell keys</a>'; ?>

                <!-- add games -->
                <?php if ($_SESSION['role_login'] == $user_roles[ROLE_ADMIN])
                    echo '<a href="add_games.php">Add games</a>'; ?>

                <!-- universal -->
                <a href="profile.php?p=<?php echo ($_SESSION['name_login']); ?>">View Profile</a>
                <a href="cart.php">Cart</a>
                <a href="purchases.php">Purchases</a>
                <a href="my_keys.php">My keys</a>
                <a href="logout.php">Log Out</a>
            </div>
            <?php
        } else {
            ?>
            <a href="#" class="profile-link">
                <span>Sign in ▼</span>
                <img src="images/profile-pic2.png" alt="Profile Icon" class="profile-icon">
            </a>
            <div class="dropdown-menu">
                <a href="login.php">Log In</a>
                <a href="register.php">Register</a>
            </div>
            <?php
        }
        ?>
    </div>
</header>

<!-- Search bar for mobile -->
<div class="search-container-mobile">
    <form action="search.php" method="GET" class="search-form" onsubmit="return validateSearch('searchFieldMobile')">
        <input type="text" name="s" placeholder="Search for games..." class="search-input" id="searchFieldMobile">
        <button type="submit" class="search-button">
            <img src="images/glass2.png" alt="Search Icon" class="search-icon">
        </button>
    </form>
</div>

<script>
    function validateSearch(field) {
        const searchField = document.getElementById(field);
        return searchField.value.trim() !== "";
    }
</script>