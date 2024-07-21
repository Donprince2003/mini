<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Website Navigation Bar</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-image: linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.5)), url('p.jpg');
            background-size: cover;
            background-position: center;
            color: #fff; /* Adjust text color for better contrast */
        }

        header {
            background-color: #333;
            color: #fff;
            padding: 10px 0;
        }

        nav ul {
            list-style-type: none;
            text-align: center;
            margin: 0;
            padding: 0;
        }

        nav ul li {
            display: inline;
        }

        nav ul li a {
            text-decoration: none;
            color: #fff;
            padding: 10px 20px;
            display: inline-block;
        }

        nav ul li a:hover {
            background-color: #555;
        }
    </style>
</head>
<body>
    <header>
        <nav>
            <ul>
                <li><a href="#">Home</a></li>
                <li><a href="about.php">About</a></li>
                <li><a href="#">Contact</a></li>
                <li><a href="proflie.php">profile</a></li>
            </ul>
        </nav>
    </header>
    <!-- Your main content here -->
</body>
</html>
