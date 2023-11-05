<!DOCTYPE html>
<html>
<head>
    <title>Instructor Operations</title>
</head>
<body>
    <h1>Instructor Operations</h1>
<form action="" method="post">
    <button type="submit" name="logout">Logout</button>
</form>
    <?php
    session_start();
    require_once("../includes/db_connect.php");
    require_once("../includes/logout.php");

    // Define the query to select all students
    $query = "SELECT * FROM student";

    echo "<p><strong>Select All Students:</strong></p>";
        
    $result = $conn->query($query);

    if ($result) {
        if ($result->num_rows > 0) {
            echo "<table border='1'><tr><th>Name</th><th>DOB</th></tr>";

            while ($row = $result->fetch_assoc()) {
                echo "<tr><td>" . $row["name"] . "</td><td>" . $row["dob"] . "</td></tr>";
            }

            echo "</table>";
        } else {
            echo "No records found.";
        }
    } else {
        echo "Error: " . $conn->error;
    }
    
    echo "<br><br>";
  
    // Close the database connection
    $conn->close();


    if(isset($_POST["logout"])) {
        handleLogout();
    }
    ?>

</body>
</html>
