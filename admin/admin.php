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

                <label for="offered_semesters" class="block text-lg font-semibold mt-2">Offered Semesters:</label>
                <input type="text" name="offered_semesters" id="offered_semesters" class="border p-2 rounded-md"
                    required>

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
                $offered_semesters = trim($_POST["offered_semesters"]);

                // Insert the course data into your database
                // You need to replace these placeholders with your database logic
                $sql = "INSERT INTO courses (course_code, course_title, course_description, credit_value, offered_semesters) VALUES (?, ?, ?, ?, ?)";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("sssds", $course_code, $course_title, $course_description, $credit_value, $offered_semesters);

                if ($stmt->execute()) {
                    echo "Course added successfully!";
                } else {
                    echo "Error adding the course: " . $stmt->error;
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
                $insert_query = "INSERT INTO course_prerequisites (course_code, requested_course) VALUES ('$course_code', '$requested_course')";
                if ($conn->query($insert_query) === TRUE) {
                    echo "Prerequisite added successfully.";
                } else {
                    echo "Error: " . $conn->error;
                }
            }
            ?>

            <!-- Table to Display Existing Prerequisites -->
            <?php
            $prerequisite_query = "SELECT * FROM course_prerequisites WHERE course_code = '$course_code'";
            $prerequisite_result = $conn->query($prerequisite_query);

            if ($prerequisite_result->num_rows > 0) {
                echo "<p class='text-lg font-semibold mt-4'><strong>Prerequisites for Course Code: $course_code</strong></p>";
                echo "<table class='table-auto border border-collapse border-gray-700'>";
                echo "<thead class='bg-gray-300'>";
                echo "<tr>";
                echo "<th class='px-4 py-2'>Requested Course Code</th>";
                echo "</tr>";
                echo "</thead>";
                echo "<tbody>";

                while ($row = $prerequisite_result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td class='border px-4 py-2'>" . $row["requested_course"] . "</td>";
                    echo "</tr>";
                }

                echo "</tbody>";
                echo "</table>";
            } else {
                echo "No prerequisites found for Course Code: $course_code.";
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
                $sql = "INSERT INTO course_corequisites (course_code, requested_course) VALUES ('$course_code', '$requested_course') ON DUPLICATE KEY UPDATE requested_course = VALUES(requested_course)";

                // Execute the SQL query (assuming you have a database connection)
                // $conn->query($sql);
            
                // Display a success message or handle errors
                // Replace this with appropriate success/error handling
                if ($conn->query($sql)) {
                    echo "Co-requisite added/updated successfully.";
                } else {
                    echo "Error: " . $conn->error;
                }
            }
            ?>

            <!-- Display Co-requisites Table -->
            <?php
            // Retrieve and display the co-requisites table
            // Replace this with your actual database retrieval code
            $co_requisites_query = "SELECT course_code, requested_course FROM course_corequisites";
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
                echo "No co-requisites found.";
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

                // Connect to your database (replace with your connection code)
                $conn = new mysqli("localhost", "username", "password", "database_name");

                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }

                // Retrieve academic reports for the specified student
                $report_query = "SELECT * FROM grade WHERE student_id = '$student_id'";
                $report_result = $conn->query($report_query);

                if ($report_result->num_rows > 0) {
                    echo "<p class='text-lg font-semibold mb-4'><strong>Academic Report for Student ID: $student_id</strong></p>";
                    echo "<table class='table-auto border border-collapse border-gray-700'>";
                    echo "<thead class='bg-gray-300'>";
                    echo "<tr>";
                    echo "<th class='px-4 py-2'>Student ID</th>";
                    echo "<th class='px-4 py-2'>Course Code</th>";
                    echo "<th class='px-4 py-2'>Instructor ID</th>";
                    echo "<th class='px-4 py-2'>Grade Value</th>";
                    echo "<th class='px-4 py-2'>Date</th>";
                    echo "</tr>";
                    echo "</thead>";
                    echo "<tbody>";

                    while ($row = $report_result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td class='border px-4 py-2'>" . $row["student_id"] . "</td>";
                        echo "<td class='border px-4 py-2'>" . $row["course_code"] . "</td>";
                        echo "<td class='border px-4 py-2'>" . $row["instructor_id"] . "</td>";
                        echo "<td class='border px-4 py-2'>" . $row["grade_value"] . "</td>";
                        echo "<td class='border px-4 py-2'>" . $row["date"] . "</td>";
                        echo "</tr>";
                    }

                    echo "</tbody>";
                    echo "</table>";
                } else {
                    echo "No academic reports found for Student ID: $student_id.";
                }

                $conn->close(); // Close the database connection
            }
            ?>
        </div>
    </section>


    <!-- Section: View and Update Course Information -->
    <section class="my-8">
        <h2 class="text-2xl font-semibold mb-4">View and Update Course Information</h2>
        <div class="border p-4 rounded-md">

            <!-- Update Course Information Form -->
            <form action="" method="post" class="mb-4">
                <label for="course_code" class="block text-lg font-semibold">Enter Course Code:</label>
                <input type="text" name="course_code" id="course_code" class="border p-2 rounded-md" required>
                <button type="submit" name="search_course"
                    class="bg-blue-500 text-white px-4 py-2 rounded-md ml-2">Search</button>
            </form>

            <?php
            // Handle form submission
            if (isset($_POST["search_course"])) {
                $course_code = trim($_POST["course_code"]);

                // Retrieve course information
                $course_query = "SELECT * FROM course WHERE course_code = '$course_code'";
                $course_result = $conn->query($course_query);

                if ($course_result->num_rows > 0) {
                    $row = $course_result->fetch_assoc();

                    // Display course information in a form for updating
                    echo "<form action='' method='post' class='mb-4'>";
                    echo "<label for='title' class='block text-lg font-semibold'>Course Title:</label>";
                    echo "<input type='text' name='title' id='title' class='border p-2 rounded-md' value='" . $row["title"] . "' required>";

                    echo "<label for='description' class='block text-lg font-semibold'>Course Description:</label>";
                    echo "<textarea name='description' id='description' class='border p-2 rounded-md' required>" . $row["description"] . "</textarea>";

                    echo "<label for='credit_value' class='block text-lg font-semibold'>Credit Value:</label>";
                    echo "<input type='text' name='credit_value' id='credit_value' class='border p-2 rounded-md' value='" . $row["credit_value"] . "' required>";

                    echo "<label for='level' class='block text-lg font-semibold'>Course Level:</label>";
                    echo "<input type='text' name='level' id='level' class='border p-2 rounded-md' value='" . $row["level"] . "' required>";

                    echo "<button type='submit' name='update_course'
                    class='bg-blue-500 text-white px-4 py-2 rounded-md mt-2'>Update Course</button>";
                    echo "</form>";
                } else {
                    echo "No records found for Course Code: $course_code.";
                }
            }

            // Handle course update
            if (isset($_POST["update_course"])) {
                $title = trim($_POST["title"]);
                $description = trim($_POST["description"]);
                $credit_value = trim($_POST["credit_value"]);
                $level = trim($_POST["level"]);

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
            <!-- Form for updating student information -->
            <form action="" method="post" class="mb-4">
                <label for="student_id" class="block text-lg font-semibold">Enter Student ID:</label>
                <input type="text" name="student_id" id="student_id" class="border p-2 rounded-md" required>
                <button type="submit" name="search_student"
                    class="bg-blue-500 text-white px-4 py-2 rounded-md ml-2">Search</button>
            </form>

            <?php
            if (isset($_POST["search_student"])) {
                $student_id = trim($_POST["student_id"]);

                // Retrieve student information
                // You should replace 'your_db_connection' and 'student' with your actual database connection and table name.
                $student_query = "SELECT * FROM student WHERE student_id = '$student_id'";
                $student_result = $your_db_connection->query($student_query);

                if ($student_result->num_rows > 0) {
                    // Display the student information in a form for updating
                    $student_data = $student_result->fetch_assoc();
                    ?>
                    <form action="" method="post">
                        <input type="hidden" name="student_id" value="<?php echo $student_data['student_id']; ?>">
                        <label for="name" class="block text-lg font-semibold">Name:</label>
                        <input type="text" name="name" id="name" class="border p-2 rounded-md"
                            value="<?php echo $student_data['name']; ?>" required>

                        <label for="dob" class="block text-lg font-semibold">Date of Birth:</label>
                        <input type="date" name="dob" id="dob" class="border p-2 rounded-md"
                            value="<?php echo $student_data['dob']; ?>" required>

                        <label for="academic_program" class="block text-lg font-semibold">Academic Program:</label>
                        <input type="text" name="academic_program" id="academic_program" class="border p-2 rounded-md"
                            value="<?php echo $student_data['academic_program']; ?>" required>

                        <label for="advisor" class="block text-lg font-semibold">Academic Advisor:</label>
                        <input type="text" name="advisor" id="advisor" class="border p-2 rounded-md"
                            value="<?php echo $student_data['advisor']; ?>" required>

                        <button type="submit" name="update_student"
                            class="bg-green-500 text-white px-4 py-2 rounded-md mt-4">Update</button>
                    </form>
                    <?php
                } else {
                    echo "No records found for Student ID: $student_id.";
                }
            }

            if (isset($_POST["update_student"])) {
                $student_id = trim($_POST["student_id"]);
                $name = trim($_POST["name"]);
                $dob = trim($_POST["dob"]);
                $academic_program = trim($_POST["academic_program"]);
                $advisor = trim($_POST["advisor"]);

                // Update student information in the database
                // You should replace 'your_db_connection' and 'student' with your actual database connection and table name.
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

            <!-- Form for Updating Instructor Information -->
            <form action="" method="post" class="mb-4">
                <label for="instructor_id" class="block text-lg font-semibold">Instructor ID:</label>
                <input type="text" name="instructor_id" id="instructor_id" class="border p-2 rounded-md" required>

                <!-- Other fields to update instructor information -->
                <label for="name" class="block text-lg font-semibold">Name:</label>
                <input type="text" name="name" id="name" class="border p-2 rounded-md" required>

                <label for="department_id" class="block text-lg font-semibold">Department ID:</label>
                <input type="text" name="department_id" id="department_id" class="border p-2 rounded-md" required>

                <button type="submit" name="update_instructor"
                    class="bg-blue-500 text-white px-4 py-2 rounded-md mt-4">Update Instructor</button>
            </form>

            <?php
            // Database connection setup (Replace with your actual connection details)
            $servername = "your_server_name";
            $username = "your_username";
            $password = "your_password";
            $dbname = "your_database_name";

            $conn = new mysqli($servername, $username, $password, $dbname);

            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            if (isset($_POST["update_instructor"])) {
                // Get form input values
                $instructor_id = $_POST["instructor_id"];
                $name = $_POST["name"];
                $department_id = $_POST["department_id"];

                // Update instructor information in the database
                $update_query = "UPDATE instructor SET name = '$name', department_id = '$department_id' WHERE instructor_id = '$instructor_id'";
                if ($conn->query($update_query) === TRUE) {
                    echo "Instructor information updated successfully.";
                } else {
                    echo "Error updating instructor information: " . $conn->error;
                }
            }

            // Close the database connection
            $conn->close();
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
                echo '<ul class="list-disc pl-8">';
                while ($material_row = $material_result->fetch_assoc()) {
                    echo '<li>';
                    echo 'Material ID: ' . $material_row['material_id'] . '<br>';
                    echo 'Title: ' . $material_row['title'] . '<br>';
                    echo 'Format: ' . $material_row['format'] . '<br>';
                    echo 'Link: ' . $material_row['link'] . '<br>';
                    echo 'Course Code: ' . $material_row['course_code'] . '<br>';
                    echo 'Instructor ID: ' . $material_row['instructor_id'] . '<br>';
                    echo '</li>';
                }
                echo '</ul>';
            } else {
                echo 'No course materials found.';
            }
            ?>

            <!-- Form to update course materials -->
            <h3 class="text-xl font-semibold mt-8 mb-4">Update Course Material:</h3>
            <form action="" method="post">
                <label for="material_id" class="block text-lg font-semibold">Material ID:</label>
                <input type="text" name="material_id" id="material_id" class="border p-2 rounded-md" required>

                <!-- Other input fields for updating course materials (title, format, link, course_code, instructor_id) -->

                <button type="submit" name="update_material"
                    class="bg-blue-500 text-white px-4 py-2 rounded-md mt-2">Update Material</button>
            </form>

            <?php
            if (isset($_POST["update_material"])) {
                // Handle the update operation here
                $material_id = $_POST["material_id"];
                // Retrieve other form inputs (title, format, link, course_code, instructor_id)
            
                // Build and execute the SQL update query
                $update_query = "UPDATE course_material SET title = '...', format = '...', link = '...', course_code = '...', instructor_id = '...' WHERE material_id = '$material_id'";

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