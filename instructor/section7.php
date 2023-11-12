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


    <!-- Section 5: Delete Course Material -->
    <section class="my-8">
        <h2 class="text-2xl font-semibold mb-4">Delete Course Material</h2>
        <div class="border p-4 rounded-md">
            <!-- Course Material Deletion Form -->
            <form action="" method="post">
                <label for="material_id" class="block text-lg font-semibold">Material ID:</label>
                <input type="text" name="material_id" id="material_id" class="border p-2 rounded-md" required>

                <button type="submit" name="delete_material"
                    class="bg-red-500 text-white px-4 py-2 rounded-md mt-4">Delete Material</button>
            </form>

            <?php
            if (isset($_POST["delete_material"])) {
                $material_id = $_POST["material_id"];

                // Delete the course material from the database
                $query = "DELETE FROM course_material WHERE material_id = '$material_id'";
                $result = $conn->query($query);

                if ($result) {
                    echo "<p class='mt-4 text-green-500'>Course material deleted successfully.</p>";
                } else {
                    echo "<p class='mt-4 text-red-500'>Error deleting course material: " . $conn->error . "</p>";
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