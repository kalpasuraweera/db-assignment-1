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


    <!-- Section 2: Assign Grades to Students in Courses -->
    <section class="my-8">
        <h2 class="text-2xl font-semibold mb-4">Assign Grades to Students in Courses</h2>
        <div class="border p-4 rounded-md">
            <!-- Grade Assignment Form -->
            <form action="" method="post">
                <label for="student_id" class="block text-lg font-semibold">Student ID:</label>
                <input type="text" name="student_id" id="student_id" class="border p-2 rounded-md" required>

                <label for="course_code" class="block text-lg font-semibold mt-4">Course Code:</label>
                <input type="text" name="course_code" id="course_code" class="border p-2 rounded-md" required>

                <label for="grade" class="block text-lg font-semibold mt-4">Grade:</label>
                <input type="text" name="grade" id="grade" class="border p-2 rounded-md" required>

                <label for="instructor_id" class="block text-lg font-semibold">Instructor ID:</label>
                <input type="text" name="instructor_id" id="instructor_id" class="border p-2 rounded-md" required>

                <button type="submit" name="assign_grade"
                    class="bg-blue-500 text-white px-4 py-2 rounded-md mt-4">Assign Grade</button>
            </form>

            <?php
            if (isset($_POST["assign_grade"])) {
                $student_id = $_POST["student_id"];
                $course_code = $_POST["course_code"];
                $grade_value = $_POST["grade"];
                $instructor_id = $_POST["instructor_id"];

                // Insert the grade into the database
                $query = "INSERT INTO grade (student_id, course_code, instructor_id, grade_value, date) 
                VALUES ('$student_id', '$course_code', '$instructor_id', '$grade_value', NOW())";
                $result = $conn->query($query);

                if ($result) {
                    echo "<p class='mt-4 text-green-500'>Grade assigned successfully.</p>";
                } else {
                    echo "<p class='mt-4 text-red-500'>Error assigning grade: " . $conn->error . "</p>";
                }
            }
            ?>

            <p class='text-lg font-semibold mb-4'><strong>Available Grades:</strong></p>
            <table class="table-auto border border-collapse border-gray-700 mt-2">
                <thead class="bg-gray-300">
                    <tr>
                        <th class="px-4 py-2">Student ID</th>
                        <th class="px-4 py-2">Course Code</th>
                        <th class="px-4 py-2">Instructor ID</th>
                        <th class="px-4 py-2">Grade Value</th>
                        <th class="px-4 py-2">Date</th>
                        <!-- You can add more columns here as needed -->
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Retrieve and display all available grades
                    $query = "SELECT * FROM grade";
                    $result = $conn->query($query);

                    if ($result && $result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td class='border px-4 py-2'>" . $row['student_id'] . "</td>";
                            echo "<td class='border px-4 py-2'>" . $row['course_code'] . "</td>";
                            echo "<td class='border px-4 py-2'>" . $row['instructor_id'] . "</td>";
                            echo "<td class='border px-4 py-2'>" . $row['grade_value'] . "</td>";
                            echo "<td class='border px-4 py-2'>" . $row['date'] . "</td>";
                            // You can add more cells for additional columns here
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td class='border px-4 py-2' colspan='5'>No grades available.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>

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