<?php
session_start();
include("conn.php");

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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $new_name = mysqli_real_escape_string($conn, $_POST['name']);
    $new_address = mysqli_real_escape_string($conn, $_POST['address']);
    $new_contact = mysqli_real_escape_string($conn, $_POST['contact']);
    $new_gender = mysqli_real_escape_string($conn, $_POST['gender']);

    $update_sql = "UPDATE user_tab SET user_name = ?, user_address = ?, user_contact = ?, user_gender = ? WHERE user_id = ?";
    $update_stmt = $conn->prepare($update_sql);
    $update_stmt->bind_param("sssss", $new_name, $new_address, $new_contact, $new_gender, $user_id);

    if ($update_stmt->execute()) {
        echo "<script>alert('Profile updated successfully!'); window.location.href = 'profile.php';</script>";
    } else {
        echo "<script>alert('Error updating profile!');</script>";
    }

    $update_stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" type="text/css" href="style1.css">
<title>Edit Profile</title>
</head>
<body>
<div class="container">
  <h2>Edit Profile</h2>
  <form method="POST">
    <label for="name">Name:</label>
    <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($user_name); ?>" required><br><br>

    <label for="address">Address:</label>
    <input type="text" id="address" name="address" value="<?php echo htmlspecialchars($user_address); ?>" required><br><br>

    <label for="contact">Mobile Number:</label>
    <input type="text" id="contact" name="contact" value="<?php echo htmlspecialchars($user_contact); ?>" required maxlength="10"><br><br>

    <label for="gender">Gender:</label>
    <select id="gender" name="gender" required>
      <option value="male" <?php if($user_gender == 'male') echo 'selected'; ?>>Male</option>
      <option value="female" <?php if($user_gender == 'female') echo 'selected'; ?>>Female</option>
      <option value="other" <?php if($user_gender == 'other') echo 'selected'; ?>>Other</option>
    </select><br><br>

    <button type="submit">Update Profile</button>
  </form>
  <a href="profile.php">Back to Profile</a>
</div>
</body>
</html>