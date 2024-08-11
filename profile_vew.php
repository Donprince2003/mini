<?php
session_start();
include("conn.php");
include("index.php");

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Get today's date in YYYY-MM-DD format
$today = date("Y-m-d");

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['user_worker_id'])) {
    $user_worker_id = $_POST['user_worker_id'];
    $user_id = $_SESSION['user_id'];

    $sql = "SELECT * FROM user_tab WHERE user_id = '$user_worker_id'";
    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        $user_data = mysqli_fetch_array($result, MYSQLI_ASSOC);

        $user_name = $user_data['user_name'];
        $user_address = $user_data['user_address'];
        $user_contact = $user_data['user_contact'];
        $user_gender = $user_data['user_gender'];
        $user_role = $user_data['user_role'];
        $user_rating = $user_data['user_rating'];

        $sql = "SELECT img_id FROM pro_img WHERE user_id = '$user_worker_id'";
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {
            $img_data = mysqli_fetch_array($result, MYSQLI_ASSOC);
            $user_img = $img_data['img_id'];
        } else {
            $user_img = "d.png";
        }

        if ($user_role == "worker") {
            $sql = "SELECT * FROM worker_tab WHERE user_id = '$user_worker_id'";
            $res = mysqli_query($conn, $sql);

            if (mysqli_num_rows($res) > 0) {
                $worker_data = mysqli_fetch_array($res, MYSQLI_ASSOC);
            } else {
                $sql = "INSERT INTO worker_tab (worker_id, user_id, worker_job_field, worker_experience) VALUES ('', '$user_worker_id', 'no data found', 'no data found')";
                mysqli_query($conn, $sql);

                $sql = "SELECT * FROM worker_tab WHERE user_id = '$user_worker_id'";
                $res = mysqli_query($conn, $sql);
                $worker_data = mysqli_fetch_array($res, MYSQLI_ASSOC);
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
                        <?php echo "<img src='image/" . htmlspecialchars($user_img) . "' width='50%'>"; ?>
                    </div>
                    <p><strong>Name:</strong> <?php echo htmlspecialchars($user_name); ?></p>
                    <p><strong>Address:</strong> <?php echo htmlspecialchars($user_address); ?></p>
                    <p><strong>Mobile Number:</strong> <?php echo htmlspecialchars($user_contact); ?></p>
                    <p><strong>Gender:</strong> <?php echo htmlspecialchars($user_gender); ?></p>
                    <p><strong>User Role:</strong> <?php echo htmlspecialchars($user_role); ?></p>
                    <p><strong>Worker ID:</strong> <?php echo htmlspecialchars($worker_id); ?></p>
                    <p><strong>Job:</strong> <?php echo htmlspecialchars($worker_job); ?></p>
                    <p><strong>Work experience:</strong> <?php echo htmlspecialchars($worker_exp); ?></p>
                    <form method="POST" action="add_job.php">
                        <label for="job_date">Job Date:</label>
                        <input type="date" id="job_date" name="job_date" required min="<?php echo $today; ?>">
                        <label for="job_work">Job Description:</label>
                        <textarea id="job_work" name="job_work" required></textarea>
                        <input type="hidden" name="user_worker_id" value="<?php echo htmlspecialchars($user_worker_id); ?>">
                        <input type="hidden" name="user_id" value="<?php echo htmlspecialchars($user_id); ?>">
                        <br><br>
                        <button type="submit" name="submit">Submit job require</button>
                    </form>
                </div>
            </body>

            </html>
            <?php
        }
    } else {
        echo ("<script>alert('Worker not found');</script>");
    }
} else {
    echo "Invalid request.";
}

mysqli_close($conn);
?>
