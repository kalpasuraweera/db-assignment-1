<?php
session_start();
require_once("../includes/db_connect.php");
require_once("../includes/logout.php");
if (isset($_POST["logout"])) {
    handleLogout();
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>UniCourse</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="p-2">

    <!-- Student Dashboard Header -->
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-3xl font-bold">Instructor Dashboard</h1>
        <form action="" method="post">
            <button type="submit" name="logout" class="bg-red-500 text-white px-4 py-2 rounded-md">Logout</button>
        </form>
    </div>

    <!-- Section 1: View and Update Personal Info -->
    <section class="my-8">
        <h2 class="text-2xl font-semibold mb-4">View and Update Personal Info</h2>
        <div class="border p-4 rounded-md">
            <!-- Instructor Info Form -->
            <form action="" method="post">
                <label for="instructor_id">Instructor ID:</label>
                <input type="text" name="instructor_id" id="instructor_id">
                <label for="name">Name:</label>
                <input type="text" name="name" id="name">
                <label for="dob">Date of Birth:</label>
                <input type="date" name="dob" id="dob">
                <button type="submit" name="update_info">Update Info</button>
            </form>

            <?php
            // Display a table of all instructor details
            $query = "SELECT * FROM instructor";
            $result = $conn->query($query);

            if ($result && $result->num_rows > 0) {
                echo "<h3>All Instructors:</h3>";
                echo "<table class='table-auto border border-collapse border-gray-700'>";
                echo "<thead class='bg-gray-300'>";
                echo "<tr>";
                echo "<th class='px-4 py-2'>Instructor ID</th>";
                echo "<th class='px-4 py-2'>Name</th>";
                echo "<th class='px-4 py-2'>Department</th>";
                echo "</tr>";
                echo "</thead>";
                echo "<tbody>";

                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td class='border px-4 py-2'>" . $row["instructor_id"] . "</td>";
                    echo "<td class='border px-4 py-2'>" . $row["name"] . "</td>";
                    echo "<td class='border px-4 py-2'>" . $row["department_id"] . "</td>";
                    echo "</tr>";
                }

                echo "</tbody>";
                echo "</table>";
            } else {
                echo "No instructor details available.";
            }

            if (isset($_POST["update_info"])) {
                // Get the instructor ID from the form submission
                $instructor_id = $_POST["instructor_id"];
                $name = $_POST["name"];
                $dob = $_POST["dob"];

                // Update the instructor's personal information in the database
                $query = "UPDATE instructor SET name = '$name', dob = '$dob' WHERE instructor_id = '$instructor_id'";
                $result = $conn->query($query);

                if ($result) {
                    echo "Personal information updated successfully.";
                } else {
                    echo "Error updating personal information: " . $conn->error;
                }
            }
            ?>
        </div>
    </section>


    <!-- Section 1: View Course Information -->
    <section class="my-8">
        <h2 class="text-2xl font-semibold mb-4">View Course Information</h2>
        <div class="border p-4 rounded-md">

            <!-- Search Form -->
            <form action="" method="post" class="mb-4">
                <label for="course_code" class="block text-lg font-semibold">Enter Course Code:</label>
                <input type="text" name="course_code" id="course_code" class="border p-2 rounded-md" required>
                <button type="submit" name="search_course"
                    class="bg-blue-500 text-white px-4 py-2 rounded-md ml-2">Search</button>
            </form>

            <?php
            // Define the query to select a course by course_code
            $query = "SELECT * FROM course";

            if (isset($_POST["search_course"])) {
                $course_code = $_POST["course_code"];
                $query = "SELECT * FROM course WHERE course_code = '$course_code'";
            }
            $result = $conn->query($query);

            if ($result) {
                if ($result->num_rows > 0) {
                    echo "<p class='text-lg font-semibold mb-4'><strong>Course Information:</strong></p>";
                    echo "<table class='table-auto border border-collapse border-gray-700'>";
                    echo "<thead class='bg-gray-300'>";
                    echo "<tr>";
                    echo "<th class='px-4 py-2'>Course Code</th>";
                    echo "<th class='px-4 py-2'>Title</th>";
                    echo "<th class='px-4 py-2'>Description</th>";
                    echo "<th class='px-4 py-2'>Credit Value</th>";
                    echo "<th class='px-4 py-2'>Level</th>";
                    echo "</tr>";
                    echo "</thead>";
                    echo "<tbody>";

                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td class='border px-4 py-2'>" . $row["course_code"] . "</td>";
                        echo "<td class='border px-4 py-2'>" . $row["title"] . "</td>";
                        echo "<td class='border px-4 py-2'>" . $row["description"] . "</td>";
                        echo "<td class='border px-4 py-2'>" . $row["credit_value"] . "</td>";
                        echo "<td class='border px-4 py-2'>" . $row["level"] . "</td>";
                        echo "</tr>";
                    }

                    echo "</tbody>";
                    echo "</table>";
                } else {
                    echo "No records found for course code: $course_code.";
                }
            } else {
                echo "Error: " . $conn->error;
            }
            ?>
        </div>
    </section>

    <section class="my-8">
        <h2 class="text-2xl font-semibold mb-4">View Courses Taught by Instructor</h2>
        <div class="border p-4 rounded-md">

            <!-- Search Form -->
            <form action="" method="post" class="mb-4">
                <label for="instructor_id" class="block text-lg font-semibold">Enter Instructor ID:</label>
                <input type="text" name="instructor_id" id="instructor_id" class="border p-2 rounded-md" required>
                <button type="submit" name="instructor_search_courses"
                    class="bg-blue-500 text-white px-4 py-2 rounded-md ml-2">Search</button>
            </form>

            <?php

            if (isset($_POST["instructor_search_courses"])) {
                $instructor_id = $_POST["instructor_id"];
                $query = "SELECT * FROM teaching
                      JOIN course ON teaching.course_code = course.course_code
                      JOIN instructor ON teaching.instructor_id = instructor.instructor_id
                      WHERE instructor.instructor_id = '$instructor_id'";

                $result = $conn->query($query);

                if ($result) {
                    if ($result->num_rows > 0) {
                        echo "<p class='text-lg font-semibold mb-4'><strong>Courses Taught by Instructor:</strong></p>";
                        echo "<table class='table-auto border border-collapse border-gray-700'>";
                        echo "<thead class='bg-gray-300'>";
                        echo "<tr>";
                        echo "<th class='px-4 py-2'>Course Code</th>";
                        echo "<th class='px-4 py-2'>Title</th>";
                        echo "<th class='px-4 py-2'>Description</th>";
                        echo "<th class='px-4 py-2'>Credit Value</th>";
                        echo "<th class='px-4 py-2'>Level</th>";
                        echo "</tr>";
                        echo "</thead>";
                        echo "<tbody>";

                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td class='border px-4 py-2'>" . $row["course_code"] . "</td>";
                            echo "<td class='border px-4 py-2'>" . $row["title"] . "</td>";
                            echo "<td class='border px-4 py-2'>" . $row["description"] . "</td>";
                            echo "<td class='border px-4 py-2'>" . $row["credit_value"] . "</td>";
                            echo "<td class='border px-4 py-2'>" . $row["level"] . "</td>";
                            echo "</tr>";
                        }

                        echo "</tbody>";
                        echo "</table>";
                    } else {
                        echo "No records found for Instructor ID: $instructor_id.";
                    }
                } else {
                    echo "Error: " . $conn->error;
                }
            }
            ?>
        </div>
    </section>
    <!-- Section 3: View Teaching History -->
    <section class="my-8">
        <h2 class="text-2xl font-semibold mb-4">View Teaching History</h2>
        <div class="border p-4 rounded-md">
            <!-- Instructor ID Form -->
            <form action="view_teaching_history.php" method="post">
                <label for="instructor_id">Instructor ID:</label>
                <input type="text" name="instructor_id" id="instructor_id">
                <button type="submit" name="view_history">View History</button>
            </form>

            <?php
            if (isset($_POST["view_history"])) {
                // Get the instructor ID from the form submission
                $instructor_id = $_POST["instructor_id"];

                // Retrieve teaching history from the database based on the provided instructor ID
                $query = "SELECT * FROM teaching WHERE instructor_id = '$instructor_id'";
                $result = $conn->query($query);

                if ($result && $result->num_rows > 0) {
                    echo "<table>";
                    echo "<tr><th>Course Code</th><th>Teaching Semester</th></tr>";
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr><td>" . $row['course_code'] . "</td><td>" . $row['teaching_semester'] . "</td></tr>";
                    }
                    echo "</table>";
                } else {
                    echo "No teaching history available for instructor ID: $instructor_id";
                }
            }
            ?>
        </div>
    </section>


    <!-- Section 2: Assign Grades to Students in Courses -->
    <section class="my-8">
        <h2 class="text-2xl font-semibold mb-4">Assign Grades to Students in Courses</h2>
        <div class="border p-4 rounded-md">
            <!-- Grade Assignment Form -->
            <form action="" method="post">
                <label for="student_id">Student ID:</label>
                <input type="text" name="student_id" id="student_id">
                <label for="course_code">Course Code:</label>
                <input type="text" name="course_code" id="course_code">
                <label for="grade">Grade:</label>
                <input type="text" name="grade" id="grade">
                <button type="submit" name="assign_grade">Assign Grade</button>
            </form>

            <?php
            if (isset($_POST["assign_grade"])) {
                $student_id = $_POST["student_id"];
                $course_code = $_POST["course_code"];
                $grade_value = $_POST["grade"];

                // Insert the grade into the database
                $query = "INSERT INTO grade (student_id, course_code, grade_value) VALUES ('$student_id', '$course_code', '$grade_value')";
                $result = $conn->query($query);

                if ($result) {
                    echo "Grade assigned successfully.";
                } else {
                    echo "Error assigning grade: " . $conn->error;
                }
            }
            ?>

            <h3>Available Grades:</h3>
            <table class="table-auto border border-collapse border-gray-700">
                <thead class="bg-gray-300">
                    <tr>
                        <th class="px-4 py-2">Grade Value</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Retrieve and display all available grades
                    $query = "SELECT DISTINCT grade_value FROM grade";
                    $result = $conn->query($query);

                    if ($result && $result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr><td class='border px-4 py-2'>" . $row['grade_value'] . "</td></tr>";
                        }
                    } else {
                        echo "<tr><td class='border px-4 py-2' colspan='1'>No grades available.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </section>



    <!-- Section 4: Add Course Materials -->
    <section class="my-8">
        <h2 class="text-2xl font-semibold mb-4">Add Course Materials</h2>
        <div class="border p-4 rounded-md">
            <!-- Course Materials Form -->
            <form action="" method="post">
                <label for="material_title">Material Title:</label>
                <input type="text" name="material_title" id="material_title">
                <label for="material_format">Material Format:</label>
                <input type="text" name="material_format" id="material_format">
                <label for="material_link">Material Link:</label>
                <input type="text" name="material_link" id="material_link">
                <label for="course_code">Course Code:</label>
                <input type="text" name="course_code" id="course_code">
                <button type="submit" name="add_material">Add Material</button>
            </form>

            <?php
            if (isset($_POST["add_material"])) {
                $material_title = $_POST["material_title"];
                $material_format = $_POST["material_format"];
                $material_link = $_POST["material_link"];
                $course_code = $_POST["course_code"];
                $instructor_id = "IN001"; // Replace with the actual instructor's ID.
            
                // Insert the course material into the database
                $query = "INSERT INTO course_material (title, format, link, course_code, instructor_id) VALUES ('$material_title', '$material_format', '$material_link', '$course_code', '$instructor_id')";
                $result = $conn->query($query);

                if ($result) {
                    echo "Course material added successfully.";
                } else {
                    echo "Error adding course material: " . $conn->error;
                }
            }
            ?>

            <!-- You can add additional code here to display a list of added course materials if needed. -->
        </div>
    </section>

    <!-- Section 5: Access Course Materials -->
    <section class="my-8">
        <h2 class="text-2xl font-semibold mb-4">Access Course Materials</h2>
        <div class="border p-4 rounded-md">
            <!-- Instructor ID Form -->
            <form action="" method="post">
                <label for="instructor_id">Instructor ID:</label>
                <input type="text" name="instructor_id" id="instructor_id">
                <button type="submit" name="search_materials">Search</button>
            </form>

            <?php
            // Define the SQL query to join tables and retrieve course materials with course name and instructor name
            $course_material_query = "SELECT cm.material_id, cm.title, cm.format, cm.link, c.title AS course_name, i.name AS instructor_name
FROM course_material cm
INNER JOIN course c ON cm.course_code = c.course_code
INNER JOIN instructor i ON cm.instructor_id = i.instructor_id";

            $course_material_result = $conn->query($course_material_query);

            if ($course_material_result->num_rows > 0) {
                echo "<p class='text-lg font-semibold mb-4'><strong>Course Materials:</strong></p>";
                echo "<table class='table-auto border border-collapse border-gray-700'>";
                echo "<thead class='bg-gray-300'>";
                echo "<tr>";
                echo "<th class='px-4 py-2'>Material ID</th>";
                echo "<th class='px-4 py-2'>Title</th>";
                echo "<th class='px-4 py-2'>Format</th>";
                echo "<th class='px-4 py-2'>Link</th>";
                echo "<th class='px-4 py-2'>Course Name</th>";
                echo "<th class='px-4 py-2'>Instructor Name</th>";
                echo "</tr>";
                echo "</thead>";
                echo "<tbody>";

                while ($row = $course_material_result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td class='border px-4 py-2'>" . $row["material_id"] . "</td>";
                    echo "<td class='border px-4 py-2'>" . $row["title"] . "</td>";
                    echo "<td class='border px-4 py-2'>" . $row["format"] . "</td>";
                    echo "<td class='border px-4 py-2 text-red-800'><a href='" . $row["link"] . "'>Download</a></td>";
                    echo "<td class='border px-4 py-2'>" . $row["course_name"] . "</td>";
                    echo "<td class='border px-4 py-2'>" . $row["instructor_name"] . "</td>";
                    echo "</tr>";
                }

                echo "</tbody>";
                echo "</table>";
            } else {
                echo "No course materials found.";
            }
            ?>

        </div>
    </section>


    <?php
    // Close the database connection
    $conn->close();
    ?>
</body>

</html>