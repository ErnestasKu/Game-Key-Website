<?php
include('include/head.html');
include('include/functions.php');
?>

<?php
session_start();
$id_shop_owner = "";
$shop = "";
$reviews = [];

if (isset($_SESSION["id_login"])) {
    $id_user = $_SESSION["id_login"];
}

if (isset($_GET["s"])) {
    $id_shop_owner = $_GET["s"];
    $shop = GetShopInfoFromId($id_shop_owner);
    $reviews = GetShopReviews($id_shop_owner);
}

// Handle shop rating submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['rating'], $_POST['review'])) {
    $rating = (int) $_POST['rating'];
    $review = isset($_POST['review']) ? trim($_POST['review']) : null;

    if ($rating >= 1 && $rating <= 5) {
        SubmitShopReview($id_shop_owner, $_SESSION['id_login'], $rating, $review);
        header("Location: shop.php?s=" . urlencode($id_shop_owner));
        exit;
    }
}
?>

<body>
    <?php include('include/header.php'); ?>
    <p class="under-header">Shop</p>

    <div class="shop-container">
        <?php if ($shop): ?>

            <div>
                <h1 class="shop-name"><?php echo $shop['shop_title']; ?></h1>
                <p class="review-rating"><strong>Stars: <?php echo round(GetStarAverage($id_shop_owner), 1); ?> / 5
                        ⭐</strong>
                </p>
            </div>

            <!-- shop Rating Form -->
            <?php if (
                isset($id_user) &&
                HasBought($id_user, $id_shop_owner) &&
                !HasReviewed($id_user, $id_shop_owner) &&
                $id_user != $id_shop_owner
            ): ?>

                <div class="rating-form">
                    <h2>Rate this Shop</h2>
                    <form method="POST">
                        <label for="rating">Rating (1-5 stars):</label>
                        <input type="number" id="rating" name="rating" min="1" max="5" required>
                        <label for="review">Review:</label>
                        <textarea id="review" name="review" rows="4" maxlength="500"></textarea>

                        <button type="submit">Submit Review</button>
                    </form>
                </div>

            <?php endif; ?>

            <!-- Shop Reviews Section -->
            <div class="reviews-section">
                <h2 class="review-header">Reviews</h2>
                <?php if (!empty($reviews)): ?>
                    <?php foreach ($reviews as $review): ?>
                        <div class="review-item">

                            <p>
                                <strong>
                                    <a href="profile.php?p=<?php echo urlencode($review['username']); ?>">
                                        <?php echo $review['username']; ?>
                                    </a>
                                </strong>
                            </p>
                            <p>Rating: <?php echo $review['rating']; ?> / 5 ⭐</p>
                            <p><small>Posted on: <?php echo $review['review_date']; ?></small></p>
                            <p><?php echo htmlspecialchars($review['review_text']); ?></p>

                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>No reviews yet.</p>
                <?php endif; ?>
            </div>
        <?php else: ?>
            <p>No such shop found.</p>
        <?php endif; ?>
    </div>

    <?php include('include/footer.php'); ?>
</body>

</html>