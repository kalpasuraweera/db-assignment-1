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