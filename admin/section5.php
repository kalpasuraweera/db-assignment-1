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


    <!-- Section: Manage Course Prerequisites -->
    <section class="my-8">
        <h2 class="text-2xl font-semibold mb-4">Manage Course Prerequisites</h2>
        <div class="border p-4 rounded-md">

            <!-- Form to Add Prerequisites -->
            <form action="" method="post" class="mb-4">
                <label for="course_code" class="block text-lg font-semibold">Enter Course Code:</label>
                <input type="text" name="course_code" id="course_code" class="border p-2 rounded-md" required>

                <label for="requested_course" class="block text-lg font-semibold mt-2">Enter Prerequisite Course
                    Code:</label>
                <input type="text" name="requested_course" id="requested_course" class="border p-2 rounded-md" required>

                <button type="submit" name="add_prerequisite"
                    class="bg-blue-500 text-white px-4 py-2 rounded-md mt-2">Add Prerequisite</button>
            </form>

            <?php
            if (isset($_POST["add_prerequisite"])) {
                $course_code = trim($_POST["course_code"]);
                $requested_course = trim($_POST["requested_course"]);

                // Insert the prerequisite into the database
                $insert_query = "INSERT INTO prerequisite (course_code, requested_course) VALUES ('$course_code', '$requested_course')";
                if ($conn->query($insert_query) === TRUE) {
                    echo "Prerequisite added successfully.";
                } else {
                    echo "Error: " . $conn->error;
                }
            }
            ?>

            <!-- Table to Display Existing Prerequisites -->
            <?php
            $prerequisite_query = "SELECT * FROM prerequisite";
            $prerequisite_result = $conn->query($prerequisite_query);

            if ($prerequisite_result->num_rows > 0) {
                echo "<p class='text-lg font-semibold mb-2'><strong>Prerequisites:</strong></p>";
                echo "<table class='table-auto border border-collapse border-gray-700'>";
                echo "<thead class='bg-gray-300'>";
                echo "<tr>";
                echo "<th class='px-4 py-2 border'>Course Code</th>";
                echo "<th class='px-4 py-2 border'>Requested Course</th>";
                echo "</tr>";
                echo "</thead>";
                echo "<tbody>";

                while ($row = $prerequisite_result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td class='px-4 py-2 border'>" . $row["course_code"] . "</td>";
                    echo "<td class='px-4 py-2 border'>" . $row["requested_course"] . "</td>";
                    echo "</tr>";
                }

                echo "</tbody>";
                echo "</table>";
            } else {
                echo "<p class='mt-4'>No prerequisites.</p>";
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