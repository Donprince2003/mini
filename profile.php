<?php
session_start();
include("conn.php");
include("home.php");


if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Fetch user data from session
$user_id = $_SESSION['user_id'];


$sql = "SELECT user_id, user_name, user_address, user_contact, user_gender, user_role FROM user_tab WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $user_id);
$stmt->execute();
$stmt->bind_result($user_id, $user_name, $user_address, $user_contact, $user_gender, $user_role);
$stmt->fetch();
$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" type="text/css" href="style1.css">
<title>Profile Page</title>
</head>
<body>
<div class="container">
  <h2>Welcome, <?php echo htmlspecialchars($user_name); ?>!</h2>
  <p><strong>User ID:</strong> <?php echo htmlspecialchars($user_id); ?></p>
  <p><strong>Name:</strong> <?php echo htmlspecialchars($user_name); ?></p>
  <p><strong>Address:</strong> <?php echo htmlspecialchars($user_address); ?></p>
  <p><strong>Mobile Number:</strong> <?php echo htmlspecialchars($user_contact); ?></p>
  <p><strong>Gender:</strong> <?php echo htmlspecialchars($user_gender); ?></p>
  <p><strong>User Role:</strong> <?php echo htmlspecialchars($user_role); ?></p>
  <a href="logout.php">Logout</a>
  <div>
  <a href="profile_updation.php">update profile</a>
</div>
</div>
</body>
</html>

