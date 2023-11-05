<!DOCTYPE html>
<html>
<head>
    <title>Student Operations</title>
</head>
<body>
    <h1>Student Operations</h1>

    <?php
    // Database connection settings
    $host = "your_host";
    $username = "your_username";
    $password = "your_password";
    $database = "your_database";
    
    // Create a MySQL connection
    $conn = new mysqli($host, $username, $password, $database);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Define the query to select all students
    $query = "SELECT name, age FROM students";

    echo "<p><strong>Select All Students:</strong></p>";
        
    $result = $conn->query($query);

    if ($result) {
        if ($result->num_rows > 0) {
            echo "<table border='1'><tr><th>Name</th><th>Age</th></tr>";

            while ($row = $result->fetch_assoc()) {
                echo "<tr><td>" . $row["name"] . "</td><td>" . $row["age"] . "</td></tr>";
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
    ?>

</body>
</html>
