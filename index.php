<!DOCTYPE html>
<html>

<head>
    <title>UniCourse</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-200 p-6">
    <?php
    session_start();
    require_once("includes/login.php");
    if (isset($_SESSION['username']) && isset($_SESSION['password'])) {
        $response = handleLogin($_SESSION['username'], $_SESSION['password']);
    }

    ?>

    <div class="flex flex-col justify-center items-center min-h-screen">
        <h1 class="text-3xl font-bold mb-4">UniCourse College Management System</h1>
        <p class="mb-4">Enter your username and password to log in to the system</p>
        <div class="bg-white p-6 rounded shadow-md w-1/3 flex flex-col justify-center items-center">
            <h2 class="text-3xl font-bold mb-4">User Log In</h2>
            <form action="" method="post" class="space-y-4">
                <input type="text" name="username" placeholder="Enter username"
                    class="w-full p-2 border border-gray-300 rounded">
                <input type="password" name="password" placeholder="Enter password"
                    class="w-full p-2 border border-gray-300 rounded">
                <p class="mb-4 text-red-600">
                    <?php
                    if (isset($_POST['submit'])) {
                        $username = $_POST['username'];
                        $password = $_POST['password'];
                        $_SESSION['username'] = $username;
                        $_SESSION['password'] = $password;
                        $response = handleLogin($username, $password);
                        if ($response) {
                            echo $response;
                        }
                    }
                    ?>
                </p>
                <input type="submit" name="submit" value="Login"
                    class="w-full p-2 bg-blue-500 text-white rounded hover:bg-blue-600">
            </form>
        </div>
    </div>



</body>

</html>