<?php 
session_start();

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    $_SESSION['msg'] = "You must log in first";
    header('location: login.php');
}

// Handle logout
if (isset($_GET['logout'])) {
    session_destroy();
    unset($_SESSION['username']);
    header("location: login.php");
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>User Home</title>
    <link rel="stylesheet"  href="style.css">
</head>
<body id="home-page">

<div class="home-header">
    <h2>Welcome to Your Dashboard</h2>
</div>
<div class="home-content">
    <!-- notification message -->
    <?php if (isset($_SESSION['success'])) : ?>
        <div class="success">
            <h3>
                <?php 
                    echo $_SESSION['success']; 
                    unset($_SESSION['success']);
                ?>
            </h3>
        </div>
    <?php endif; ?> <!-- Added missing closing statement for success message -->

    <!-- logged in user information -->
    <?php if (isset($_SESSION['username'])) : ?>
        <p>Welcome, <strong><?php echo $_SESSION['username']; ?></strong></p>

        <!-- Profile Information Section -->
        <div class="profile-info">
            <h4>Your Profile Information</h4>
            <p>Username: <?php echo $_SESSION['username']; ?></p>

            <!-- User Resources or Links -->
            <div class="user-resources">
                <h4>Useful Links</h4>
                <ul>
                    <li><a href="#">Update Profile</a></li>
                    <li><a href="#">View Account History</a></li>
                    <li><a href="#">Contact Support</a></li>
                </ul>
            </div>
        </div>

        <!-- New Section for Additional Components -->
        <div class="additional-section">
            <h4>Explore More Features</h4>
            <div class="feature-box">
                <p>Feature 1: Dashboard Overview</p>
            </div>
            <div class="feature-box">
                <p>Feature 2: Recent Activities</p>
            </div>
        </div>

        <!-- Logout -->
        <p><a href="index.php?logout='1'" style="color: red;">Logout</a></p>
    <?php endif; ?> <!-- Added missing closing statement for logged in user information -->
</div>

</body>
</html>
