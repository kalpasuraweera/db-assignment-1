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



    <!-- Section: View and Update Student Information -->
    <section class="my-8">
        <h2 class="text-2xl font-semibold mb-4">View and Update Student Information</h2>
        <div class="border p-4 rounded-md">
            <?php
            // Display all rows of the student table
            $all_students_query = "SELECT * FROM student";
            $all_students_result = $conn->query($all_students_query);

            if ($all_students_result->num_rows > 0) {
                echo "<p class='text-lg font-semibold mb-4'><strong>All Students:</strong></p>";
                echo "<table class='table-auto border border-collapse border-gray-700'>";
                echo "<thead class='bg-gray-300'>";
                echo "<tr>";
                echo "<th class='px-4 py-2'>Student ID</th>";
                echo "<th class='px-4 py-2'>Name</th>";
                echo "<th class='px-4 py-2'>Date of Birth</th>";
                echo "<th class='px-4 py-2'>Academic Program</th>";
                echo "<th class='px-4 py-2'>Academic Advisor</th>";
                echo "</tr>";
                echo "</thead>";
                echo "<tbody>";

                while ($student_row = $all_students_result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td class='border px-4 py-2'>" . $student_row["student_id"] . "</td>";
                    echo "<td class='border px-4 py-2'>" . $student_row["name"] . "</td>";
                    echo "<td class='border px-4 py-2'>" . $student_row["dob"] . "</td>";
                    echo "<td class='border px-4 py-2'>" . $student_row["academic_program"] . "</td>";
                    echo "<td class='border px-4 py-2'>" . $student_row["advisor"] . "</td>";
                    echo "</tr>";
                }

                echo "</tbody>";
                echo "</table>";
            } else {
                echo "<p class='text-lg font-semibold mb-4'>No students found.</p>";
            }
            ?>

            <!-- Update Student Information Form -->
            <form action="" method="post" class="mb-4">
                <label for="student_id" class="block text-lg font-semibold mt-4">Enter Student ID for Update:</label>
                <input type="text" name="student_id" id="student_id" class="border p-2 rounded-md" required>

                <!-- Include necessary fields for updating -->
                <label for="name" class="block text-lg font-semibold mt-2">Name:</label>
                <input type="text" name="name" id="name" class="border p-2 rounded-md" required>

                <label for="dob" class="block text-lg font-semibold mt-2">Date of Birth:</label>
                <input type="date" name="dob" id="dob" class="border p-2 rounded-md" required>

                <label for="academic_program" class="block text-lg font-semibold mt-2">Academic Program:</label>
                <input type="text" name="academic_program" id="academic_program" class="border p-2 rounded-md" required>

                <label for="advisor" class="block text-lg font-semibold mt-2">Academic Advisor:</label>
                <input type="text" name="advisor" id="advisor" class="border p-2 rounded-md" required>

                <button type="submit" name="update_student"
                    class="bg-blue-500 text-white px-4 py-2 rounded-md mt-4">Update Student</button>
            </form>

            <?php
            // Handle student update
            if (isset($_POST["update_student"])) {
                $student_id = trim($_POST["student_id"]);
                $name = trim($_POST["name"]);
                $dob = trim($_POST["dob"]);
                $academic_program = mysqli_escape_string($conn, trim($_POST["academic_program"]));
                $advisor = trim($_POST["advisor"]);

                // Update student information in the database
                $update_query = "UPDATE student SET name = '$name', dob = '$dob', academic_program = '$academic_program', advisor = '$advisor' WHERE student_id = '$student_id'";
                if ($conn->query($update_query) === TRUE) {
                    echo "Student information updated successfully.";
                } else {
                    echo "Error updating student information: ";
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