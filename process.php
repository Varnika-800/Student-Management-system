<?php
session_start();

include('includes/config.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Logic for Registration Form
    if (isset($_POST["name"]) && isset($_POST["email"]) && isset($_POST["father_name"]) && isset($_POST["class"]) && isset($_POST["password"]) && isset($_POST["confirm_password"])) {
        $name = $_POST["name"];
        $email = $_POST["email"];
        $father_name = $_POST["father_name"];
        $class = $_POST["class"];
        $password = $_POST["password"];
        $confirm_password = $_POST["confirm_password"];

        if ($password === $confirm_password) {
            // Passwords match, proceed with registration
            $registration_year = date("Y"); // Get the current year

            // Hash the password
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            // Use prepared statements to prevent SQL injection
            $stmt = $conn->prepare("INSERT INTO students (name, email, father_name, class, registration_year, password) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("sssiis", $name, $email, $father_name, $class, $registration_year, $hashedPassword);

            if ($stmt->execute()) {
                echo "Student registered successfully!! Please Login To Proceed";
            } else {
                // Provide a more user-friendly error message
                if ($stmt->errno == 1062) {
                    echo "Email already registered. Please use a different email.";
                } else {
                    echo "Error: " . $stmt->error;
                }
            }

            $stmt->close();
        } else {
            echo "Passwords do not match";
        }
    }

    // Logic for Student Login Form
    elseif (isset($_POST["student_email"]) && isset($_POST["student_password"])) {
        $studentEmail = $_POST["student_email"];
        $studentPassword = $_POST["student_password"];

        // Use prepared statements to prevent SQL injection
        $studentStmt = $conn->prepare("SELECT * FROM students WHERE email = ?");
        $studentStmt->bind_param("s", $studentEmail);

        $studentStmt->execute();
        $studentResult = $studentStmt->get_result();

        if ($studentResult->num_rows > 0) {
            // Student email found, now verify the password
            $studentData = $studentResult->fetch_assoc();
            if (password_verify($studentPassword, $studentData['password'])) {
                // Set session variables
                $_SESSION["user_id"] = $studentData['id'];
                $_SESSION["user_name"] = $studentData['name'];
                $_SESSION["user_email"] = $studentData['email'];
                $_SESSION["user_father_name"] = $studentData['father_name'];
                $_SESSION["user_class"] = $studentData['class'];

                // Redirect to user.php
                header("Location: user.php");
                exit();
            } else {
                echo "Invalid student password";
            }

            $studentStmt->close();
        }
    }

    // Logic for Admin Login Form
    elseif (isset($_POST["admin_email"]) && isset($_POST["admin_password"])) {
        $adminEmail = $_POST["admin_email"];
        $adminPassword = $_POST["admin_password"];

        // Use prepared statements to prevent SQL injection
        $adminStmt = $conn->prepare("SELECT * FROM admin WHERE email = ? AND password = ?");
        $adminStmt->bind_param("ss", $adminEmail, $adminPassword);

        $adminStmt->execute();
        $adminResult = $adminStmt->get_result();

        if ($adminResult->num_rows > 0) {
            // Admin email and password combination found
            $adminData = $adminResult->fetch_assoc();

            // Set session variables for admin
            $_SESSION["admin_id"] = $adminData['id'];
            $_SESSION["admin_name"] = $adminData['name'];
            $_SESSION["admin_email"] = $adminData['email'];

            // Redirect to admin.php
            header("Location: admin.php");
            exit();
        } else {
            echo "Invalid admin Email or password";
        }

        $adminStmt->close();
    } else {
        echo "Invalid parameters or Not Registered Yet";
    }
}

$conn->close();
