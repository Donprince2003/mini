
<!DOCTYPE html>
<html lang="en">
<head>
<link rel="stylesheet" type="text/css" href="style1.css" >
    <title>Registration Form</title>
</head>
<body>
    <div class="container">
        <h1>Registration Form</h1>
        <form name= "reg" method="POST" >
        <input type="text" placeholder="name" name="name" required>
        <input type="email" placeholder="email" name="email" required>
        <input type="password" placeholder="password" name="password" required>
        <input type="submit" value="register" name="register">
        <dev class="login now">
            <a href="login.php">login now</a>
        </dev>
        </form>
    </div>
  <?php
    include("con.php");
    if (isset($_POST['submit'])) 
    {
		$name=$_POST['name'];
        $email=$_POST['email'];
		$password=$_POST['password'];
        if (strlen($password)<8) 
        {
            echo "<script>alert('Password must be at least 8 characters long');</script>";
        }
        else
        {
            $query="select user_id from user_tab where user_id='$email'";
            $res=mysqli_query($con,$query);
            if(mysqli_num_rows($res)== 0)
            {        
                $query="INSERT INTO `user_tab` (`user_id`, `user_name`, `user_password`) VALUES ('$email', '$name', '$password')";
                $res=mysqli_query($con,$query);
                echo $res;

                if($res==1)
                {
                    echo "<script>alert('Regestration sucessfull !');</script>";
                }  
            }
            else

            {
                echo "<script>alert('Regestration failed !');</script>";
            }
        }
    }
	?>
</div>
</body>
</html>