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
        <button onclick="goBack()" class="bg-blue-500 text-white px-4 py-2 rounded-md">Go Back</button>
    </div>


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