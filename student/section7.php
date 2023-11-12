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


    <!-- Section 6: Access Course Materials -->
    <section class="my-8">
        <h2 class="text-2xl font-semibold mb-4">Access Course Materials</h2>
        <div class="border p-4 rounded-md">
            <?php
            // Define the SQL query to join tables and retrieve course materials with course name and instructor name
            $course_material_query = "SELECT cm.material_id, cm.title, cm.format, cm.link, c.title AS course_name, i.name AS instructor_name
            FROM course_material cm
            INNER JOIN course c ON cm.course_code = c.course_code
            INNER JOIN instructor i ON cm.instructor_id = i.instructor_id";

            $course_material_result = $conn->query($course_material_query);

            if ($course_material_result->num_rows > 0) {
                echo "<p class='text-lg font-semibold mb-4'><strong>Course Materials:</strong></p>";
                echo "<table class='table-auto border border-collapse border-gray-700'>";
                echo "<thead class='bg-gray-300'>";
                echo "<tr>";
                echo "<th class='px-4 py-2'>Material ID</th>";
                echo "<th class='px-4 py-2'>Title</th>";
                echo "<th class='px-4 py-2'>Format</th>";
                echo "<th class='px-4 py-2'>Link</th>";
                echo "<th class='px-4 py-2'>Course Name</th>";
                echo "<th class='px-4 py-2'>Instructor Name</th>";
                echo "</tr>";
                echo "</thead>";
                echo "<tbody>";

                while ($row = $course_material_result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td class='border px-4 py-2'>" . $row["material_id"] . "</td>";
                    echo "<td class='border px-4 py-2'>" . $row["title"] . "</td>";
                    echo "<td class='border px-4 py-2'>" . $row["format"] . "</td>";
                    echo "<td class='border px-4 py-2 text-red-800'><a href='" . $row["link"] . "'>Download</a></td>";
                    echo "<td class='border px-4 py-2'>" . $row["course_name"] . "</td>";
                    echo "<td class='border px-4 py-2'>" . $row["instructor_name"] . "</td>";
                    echo "</tr>";
                }

                echo "</tbody>";
                echo "</table>";
            } else {
                echo "No course materials found.";
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