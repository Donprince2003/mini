<?php
include('conn.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") 
{
    $user_email = mysqli_real_escape_string($conn, $_POST['email']);
    $user_name = mysqli_real_escape_string($conn, $_POST['name']);
    $user_password = mysqli_real_escape_string($conn, $_POST['password']);
    $user_password_confirm = mysqli_real_escape_string($conn, $_POST['password_confirm']);
    $user_role = mysqli_real_escape_string($conn, $_POST['role']);
    $user_gender = mysqli_real_escape_string($conn, $_POST['gender']);
    $user_address = mysqli_real_escape_string($conn, $_POST['address']);
    $user_contact = mysqli_real_escape_string($conn, $_POST['contact']);

    $errors = [];

    // Check if email already exists
    $email_check_query = "SELECT * FROM user_tab WHERE user_id='$user_email' LIMIT 1";
    $result = mysqli_query($conn, $email_check_query);
    $user = mysqli_fetch_assoc($result);
    
    if ($user) 
    {
        if ($user['user_id'] === $user_email) 
        {
            $errors[] = "Email already exists";
        }
    }

    if (!filter_var($user_email, FILTER_VALIDATE_EMAIL)) 
    {
        $errors[] = "Invalid email format";
    }

    if ($user_password !== $user_password_confirm) 
    {
        $errors[] = "Passwords do not match";
    }

    if (!preg_match('/^[0-9]{10}$/', $user_contact)) 
    {
        $errors[] = "Invalid contact number. It must be exactly 10 digits.";
    }

    else
    {
        $sql = "INSERT INTO user_tab (user_id, user_name, user_password, user_role, user_gender, user_address, user_contact) 
                VALUES ('$user_email', '$user_name', '$user_password', '$user_role', '$user_gender', '$user_address', '$user_contact')";
        
        if (mysqli_query($conn, $sql)) 
        {
            header("location: login.php");
        } 
        else 
        {
            $errors[] = "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" type="text/css" href="style1.css" >
    <title>Register</title>
</head>
<body>
<div class="container">
    <h2>Register</h2>
    <form action="" method="post">
        <label>Email:</label>
        <input type="email" name="email" required><br><br>
        
        <label>Name:</label>
        <input type="text" name="name" required><br><br>
        
        <label>Password:</label>
        <input type="password" name="password" required><br><br>
        
        <label>Confirm Password:</label>
        <input type="password" name="password_confirm" required><br><br>
        
        <label>Role:</label>
        <select name="role" required>
            <option value="user">User</option>
            <option value="worker">Worker</option>
        </select><br><br>
        
        <label>Gender:</label>
        <select name="gender" required>
            <option value="male">Male</option>
            <option value="female">Female</option>
            <option value="other">Other</option>
        </select><br><br>

        <label>Contact Number:</label>
        <input type="text" name="contact" required maxlength="10"><br><br>
        
        <label>Address:</label>
        <textarea name="address" required></textarea><br><br>
        
        <input type="submit" value="Register">
        <div>
            <a href="login.php">login now</a>
        </div>
    </form>
<div>
