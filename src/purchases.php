<?php
include('include/head.html');
include('include/functions.php');
?>


<?php
session_start();
if (!isset($_SESSION['id_login'])) {
    header("Location: index.php");
    exit();
}

$id_user = $_SESSION['id_login'];
$purchases = GetUserHistory($id_user);
?>

<body>
    <?php include('include/header.php'); ?>
    <p class="under-header">Purchase history</p>



    <div class="purchase-history-container">
        <?php if (empty($purchases)): ?>
            <h1 style="text-align: center">You haven't made any purchases yet.</h1>
        <?php else: ?>
            <?php
            $orders = [];
            foreach ($purchases as $purchase) {
                $orders[$purchase['id_order']]['order_date'] = $purchase['order_date'];
                $orders[$purchase['id_order']]['price'] = $purchase['price'];
                $orders[$purchase['id_order']]['keys'][] = $purchase['title'];
                $orders[$purchase['id_order']]['gk_prices'][] = $purchase['gk_price'];
            }

            foreach ($orders as $order_id => $order): ?>
                <div class="order">
                    <h3>Order ID: <?php echo $order_id; ?></h3>
                    <p><strong>Order Date:</strong> <?php echo $order['order_date']; ?></p>
                    <p><strong>Total Price:</strong> €<?php echo number_format($order['price'], 2); ?></p>
                    <p><strong>Games Purchased:</strong></p>
                    <ul>
                        <?php for ($i = 0; $i < count($order['keys']); $i++): ?>
                            <li><?php echo "€" . $order['gk_prices'][$i] . " - " . $order['keys'][$i]; ?></li>
                        <?php endfor; ?>
                    </ul>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>

    <?php include('include/footer.php'); ?>
</body>

</html>