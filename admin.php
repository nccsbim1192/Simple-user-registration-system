<?php 
session_start(); 
// 
// Check if the user is logged in as an admin
if (!isset($_SESSION['username']) || $_SESSION['role'] != 'admin') {
    $_SESSION['msg'] = "You must log in as an admin first";
    header('location: login.php');
}

// Connect to database
$db = mysqli_connect('localhost', 'root', '', 'registration');

// Fetch all users
$query = "SELECT * FROM users";
$results = mysqli_query($db, $query);

// Count total users
$total_users_query = "SELECT COUNT(*) as total_users FROM users";
$total_users_result = mysqli_query($db, $total_users_query);
$total_users = mysqli_fetch_assoc($total_users_result)['total_users'];

// Count total admin users
$admin_users_query = "SELECT COUNT(*) as total_admins FROM users WHERE role = 'admin'";
$admin_users_result = mysqli_query($db, $admin_users_query);
$total_admins = mysqli_fetch_assoc($admin_users_result)['total_admins'];

// Count total regular users
$regular_users_query = "SELECT COUNT(*) as total_regulars FROM users WHERE role = 'user'";
$regular_users_result = mysqli_query($db, $regular_users_query);
$total_regulars = mysqli_fetch_assoc($regular_users_result)['total_regulars'];

?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
    <link rel="stylesheet" type="text/css" href="admin.css">
</head>
<body>

<!-- Sidebar -->
<div class="sidebar">
    <a href="admin.php">Dashboard</a>
    <a href="add_user.php">Add User</a>
    <a href="edit_user.php">Edit User</a>
</div>

<!-- Main content -->
<div class="content">
    <div class="header">
        <h2>Admin Dashboard</h2>
    </div>
    
    <h3>Welcome Admin, <?php echo $_SESSION['username']; ?></h3>

    <!-- Dashboard stats -->
    <div class="stats-container">
        <div class="stat-box">
            <h3>Total Users</h3>
            <p><?php echo $total_users; ?></p>
        </div>
        <div class="stat-box">
            <h3>Total Admins</h3>
            <p><?php echo $total_admins; ?></p>
        </div>
        <div class="stat-box">
            <h3>Total Regular Users</h3>
            <p><?php echo $total_regulars; ?></p>
        </div>
    </div>

    <!-- Table of users -->
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Username</th>
                <th>Email</th>
                <th>Role</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = mysqli_fetch_assoc($results)) { ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo $row['username']; ?></td>
                    <td><?php echo $row['email']; ?></td>
                    <td><?php echo $row['role']; ?></td>
                    <td>
                        <a href="edit_user.php?id=<?php echo $row['id']; ?>">Edit</a> | 
                        <a href="delete_user.php?id=<?php echo $row['id']; ?>" onclick="return confirm('Are you sure?')">Delete</a>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
    
    <a href="index.php?logout='1'" style="color: red;">Logout</a>
</div>

</body>
</html>
