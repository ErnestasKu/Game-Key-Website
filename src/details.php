<?php
include('include/head.html');
include('include/functions.php');
include('include/popup.php');
?>

<?php
session_start();
$id_game = $_GET["g"];

if ($id_game === null || $id_game <= 0)
    die("Invalid game ID.");

$game = GetGame($id_game);

if (!$game)
    die("Game not found.");

// cart functions
if (isset($_POST['add_to_cart'])) {
    if (!isset($_SESSION['id_login'])) {
        header("Location: login.php");
        exit();
    } else if (isset($_POST['id_key'])) {
        $id_user = $_SESSION["id_login"];
        $id_key = $_POST['id_key'];

        if (!IsInCart($id_user, $id_key)) {
            AddToCart($id_user, $id_key);
            echo "<script>showPopup('Successfully added to cart!');</script>";
        } else {
            echo "<script>showPopup('This item is already inside of your cart');</script>";
        }
    }
}
?>

<body>
    <?php include('include/header.php'); ?>

    <div class="box-game">
        <div class="game-details-container">
            <h1 class="game-title"><?php echo htmlspecialchars($game["title"]); ?></h1>

            <div class="game-details">
                <img src="./images/logo1.png" class="game-cover">
                <div class="game-info">
                    <p><strong>Release Date:</strong> <?php echo htmlspecialchars($game["release_date"]); ?></p>
                    <p><strong>Description:</strong> <?php echo htmlspecialchars($game["description"]); ?></p>
                </div>
            </div>
        </div>
    </div>

    <div class="box-game">
        <div class="game-details-container">
            <?php
            $result = GetAvailableGameKeys($id_game);
            if ($result->num_rows > 0): ?>

                <div class="game-key-item">
                    <div class="labels">
                        <span class="label">Seller</span>
                        <span class="label">Price</span>
                        <span class="label">Stock</span>
                        <span class="label">Platform</span>
                        <span class="label"></span>
                    </div>

                    <?php
                    while ($key = $result->fetch_assoc()):
                        ?>
                        <div class="game-key-list-item">
                            <div class="seller">
                                <a href="shop.php?s=<?php echo $key['id_seller']; ?>">
                                    <?php echo $key['shop_title']; ?>
                                </a>
                            </div>

                            <div class="price">€<?php echo $key['price']; ?></div>
                            <div class="stock"><?php echo $key['stock']; ?></div>
                            <div class="platform"><?php echo $key['platform']; ?></div>

                            <div class="cart-button">
                                <form method="post">
                                    <input type="hidden" name="id_key" value="<?php echo $key['id_key']; ?>">
                                    <button type="submit" name="add_to_cart">Add to Cart</button>
                                </form>
                            </div>
                        </div>
                    <?php endwhile; ?>
                </div>

            <?php else: ?>
                <p style="text-align:center">No keys available yet.</p>
            <?php endif; ?>
        </div>
    </div>

    <?php include('include/footer.php'); ?>
</body>

</html>