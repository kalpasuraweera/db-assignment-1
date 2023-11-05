<!DOCTYPE html>
<html>

<head>
    <title>UniCourse</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body>
    <?php
    session_start();
    require_once("../includes/db_connect.php");
    require_once("../includes/logout.php");
    ?>
    <h1 class="text-3xl font-bold mb-4">Student Dashboard</h1>
    <form action="" method="post">
        <button type="submit" name="logout" class="bg-blue-500 text-white px-4 py-2 rounded-md">Logout</button>
    </form>

    <!-- Section 1: View course information -->
    <section class="my-8">
        <h2 class="text-2xl font-semibold mb-4">View Course Information</h2>
        <div class="border p-4 rounded-md">
            <!-- Course information content goes here -->
        </div>
    </section>

    <!-- Section 2: Enroll in courses -->
    <section class="my-8">
        <h2 class="text-2xl font-semibold mb-4">Enroll in Courses</h2>
        <div class="border p-4 rounded-md">
            <!-- Enroll in courses content goes here -->
        </div>
    </section>

    <!-- Section 3: Check enrollment status -->
    <section class="my-8">
        <h2 class="text-2xl font-semibold mb-4">Check Enrollment Status</h2>
        <div class="border p-4 rounded-md">
            <!-- Enrollment status content goes here -->
        </div>
    </section>

    <!-- Section 4: View personal student information -->
    <section class="my-8">
        <h2 class="text-2xl font-semibold mb-4">View Personal Student Information</h2>
        <div class="border p-4 rounded-md">

            <!-- Search Form -->
            <form action="" method="post" class="mb-4">
                <label for="student_id" class="block text-lg font-semibold">Enter Student ID:</label>
                <input type="text" name="student_id" id="student_id" class="border p-2 rounded-md" required>
                <button type="submit" name="search"
                    class="bg-blue-500 text-white px-4 py-2 rounded-md ml-2">Search</button>
            </form>

            <?php


            if (isset($_POST["search"])) {
                $student_id = $_POST["student_id"];
                echo $student_id;
                // Define the query to select a student by student_id
                $query = "SELECT * FROM student WHERE student_id = '$student_id'";

                $result = $conn->query($query);

                if ($result) {
                    if ($result->num_rows > 0) {
                        echo "<p><strong>Student Information:</strong></p>";
                        echo "<table border='1'><tr><th>Name</th><th>Date of Birth</th></tr>";

                        while ($row = $result->fetch_assoc()) {
                            echo "<tr><td>" . $row["name"] . "</td><td>" . $row["dob"] . "</td></tr>";
                        }

                        echo "</table>";
                    } else {
                        echo "No records found for student ID: $student_id.";
                    }
                } else {
                    echo "Error: " . $conn->error;
                }
            }
            ?>
        </div>
    </section>


    <!-- Section 5: View grades and GPA -->
    <section class="my-8">
        <h2 class="text-2xl font-semibold mb-4">View Grades and GPA</h2>
        <div class="border p-4 rounded-md">
            <!-- Grades and GPA content goes here -->
        </div>
    </section>

    <!-- Section 6: Access course materials -->
    <section class="my-8">
        <h2 class="text-2xl font-semibold mb-4">Access Course Materials</h2>
        <div class="border p-4 rounded-md">
            <!-- Course materials content goes here -->
        </div>
    </section>

    <?php

    // Close the database connection
    $conn->close();

    if (isset($_POST["logout"])) {
        handleLogout();
    }
    ?>
</body>

</html>