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