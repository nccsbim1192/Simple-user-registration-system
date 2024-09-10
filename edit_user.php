<?php 
session_start(); 
// || $_SESSION['role'] != 'admin'
if (!isset($_SESSION['username']) ) {
    header('location: login.php');
}

// Connect to database
$db = mysqli_connect('localhost', 'root', '', 'registration');

// Fetch user data based on ID
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = "SELECT * FROM users WHERE id = $id";
    $result = mysqli_query($db, $query);
    $user = mysqli_fetch_assoc($result);
}

// Handle form submission
if (isset($_POST['edit_user'])|| $_SESSION['role'] != 'admin') {
    $username = mysqli_real_escape_string($db, $_POST['username']);
    $email = mysqli_real_escape_string($db, $_POST['email']);
    $role = mysqli_real_escape_string($db, $_POST['role']);

    $query = "UPDATE users SET username = '$username', email = '$email', role = '$role' WHERE id = $id";
    mysqli_query($db, $query);
    header('location: admin.php');
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit User</title>
    <link rel="stylesheet" type="text/css" href="admin.css">
</head>
<body>

<div class="form-container">
    <h2>Edit User</h2>
    <form method="POST" action="edit_user.php?id=<?php echo $id; ?>">
        <input type="text" name="username" value="<?php echo $user['username']; ?>" required>
        <input type="email" name="email" value="<?php echo $user['email']; ?>" required>
        <input type="text" name="role" value="<?php echo $user['role']; ?>" required>
        <input type="submit" name="edit_user" value="Edit User">
    </form>
</div>

</body>
</html>
