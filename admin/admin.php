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
        <h1 class="text-3xl font-bold">Admin Dashboard</h1>
        <form action="" method="post">
            <button type="submit" name="logout" class="bg-red-500 text-white px-4 py-2 rounded-md">Logout</button>
        </form>
    </div>


    <!-- Section: Add Course -->
    <section class="my-8">
        <h2 class="text-2xl font-semibold mb-4">Add Courses</h2>
        <div class="border p-4 rounded-md">
            <!-- Add Course Form -->
            <form action="" method="post" class="mb-4">
                <label for="course_code" class="block text-lg font-semibold">Course Code:</label>
                <input type="text" name="course_code" id="course_code" class="border p-2 rounded-md" required>

                <label for="course_title" class="block text-lg font-semibold mt-2">Course Title:</label>
                <input type="text" name="course_title" id="course_title" class="border p-2 rounded-md" required>

                <label for="course_description" class="block text-lg font-semibold mt-2">Course Description:</label>
                <textarea name="course_description" id="course_description" class="border p-2 rounded-md"
                    required></textarea>

                <label for="credit_value" class="block text-lg font-semibold mt-2">Credit Value:</label>
                <input type="number" name="credit_value" id="credit_value" class="border p-2 rounded-md" required>

                <label for="course_level" class="block text-lg font-semibold mt-2">Course Level:</label>
                <input type="text" name="course_level" id="course_level" class="border p-2 rounded-md" required>

                <button type="submit" name="add_course" class="bg-blue-500 text-white px-4 py-2 rounded-md mt-4">Add
                    Course</button>
            </form>

            <?php
            if (isset($_POST["add_course"])) {
                // Handle the POST request to add a course
                $course_code = trim($_POST["course_code"]);
                $course_title = trim($_POST["course_title"]);
                $course_description = trim($_POST["course_description"]);
                $credit_value = intval($_POST["credit_value"]);
                $course_level = trim($_POST["course_level"]);

                // Insert the course data into your database
                // You need to replace these placeholders with your database logic
                $sql = "INSERT INTO course (course_code, title, description, credit_value, level) 
                    VALUES ('$course_code', '$course_title', '$course_description', $credit_value, '$course_level')";

                // Execute the SQL query
                $result = $conn->query($sql);

                if ($result) {
                    echo "<p class='mt-4 text-green-500'>Course added successfully.</p>";
                } else {
                    echo "<p class='mt-4 text-red-500'>Error adding course: " . $conn->error . "</p>";
                }
            }
            ?>
        </div>
    </section>



    <!-- Section: Manage Course Prerequisites -->
    <section class="my-8">
        <h2 class="text-2xl font-semibold mb-4">Manage Course Prerequisites</h2>
        <div class="border p-4 rounded-md">

            <!-- Form to Add Prerequisites -->
            <form action="" method="post" class="mb-4">
                <label for="course_code" class="block text-lg font-semibold">Enter Course Code:</label>
                <input type="text" name="course_code" id="course_code" class="border p-2 rounded-md" required>

                <label for="requested_course" class="block text-lg font-semibold mt-2">Enter Prerequisite Course
                    Code:</label>
                <input type="text" name="requested_course" id="requested_course" class="border p-2 rounded-md" required>

                <button type="submit" name="add_prerequisite"
                    class="bg-blue-500 text-white px-4 py-2 rounded-md mt-2">Add Prerequisite</button>
            </form>

            <?php
            if (isset($_POST["add_prerequisite"])) {
                $course_code = trim($_POST["course_code"]);
                $requested_course = trim($_POST["requested_course"]);

                // Insert the prerequisite into the database
                $insert_query = "INSERT INTO prerequisite (course_code, requested_course) VALUES ('$course_code', '$requested_course')";
                if ($conn->query($insert_query) === TRUE) {
                    echo "Prerequisite added successfully.";
                } else {
                    echo "Error: " . $conn->error;
                }
            }
            ?>

            <!-- Table to Display Existing Prerequisites -->
            <?php
            $prerequisite_query = "SELECT * FROM prerequisite";
            $prerequisite_result = $conn->query($prerequisite_query);

            if ($prerequisite_result->num_rows > 0) {
                echo "<p class='text-lg font-semibold mb-2'><strong>Prerequisites:</strong></p>";
                echo "<table class='table-auto border border-collapse border-gray-700'>";
                echo "<thead class='bg-gray-300'>";
                echo "<tr>";
                echo "<th class='px-4 py-2 border'>Course Code</th>";
                echo "<th class='px-4 py-2 border'>Requested Course</th>";
                echo "</tr>";
                echo "</thead>";
                echo "<tbody>";

                while ($row = $prerequisite_result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td class='px-4 py-2 border'>" . $row["course_code"] . "</td>";
                    echo "<td class='px-4 py-2 border'>" . $row["requested_course"] . "</td>";
                    echo "</tr>";
                }

                echo "</tbody>";
                echo "</table>";
            } else {
                echo "<p class='mt-4'>No prerequisites.</p>";
            }

            ?>

        </div>
    </section>
    <!-- Section: Manage Course Co-requisites -->
    <section class="my-8">
        <h2 class="text-2xl font-semibold mb-4">Manage Course Co-requisites</h2>
        <div class="border p-4 rounded-md">

            <!-- Add Co-requisite Form -->
            <form action="" method="post" class="mb-4">
                <label for="course_code" class="block text-lg font-semibold">Enter Course Code:</label>
                <input type="text" name="course_code" id="course_code" class="border p-2 rounded-md" required>

                <label for="requested_course" class="block text-lg font-semibold">Enter Co-requisite Course
                    Code:</label>
                <input type="text" name="requested_course" id="requested_course" class="border p-2 rounded-md" required>

                <button type="submit" name="add_co_requisite"
                    class="bg-blue-500 text-white px-4 py-2 rounded-md ml-2">Add Co-requisite</button>
            </form>

            <?php
            // Handle the form submission
            if (isset($_POST["add_co_requisite"])) {
                $course_code = trim($_POST["course_code"]);
                $requested_course = trim($_POST["requested_course"]);

                // Insert the co-requisite into the database or update the existing record
                // Replace this with your actual database interaction code
                $sql = "INSERT INTO co_requisite (course_code, requested_course) 
                    VALUES ('$course_code', '$requested_course') 
                    ON DUPLICATE KEY UPDATE requested_course = VALUES(requested_course)";

                // Execute the SQL query (assuming you have a database connection)
                // $conn->query($sql);
            
                // Display a success message or handle errors
                // Replace this with appropriate success/error handling
                if ($conn->query($sql)) {
                    echo "<p class='mt-4 text-green-500'>Co-requisite added/updated successfully.</p>";
                } else {
                    echo "<p class='mt-4 text-red-500'>Error: " . $conn->error . "</p>";
                }
            }
            ?>

            <!-- Display Co-requisites Table -->
            <?php
            // Retrieve and display the co-requisites table
            // Replace this with your actual database retrieval code
            $co_requisites_query = "SELECT course_code, requested_course FROM co_requisite";
            $co_requisites_result = $conn->query($co_requisites_query);

            if ($co_requisites_result->num_rows > 0) {
                echo "<p class='text-lg font-semibold mb-4'><strong>Co-requisites:</strong></p>";
                echo "<table class='table-auto border border-collapse border-gray-700'>";
                echo "<thead class='bg-gray-300'>";
                echo "<tr>";
                echo "<th class='px-4 py-2'>Course Code</th>";
                echo "<th class='px-4 py-2'>Co-requisite Course Code</th>";
                echo "</tr>";
                echo "</thead>";
                echo "<tbody>";

                while ($row = $co_requisites_result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td class='border px-4 py-2'>" . $row["course_code"] . "</td>";
                    echo "<td class='border px-4 py-2'>" . $row["requested_course"] . "</td>";
                    echo "</tr>";
                }

                echo "</tbody>";
                echo "</table>";
            } else {
                echo "<p>No co-requisites found.</p>";
            }
            ?>
        </div>
    </section>

    <!-- Section: Manage Enrollment -->
    <section class="my-8">
        <h2 class="text-2xl font-semibold mb-4">Manage Enrollment</h2>
        <div class="border p-4 rounded-md">
            <!-- Enrollment Management Form -->
            <form action="" method="post" class="mb-4">
                <div class="mb-4">
                    <label for="semester_id" class="block text-lg font-semibold">Semester ID:</label>
                    <input type="text" name="semester_id" id="semester_id" class="border p-2 rounded-md" required>
                </div>
                <div class="mb-4">
                    <label for="course_code" class="block text-lg font-semibold">Course Code:</label>
                    <input type="text" name="course_code" id="course_code" class="border p-2 rounded-md" required>
                </div>
                <div class="mb-4">
                    <label for="student_id" class="block text-lg font-semibold">Student ID:</label>
                    <input type="text" name="student_id" id="student_id" class="border p-2 rounded-md" required>
                </div>
                <div class="mb-4">
                    <label for="enrollment_status" class="block text-lg font-semibold">Enrollment Status:</label>
                    <select name="enrollment_status" id="enrollment_status" class="border p-2 rounded-md" required>
                        <option value="registered">Registered</option>
                        <option value="dropped">Dropped</option>
                        <option value="waitlisted">Waitlisted</option>
                    </select>
                </div>
                <button type="submit" name="update_enrollment"
                    class="bg-blue-500 text-white px-4 py-2 rounded-md">Update Enrollment</button>
            </form>

            <?php
            // Handle the form submission
            if (isset($_POST["update_enrollment"])) {
                $semester_id = $_POST["semester_id"];
                $course_code = $_POST["course_code"];
                $student_id = $_POST["student_id"];
                $enrollment_status = $_POST["enrollment_status"];

                // Perform the database update operation (you should have a database connection established)
                // You'll need to replace the following code with your database query
                $sql = "UPDATE enroll SET enrollment_status = '$enrollment_status' WHERE semester_id = '$semester_id' AND course_code = '$course_code' AND student_id = '$student_id'";

                if ($conn->query($sql) === true) {
                    echo "Enrollment status updated successfully.";
                } else {
                    echo "Error updating enrollment status: " . $conn->error;
                }
            }
            ?>
        </div>
    </section>


    <!-- Section: Generate Academic Reports -->
    <section class="my-8">
        <h2 class="text-2xl font-semibold mb-4">Generate Academic Reports</h2>
        <div class="border p-4 rounded-md">
            <!-- Academic Report Form -->
            <form action="" method="post" class="mb-4">
                <label for="student_id" class="block text-lg font-semibold">Enter Student ID:</label>
                <input type="text" name="student_id" id="student_id" class="border p-2 rounded-md" required>
                <button type="submit" name="generate_report"
                    class="bg-blue-500 text-white px-4 py-2 rounded-md ml-2">Generate Report</button>
            </form>

            <?php
            if (isset($_POST["generate_report"])) {
                $student_id = trim($_POST["student_id"]);

                // Retrieve academic reports for the specified student, joining with course and instructor tables
                $report_query = "SELECT g.student_id, g.course_code, g.instructor_id, g.grade_value, g.date, c.title AS course_title, i.name AS instructor_name
                    FROM grade g
                    JOIN course c ON g.course_code = c.course_code
                    JOIN instructor i ON g.instructor_id = i.instructor_id
                    WHERE g.student_id = '$student_id'";
                $report_result = $conn->query($report_query);

                if ($report_result->num_rows > 0) {
                    echo "<p class='text-lg font-semibold mb-4'><strong>Academic Report for Student ID: $student_id</strong></p>";
                    echo "<table class='table-auto border border-collapse border-gray-700'>";
                    echo "<thead class='bg-gray-300'>";
                    echo "<tr>";
                    echo "<th class='px-4 py-2'>Student ID</th>";
                    echo "<th class='px-4 py-2'>Course Title</th>";
                    echo "<th class='px-4 py-2'>Instructor Name</th>";
                    echo "<th class='px-4 py-2'>Grade Value</th>";
                    echo "<th class='px-4 py-2'>Date</th>";
                    echo "</tr>";
                    echo "</thead>";
                    echo "<tbody>";

                    while ($row = $report_result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td class='border px-4 py-2'>" . $row["student_id"] . "</td>";
                        echo "<td class='border px-4 py-2'>" . $row["course_title"] . "</td>";
                        echo "<td class='border px-4 py-2'>" . $row["instructor_name"] . "</td>";
                        echo "<td class='border px-4 py-2'>" . $row["grade_value"] . "</td>";
                        echo "<td class='border px-4 py-2'>" . $row["date"] . "</td>";
                        echo "</tr>";
                    }

                    echo "</tbody>";
                    echo "</table>";
                } else {
                    echo "No academic reports found for Student ID: $student_id.";
                }
            }
            ?>
        </div>
    </section>


    <!-- Section: View and Update Course Information -->
    <section class="my-8">
        <h2 class="text-2xl font-semibold mb-4">View and Update Course Information</h2>
        <div class="border p-4 rounded-md">

            <?php
            // Display all rows of the course table
            $all_courses_query = "SELECT * FROM course";
            $all_courses_result = $conn->query($all_courses_query);

            if ($all_courses_result->num_rows > 0) {
                echo "<p class='text-lg font-semibold mb-4'><strong>All Courses:</strong></p>";
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

                while ($row = $all_courses_result->fetch_assoc()) {
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
                echo "<p class='text-lg font-semibold mb-4'>No courses found.</p>";
            }
            ?>

            <!-- Update Course Information Form -->
            <form action="" method="post" class="mb-4">
                <label for="course_code" class="block text-lg font-semibold mt-4">Enter Course Code for Update:</label>
                <input type="text" name="course_code" id="course_code" class="border p-2 rounded-md" required>

                <!-- Include necessary fields for updating -->
                <label for="title" class="block text-lg font-semibold mt-2">Course Title:</label>
                <input type="text" name="title" id="title" class="border p-2 rounded-md" required>

                <label for="description" class="block text-lg font-semibold mt-2">Course Description:</label>
                <textarea name="description" id="description" class="border p-2 rounded-md" required></textarea>

                <label for="credit_value" class="block text-lg font-semibold mt-2">Credit Value:</label>
                <input type="text" name="credit_value" id="credit_value" class="border p-2 rounded-md" required>

                <label for="level" class="block text-lg font-semibold mt-2">Course Level:</label>
                <input type="text" name="level" id="level" class="border p-2 rounded-md" required>

                <button type="submit" name="update_course"
                    class="bg-blue-500 text-white px-4 py-2 rounded-md mt-2">Update Course</button>
            </form>

            <?php
            // Handle course update
            if (isset($_POST["update_course"])) {
                $title = trim($_POST["title"]);
                $description = trim($_POST["description"]);
                $credit_value = trim($_POST["credit_value"]);
                $level = trim($_POST["level"]);
                $course_code = trim($_POST["course_code"]);

                // Update course information in the database
                $update_query = "UPDATE course SET title = '$title', description = '$description', credit_value = '$credit_value', level = '$level' WHERE course_code = '$course_code'";
                if ($conn->query($update_query) === TRUE) {
                    echo "Course information updated successfully.";
                } else {
                    echo "Error updating course information: " . $conn->error;
                }
            }
            ?>
        </div>
    </section>



    <!-- Section: View and Update Student Information -->
    <section class="my-8">
        <h2 class="text-2xl font-semibold mb-4">View and Update Student Information</h2>
        <div class="border p-4 rounded-md">
            <?php
            // Display all rows of the student table
            $all_students_query = "SELECT * FROM student";
            $all_students_result = $conn->query($all_students_query);

            if ($all_students_result->num_rows > 0) {
                echo "<p class='text-lg font-semibold mb-4'><strong>All Students:</strong></p>";
                echo "<table class='table-auto border border-collapse border-gray-700'>";
                echo "<thead class='bg-gray-300'>";
                echo "<tr>";
                echo "<th class='px-4 py-2'>Student ID</th>";
                echo "<th class='px-4 py-2'>Name</th>";
                echo "<th class='px-4 py-2'>Date of Birth</th>";
                echo "<th class='px-4 py-2'>Academic Program</th>";
                echo "<th class='px-4 py-2'>Academic Advisor</th>";
                echo "</tr>";
                echo "</thead>";
                echo "<tbody>";

                while ($student_row = $all_students_result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td class='border px-4 py-2'>" . $student_row["student_id"] . "</td>";
                    echo "<td class='border px-4 py-2'>" . $student_row["name"] . "</td>";
                    echo "<td class='border px-4 py-2'>" . $student_row["dob"] . "</td>";
                    echo "<td class='border px-4 py-2'>" . $student_row["academic_program"] . "</td>";
                    echo "<td class='border px-4 py-2'>" . $student_row["advisor"] . "</td>";
                    echo "</tr>";
                }

                echo "</tbody>";
                echo "</table>";
            } else {
                echo "<p class='text-lg font-semibold mb-4'>No students found.</p>";
            }
            ?>

            <!-- Update Student Information Form -->
            <form action="" method="post" class="mb-4">
                <label for="student_id" class="block text-lg font-semibold mt-4">Enter Student ID for Update:</label>
                <input type="text" name="student_id" id="student_id" class="border p-2 rounded-md" required>

                <!-- Include necessary fields for updating -->
                <label for="name" class="block text-lg font-semibold mt-2">Name:</label>
                <input type="text" name="name" id="name" class="border p-2 rounded-md" required>

                <label for="dob" class="block text-lg font-semibold mt-2">Date of Birth:</label>
                <input type="date" name="dob" id="dob" class="border p-2 rounded-md" required>

                <label for="academic_program" class="block text-lg font-semibold mt-2">Academic Program:</label>
                <input type="text" name="academic_program" id="academic_program" class="border p-2 rounded-md" required>

                <label for="advisor" class="block text-lg font-semibold mt-2">Academic Advisor:</label>
                <input type="text" name="advisor" id="advisor" class="border p-2 rounded-md" required>

                <button type="submit" name="update_student"
                    class="bg-green-500 text-white px-4 py-2 rounded-md mt-4">Update Student</button>
            </form>

            <?php
            // Handle student update
            if (isset($_POST["update_student"])) {
                $student_id = trim($_POST["student_id"]);
                $name = trim($_POST["name"]);
                $dob = trim($_POST["dob"]);
                $academic_program = trim($_POST["academic_program"]);
                $advisor = trim($_POST["advisor"]);

                // Update student information in the database
                $update_query = "UPDATE student SET name = '$name', dob = '$dob', academic_program = '$academic_program', advisor = '$advisor' WHERE student_id = '$student_id'";
                if ($your_db_connection->query($update_query) === TRUE) {
                    echo "Student information updated successfully.";
                } else {
                    echo "Error updating student information: " . $your_db_connection->error;
                }
            }
            ?>
        </div>
    </section>


    <!-- Section: View and Update Instructor Information -->
    <section class="my-8">
        <h2 class="text-2xl font-semibold mb-4">View and Update Instructor Information</h2>
        <div class="border p-4 rounded-md">

            <?php
            // Display all rows of the instructor table
            $all_instructors_query = "SELECT * FROM instructor";
            $all_instructors_result = $conn->query($all_instructors_query);

            if ($all_instructors_result->num_rows > 0) {
                echo "<p class='text-lg font-semibold mb-4'><strong>All Instructors:</strong></p>";
                echo "<table class='table-auto border border-collapse border-gray-700'>";
                echo "<thead class='bg-gray-300'>";
                echo "<tr>";
                echo "<th class='px-4 py-2'>Instructor ID</th>";
                echo "<th class='px-4 py-2'>Name</th>";
                echo "<th class='px-4 py-2'>Department ID</th>";
                echo "</tr>";
                echo "</thead>";
                echo "<tbody>";

                while ($row = $all_instructors_result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td class='border px-4 py-2'>" . $row["instructor_id"] . "</td>";
                    echo "<td class='border px-4 py-2'>" . $row["name"] . "</td>";
                    echo "<td class='border px-4 py-2'>" . $row["department_id"] . "</td>";
                    echo "</tr>";
                }

                echo "</tbody>";
                echo "</table>";
            } else {
                echo "<p class='text-lg font-semibold mb-4'>No instructors found.</p>";
            }
            ?>

            <!-- Update Instructor Information Form -->
            <form action="" method="post" class="mb-4">
                <label for="instructor_id" class="block text-lg font-semibold mt-4">Enter Instructor ID for
                    Update:</label>
                <input type="text" name="instructor_id" id="instructor_id" class="border p-2 rounded-md" required>

                <!-- Include necessary fields for updating -->
                <label for="name" class="block text-lg font-semibold mt-2">Instructor Name:</label>
                <input type="text" name="name" id="name" class="border p-2 rounded-md" required>

                <label for="department_id" class="block text-lg font-semibold mt-2">Department ID:</label>
                <input type="text" name="department_id" id="department_id" class="border p-2 rounded-md" required>

                <button type="submit" name="update_instructor"
                    class="bg-blue-500 text-white px-4 py-2 rounded-md mt-2">Update Instructor</button>
            </form>

            <?php
            // Handle instructor update
            if (isset($_POST["update_instructor"])) {
                $name = trim($_POST["name"]);
                $department_id = trim($_POST["department_id"]);
                $instructor_id = trim($_POST["instructor_id"]);

                // Update instructor information in the database
                $update_query = "UPDATE instructor SET name = '$name', department_id = '$department_id' WHERE instructor_id = '$instructor_id'";
                if ($conn->query($update_query) === TRUE) {
                    echo "Instructor information updated successfully.";
                } else {
                    echo "Error updating instructor information: " . $conn->error;
                }
            }
            ?>
        </div>
    </section>


    <!-- Section: Access Digital Library of Course Materials -->
    <section class="my-8">
        <h2 class="text-2xl font-semibold mb-4">Access Digital Library of Course Materials</h2>
        <div class="border p-4 rounded-md">
            <!-- Display a list of existing materials -->
            <h3 class="text-xl font-semibold mb-4">List of Course Materials:</h3>

            <?php
            // Query to fetch existing course materials
            $material_query = "SELECT * FROM course_material";
            $material_result = $conn->query($material_query);

            if ($material_result->num_rows > 0) {
                echo "<table class='table-auto border border-collapse border-gray-700'>";
                echo "<thead class='bg-gray-300'>";
                echo "<tr>";
                echo "<th class='px-4 py-2'>Material ID</th>";
                echo "<th class='px-4 py-2'>Title</th>";
                echo "<th class='px-4 py-2'>Format</th>";
                echo "<th class='px-4 py-2'>Link</th>";
                echo "<th class='px-4 py-2'>Course Code</th>";
                echo "<th class='px-4 py-2'>Instructor ID</th>";
                echo "</tr>";
                echo "</thead>";
                echo "<tbody>";

                while ($material_row = $material_result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td class='border px-4 py-2'>" . $material_row["material_id"] . "</td>";
                    echo "<td class='border px-4 py-2'>" . $material_row["title"] . "</td>";
                    echo "<td class='border px-4 py-2'>" . $material_row["format"] . "</td>";
                    echo "<td class='border px-4 py-2'>" . $material_row["link"] . "</td>";
                    echo "<td class='border px-4 py-2'>" . $material_row["course_code"] . "</td>";
                    echo "<td class='border px-4 py-2'>" . $material_row["instructor_id"] . "</td>";
                    echo "</tr>";
                }

                echo "</tbody>";
                echo "</table>";
            } else {
                echo "<p class='text-lg font-semibold mb-4'>No course materials found.</p>";
            }
            ?>

            <!-- Form to update course materials -->
            <h3 class="text-xl font-semibold mt-8 mb-4">Update Course Material:</h3>
            <form action="" method="post">
                <label for="material_id" class="block text-lg font-semibold">Material ID:</label>
                <input type="text" name="material_id" id="material_id" class="border p-2 rounded-md" required>

                <!-- Include necessary fields for updating -->
                <label for="title" class="block text-lg font-semibold mt-2">Title:</label>
                <input type="text" name="title" id="title" class="border p-2 rounded-md" required>

                <label for="format" class="block text-lg font-semibold mt-2">Format:</label>
                <input type="text" name="format" id="format" class="border p-2 rounded-md" required>

                <label for="link" class="block text-lg font-semibold mt-2">Link:</label>
                <input type="text" name="link" id="link" class="border p-2 rounded-md" required>

                <label for="course_code" class="block text-lg font-semibold mt-2">Course Code:</label>
                <input type="text" name="course_code" id="course_code" class="border p-2 rounded-md" required>

                <label for="instructor_id" class="block text-lg font-semibold mt-2">Instructor ID:</label>
                <input type="text" name="instructor_id" id="instructor_id" class="border p-2 rounded-md" required>

                <button type="submit" name="update_material"
                    class="bg-blue-500 text-white px-4 py-2 rounded-md mt-2">Update Material</button>
            </form>

            <?php
            if (isset($_POST["update_material"])) {
                // Handle the update operation here
                $material_id = $_POST["material_id"];
                $title = $_POST["title"];
                $format = $_POST["format"];
                $link = $_POST["link"];
                $course_code = $_POST["course_code"];
                $instructor_id = $_POST["instructor_id"];

                // Build and execute the SQL update query
                $update_query = "UPDATE course_material SET title = '$title', format = '$format', link = '$link', course_code = '$course_code', instructor_id = '$instructor_id' WHERE material_id = '$material_id'";

                if ($conn->query($update_query) === TRUE) {
                    echo "Material updated successfully.";
                } else {
                    echo "Error updating material: " . $conn->error;
                }
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