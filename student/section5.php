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


    <!-- Section 4: View personal student information -->
    <section class="my-8">
        <h2 class="text-2xl font-semibold mb-4">View Personal Student Information</h2>
        <div class="border p-4 rounded-md">

            <!-- Search Form -->
            <form action="" method="post" class="mb-4">
                <label for="student_id" class="block text-lg font-semibold">Enter Student ID:</label>
                <input type="text" name="student_id" id="student_id" class="border p-2 rounded-md" required>
                <button type="submit" name="search_student"
                    class="bg-blue-500 text-white px-4 py-2 rounded-md ml-2">Search</button>
            </form>

            <?php
            // Define the query to select a student by student_id
            $query = "SELECT * FROM student";

            if (isset($_POST["search_student"])) {
                $student_id = trim($_POST["student_id"]);
                $query = "SELECT * FROM student WHERE student_id = '$student_id'";
            }
            $result = $conn->query($query);

            if ($result) {
                if ($result->num_rows > 0) {
                    echo "<p class='text-lg font-semibold mb-4'><strong>Student Information:</strong></p>";
                    echo "<table class='table-auto border border-collapse border-gray-700'>";
                    echo "<thead class='bg-gray-300'>";
                    echo "<tr>";
                    echo "<th class='px-4 py-2'>Student ID</th>";
                    echo "<th class='px-4 py-2'>Name</th>";
                    echo "<th class='px-4 py-2'>Date of Birth</th>";
                    echo "<th class='px-4 py-2'>Academic Program</th>";
                    echo "<th class='px-4 py-2'>Advisor</th>";
                    echo "</tr>";
                    echo "</thead>";
                    echo "<tbody>";

                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td class='border px-4 py-2'>" . $row["student_id"] . "</td>";
                        echo "<td class='border px-4 py-2'>" . $row["name"] . "</td>";
                        echo "<td class='border px-4 py-2'>" . $row["dob"] . "</td>";
                        echo "<td class='border px-4 py-2'>" . $row["academic_program"] . "</td>";
                        echo "<td class='border px-4 py-2'>" . $row["advisor"] . "</td>";
                        echo "</tr>";
                    }

                    echo "</tbody>";
                    echo "</table>";
                } else {
                    echo "No records found for student ID: $student_id.";
                }
            } else {
                echo "Error: " . $conn->error;
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