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


    <!-- Section: Manage Course Co-requisites -->
    <section class="my-8">
        <h2 class="text-2xl font-semibold mb-4">Manage Course Co-requisites</h2>
        <div class="border p-4 rounded-md">

            <!-- Add Co-requisite Form -->
            <form action="" method="post" class="mb-4">
                <label for="course_code" class="block text-lg font-semibold">Enter Course Code:</label>
                <input type="text" name="course_code" id="course_code" class="border p-2 rounded-md" required>

                <label for="requested_course" class="block text-lg font-semibold">Enter Co-requisite Course
                    Code:</label>
                <input type="text" name="requested_course" id="requested_course" class="border p-2 rounded-md" required>

                <button type="submit" name="add_co_requisite"
                    class="bg-blue-500 text-white px-4 py-2 rounded-md ml-2">Add Co-requisite</button>
            </form>

            <?php
            // Handle the form submission
            if (isset($_POST["add_co_requisite"])) {
                $course_code = trim($_POST["course_code"]);
                $requested_course = trim($_POST["requested_course"]);

                // Insert the co-requisite into the database or update the existing record
                // Replace this with your actual database interaction code
                $sql = "INSERT INTO co_requisite (course_code, requested_course) 
                    VALUES ('$course_code', '$requested_course') 
                    ON DUPLICATE KEY UPDATE requested_course = VALUES(requested_course)";

                // Execute the SQL query (assuming you have a database connection)
                // $conn->query($sql);
            
                // Display a success message or handle errors
                // Replace this with appropriate success/error handling
                if ($conn->query($sql)) {
                    echo "<p class='mt-4 text-green-500'>Co-requisite added/updated successfully.</p>";
                } else {
                    echo "<p class='mt-4 text-red-500'>Error: " . $conn->error . "</p>";
                }
            }
            ?>

            <!-- Display Co-requisites Table -->
            <?php
            // Retrieve and display the co-requisites table
            // Replace this with your actual database retrieval code
            $co_requisites_query = "SELECT course_code, requested_course FROM co_requisite";
            $co_requisites_result = $conn->query($co_requisites_query);

            if ($co_requisites_result->num_rows > 0) {
                echo "<p class='text-lg font-semibold mb-4'><strong>Co-requisites:</strong></p>";
                echo "<table class='table-auto border border-collapse border-gray-700'>";
                echo "<thead class='bg-gray-300'>";
                echo "<tr>";
                echo "<th class='px-4 py-2'>Course Code</th>";
                echo "<th class='px-4 py-2'>Co-requisite Course Code</th>";
                echo "</tr>";
                echo "</thead>";
                echo "<tbody>";

                while ($row = $co_requisites_result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td class='border px-4 py-2'>" . $row["course_code"] . "</td>";
                    echo "<td class='border px-4 py-2'>" . $row["requested_course"] . "</td>";
                    echo "</tr>";
                }

                echo "</tbody>";
                echo "</table>";
            } else {
                echo "<p>No co-requisites found.</p>";
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