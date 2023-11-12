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


    <!-- Section: Check Enrollment Status -->
    <section class="my-8">
        <h2 class="text-2xl font-semibold mb-4">Check Enrollment Status</h2>
        <div class="border p-4 rounded-md">

            <!-- Search Form for Enrollment Status -->
            <form action="" method="post" class="mb-4">
                <label for="search_student_id" class="block text-lg font-semibold">Student ID:</label>
                <input type="text" name="search_student_id" id="search_student_id" class="border p-2 rounded-md">
                <label for="search_course_code" class="block text-lg font-semibold">Course Code:</label>
                <input type="text" name="search_course_code" id="search_course_code" class="border p-2 rounded-md">
                <label for="search_semester_id" class="block text-lg font-semibold">Semester ID:</label>
                <input type="text" name="search_semester_id" id="search_semester_id" class="border p-2 rounded-md">
                <button type="submit" name="check_enrollment"
                    class="bg-blue-500 text-white px-4 py-2 rounded-md ml-2">Check Status</button>
            </form>

            <?php
            if (isset($_POST["check_enrollment"])) {
                $search_student_id = $_POST["search_student_id"];
                $search_course_code = $_POST["search_course_code"];
                $search_semester_id = $_POST["search_semester_id"];

                // Construct the query to check enrollment status
                $enrollment_status_query = "SELECT * FROM enroll
                WHERE student_id = '$search_student_id'
                OR course_code = '$search_course_code'
                OR semester_id = '$search_semester_id'";

                $enrollment_status_result = $conn->query($enrollment_status_query);

                if ($enrollment_status_result->num_rows > 0) {
                    echo "<p class='text-lg font-semibold mb-4'><strong>Enrollment Status:</strong></p>";
                    echo "<table class='table-auto border border-collapse border-gray-700'>";
                    echo "<thead class='bg-gray-300'>";
                    echo "<tr>";
                    echo "<th class='px-4 py-2'>Student ID</th>";
                    echo "<th class='px-4 py-2'>Course Code</th>";
                    echo "<th class='px-4 py-2'>Semester ID</th>";
                    echo "<th class='px-4 py-2'>Enrollment Status</th>";
                    echo "</tr>";
                    echo "</thead>";
                    echo "<tbody>";

                    while ($row = $enrollment_status_result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td class='border px-4 py-2'>" . $row["student_id"] . "</td>";
                        echo "<td class='border px-4 py-2'>" . $row["course_code"] . "</td>";
                        echo "<td class='border px-4 py-2'>" . $row["semester_id"] . "</td>";
                        echo "<td class='border px-4 py-2'>" . $row["enrollment_status"] . "</td>";
                        echo "</tr>";
                    }

                    echo "</tbody>";
                    echo "</table>";
                } else {
                    echo "No records found for the specified criteria.";
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