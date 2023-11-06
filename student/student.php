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
        <h1 class="text-3xl font-bold">Student Dashboard</h1>
        <form action="" method="post">
            <button type="submit" name="logout" class="bg-red-500 text-white px-4 py-2 rounded-md">Logout</button>
        </form>
    </div>

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


    <!-- Section: View Semester Details and Courses -->
    <section class="my-8">
        <h2 class="text-2xl font-semibold mb-4">View Semester Details and Courses</h2>
        <div class="border p-4 rounded-md">

            <!-- Search Form for Semester -->
            <form action="" method="post" class="mb-4">
                <label for="semester_id" class="block text-lg font-semibold">Enter Semester ID:</label>
                <input type="text" name="semester_id" id="semester_id" class="border p-2 rounded-md" required>
                <button type="submit" name="search_semester"
                    class="bg-blue-500 text-white px-4 py-2 rounded-md ml-2">Search</button>
            </form>

            <?php


            if (isset($_POST["search_semester"])) {
                $semester_id = trim($_POST["semester_id"]);

                // Retrieve and display semester information with related courses
                $semester_query = "SELECT s.semester_id, s.start_date, s.end_date, c.course_code, c.title, c.description, c.credit_value, c.level
        FROM semester_course sc
        INNER JOIN semester s ON sc.semester_id = s.semester_id
        INNER JOIN course c ON sc.course_code = c.course_code
        WHERE sc.semester_id = '$semester_id'";

                $semester_result = $conn->query($semester_query);

                if ($semester_result->num_rows > 0) {
                    echo "<p class='text-lg font-semibold mb-4'><strong>Semester Information and Courses:</strong></p>";
                    echo "<table class='table-auto border border-collapse border-gray-700'>";
                    echo "<thead class='bg-gray-300'>";
                    echo "<tr>";
                    echo "<th class='px-4 py-2'>Semester ID</th>";
                    echo "<th class='px-4 py-2'>Start Date</th>";
                    echo "<th class='px-4 py-2'>End Date</th>";
                    echo "<th class='px-4 py-2'>Course Code</th>";
                    echo "<th class='px-4 py-2'>Course Title</th>";
                    echo "<th class='px-4 py-2'>Course Description</th>";
                    echo "<th class='px-4 py-2'>Credit Value</th>";
                    echo "<th class='px-4 py-2'>Level</th>";
                    echo "</tr>";
                    echo "</thead>";
                    echo "<tbody>";

                    while ($row = $semester_result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td class='border px-4 py-2'>" . $row["semester_id"] . "</td>";
                        echo "<td class='border px-4 py-2'>" . $row["start_date"] . "</td>";
                        echo "<td class='border px-4 py-2'>" . $row["end_date"] . "</td>";
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
                    echo "No records found for Semester ID: $semester_id.";
                }
            } else {
                $semester_query = "SELECT * FROM semester";
                $semester_result = $conn->query($semester_query);

                if ($semester_result) {
                    if ($semester_result->num_rows > 0) {
                        echo "<p class='text-lg font-semibold mb-4'><strong>Semester Information:</strong></p>";
                        echo "<table class='table-auto border border-collapse border-gray-700'>";
                        echo "<thead class='bg-gray-300'>";
                        echo "<tr>";
                        echo "<th class='px-4 py-2'>Semester ID</th>";
                        echo "<th class='px-4 py-2'>Start Date</th>";
                        echo "<th class='px-4 py-2'>End Date</th>";
                        echo "</tr>";
                        echo "</thead>";
                        echo "<tbody>";

                        while ($row = $semester_result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td class='border px-4 py-2'>" . $row["semester_id"] . "</td>";
                            echo "<td class='border px-4 py-2'>" . $row["start_date"] . "</td>";
                            echo "<td class='border px-4 py-2'>" . $row["end_date"] . "</td>";
                            echo "</tr>";
                        }

                        echo "</tbody>";
                        echo "</table>";
                    }
                } else {
                    echo "Error: " . $conn->error;
                }
            }


            ?>
        </div>
    </section>


    <!-- Section: Enroll in Courses -->
    <section class="my-8">
        <h2 class="text-2xl font-semibold mb-4">Enroll in Courses</h2>
        <div class="border p-4 rounded-md">

            <!-- Enrollment Form -->
            <form action="" method="post" class="mb-4">
                <label for="student_id" class="block text-lg font-semibold">Student ID:</label>
                <input type="text" name="student_id" id="student_id" class="border p-2 rounded-md" required>
                <label for="course_code" class="block text-lg font-semibold">Course Code:</label>
                <input type="text" name="course_code" id="course_code" class="border p-2 rounded-md" required>
                <label for="semester_id" class="block text-lg font-semibold">Semester ID:</label>
                <input type="text" name="semester_id" id="semester_id" class="border p-2 rounded-md" required>
                <button type="submit" name="enroll"
                    class="bg-blue-500 text-white px-4 py-2 rounded-md ml-2">Enroll</button>
            </form>

            <?php
            if (isset($_POST["enroll"])) {
                $student_id = trim($_POST["student_id"]);
                $course_code = $_POST["course_code"];
                $semester_id = $_POST["semester_id"];
                // You should validate input data here.
            
                // Insert the enrollment record into the enroll table
                $enroll_query = "INSERT INTO enroll (semester_id, course_code, student_id, enrollment_status) 
                            VALUES ('$semester_id', '$course_code', '$student_id', 'waitlisted')";

                if ($conn->query($enroll_query) === TRUE) {
                    echo "Enrollment successful.";
                } else {
                    echo "Error: " . $conn->error;
                }
            }
            ?>
        </div>
    </section>

    <!-- Section: Check Enrollment Status -->
    <section class="my-8">
        <h2 class="text-2xl font-semibold mb-4">Check Enrollment Status</h2>
        <div class="border p-4 rounded-md">

            <!-- Search Form for Enrollment Status -->
            <form action="" method="post" class="mb-4">
                <label for="search_student_id" class="block text-lg font-semibold">Student ID:</label>
                <input type="text" name="search_student_id" id="search_student_id" class="border p-2 rounded-md">
                <label for="search_course_code" class="block text-lg font-semibold">Course Code:</label>
                <input type="text" name="search_course_code" id="search_course_code" class="border p-2 rounded-md">
                <label for="search_semester_id" class="block text-lg font-semibold">Semester ID:</label>
                <input type="text" name="search_semester_id" id="search_semester_id" class="border p-2 rounded-md">
                <button type="submit" name="check_enrollment"
                    class="bg-blue-500 text-white px-4 py-2 rounded-md ml-2">Check Status</button>
            </form>

            <?php
            if (isset($_POST["check_enrollment"])) {
                $search_student_id = $_POST["search_student_id"];
                $search_course_code = $_POST["search_course_code"];
                $search_semester_id = $_POST["search_semester_id"];

                // Construct the query to check enrollment status
                $enrollment_status_query = "SELECT * FROM enroll
                WHERE student_id = '$search_student_id'
                OR course_code = '$search_course_code'
                OR semester_id = '$search_semester_id'";

                $enrollment_status_result = $conn->query($enrollment_status_query);

                if ($enrollment_status_result->num_rows > 0) {
                    echo "<p class='text-lg font-semibold mb-4'><strong>Enrollment Status:</strong></p>";
                    echo "<table class='table-auto border border-collapse border-gray-700'>";
                    echo "<thead class='bg-gray-300'>";
                    echo "<tr>";
                    echo "<th class='px-4 py-2'>Student ID</th>";
                    echo "<th class='px-4 py-2'>Course Code</th>";
                    echo "<th class='px-4 py-2'>Semester ID</th>";
                    echo "<th class='px-4 py-2'>Enrollment Status</th>";
                    echo "</tr>";
                    echo "</thead>";
                    echo "<tbody>";

                    while ($row = $enrollment_status_result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td class='border px-4 py-2'>" . $row["student_id"] . "</td>";
                        echo "<td class='border px-4 py-2'>" . $row["course_code"] . "</td>";
                        echo "<td class='border px-4 py-2'>" . $row["semester_id"] . "</td>";
                        echo "<td class='border px-4 py-2'>" . $row["enrollment_status"] . "</td>";
                        echo "</tr>";
                    }

                    echo "</tbody>";
                    echo "</table>";
                } else {
                    echo "No records found for the specified criteria.";
                }
            }
            ?>
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
                <button type="submit" name="search_student"
                    class="bg-blue-500 text-white px-4 py-2 rounded-md ml-2">Search</button>
            </form>

            <?php
            // Define the query to select a student by student_id
            $query = "SELECT * FROM student";

            if (isset($_POST["search_student"])) {
                $student_id = trim($_POST["student_id"]);
                $query = "SELECT * FROM student WHERE student_id = '$student_id'";
            }
            $result = $conn->query($query);

            if ($result) {
                if ($result->num_rows > 0) {
                    echo "<p class='text-lg font-semibold mb-4'><strong>Student Information:</strong></p>";
                    echo "<table class='table-auto border border-collapse border-gray-700'>";
                    echo "<thead class='bg-gray-300'>";
                    echo "<tr>";
                    echo "<th class='px-4 py-2'>Student ID</th>";
                    echo "<th class='px-4 py-2'>Name</th>";
                    echo "<th class='px-4 py-2'>Date of Birth</th>";
                    echo "<th class='px-4 py-2'>Academic Program</th>";
                    echo "<th class='px-4 py-2'>Advisor</th>";
                    echo "</tr>";
                    echo "</thead>";
                    echo "<tbody>";

                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td class='border px-4 py-2'>" . $row["student_id"] . "</td>";
                        echo "<td class='border px-4 py-2'>" . $row["name"] . "</td>";
                        echo "<td class='border px-4 py-2'>" . $row["dob"] . "</td>";
                        echo "<td class='border px-4 py-2'>" . $row["academic_program"] . "</td>";
                        echo "<td class='border px-4 py-2'>" . $row["advisor"] . "</td>";
                        echo "</tr>";
                    }

                    echo "</tbody>";
                    echo "</table>";
                } else {
                    echo "No records found for student ID: $student_id.";
                }
            } else {
                echo "Error: " . $conn->error;
            }


            ?>
        </div>
    </section>


    <!-- Section 5: View Grades and GPA -->
    <section class="my-8">
        <h2 class="text-2xl font-semibold mb-4">View Grades and GPA</h2>
        <div class="border p-4 rounded-md">
            <!-- Search Form for Student ID -->
            <form action="" method="post" class="mb-4">
                <label for="student_id" class="block text-lg font-semibold">Enter Student ID:</label>
                <input type="text" name="student_id" id="student_id" class="border p-2 rounded-md" required>
                <button type="submit" name="search_grades"
                    class="bg-blue-500 text-white px-4 py-2 rounded-md ml-2">Search</button>
            </form>

            <?php
            if (isset($_POST["search_grades"])) {
                $student_id = trim($_POST["student_id"]);

                // Define the SQL query to join the "grade" and "course" tables to retrieve grades and course information
                $grades_query = "SELECT g.course_code, c.title, c.credit_value, g.grade_value
                FROM grade g
                INNER JOIN course c ON g.course_code = c.course_code
                WHERE g.student_id = '$student_id'";

                $grades_result = $conn->query($grades_query);

                if ($grades_result->num_rows > 0) {
                    echo "<p class='text-lg font-semibold mb-4'><strong>Grades:</strong></p>";
                    echo "<table class='table-auto border border-collapse border-gray-700'>";
                    echo "<thead class='bg-gray-300'>";
                    echo "<tr>";
                    echo "<th class='px-4 py-2'>Course Code</th>";
                    echo "<th class='px-4 py-2'>Course Title</th>";
                    echo "<th class='px-4 py-2'>Credit Value</th>";
                    echo "<th class='px-4 py-2'>Grade Value</th>";
                    echo "</tr>";
                    echo "</thead>";
                    echo "<tbody>";

                    $total_credit = 0;
                    $total_grade_points = 0;

                    while ($row = $grades_result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td class='border px-4 py-2'>" . $row["course_code"] . "</td>";
                        echo "<td class='border px-4 py-2'>" . $row["title"] . "</td>";
                        echo "<td class='border px-4 py-2'>" . $row["credit_value"] . "</td>";
                        echo "<td class='border px-4 py-2'>" . $row["grade_value"] . "</td>";
                        echo "</tr>";

                        // Calculate the total credit hours and total grade points
                        $total_credit += $row["credit_value"];
                        $total_grade_points += $row["grade_value"] * $row["credit_value"];
                    }

                    echo "</tbody>";
                    echo "</table>";

                    // Calculate GPA
                    if ($total_credit > 0) {
                        $gpa = $total_grade_points / $total_credit;
                        echo "<p class='text-lg font-semibold mt-4'><strong>GPA:</strong> " . number_format($gpa, 2) . "</p>";
                    }
                } else {
                    echo "No grades found for the specified student.";
                }
            }
            ?>
        </div>
    </section>


    <!-- Section 6: Access Course Materials -->
    <section class="my-8">
        <h2 class="text-2xl font-semibold mb-4">Access Course Materials</h2>
        <div class="border p-4 rounded-md">
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