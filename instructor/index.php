<?php
session_start();
require_once("../includes/db_connect.php");
require_once("../includes/logout.php");
if (isset($_POST["logout"])) {
    handleLogout();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>UniCourse Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100 p-4">

    <!-- Instructor Dashboard Header -->
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-3xl font-bold">Instructor Dashboard</h1>
        <form action="" method="post">
            <button type="submit" name="logout" class="bg-red-500 text-white px-4 py-2 rounded-md">Logout</button>
        </form>
    </div>

    <!-- Dashboard Tiles -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">
        <!-- Tile 1: View and Update Personal Info -->
        <div class="bg-gradient-to-r from-blue-500 to-blue-700 p-4 rounded-md shadow-md text-center cursor-pointer hover:shadow-lg transition-transform transform hover:scale-105"
            onclick="redirectTo('./section1.php')">
            <h2 class="text-xl font-semibold mb-2 text-white">View and Update Personal Info</h2>
            <!-- Add relevant content or link here -->
        </div>

        <!-- Tile 2: View Course Information -->
        <div class="bg-gradient-to-r from-blue-500 to-blue-700 p-4 rounded-md shadow-md text-center cursor-pointer hover:shadow-lg transition-transform transform hover:scale-105"
            onclick="redirectTo('./section2.php')">
            <h2 class="text-xl font-semibold mb-2 text-white">View Course Information</h2>
            <!-- Add relevant content or link here -->
        </div>

        <!-- Tile 3: View Teaching History -->
        <div class="bg-gradient-to-r from-blue-500 to-blue-700 p-4 rounded-md shadow-md text-center cursor-pointer hover:shadow-lg transition-transform transform hover:scale-105"
            onclick="redirectTo('./section3.php')">
            <h2 class="text-xl font-semibold mb-2 text-white">View Courses Taught by Instructor</h2>
            <!-- Add relevant content or link here -->
        </div>

        <!-- Tile 4: Assign Grades to Students in Courses -->
        <div class="bg-gradient-to-r from-blue-500 to-blue-700 p-4 rounded-md shadow-md text-center cursor-pointer hover:shadow-lg transition-transform transform hover:scale-105"
            onclick="redirectTo('./section4.php')">
            <h2 class="text-xl font-semibold mb-2 text-white">View Teaching History</h2>
            <!-- Add relevant content or link here -->
        </div>

        <!-- Tile 5: Add Course Materials -->
        <div class="bg-gradient-to-r from-blue-500 to-blue-700 p-4 rounded-md shadow-md text-center cursor-pointer hover:shadow-lg transition-transform transform hover:scale-105"
            onclick="redirectTo('./section5.php')">
            <h2 class="text-xl font-semibold mb-2 text-white">Assign Grades to Students in Courses</h2>
            <!-- Add relevant content or link here -->
        </div>

        <!-- Tile 6: Delete Course Material -->
        <div class="bg-gradient-to-r from-blue-500 to-blue-700 p-4 rounded-md shadow-md text-center cursor-pointer hover:shadow-lg transition-transform transform hover:scale-105"
            onclick="redirectTo('./section6.php')">
            <h2 class="text-xl font-semibold mb-2 text-white">Add Course Materials</h2>
            <!-- Add relevant content or link here -->
        </div>

        <!-- Tile 7: Access Course Materials -->
        <div class="bg-gradient-to-r from-blue-500 to-blue-700 p-4 rounded-md shadow-md text-center cursor-pointer hover:shadow-lg transition-transform transform hover:scale-105"
            onclick="redirectTo('./section7.php')">
            <h2 class="text-xl font-semibold mb-2 text-white">Delete Course Material</h2>
            <!-- Add relevant content or link here -->
        </div>

        <!-- Tile 7: Access Course Materials -->
        <div class="bg-gradient-to-r from-blue-500 to-blue-700 p-4 rounded-md shadow-md text-center cursor-pointer hover:shadow-lg transition-transform transform hover:scale-105"
            onclick="redirectTo('./section8.php')">
            <h2 class="text-xl font-semibold mb-2 text-white">Access Course Materials</h2>
            <!-- Add relevant content or link here -->
        </div>
    </div>

    <script>
        function redirectTo(url) {
            window.location.href = url;
        }
    </script>

    <?php
    // Close the database connection
    $conn->close();
    ?>
</body>

</html>