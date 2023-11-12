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



    <!-- Section: View and Update Instructor Information -->
    <section class="my-8">
        <h2 class="text-2xl font-semibold mb-4">View and Update Instructor Information</h2>
        <div class="border p-4 rounded-md">

            <?php
            // Display all rows of the instructor table
            $all_instructors_query = "SELECT * FROM instructor";
            $all_instructors_result = $conn->query($all_instructors_query);

            if ($all_instructors_result->num_rows > 0) {
                echo "<p class='text-lg font-semibold mb-4'><strong>All Instructors:</strong></p>";
                echo "<table class='table-auto border border-collapse border-gray-700'>";
                echo "<thead class='bg-gray-300'>";
                echo "<tr>";
                echo "<th class='px-4 py-2'>Instructor ID</th>";
                echo "<th class='px-4 py-2'>Name</th>";
                echo "<th class='px-4 py-2'>Department ID</th>";
                echo "</tr>";
                echo "</thead>";
                echo "<tbody>";

                while ($row = $all_instructors_result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td class='border px-4 py-2'>" . $row["instructor_id"] . "</td>";
                    echo "<td class='border px-4 py-2'>" . $row["name"] . "</td>";
                    echo "<td class='border px-4 py-2'>" . $row["department_id"] . "</td>";
                    echo "</tr>";
                }

                echo "</tbody>";
                echo "</table>";
            } else {
                echo "<p class='text-lg font-semibold mb-4'>No instructors found.</p>";
            }
            ?>

            <!-- Update Instructor Information Form -->
            <form action="" method="post" class="mb-4">
                <label for="instructor_id" class="block text-lg font-semibold mt-4">Enter Instructor ID for
                    Update:</label>
                <input type="text" name="instructor_id" id="instructor_id" class="border p-2 rounded-md" required>

                <!-- Include necessary fields for updating -->
                <label for="name" class="block text-lg font-semibold mt-2">Instructor Name:</label>
                <input type="text" name="name" id="name" class="border p-2 rounded-md" required>

                <label for="department_id" class="block text-lg font-semibold mt-2">Department ID:</label>
                <input type="text" name="department_id" id="department_id" class="border p-2 rounded-md" required>

                <button type="submit" name="update_instructor"
                    class="bg-blue-500 text-white px-4 py-2 rounded-md mt-2">Update Instructor</button>
            </form>

            <?php
            // Handle instructor update
            if (isset($_POST["update_instructor"])) {
                $name = trim($_POST["name"]);
                $department_id = trim($_POST["department_id"]);
                $instructor_id = trim($_POST["instructor_id"]);

                // Update instructor information in the database
                $update_query = "UPDATE instructor SET name = '$name', department_id = '$department_id' WHERE instructor_id = '$instructor_id'";
                if ($conn->query($update_query) === TRUE) {
                    echo "Instructor information updated successfully.";
                } else {
                    echo "Error updating instructor information: " . $conn->error;
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