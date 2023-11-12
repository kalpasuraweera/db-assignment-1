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

    <!-- Student Dashboard Header -->
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-3xl font-bold">Student Dashboard</h1>
        <form action="" method="post">
            <button type="submit" name="logout" class="bg-red-500 text-white px-4 py-2 rounded-md">Logout</button>
        </form>
    </div>

    <!-- Dashboard Tiles -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">
        <!-- Tile 1: View Course Information -->
        <div class="bg-gradient-to-r from-blue-500 to-blue-700 p-4 rounded-md shadow-md text-center cursor-pointer hover:shadow-lg transition-transform transform hover:scale-105"
            onclick="redirectTo('./section1.php')">
            <h2 class="text-xl font-semibold mb-2 text-white">View Course Information</h2>
            <!-- Add relevant content or link here -->
        </div>

        <!-- Tile 2: View Semester Details and Courses -->
        <div class="bg-gradient-to-r from-blue-500 to-blue-700 p-4 rounded-md shadow-md text-center cursor-pointer hover:shadow-lg transition-transform transform hover:scale-105"
            onclick="redirectTo('./section2.php')">
            <h2 class="text-xl font-semibold mb-2 text-white">View Semester Details</h2>
            <!-- Add relevant content or link here -->
        </div>

        <!-- Tile 3: Enroll in Courses -->
        <div class="bg-gradient-to-r from-blue-500 to-blue-700 p-4 rounded-md shadow-md text-center cursor-pointer hover:shadow-lg transition-transform transform hover:scale-105"
            onclick="redirectTo('./section3.php')">
            <h2 class="text-xl font-semibold mb-2 text-white">Enroll in Courses</h2>
            <!-- Add relevant content or link here -->
        </div>

        <!-- Tile 4: Check Enrollment Status -->
        <div class="bg-gradient-to-r from-blue-500 to-blue-700 p-4 rounded-md shadow-md text-center cursor-pointer hover:shadow-lg transition-transform transform hover:scale-105"
            onclick="redirectTo('./section4.php')">
            <h2 class="text-xl font-semibold mb-2 text-white">Check Enrollment Status</h2>
            <!-- Add relevant content or link here -->
        </div>

        <!-- Tile 5: View Personal Student Information -->
        <div class="bg-gradient-to-r from-blue-500 to-blue-700 p-4 rounded-md shadow-md text-center cursor-pointer hover:shadow-lg transition-transform transform hover:scale-105"
            onclick="redirectTo('./section5.php')">
            <h2 class="text-xl font-semibold mb-2 text-white">View Personal Student Information</h2>
            <!-- Add relevant content or link here -->
        </div>

        <!-- Tile 6: View Grades and GPA -->
        <div class="bg-gradient-to-r from-blue-500 to-blue-700 p-4 rounded-md shadow-md text-center cursor-pointer hover:shadow-lg transition-transform transform hover:scale-105"
            onclick="redirectTo('./section6.php')">
            <h2 class="text-xl font-semibold mb-2 text-white">View Grades and GPA</h2>
            <!-- Add relevant content or link here -->
        </div>

        <!-- Tile 7: Access Course Materials -->
        <div class="bg-gradient-to-r from-blue-500 to-blue-700 p-4 rounded-md shadow-md text-center cursor-pointer hover:shadow-lg transition-transform transform hover:scale-105"
            onclick="redirectTo('./section7.php')">
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