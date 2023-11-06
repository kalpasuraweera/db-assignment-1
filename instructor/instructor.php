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
            <!-- Add your view and update personal info form here -->
            <form action="update_personal_info.php" method="post">
                <label for="name">Name:</label>
                <input type="text" name="name" id="name">
                <label for="dob">Date of Birth:</label>
                <input type="date" name="dob" id="dob">
                <button type="submit" name="update_info">Update Info</button>
            </form>
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
            <?php
            // Retrieve teaching history from the database
            $query = "SELECT * FROM teaching WHERE instructor_id = 'IN001'";
            $result = $conn->query($query);

            if ($result && $result->num_rows > 0) {
                echo "<table>";
                echo "<tr><th>Course Code</th><th>Teaching Semester</th></tr>";
                while ($row = $result->fetch_assoc()) {
                    echo "<tr><td>" . $row['course_code'] . "</td><td>" . $row['teaching_semester'] . "</td></tr>";
                }
                echo "</table>";
            } else {
                echo "No teaching history available.";
            }
            ?>
        </div>
    </section>

    <!-- Section 2: Assign Grades to Students in Courses -->
    <section class="my-8">
        <h2 class="text-2xl font-semibold mb-4">Assign Grades to Students in Courses</h2>
        <div class="border p-4 rounded-md">
            <!-- Add your form for assigning grades to students here -->
            <form action="assign_grades.php" method="post">
                <label for="student_id">Student ID:</label>
                <input type="text" name="student_id" id="student_id">
                <label for="course_code">Course Code:</label>
                <input type="text" name="course_code" id="course_code">
                <label for="grade">Grade:</label>
                <input type="text" name="grade" id="grade">
                <button type="submit" name="assign_grade">Assign Grade</button>
            </form>
        </div>
    </section>

    <!-- Section 4: Add Course Materials -->
    <section class="my-8">
        <h2 class="text-2xl font-semibold mb-4">Add Course Materials</h2>
        <div class="border p-4 rounded-md">
            <!-- Add your form for adding course materials here -->
            <form action="add_course_material.php" method="post">
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
        </div>
    </section>
    <!-- Section 5: Access Course Materials -->
    <section class="my-8">
        <h2 class="text-2xl font-semibold mb-4">Access Course Materials</h2>
        <div class="border p-4 rounded-md">
            <!-- Add links or buttons to access course materials -->
            <?php
            // Retrieve course materials associated with the courses the instructor teaches
            $query = "SELECT * FROM course_material WHERE instructor_id = 'IN001'";
            $result = $conn->query($query);

            if ($result && $result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<a href='" . $row['material_link'] . "'>" . $row['material_title'] . "</a><br>";
                }
            } else {
                echo "No course materials available.";
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