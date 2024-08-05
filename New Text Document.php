<!DOCTYPE html>
<html>
<head>
    <title>Employee List</title>
</head>
<body>
    <h1>Employee List</h1>

    <?php
    include('connection.php');

    if (isset($_POST['delete'])) {
        $empno = intval($_POST['empno']);
        $deleteQuery = "DELETE FROM employee WHERE empno = $empno";
        if (mysqli_query($connection, $deleteQuery)) {
            echo "Employee record deleted successfully.<br>";
        } else {
            echo "Error deleting record: " . mysqli_error($connection) . "<br>";
        }
    }

    $query = "SELECT * FROM employee";
    $result = mysqli_query($connection, $query);

    if (mysqli_num_rows($result) > 0) {
        echo '<table border="1">';
        echo '<tr><th>EmpNo</th><th>Name</th><th>Mobile</th><th>Date of Birth</th><th>Action</th></tr>';
        while ($row = mysqli_fetch_assoc($result)) {
            echo '<tr>';
            echo '<td>' . $row['empno'] . '</td>';
            echo '<td>' . $row['ename'] . '</td>';
            echo '<td>' . $row['mobile'] . '</td>';
            echo '<td>' . $row['dob'] . '</td>';
            echo '<td>
                    <form method="POST" style="display:inline;">
                        <input type="hidden" name="empno" value="' . $row['empno'] . '">
                        <input type="submit" name="delete" value="Delete">
                    </form>
                  </td>';
            echo '</tr>';
        }
        echo '</table>';
    } else {
        echo "No records found!";
    }

    mysqli_close($connection);
    ?>
</body>
</html>
