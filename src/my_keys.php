<?php
include('include/head.html');
include('include/functions.php');
include('include/popup.php');
?>


<?php
session_start();
if (!isset($_SESSION['id_login'])) {
    header("Location: index.php");
    exit();
}

$id_user = $_SESSION['id_login'];
?>

<script>
    function toggleCode(id) {
        var codeElement = document.getElementById('code-' + id);
        if (codeElement.style.display === 'none') {
            codeElement.style.display = 'inline';
        } else {
            codeElement.style.display = 'none';
        }
    }
</script>


<script>
    function showTab(tabId) {
        // Hide all tab content
        document.querySelectorAll('.tab-content').forEach(tab => tab.style.display = 'none');
        // Remove active class from all tab buttons
        document.querySelectorAll('.tab-button').forEach(button => button.classList.remove('active'));
        // Show the selected tab and set the button to active
        document.getElementById(tabId).style.display = 'block';
        document.querySelector(`[data-tab="${tabId}"]`).classList.add('active');
    }

    // Set the default tab on page load
    document.addEventListener('DOMContentLoaded', () => {
        showTab('bought-tab');
    });
</script>

<body>
    <?php include('include/header.php'); ?>

    <p class="under-header">My keys</p>

    <!-- tab navigation -->
    <?php if (HasShop($id_user)): ?>
        <div class="tab-container">
            <button class="tab-button active" data-tab="bought-tab" onclick="showTab('bought-tab')">Purchased keys</button>
            <button class="tab-button" data-tab="sold-tab" onclick="showTab('sold-tab')">Sold keys</button>
        </div>
    <?php endif; ?>


    <!-- Tab Content -->
    <div id="bought-tab" class="tab-content">

        <?php $result = GetUserKeys($id_user); ?>

        <!-- purchased keys -->
        <div class="my-keys-container">
            <?php if ($result->num_rows > 0): ?>
                <ul>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <li>
                            <strong>Game:</strong> <?php echo $row["title"]; ?><br>

                            <strong>Code:</strong>
                            <span id="code-<?php echo $row['id_key']; ?>" class="blurred-code">
                                <?php echo $row["code"]; ?>
                            </span><br>

                            <strong>Platform:</strong> <?php echo $row["platform"]; ?><br>
                            <strong>Order id:</strong> <?php echo $row["id_order"]; ?><br>
                            <strong>Purchased On:</strong> <?php echo $row["order_date"]; ?>
                        </li>
                    <?php endwhile; ?>
                </ul>
            <?php else: ?>
                <p>You have no purchased keys.</p>
            <?php endif; ?>
        </div>

    </div>

    <!-- sold keys -->
    <div id="sold-tab" class="tab-content" style="display: none;">

        <?php $result = GetSellerKeys($id_user); ?>

        <!-- purchased keys -->
        <div class="my-keys-container">
            <?php if ($result->num_rows > 0): ?>
                <ul>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <li>
                            <strong>Game:</strong> <?php echo $row["title"]; ?><br>

                            <strong>Code:</strong>
                            <span id="code-<?php echo $row['id_key']; ?>" class="blurred-code">
                                <?php echo $row["code"]; ?>
                            </span><br>

                            <strong>Platform:</strong> <?php echo $row["platform"]; ?><br>
                            <strong>Status:</strong> <?php echo $row["status"]; ?><br>
                            <?php if ($row["id_order"]): ?>
                                <strong>Order id:</strong> <?php echo $row["id_order"]; ?><br>

                                <strong>Buyer: </strong>
                                <a href="profile.php?p=<?php echo urlencode($row['username']); ?>">
                                    <?php echo $row['username']; ?>
                                </a><br>

                                <strong>Purchased On:</strong> <?php echo $row["order_date"]; ?>
                            <?php endif; ?>
                        </li>
                    <?php endwhile; ?>
                </ul>
            <?php else: ?>
                <p>You have no keys for sale.</p>
            <?php endif; ?>
        </div>

    </div>

    <?php include('include/footer.php'); ?>
</body>

</html>