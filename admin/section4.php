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


    <!-- Section: Add Student -->
    <section class="my-8">
        <h2 class="text-2xl font-semibold mb-4">Add Student</h2>
        <div class="border p-4 rounded-md">
            <!-- Add Student Form -->
            <form action="" method="post" class="mb-4">
                <label for="student_id" class="block text-lg font-semibold">Student ID:</label>
                <input type="text" name="student_id" id="student_id" class="border p-2 rounded-md" required>

                <label for="name" class="block text-lg font-semibold mt-2">Name:</label>
                <input type="text" name="name" id="name" class="border p-2 rounded-md" required>

                <label for="dob" class="block text-lg font-semibold mt-2">Date of Birth:</label>
                <input type="date" name="dob" id="dob" class="border p-2 rounded-md" required>

                <label for="academic_program" class="block text-lg font-semibold mt-2">Academic Program:</label>
                <input type="text" name="academic_program" id="academic_program" class="border p-2 rounded-md" required>

                <label for="advisor" class="block text-lg font-semibold mt-2">Advisor:</label>
                <input type="text" name="advisor" id="advisor" class="border p-2 rounded-md" required>

                <button type="submit" name="add_student" class="bg-blue-500 text-white px-4 py-2 rounded-md mt-4">Add
                    Student</button>
            </form>

            <?php
            if (isset($_POST["add_student"])) {
                // Handle the POST request to add a student
                $student_id = trim($_POST["student_id"]);
                $name = trim($_POST["name"]);
                $dob = trim($_POST["dob"]);
                $academic_program = mysqli_escape_string($conn, trim($_POST["academic_program"]));
                $advisor = trim($_POST["advisor"]);

                // Insert the student data into your database
                // You need to replace these placeholders with your database logic
                $sql = "INSERT INTO student (student_id, `name`, dob, academic_program, advisor) 
                VALUES ('$student_id', '$name', '$dob', '$academic_program', '$advisor')";

                // Execute the SQL query
                $result = $conn->query($sql);

                if ($result) {
                    echo "<p class='mt-4 text-green-500'>Student added successfully.</p>";
                } else {
                    echo "<p class='mt-4 text-red-500'>Error adding student: " . $conn->error . "</p>";
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