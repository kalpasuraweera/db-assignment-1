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