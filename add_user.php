<?php 
session_start(); 
// || $_SESSION['role'] != 'admin'
if (!isset($_SESSION['username']) ) {
    header('location: login.php');
}

// Connect to database
$db = mysqli_connect('localhost', 'root', '', 'registration');

// Handle form submission
if (isset($_POST['add_user'])) {
    $username = mysqli_real_escape_string($db, $_POST['username']);
    $email = mysqli_real_escape_string($db, $_POST['email']);
    $password = md5(mysqli_real_escape_string($db, $_POST['password'])); // Encrypt password
    $role = mysqli_real_escape_string($db, $_POST['role']);

    $query = "INSERT INTO users (username, email, password, role) VALUES ('$username', '$email', '$password', '$role')";
    mysqli_query($db, $query);
    header('location: admin.php');
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add New User</title>
    <link rel="stylesheet" type="text/css" href="admin.css">
</head>
<body>

<div class="form-container">
    <h2>Add New User</h2>
    <form method="POST" action="add_user.php">
        <input type="text" name="username" placeholder="Username" required>
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Password" required>
        <input type="text" name="role" placeholder="Role (user/admin)" required>
        <input type="submit" name="add_user" value="Add User">
    </form>
</div>

</body>
</html>
