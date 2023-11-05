<?php
function handleLogin($username, $password) {
    try {
        $conn = new mysqli('localhost', $username, $password, 'uni_course_db');
    
        if ($conn->connect_error) {
            return "Connection failed";
        }
        echo "Connected successfully";
        switch ($username) {
            case 'student':
                header('Location: student/student.php');
                exit();
    
            case 'admin':
                header('Location: admin/admin.php');
                exit();
    
            case 'instructor':
                header('Location: instructor/instructor.php');
                exit();
            default:
                header('Location: index.php');
                exit();
        }
    } catch (Exception $e) {
        return "Invalid username or password";
    }
}

?>