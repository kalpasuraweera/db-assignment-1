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
        <button onclick="goBack()" class="bg-blue-500 text-white px-4 py-2 rounded-md">Go Back</button>
    </div>


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