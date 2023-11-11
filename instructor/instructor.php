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
            <form action="" method="post" class="mb-4">
                <label for="instructor_id" class="block text-lg font-semibold">Instructor ID:</label>
                <input type="text" name="instructor_id" id="instructor_id" class="border p-2 rounded-md" required>

                <label for="name" class="block text-lg font-semibold mt-4">Name:</label>
                <input type="text" name="name" id="name" class="border p-2 rounded-md" required>

                <button type="submit" name="update_info" class="bg-blue-500 text-white px-4 py-2 rounded-md mt-4">Update
                    Info</button>
            </form>
            <?php

            if (isset($_POST["update_info"])) {
                // Get the instructor ID from the form submission
                $instructor_id = $_POST["instructor_id"];
                $name = $_POST["name"];

                // Update the instructor's personal information in the database
                $query = "UPDATE instructor SET name = '$name' WHERE instructor_id = '$instructor_id'";
                $result = $conn->query($query);

                if ($result) {
                    echo "Personal information updated successfully.";
                } else {
                    echo "Error updating personal information: " . $conn->error;
                }
            }

            // Display a table of all instructor details
            $query = "SELECT i.instructor_id, i.name, ic.contact, isu.subject, d.department_name 
            FROM instructor i 
            LEFT JOIN instructor_contact ic ON i.instructor_id = ic.instructor_id 
            LEFT JOIN instructor_subject isu ON i.instructor_id = isu.instructor_id 
            LEFT JOIN department d ON d.department_id = i.department_id";
            $result = $conn->query($query);

            if ($result && $result->num_rows > 0) {
                echo "<p class='text-lg font-semibold mb-4'><strong>Student Information:</strong></p>";
                echo "<table class='table-auto border border-collapse border-gray-700'>";
                echo "<thead class='bg-gray-300'>";
                echo "<tr>";
                echo "<th class='px-4 py-2'>Instructor ID</th>";
                echo "<th class='px-4 py-2'>Name</th>";
                echo "<th class='px-4 py-2'>Contact</th>";
                echo "<th class='px-4 py-2'>Subject</th>";
                echo "<th class='px-4 py-2'>Department</th>";
                echo "</tr>";
                echo "</thead>";
                echo "<tbody>";

                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td class='border px-4 py-2'>" . $row["instructor_id"] . "</td>";
                    echo "<td class='border px-4 py-2'>" . $row["name"] . "</td>";
                    echo "<td class='border px-4 py-2'>" . $row["contact"] . "</td>";
                    echo "<td class='border px-4 py-2'>" . $row["subject"] . "</td>";
                    echo "<td class='border px-4 py-2'>" . $row["department_name"] . "</td>";
                    echo "</tr>";
                }

                echo "</tbody>";
                echo "</table>";
            } else {
                echo "No instructor details available.";
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
            <form action="" method="post" class="mb-4">
                <label for="instructor_id" class="block text-lg font-semibold">Instructor ID:</label>
                <input type="text" name="instructor_id" id="instructor_id" class="border p-2 rounded-md" required>
                <button type="submit" name="view_history" class="bg-blue-500 text-white px-4 py-2 rounded-md mt-4">View
                    History</button>
            </form>

            <?php
            if (isset($_POST["view_history"])) {
                // Get the instructor ID from the form submission
                $instructor_id = $_POST["instructor_id"];

                // Retrieve teaching history with course names from the database based on the provided instructor ID
                $query = "SELECT t.*, c.title AS course_name
                      FROM teaching t
                      JOIN course c ON t.course_code = c.course_code
                      WHERE t.instructor_id = '$instructor_id'";
                $result = $conn->query($query);

                if ($result && $result->num_rows > 0) {
                    echo "<p class='text-lg font-semibold mb-4'><strong>Teaching History:</strong></p>";
                    echo "<table class='table-auto border border-collapse border-gray-700'>";
                    echo "<thead class='bg-gray-300'>";
                    echo "<tr>";
                    echo "<th class='px-4 py-2'>Course Code</th>";
                    echo "<th class='px-4 py-2'>Course Name</th>";
                    echo "<th class='px-4 py-2'>Teaching Semester</th>";
                    echo "</tr>";
                    echo "</thead>";
                    echo "<tbody>";

                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td class='border px-4 py-2'>" . $row['course_code'] . "</td>";
                        echo "<td class='border px-4 py-2'>" . $row['course_name'] . "</td>";
                        echo "<td class='border px-4 py-2'>" . $row['semester_id'] . "</td>";
                        echo "</tr>";
                    }

                    echo "</tbody>";
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
                <label for="student_id" class="block text-lg font-semibold">Student ID:</label>
                <input type="text" name="student_id" id="student_id" class="border p-2 rounded-md" required>

                <label for="course_code" class="block text-lg font-semibold mt-4">Course Code:</label>
                <input type="text" name="course_code" id="course_code" class="border p-2 rounded-md" required>

                <label for="grade" class="block text-lg font-semibold mt-4">Grade:</label>
                <input type="text" name="grade" id="grade" class="border p-2 rounded-md" required>

                <button type="submit" name="assign_grade"
                    class="bg-blue-500 text-white px-4 py-2 rounded-md mt-4">Assign Grade</button>
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
                    echo "<p class='mt-4 text-green-500'>Grade assigned successfully.</p>";
                } else {
                    echo "<p class='mt-4 text-red-500'>Error assigning grade: " . $conn->error . "</p>";
                }
            }
            ?>

            <p class='text-lg font-semibold mb-4'><strong>Available Grades:</strong></p>
            <table class="table-auto border border-collapse border-gray-700 mt-2">
                <thead class="bg-gray-300">
                    <tr>
                        <th class="px-4 py-2">Student ID</th>
                        <th class="px-4 py-2">Course Code</th>
                        <th class="px-4 py-2">Instructor ID</th>
                        <th class="px-4 py-2">Grade Value</th>
                        <th class="px-4 py-2">Date</th>
                        <!-- You can add more columns here as needed -->
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Retrieve and display all available grades
                    $query = "SELECT * FROM grade";
                    $result = $conn->query($query);

                    if ($result && $result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td class='border px-4 py-2'>" . $row['student_id'] . "</td>";
                            echo "<td class='border px-4 py-2'>" . $row['course_code'] . "</td>";
                            echo "<td class='border px-4 py-2'>" . $row['instructor_id'] . "</td>";
                            echo "<td class='border px-4 py-2'>" . $row['grade_value'] . "</td>";
                            echo "<td class='border px-4 py-2'>" . $row['date'] . "</td>";
                            // You can add more cells for additional columns here
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td class='border px-4 py-2' colspan='5'>No grades available.</td></tr>";
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
                <label for="material_title" class="block text-lg font-semibold">Material Title:</label>
                <input type="text" name="material_title" id="material_title" class="border p-2 rounded-md" required>

                <label for="material_format" class="block text-lg font-semibold mt-4">Material Format:</label>
                <input type="text" name="material_format" id="material_format" class="border p-2 rounded-md" required>

                <label for="material_link" class="block text-lg font-semibold mt-4">Material Link:</label>
                <input type="text" name="material_link" id="material_link" class="border p-2 rounded-md" required>

                <label for="course_code" class="block text-lg font-semibold mt-4">Course Code:</label>
                <input type="text" name="course_code" id="course_code" class="border p-2 rounded-md" required>

                <button type="submit" name="add_material" class="bg-blue-500 text-white px-4 py-2 rounded-md mt-4">Add
                    Material</button>
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
                    echo "<p class='mt-4 text-green-500'>Course material added successfully.</p>";
                } else {
                    echo "<p class='mt-4 text-red-500'>Error adding course material: " . $conn->error . "</p>";
                }
            }
            ?>
        </div>
    </section>

    <!-- Section 5: Delete Course Material -->
    <section class="my-8">
        <h2 class="text-2xl font-semibold mb-4">Delete Course Material</h2>
        <div class="border p-4 rounded-md">
            <!-- Course Material Deletion Form -->
            <form action="" method="post">
                <label for="material_id" class="block text-lg font-semibold">Material ID:</label>
                <input type="text" name="material_id" id="material_id" class="border p-2 rounded-md" required>

                <button type="submit" name="delete_material"
                    class="bg-red-500 text-white px-4 py-2 rounded-md mt-4">Delete Material</button>
            </form>

            <?php
            if (isset($_POST["delete_material"])) {
                $material_id = $_POST["material_id"];

                // Delete the course material from the database
                $query = "DELETE FROM course_material WHERE material_id = '$material_id'";
                $result = $conn->query($query);

                if ($result) {
                    echo "<p class='mt-4 text-green-500'>Course material deleted successfully.</p>";
                } else {
                    echo "<p class='mt-4 text-red-500'>Error deleting course material: " . $conn->error . "</p>";
                }
            }
            ?>
        </div>
    </section>

    <!-- Section 5: Access Course Materials -->
    <section class="my-8">
        <h2 class="text-2xl font-semibold mb-4">Access Course Materials</h2>
        <div class="border p-4 rounded-md">
            <!-- Instructor ID Form -->
            <form action="" method="post" class="mb-4">
                <label for="instructor_id" class="block text-lg font-semibold">Instructor ID:</label>
                <input type="text" name="instructor_id" id="instructor_id" class="border p-2 rounded-md" required>
                <button type="submit" name="search_materials"
                    class="bg-blue-500 text-white px-4 py-2 rounded-md mt-4">Search</button>
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
                    echo "<td class='border px-4 py-2 text-blue-500'><a href='" . $row["link"] . "' target='_blank'>Download</a></td>";
                    echo "<td class='border px-4 py-2'>" . $row["course_name"] . "</td>";
                    echo "<td class='border px-4 py-2'>" . $row["instructor_name"] . "</td>";
                    echo "</tr>";
                }

                echo "</tbody>";
                echo "</table>";
            } else {
                echo "<p class='mt-4 text-red-500'>No course materials found.</p>";
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