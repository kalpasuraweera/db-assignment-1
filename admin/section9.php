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