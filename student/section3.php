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
        <button onclick="goBack()" class="bg-blue-500 text-white px-4 py-2 rounded-md">Go Back</button>
    </div>


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


    <?php
    // Close the database connection
    $conn->close();
    ?>
    <script>
        function goBack() {
            window.location.href = './index.php';
        }
    </script>
</body>

</html>