<?php
include('include/head.html');
include('include/functions.php');
?>

<?php
$search = "";
if (isset($_GET["s"])) {
    $search = $_GET["s"];
    $search_list = SearchForGames($search);
}
?>


<body>
    <?php include('include/header.php'); ?>

    <h1 class="page-title">Search for: <?php echo $search; ?></h1>
    <?php if (empty($search))
        echo '<h2 style="text-align:center">No such game found</h2>'; ?>

    <div>
        <?php while ($game = $search_list->fetch_assoc()): ?>
            <div class="box-search">
                <div>
                    <a href="details.php?g=<?php echo $game['id_game']; ?>">
                        <img src="./images/logo1.png" class="game-search-cover" alt="Game Cover">
                    </a>
                </div>
                <div class="game-search-details">
                    <a href="details.php?g=<?php echo $game['id_game']; ?>" class="game-serach-title" alt="Game Cover"
                        loading="lazy">
                        <p class="game-serach-title"><?php echo $game["title"]; ?></p>
                    </a>
                    <div>
                        <p><strong>Release Date:</strong> <?php echo $game["release_date"]; ?></p>
                        <p class="game-serach-price">
                            <strong><?php echo isset($game["price"]) ? '€' . $game["price"] : 'n/a'; ?></strong>
                        </p>
                    </div>
                </div>
            </div>
        <?php endwhile; ?>

    </div>

    <?php include('include/footer.php'); ?>
</body>

</html>