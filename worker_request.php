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
    <title>Worker Confirmation Dashboard</title>
    <style>
        button,
        input[type="submit"] {
            width: 100px;
            padding: 10px;
            background-color: #5cb85c;
            border: none;
            border-radius: 4px;
            color: white;
            font-size: 16px;
            cursor: pointer;
            display: block;
            /* Make each button take a full line */
            margin-bottom: 10px;
            /* Add some space between the buttons */
        }

        .container {
            width: 350px;
            margin: 100px auto;
            padding: 20px;
            background: #fff;
            border-radius: 5px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .grid-container {
            display: grid;
            width: 300px;
            grid-template-columns: 1fr 1fr;
            gap: 10px;
            border: 1px solid #ddd;
            padding: 10px;
            margin-bottom: 10px;
            position: relative;
        }

        .item-actions {
            display: flex;
            flex-direction: column;
            /* Arrange buttons in a column */
            gap: 10px;
        }

        .header {
            text-align: center;
            padding: 20px;
        }

        .dashboard-container {
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
    <div class="container">
        <div class="dashboard-container">
            <?php
            $worker_id = $_SESSION['user_id'];
            $sql = "SELECT * FROM worker_tab";
            $result = mysqli_query($conn, $sql);

            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    $worker_id = $row['worker_id'];
                    $user_id = $row['user_id'];

                    $user_sql = "SELECT `user_name`, `user_address`, `user_contact` FROM `user_tab` WHERE user_id='$user_id'";
                    $user_result = mysqli_query($conn, $user_sql);
                    $user_info = mysqli_fetch_assoc($user_result);

                    echo "<div class='grid-container'>";
                    echo "Worker ID: " . $row['worker_id'] . "<br>";
                    echo "Worker's User ID: " . $row['user_id'] . "<br>";
                    echo "Worker Name: " . $user_info['user_name'] . "<br>";
                    echo "Worker Job: " . $row['user_id'] . "<br>";
                    echo "Worker Date: " . $row['worker_job_date'] . "<br>";

                    if ($row['worker_status'] == 1) {
                        echo "<div class='accepted-box'>Worker Accepted</div>";
                    } elseif ($row['worker_status'] == 0) {
                        echo "<div class='declined-box'>Worker Declined</div>";
                    } elseif ($row['worker_status'] == 3) {
                        echo "Update Type: new worker <br>";
                        echo "<form action='' method='POST' class='item-actions'>";
                        echo "<input type='hidden' name='worker_id' value='$worker_id'>";
                        echo "<button type='submit' name='action' value='confirm'>Confirm</button>";
                        echo "<button type='submit' name='action' value='decline'>Decline</button>";
                        echo "</form>";
                    } elseif ($row['worker_status'] == 4) {
                        echo "Update Type: job updation <br>";
                        echo "<form action='' method='POST' class='item-actions'>";
                        echo "<input type='hidden' name='worker_id' value='$worker_id'>";
                        echo "<button type='submit' name='action' value='confirm'>Confirm</button>";
                        echo "<button type='submit' name='action' value='decline'>Decline</button>";
                        echo "</form>";
                    }
                    echo "</div>";
                }
            } else {
                echo "No workers available.";
            }

            if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action']) && isset($_POST['worker_id'])) {
                $worker_id = $_POST['worker_id'];
                $action = $_POST['action'];

                if ($action == "confirm") {
                    $accept_query = "UPDATE worker_tab SET worker_status=1, worker_job_date_acpt=NOW() WHERE worker_id='$worker_id'";
                    $update = mysqli_query($conn, $accept_query);
                    if ($update) {
                        echo "<script>alert('Worker confirmed');</script>";
                    } else {
                        echo "<script>alert('Error confirming worker');</script>";
                    }
                } elseif ($action == "decline") {
                    $decline_query = "UPDATE worker_tab SET worker_status=0, worker_job_date_acpt=NOW() WHERE worker_id='$worker_id'";
                    $update = mysqli_query($conn, $decline_query);
                    if ($update) {
                        echo "<script>alert('Worker declined');</script>";
                    } else {
                        echo "<script>alert('Error declining worker');</script>";
                    }
                }
            }
            ?>
        </div>
    </div>
</body>

</html>