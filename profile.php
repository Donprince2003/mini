<?php
session_start();
include("conn.php");
include("index.php");

if (!isset($_SESSION['user_id'])) {
  header("Location: login.php");
  exit();
}

// Fetch user data from session
$user_id = $_SESSION['user_id'];

// Get user details
$sql = "SELECT user_id, user_name, user_address, user_contact, user_gender, user_role, user_img, user_rating FROM user_tab WHERE user_id = '$user_id'";
$result = mysqli_query($conn, $sql);
$user_data = mysqli_fetch_assoc($result);

$user_name = $user_data['user_name'];
$user_address = $user_data['user_address'];
$user_contact = $user_data['user_contact'];
$user_gender = $user_data['user_gender'];
$user_role = $user_data['user_role'];
$user_rating = $user_data['user_rating'];

// Get user image
$sql = "SELECT img_id FROM pro_img WHERE user_id = '$user_id'";
$result = mysqli_query($conn, $sql);
if(mysqli_num_rows($result)>0)
{
  $img_data = mysqli_fetch_assoc($result);
  $user_img = $img_data['img_id'];
}
else
{
  $user_img = "d.png"; 
}
if ($user_role == "worker") {
  // Fetch worker-specific data
  $sql = "SELECT * FROM worker_tab WHERE user_id = '$user_id'";
  $res = mysqli_query($conn, $sql);

  if (mysqli_num_rows($res) > 0) {
    $worker_data = mysqli_fetch_assoc($res);
  } else {
    // Insert default data if none found
    $sql = "INSERT INTO worker_tab (worker_id, user_id, worker_job_field, worker_experience) VALUES ('', '$user_id', 'no data found', 'no data found')";
    $res = mysqli_query($conn, $sql);

    $sql = "SELECT * FROM worker_tab WHERE user_id = '$user_id'";
    $res = mysqli_query($conn, $sql);
    $worker_data = mysqli_fetch_assoc($res);
  }

  $worker_id = $worker_data['worker_id'];
  $worker_job = $worker_data['worker_job_field'];
  $worker_exp = $worker_data['worker_experience'];
?>
  <!DOCTYPE html>
  <html>

  <head>
    <link rel="stylesheet" type="text/css" href="style1.css">
    <title>Profile Page</title>
  </head>

  <body>
    <div class="container">
      <div style="display: flex; justify-content: center; align-items: center; border: 1px">
        <?php echo "<img src='image/" . $user_img . "' width='50%'>"; ?>
      </div>
      <h2>Welcome, <?php echo htmlspecialchars($user_name); ?>!</h2>
      <p><strong>User ID:</strong> <?php echo htmlspecialchars($user_id); ?></p>
      <p><strong>Name:</strong> <?php echo htmlspecialchars($user_name); ?></p>
      <p><strong>Address:</strong> <?php echo htmlspecialchars($user_address); ?></p>
      <p><strong>Mobile Number:</strong> <?php echo htmlspecialchars($user_contact); ?></p>
      <p><strong>Gender:</strong> <?php echo htmlspecialchars($user_gender); ?></p>
      <p><strong>User Role:</strong> <?php echo htmlspecialchars($user_role); ?></p>
      <p><strong>Worker ID:</strong> <?php echo htmlspecialchars($worker_id); ?></p>
      <p><strong>Job:</strong> <?php echo htmlspecialchars($worker_job); ?></p>
      <p><strong>Work experience:</strong> <?php echo htmlspecialchars($worker_exp); ?></p>
      <div>
        <a href="profile_updation.php"><button>Update Profile</button></a>
      </div>
    </div>
  </body>

  </html>
<?php
} else {
?>
  <!DOCTYPE html>
  <html>

  <head>
    <link rel="stylesheet" type="text/css" href="style1.css">
    <title>Profile Page</title>
  </head>

  <body>
    <div class="container">
      <div style="display: flex; justify-content: center; align-items: center; border: 1px">
        <?php echo "<img src='image/" . $user_img . "' width='50%'>"; ?>
      </div>
      <h2>Welcome, <?php echo htmlspecialchars($user_name); ?>!</h2>
      <p><strong>User ID:</strong> <?php echo htmlspecialchars($user_id); ?></p>
      <p><strong>Name:</strong> <?php echo htmlspecialchars($user_name); ?></p>
      <p><strong>Address:</strong> <?php echo htmlspecialchars($user_address); ?></p>
      <p><strong>Mobile Number:</strong> <?php echo htmlspecialchars($user_contact); ?></p>
      <p><strong>Gender:</strong> <?php echo htmlspecialchars($user_gender); ?></p>
      <p><strong>User Role:</strong> <?php echo htmlspecialchars($user_role); ?></p>
      <div>
        <a href="profile_updation.php"><button>Update Profile</button></a>
      </div>
    </div>
  </body>

  </html>
<?php
}

mysqli_close($conn);
?>