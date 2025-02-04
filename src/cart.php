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


if (isset($_SESSION['removed_keys'])) {
    // keys removed
    $message = "Unofrtunately, the selected keys for the following games are no longer in stock: ";

    $titles = array_map(function ($item) {
        return $item['title'];
    }, $_SESSION['removed_keys']);
    $message .= implode(", ", $titles);
    echo "<script>showPopup('" . addslashes($message) . "');</script>";
    unset($_SESSION['removed_keys']);

} else if (isset($_SESSION['success'])) {
    // success
    echo "<script>showPopup('" . $_SESSION['success'] . "');</script>";
    unset($_SESSION['success']);
}


$id_user = $_SESSION['id_login'];

if (isset($_POST['remove-item'])) {
    RemoveFromCart($id_user, $_POST["remove-item"]);
}

$cart = GetCart($id_user);
$total_sum = array_sum(array_column($cart, 'price'));


// validate if keys are in stock
$keys_final = [];
$reset_page = false;

foreach ($cart as $item) {
    // if not expired/sold
    if (CheckAvailibility($item['id_key'])) {
        array_push($keys_final, $item['id_key']);
    } else {
        // try to find a replacement otherwise
        $id_new_key = FindReplacement($item['id_key']);

        if (!$id_new_key || $id_new_key == null) {
            // if none found
            RemoveFromCart($id_user, $item['id_key']);
            $_SESSION['removed_keys'][] = $item;
            $reset_page = true;
        } else {
            // if found 
            array_push($keys_final, $id_new_key);
        }
    }
}

if ($reset_page) {
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

// checkout
if (isset($_POST['checkout'])) {
    if (CheckOut($id_user, $keys_final, $total_sum)) {
        // on success
        $_SESSION["success"] = 'Checkout successful!';
        ClearCart($id_user);
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    } else {
        // on failure
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    }
}
?>

<body>
    <?php include('include/header.php'); ?>
    <p class="under-header">Your cart</p>

    <div class="cart-container">

        <?php if (empty($cart)): ?>
            <h1>Your cart is empty.</h1>
        <?php else: ?>
            <div class="cart-items">
                <?php foreach ($cart as $item): ?>
                    <div class="cart-item">
                        <div class="cart-item-details">
                            <p><strong>Game:</strong> <?php echo $item["title"]; ?></p>
                            <p><strong>Price:</strong> €<?php echo $item["price"]; ?></p>
                            <p><strong>Platform:</strong> <?php echo $item["platform"]; ?></p>
                        </div>
                        <form method="POST" action="">
                            <input type="hidden" name="remove-item" value="<?php echo $item['id_key']; ?>">
                            <button type="submit" class="remove-item">Remove</button>
                        </form>
                    </div>
                <?php endforeach; ?>
            </div>

            <div class="cart-total">
                <p><strong>Total:</strong>
                    €<?php echo number_format($total_sum, 2); ?></p>
            </div>

            <div class="cart-total">
                <p><strong>Your balance:</strong>
                    €<?php echo number_format(GetBalance($id_user), 2); ?></p>
            </div>

            <form method="post">
                <button type="submit" name="checkout" class="checkout-button">Checkout</button>
            </form>
        <?php endif; ?>
    </div>

    <?php include('include/footer.php'); ?>
</body>

</html>