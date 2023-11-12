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


    <!-- Section: Add Department -->
    <section class="my-8">
        <h2 class="text-2xl font-semibold mb-4">Add Department</h2>
        <div class="border p-4 rounded-md">
            <!-- Add Department Form -->
            <form action="" method="post" class="mb-4">
                <label for="department_id" class="block text-lg font-semibold">Department ID:</label>
                <input type="text" name="department_id" id="department_id" class="border p-2 rounded-md" required>

                <label for="department_name" class="block text-lg font-semibold mt-2">Department Name:</label>
                <input type="text" name="department_name" id="department_name" class="border p-2 rounded-md" required>

                <button type="submit" name="add_department" class="bg-blue-500 text-white px-4 py-2 rounded-md mt-4">Add
                    Department</button>
            </form>

            <?php
            if (isset($_POST["add_department"])) {
                // Handle the POST request to add a department
                $department_id = trim($_POST["department_id"]);
                $department_name = trim($_POST["department_name"]);

                // Insert the department data into your database
                // You need to replace these placeholders with your database logic
                $sql = "INSERT INTO department (department_id, department_name) 
                VALUES ('$department_id', '$department_name')";

                // Execute the SQL query
                $result = $conn->query($sql);

                if ($result) {
                    echo "<p class='mt-4 text-green-500'>Department added successfully.</p>";
                } else {
                    echo "<p class='mt-4 text-red-500'>Error adding department: " . $conn->error . "</p>";
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