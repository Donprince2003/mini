<?php
session_start();
include("conn.php");
include("index.php");

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="style1.css">
    <title>Job Confirmation Dashboard</title>
    <style>
        .grid-container {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 10px;
            border: 1px solid #ddd;
            padding: 10px;
            margin-bottom: 10px;
            position: relative;
        }

        .item-actions {
            display: flex;
            gap: 10px;
        }

        .header {
            text-align: center;
            padding: 20px;
        }

        .dashboard-container {
            width: 80%;
            margin: 0 auto;
        }

        .declined-box {
            position: absolute;
            top: 10px;
            right: 10px;
            background-color: red;
            color: white;
            padding: 5px 10px;
            border-radius: 5px;
        }

        .accepted-box {
            position: absolute;
            top: 10px;
            right: 10px;
            background-color: green;
            color: white;
            padding: 5px 10px;
            border-radius: 5px;
        }
    </style>
</head>

<body>

    <div class="dashboard-container">
        <?php
        $worker_id = $_SESSION['user_id'];
        $sql = "SELECT * FROM job_tab WHERE job_worker='$worker_id'";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $job_id = $row['job_id'];
                $job_user = $row['job_user'];

                $user_sql = "SELECT `user_name`, `user_address`, `user_contact` FROM `user_tab` WHERE user_id='$job_user'";
                $user_result = mysqli_query($conn, $user_sql);
                $user_info = mysqli_fetch_assoc($user_result);

                echo "<div class='grid-container'>";
                echo "Job Id: " . $row['job_id'] . "<br>";
                echo "Employer id: " . $row['job_user'] . "<br>";
                echo "Employer name: " . $user_info['user_name'] . "<br>";
                echo "Job description: " . $row['job_work'] . "<br>";

                if ($row['job_status'] == 1) {
                    echo "<div class='accepted-box'>Job accepted</div>";
                } elseif ($row['job_status'] == 0) {
                    echo "<div class='declined-box'>Job declined</div>";
                } elseif ($row['job_status'] == 3) {
                    echo "<form action='' method='POST' class='item-actions'>";
                    echo "<input type='hidden' name='job_id' value='$job_id'>";
                    echo "<button type='submit' name='action' value='confirm'>Confirm</button>";
                    echo "<button type='submit' name='action' value='decline'>Decline</button>";
                    echo "</form>";
                }
                echo "</div>";
            }
        } else {
            echo "No jobs available.";
        }

        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action']) && isset($_POST['job_id'])) {
            $job_id = $_POST['job_id'];
            $action = $_POST['action'];

            if ($action == "confirm") {
                $accept_query = "UPDATE job_tab SET job_status=1 WHERE job_id='$job_id' AND job_worker='$worker_id'";
                $update = mysqli_query($conn, $accept_query);
                if ($update) {
                    echo "<script>alert('Job confirmed');</script>";
                    header("Location: request.php");
                } else {
                    echo "<script>alert('Error confirming job');</script>";
                }
            } elseif ($action == "decline") {
                $decline_query = "UPDATE job_tab SET job_status=0 WHERE job_id='$job_id' AND job_worker='$worker_id'";
                $update = mysqli_query($conn, $decline_query);
                if ($update) {
                    echo "<script>alert('Job declined');</script>";
                    header("Location: request.php");
                } else {
                    echo "<script>alert('Error declining job');</script>";
                }
            }
        }
        ?>
    </div>
</body>

</html>