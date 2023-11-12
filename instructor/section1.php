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

    <!-- Section 1: View and Update Personal Info -->
    <section class="my-8">
        <h2 class="text-2xl font-semibold mb-4">View and Update Personal Info</h2>
        <div class="border p-4 rounded-md">
            <!-- Instructor Info Form -->
            <form action="" method="post" class="mb-4">
                <label for="instructor_id" class="block text-lg font-semibold">Instructor ID:</label>
                <input type="text" name="instructor_id" id="instructor_id" class="border p-2 rounded-md" required>

                <label for="name" class="block text-lg font-semibold mt-4">Name:</label>
                <input type="text" name="name" id="name" class="border p-2 rounded-md" required>

                <button type="submit" name="update_info" class="bg-blue-500 text-white px-4 py-2 rounded-md mt-4">Update
                    Info</button>
            </form>
            <?php

            if (isset($_POST["update_info"])) {
                // Get the instructor ID from the form submission
                $instructor_id = $_POST["instructor_id"];
                $name = $_POST["name"];

                // Update the instructor's personal information in the database
                $query = "UPDATE instructor SET name = '$name' WHERE instructor_id = '$instructor_id'";
                $result = $conn->query($query);

                if ($result) {
                    echo "Personal information updated successfully.";
                } else {
                    echo "Error updating personal information: " . $conn->error;
                }
            }

            // Display a table of all instructor details
            $query = "SELECT i.instructor_id, i.name, ic.contact, isu.subject, d.department_name 
            FROM instructor i 
            LEFT JOIN instructor_contact ic ON i.instructor_id = ic.instructor_id 
            LEFT JOIN instructor_subject isu ON i.instructor_id = isu.instructor_id 
            LEFT JOIN department d ON d.department_id = i.department_id";
            $result = $conn->query($query);

            if ($result && $result->num_rows > 0) {
                echo "<p class='text-lg font-semibold mb-4'><strong>Student Information:</strong></p>";
                echo "<table class='table-auto border border-collapse border-gray-700'>";
                echo "<thead class='bg-gray-300'>";
                echo "<tr>";
                echo "<th class='px-4 py-2'>Instructor ID</th>";
                echo "<th class='px-4 py-2'>Name</th>";
                echo "<th class='px-4 py-2'>Contact</th>";
                echo "<th class='px-4 py-2'>Subject</th>";
                echo "<th class='px-4 py-2'>Department</th>";
                echo "</tr>";
                echo "</thead>";
                echo "<tbody>";

                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td class='border px-4 py-2'>" . $row["instructor_id"] . "</td>";
                    echo "<td class='border px-4 py-2'>" . $row["name"] . "</td>";
                    echo "<td class='border px-4 py-2'>" . $row["contact"] . "</td>";
                    echo "<td class='border px-4 py-2'>" . $row["subject"] . "</td>";
                    echo "<td class='border px-4 py-2'>" . $row["department_name"] . "</td>";
                    echo "</tr>";
                }

                echo "</tbody>";
                echo "</table>";
            } else {
                echo "No instructor details available.";
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