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

    <!-- Section: Access Digital Library of Course Materials -->
    <section class="my-8">
        <h2 class="text-2xl font-semibold mb-4">Access Digital Library of Course Materials</h2>
        <div class="border p-4 rounded-md">
            <!-- Display a list of existing materials -->
            <h3 class="text-xl font-semibold mb-4">List of Course Materials:</h3>

            <?php
            // Query to fetch existing course materials
            $material_query = "SELECT * FROM course_material";
            $material_result = $conn->query($material_query);

            if ($material_result->num_rows > 0) {
                echo "<table class='table-auto border border-collapse border-gray-700'>";
                echo "<thead class='bg-gray-300'>";
                echo "<tr>";
                echo "<th class='px-4 py-2'>Material ID</th>";
                echo "<th class='px-4 py-2'>Title</th>";
                echo "<th class='px-4 py-2'>Format</th>";
                echo "<th class='px-4 py-2'>Link</th>";
                echo "<th class='px-4 py-2'>Course Code</th>";
                echo "<th class='px-4 py-2'>Instructor ID</th>";
                echo "</tr>";
                echo "</thead>";
                echo "<tbody>";

                while ($material_row = $material_result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td class='border px-4 py-2'>" . $material_row["material_id"] . "</td>";
                    echo "<td class='border px-4 py-2'>" . $material_row["title"] . "</td>";
                    echo "<td class='border px-4 py-2'>" . $material_row["format"] . "</td>";
                    echo "<td class='border px-4 py-2'>" . $material_row["link"] . "</td>";
                    echo "<td class='border px-4 py-2'>" . $material_row["course_code"] . "</td>";
                    echo "<td class='border px-4 py-2'>" . $material_row["instructor_id"] . "</td>";
                    echo "</tr>";
                }

                echo "</tbody>";
                echo "</table>";
            } else {
                echo "<p class='text-lg font-semibold mb-4'>No course materials found.</p>";
            }
            ?>

            <!-- Form to update course materials -->
            <h3 class="text-xl font-semibold mt-8 mb-4">Update Course Material:</h3>
            <form action="" method="post">
                <label for="material_id" class="block text-lg font-semibold">Material ID:</label>
                <input type="text" name="material_id" id="material_id" class="border p-2 rounded-md" required>

                <!-- Include necessary fields for updating -->
                <label for="title" class="block text-lg font-semibold mt-2">Title:</label>
                <input type="text" name="title" id="title" class="border p-2 rounded-md" required>

                <label for="format" class="block text-lg font-semibold mt-2">Format:</label>
                <input type="text" name="format" id="format" class="border p-2 rounded-md" required>

                <label for="link" class="block text-lg font-semibold mt-2">Link:</label>
                <input type="text" name="link" id="link" class="border p-2 rounded-md" required>

                <label for="course_code" class="block text-lg font-semibold mt-2">Course Code:</label>
                <input type="text" name="course_code" id="course_code" class="border p-2 rounded-md" required>

                <label for="instructor_id" class="block text-lg font-semibold mt-2">Instructor ID:</label>
                <input type="text" name="instructor_id" id="instructor_id" class="border p-2 rounded-md" required>

                <button type="submit" name="update_material"
                    class="bg-blue-500 text-white px-4 py-2 rounded-md mt-2">Update Material</button>
            </form>

            <?php
            if (isset($_POST["update_material"])) {
                // Handle the update operation here
                $material_id = $_POST["material_id"];
                $title = $_POST["title"];
                $format = $_POST["format"];
                $link = $_POST["link"];
                $course_code = $_POST["course_code"];
                $instructor_id = $_POST["instructor_id"];

                // Build and execute the SQL update query
                $update_query = "UPDATE course_material SET title = '$title', format = '$format', link = '$link', course_code = '$course_code', instructor_id = '$instructor_id' WHERE material_id = '$material_id'";

                if ($conn->query($update_query) === TRUE) {
                    echo "Material updated successfully.";
                } else {
                    echo "Error updating material: " . $conn->error;
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