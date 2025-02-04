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
$user = GetUser($id_user);
if ($user['role'] != USER_ROLES[ROLE_ADMIN]) {
    header("Location: index.php");
    exit();
}
?>

<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_user'])) {

    $selected_id = $_POST['id_user'];
    $selected_user = GetUser($selected_id);
    if (isset($_POST['user_role'])) {

        $id_update = $_POST['id_user'];
        $new_role = $_POST['user_role'];

        // promoting to seller/admin
        if (
            $selected_user['role'] == $user_roles[ROLE_USER]
            && ($new_role == $user_roles[ROLE_SELLER] ||
                $new_role == $user_roles[ROLE_ADMIN])
        )
            CreateShop($selected_id, $selected_user['username'] . "'s shop");

        // banning
        if ($new_role == $user_roles[ROLE_BANNED])
            SuspendUserCodes($selected_id);

        // unbanning
        if (
            $selected_user['role'] == $user_roles[ROLE_BANNED] &&
            $new_role != $user_roles[ROLE_BANNED]
        )
            UnsuspendUserCodes($selected_id);

        // update user role
        UpdateRole($new_role, $id_update);
    }

    if (isset($_POST['delete'])) {
        if (IsDeletable($selected_user['id_user']))
            DeleteUser($selected_user['id_user']);
        else {
            BanUser($selected_user['id_user']);
            // $_SESSION['admin_error'] = 
            echo "<script>showPopup('This user is not deletable, and will be banned instead');</script>";
        }
    }
}

// fetch all users excluding the current user
$result = GetAllUsersExcept($id_user);
?>

<body>
    <?php include('include/header.php'); ?>
    <p class="under-header">User manager</p>

    <div class="manager">
        <div class="table-wrapper">

            <table>
                <thead>
                    <tr>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Change role</th>
                        <th>Delete</th>
                    </tr>
                </thead>
                <tbody>

                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo $row['username']; ?></td>
                            <td><?php echo $row['email']; ?></td>

                            <!-- update -->
                            <td>
                                <form method="POST">
                                    <input type="hidden" name="id_user" value="<?php echo $row['id_user']; ?>">
                                    <select name="user_role">
                                        <option value="1" <?php echo $row['role'] == 1 ? 'selected' : ''; ?>>
                                            Admin
                                        </option>
                                        <option value="2" <?php echo $row['role'] == 2 ? 'selected' : ''; ?>>
                                            User
                                        </option>
                                        <option value="3" <?php echo $row['role'] == 3 ? 'selected' : ''; ?>>
                                            Seller
                                        </option>
                                        <option value="4" <?php echo $row['role'] == 4 ? 'selected' : ''; ?>>
                                            Banned
                                        </option>
                                    </select>
                            </td>
                            <td>
                                <button type="submit" class="submit-btn">Update</button>
                                </form>
                            </td>

                            <!-- delete -->
                            <td>
                                <form method="POST" onsubmit="return confirmDelete();">
                                    <input type="hidden" name="id_user" value="<?php echo $row['id_user']; ?>">
                                    <button type="submit" name="delete" class="delete-btn">Delete</button>
                                </form>
                            </td>

                            <script>
                                function confirmDelete() {
                                    return confirm("Are you sure you wan to delete this user?");
                                }
                            </script>
                        </tr>
                    <?php endwhile; ?>

                </tbody>
            </table>

        </div>
    </div>

    <?php include('include/footer.php'); ?>
</body>

</html>