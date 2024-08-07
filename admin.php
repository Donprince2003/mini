<!DOCTYPE html>
<html>
<head>
    <title>ADMIN PAGE</title>
    <style>
        body {
            font-family: Arial, sans-serif;
    background-color: #f4f4f4;
    margin: 0;
    padding: 0;
}
        

        form {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            max-width: 500px;
            margin: 20px auto;
        }

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

        input[type="text"] {
            width: 100%;
    padding: 10px;
    margin: 10px 0;
    border: 1px solid #ddd;
    border-radius: 4px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        table, th, td {
            border: 1px solid #ddd;
            
        }

        th, td {
            padding: 12px;
            text-align: left;
        }

        th {
            background-color: #4cae4c;
            color: #fff;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        

        .container {
            max-width: 800px;
            margin: 0 auto;
        }

        
    </style>
</head>
<body>
    <div class="container">
        <h1 class="section-header"><center>Admin Page</center></h1>
        <form name="form" action="" method="POST">
            <input type="submit" value="VIEW ALL USERS" name="view_users" />
            <br><br>
            <input type="text" name="email_to_remove_user" placeholder="Enter the E-mail id"/><br><br>
            <input type="submit" value="REMOVE USER" name="remove_user" /><br><br>
            <input type="submit" value="VIEW ALL WORKERS" name="view_workers"/><br><br>
            <input type="text" placeholder="Enter E-mail id" name="email_to_remove_worker" /><br><br>
            <input type="submit" value="REMOVE WORKER" name="remove_worker" /><br><br>        
        </form>

        <?php
        include("conn.php");

        if (isset($_POST['view_users'])) {
            $qr = "SELECT * FROM `user_tab` WHERE user_role='user'";
            $res = mysqli_query($conn, $qr);
            if (mysqli_num_rows($res) > 0) {
                echo "<table>";
                echo "<tr><th>USER ID</th><th>USER NAME</th><th>USER CONTACT</th><th>USER GENDER</th><th>USER ROLE</th><th>USER ADDRESS</th></tr>";
                while ($row = mysqli_fetch_array($res)) {
                    echo "<tr><td>" . $row["user_id"] . "</td><td>" . $row["user_name"] . "</td><td>" . $row["user_contact"] . "</td><td>" . $row["user_gender"] . "</td><td>" . $row["user_role"] . "</td><td>" . $row["user_address"] . "</td></tr>";
                }
                echo "</table>";
            }
        }

        if (isset($_POST['remove_user'])) {
            $email = $_POST['email_to_remove_user'];
            $qr1 = "DELETE FROM `user_tab` WHERE user_id='$email'";
            $res1 = mysqli_query($conn, $qr1);
            $qr = "SELECT * FROM `user_tab` WHERE user_role='user'";
            $res = mysqli_query($conn, $qr);
            if (mysqli_num_rows($res) > 0) {
                echo "<table>";
                echo "<tr><th>USER ID</th><th>USER NAME</th><th>USER CONTACT</th><th>USER GENDER</th><th>USER ROLE</th><th>USER ADDRESS</th></tr>";
                while ($row = mysqli_fetch_array($res)) {
                    echo "<tr><td>" . $row["user_id"] . "</td><td>" . $row["user_name"] . "</td><td>" . $row["user_contact"] . "</td><td>" . $row["user_gender"] . "</td><td>" . $row["user_role"] . "</td><td>" . $row["user_address"] . "</td></tr>";
                }
                echo "</table>";
            }
        }

        if (isset($_POST['view_workers'])) {
            $qr = "SELECT * FROM `user_tab` WHERE user_role='worker'";
            $res = mysqli_query($conn, $qr);
            if (mysqli_num_rows($res) > 0) {
                echo "<table>";
                echo "<tr><th>USER ID</th><th>USER NAME</th><th>USER CONTACT</th><th>USER GENDER</th><th>USER ROLE</th><th>USER ADDRESS</th></tr>";
                while ($row = mysqli_fetch_array($res)) {
                    echo "<tr><td>" . $row["user_id"] . "</td><td>" . $row["user_name"] . "</td><td>" . $row["user_contact"] . "</td><td>" . $row["user_gender"] . "</td><td>" . $row["user_role"] . "</td><td>" . $row["user_address"] . "</td></tr>";
                }
                echo "</table>";
            }
        }

        if (isset($_POST['remove_worker'])) {
            $email = $_POST['email_to_remove_worker'];
            $qr1 = "DELETE FROM `user_tab` WHERE user_id='$email'";
            $res1 = mysqli_query($conn, $qr1);
            $qr = "SELECT * FROM `user_tab` WHERE user_role='worker'";
            $res = mysqli_query($conn, $qr);
            if (mysqli_num_rows($res) > 0) {
                echo "<table>";
                echo "<tr><th>USER ID</th><th>USER NAME</th><th>USER CONTACT</th><th>USER GENDER</th><th>USER ROLE</th><th>USER ADDRESS</th></tr>";
                while ($row = mysqli_fetch_array($res)) {
                    echo "<tr><td>" . $row["user_id"] . "</td><td>" . $row["user_name"] . "</td><td>" . $row["user_contact"] . "</td><td>" . $row["user_gender"] . "</td><td>" . $row["user_role"] . "</td><td>" . $row["user_address"] . "</td></tr>";
                }
                echo "</table>";
            }
        }
        ?>
    </div>
</body>
</html>







