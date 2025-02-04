<?php
include('include/head.html');
include('include/functions.php');

$items_per_page = 8;

$page = isset($_GET['page']) ? (int) $_GET['page'] : 1;
$offset = ($page - 1) * $items_per_page;

$total_games = GetTotalGames();
$result = GetGamesLimited($items_per_page, $offset);

?>

<body>
    <?php include('include/header.php'); ?>

    <!-- game list -->
    <h1 class="under-header">Available Games:</h1>
    <div class="index-box">
        <?php
        while ($product = $result->fetch_assoc()): ?>
            <div class="index-game">
                <img src="./images/logo2.png" class="index-cover" loading="lazy">
                <h2><?php echo htmlspecialchars($product['title']); ?></h2>
                <a href="details.php?g=<?php echo urlencode($product['id_game']); ?>">View keys</a>
            </div>
        <?php endwhile; ?>
    </div>

    <!-- pagination -->
    <div class="pagination">
        <?php if ($page > 1): ?>
            <a href="?page=1">First</a>
            <a href="?page=<?php echo $page - 1; ?>">Previous</a>
        <?php endif; ?>
        <span>Page <?php echo $page; ?></span>
        <?php if ($page * $items_per_page < $total_games): ?>
            <a href="?page=<?php echo $page + 1; ?>">Next</a>
            <a href="?page=<?php echo ceil($total_games / $items_per_page); ?>">Last</a>
        <?php endif; ?>
    </div>

    <?php include('include/footer.php'); ?>
</body>

</html>