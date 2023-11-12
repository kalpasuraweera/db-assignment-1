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

  
    <!-- Section 4: Add Course Materials -->
    <section class="my-8">
        <h2 class="text-2xl font-semibold mb-4">Add Course Materials</h2>
        <div class="border p-4 rounded-md">
            <!-- Course Materials Form -->
            <form action="" method="post">
                <label for="material_title" class="block text-lg font-semibold">Material Title:</label>
                <input type="text" name="material_title" id="material_title" class="border p-2 rounded-md" required>

                <label for="material_format" class="block text-lg font-semibold mt-4">Material Format:</label>
                <input type="text" name="material_format" id="material_format" class="border p-2 rounded-md" required>

                <label for="material_link" class="block text-lg font-semibold mt-4">Material Link:</label>
                <input type="text" name="material_link" id="material_link" class="border p-2 rounded-md" required>

                <label for="course_code" class="block text-lg font-semibold mt-4">Course Code:</label>
                <input type="text" name="course_code" id="course_code" class="border p-2 rounded-md" required>

                <label for="instructor_id" class="block text-lg font-semibold mt-4">Instructor ID:</label>
                <input type="text" name="instructor_id" id="instructor_id" class="border p-2 rounded-md" required>

                <button type="submit" name="add_material" class="bg-blue-500 text-white px-4 py-2 rounded-md mt-4">Add
                    Material</button>
            </form>

            <?php
            if (isset($_POST["add_material"])) {
                $material_title = $_POST["material_title"];
                $material_format = $_POST["material_format"];
                $material_link = $_POST["material_link"];
                $course_code = $_POST["course_code"];
                $instructor_id = $_POST["instructor_id"];

                // Insert the course material into the database
                $query = "INSERT INTO course_material (title, format, link, course_code, instructor_id) VALUES ('$material_title', '$material_format', '$material_link', '$course_code', '$instructor_id')";
                $result = $conn->query($query);

                if ($result) {
                    echo "<p class='mt-4 text-green-500'>Course material added successfully.</p>";
                } else {
                    echo "<p class='mt-4 text-red-500'>Error adding course material: " . $conn->error . "</p>";
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