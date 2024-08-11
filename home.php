<?php
session_start();
include("conn.php");
include("index.php");

// Fetch all workers data
$sql = "SELECT u.user_name, u.user_address, u.user_contact, w.worker_id, w.user_id, w.worker_job_field, w.worker_experience, w.worker_status, p.img_id 
        FROM user_tab u 
        LEFT JOIN worker_tab w ON u.user_id = w.user_id
        LEFT JOIN pro_img p ON u.user_id = p.user_id
        WHERE u.user_role = 'worker'";
$result = mysqli_query($conn, $sql);
$img_path = "image/d.png";

?>
<!DOCTYPE html>
<html>

<head>
    <style>
        .container {
            width: 75%;
            margin: 100px auto;
            padding: 20px;
            background: #fff;
            border-radius: 5px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        button,
        input[type="submit"] {
            width: 100%;
            padding: 10px;
            background-color: #5cb85c;
            border: none;
            border-radius: 4px;
            color: white;
            font-size: 16px;
            cursor: pointer;
        }

        button:hover,
        input[type="submit"]:hover {
            background-color: #4cae4c;
        }
    </style>
    <title>Home - Worker Profiles</title>
</head>

<body>
    <div>
        <h2>Worker Profiles</h2>
        <?php if ($result && mysqli_num_rows($result) > 0) : ?>
            <?php while ($worker = mysqli_fetch_assoc($result)) :
            if($worker['worker_status']==1)
            {
                $img_path = ($worker['img_id'] && $worker['img_id'] != "d.png") ? "image/" . $worker['img_id'] : "image/d.png";
            ?>
            <div class="container">
                <div class="row align-items-start">
                    <div class="col">
                        <img src="<?php echo $img_path; ?>" alt="Profile Picture" style="width:150px;height:150px;"><br><br>
                    </div>
                    <div class="col">
                        <p><strong>Worker ID:</strong> <?php echo htmlspecialchars($worker['worker_id']); ?></p>
                        <p><strong>Name:</strong> <?php echo htmlspecialchars($worker['user_name']); ?></p>
                        <p><strong>Address:</strong> <?php echo htmlspecialchars($worker['user_address']); ?></p>
                        <p><strong>Mobile Number:</strong> <?php echo htmlspecialchars($worker['user_contact']); ?></p>
                        <p><strong>Job:</strong> <?php echo htmlspecialchars($worker['worker_job_field']); ?></p>
                        <p><strong>Experience (in years):</strong> <?php echo htmlspecialchars($worker['worker_experience']); ?></p>
                    </div>
                    <div class="col">
                        <form method="POST" action="profile_vew.php">
                            <input type="hidden" name="user_worker_id" value="<?php echo htmlspecialchars($worker['user_id']); ?>">
                            <button type="submit" name="submit">Select worker</button>
                        </form>
                    </div>
                </div>
            </div>
            <hr>
            <?php 
            }
        endwhile; ?>
        <?php else : ?>
            <p>No workers found.</p>
        <?php endif; ?>
    </div>
</body>

</html>
