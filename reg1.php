

<!DOCTYPE html>
<html lang="en">
<head>

  <title>Registration Form</title>
</head>
<body>
<div>
  <h1>Registration Form</h1>
  <form name= "reg" method="POST" >
   
    <input type="text" placeholder="name" name="name" required>

    
    <input type="email" placeholder="email" name="email" required>

   
    <input type="password" placeholder="password" name="password" required>

    <input type="submit" value="register" name="register">
  <dev class="login now">
    <a href="login.php">login now</a>
  </dev>
  <div>
  <a href="login.php">login now</a>
</div>
  </form>
  <?php
  session_start();
  include("con.php");

  // Check if the form is submitted
  if (isset($_POST['submit'])) {
      $name = $_POST['name'];
      $email = $_POST['email'];
      $password = $_POST['password'];

      // Check password length
      if (strlen($password) < 8) {
          echo "<script>alert('Password must be at least 8 characters long');</script>";
      } else {
          // Check if the email already exists
          $query = "SELECT user_id FROM user_tab WHERE user_id = ?";
          $stmt = $con->prepare($query);
          
          if (!$stmt) {
              die("SQL Error: " . $con->error);
          }

          $stmt->bind_param("s", $email);
          $stmt->execute();
          $res = $stmt->get_result();

          if (mysqli_num_rows($res) == 0) {
              // Hash the password before storing it
              $hashed_password = password_hash($password, PASSWORD_DEFAULT);

              // Insert new user
              $insert_query = "INSERT INTO user_tab (user_id, user_name, user_password) VALUES (?, ?, ?)";
              $insert_stmt = $con->prepare($insert_query);
              
              if (!$insert_stmt) {
                  die("SQL Error: " . $con->error);
              }

              $insert_stmt->bind_param("sss", $email, $name, $hashed_password);
              $insert_res = $insert_stmt->execute();

              if ($insert_res) {
                  echo "<script>alert('Registration successful!');</script>";
              } else {
                  echo "<script>alert('Registration failed! Please try again.');</script>";
              }

              $insert_stmt->close();
          } else {
              echo "<script>alert('Email ID already exists!');</script>";
          }

          $stmt->close();
      }

      $con->close(); // Close the database connection
  }
  ?>


</div>
</body>
</html>