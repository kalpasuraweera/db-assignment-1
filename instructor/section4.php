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



    <!-- Section 3: View Teaching History -->
    <section class="my-8">
        <h2 class="text-2xl font-semibold mb-4">View Teaching History</h2>
        <div class="border p-4 rounded-md">
            <!-- Instructor ID Form -->
            <form action="" method="post" class="mb-4">
                <label for="instructor_id" class="block text-lg font-semibold">Instructor ID:</label>
                <input type="text" name="instructor_id" id="instructor_id" class="border p-2 rounded-md" required>
                <button type="submit" name="view_history" class="bg-blue-500 text-white px-4 py-2 rounded-md mt-4">View
                    History</button>
            </form>

            <?php
            if (isset($_POST["view_history"])) {
                // Get the instructor ID from the form submission
                $instructor_id = $_POST["instructor_id"];

                // Retrieve teaching history with course names from the database based on the provided instructor ID
                $query = "SELECT t.*, c.title AS course_name
                      FROM teaching t
                      JOIN course c ON t.course_code = c.course_code
                      WHERE t.instructor_id = '$instructor_id'";
                $result = $conn->query($query);

                if ($result && $result->num_rows > 0) {
                    echo "<p class='text-lg font-semibold mb-4'><strong>Teaching History:</strong></p>";
                    echo "<table class='table-auto border border-collapse border-gray-700'>";
                    echo "<thead class='bg-gray-300'>";
                    echo "<tr>";
                    echo "<th class='px-4 py-2'>Course Code</th>";
                    echo "<th class='px-4 py-2'>Course Name</th>";
                    echo "<th class='px-4 py-2'>Teaching Semester</th>";
                    echo "</tr>";
                    echo "</thead>";
                    echo "<tbody>";

                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td class='border px-4 py-2'>" . $row['course_code'] . "</td>";
                        echo "<td class='border px-4 py-2'>" . $row['course_name'] . "</td>";
                        echo "<td class='border px-4 py-2'>" . $row['semester_id'] . "</td>";
                        echo "</tr>";
                    }

                    echo "</tbody>";
                    echo "</table>";
                } else {
                    echo "No teaching history available for instructor ID: $instructor_id";
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