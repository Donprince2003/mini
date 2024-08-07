<?php
session_start();
include("conn.php");
include("index.php");


if (isset($_POST['submit'])) {
  $username = mysqli_real_escape_string($conn, $_POST['name']);
  $password = mysqli_real_escape_string($conn, $_POST['password']);

  $sql = "SELECT * FROM user_tab WHERE user_id = '$username'";
  $result = $conn->query($sql);

  if ($result->num_rows > 0) {
    $row = mysqli_fetch_assoc($result);
    $user_password = $row['user_password'];
    if ($password == $user_password) {
      $role=$row['user_role'];
      $_SESSION['user_role'] =$role;
      $_SESSION['user_id'] = $username;
      

      echo "<script>alert('login');</script>";
      $update_sql = "UPDATE user_tab SET user_status = 1 WHERE user_id = '$username'";
      $result = mysqli_query($conn, $update_sql);
      
      header("Location: profile.php");
    } else {
      echo "<script>alert('wrong password!');</script>";
    }
  } else {
    echo "<script>alert('User ID does not exist!');</script>";
  }
}

?>

<!DOCTYPE html>
<html>

<head>
  <link rel="stylesheet" type="text/css" href="style1.css">
  <title>Login Page</title>
  <script>
    function validateEmail() {
      var email = document.forms["loginForm"]["name"].value;
      var re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
      if (!re.test(email)) {
        alert("Please enter a valid email address.");
        return false;
      }
      return true;
    }
  </script>
</head>

<body>
  <div class="container">
    <h2>Login</h2>
    <form name="loginForm" method="POST" onsubmit="return validateEmail()">
      <input type="text" placeholder="Email" name="name" required>
      <input type="password" placeholder="Password" name="password" required>
      <button type="submit" name="submit">Login</button>
      <div class="register-now">
        <a href="reg3.php">Register now</a>
      </div>
    </form>
  </div>
</body>

</html>