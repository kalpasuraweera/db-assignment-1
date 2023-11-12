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

    <?php
    // Close the database connection
    $conn->close();
    ?>
    <script>
        function goBack() {
            window.history.back();
        }
    </script>
</body>

</html>