<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>School Management System</title>
    <link rel="stylesheet" href="/css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <style>
        /* Add your custom styles here */
        body {
            margin: 20px;
            padding-bottom: 50px;
            background-color: #f8f9fa;
            border: 2px solid #000;
            border-radius: 2rem;
        }

        .container {
            padding-top: 50px;
        }

        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        }

        .btn-register {
            background-color: #ffc107;
            color: #212529;
        }

        h3 {
            background-color: #5ce786;
            color: #000;
            border-radius: 2rem;
        }

        .btn-login,
        .btn-register {
            width: 150px;
            margin-top: 20px;
        }

        .vertical-line {
            border-left: 2px solid #000;
            height: 100%;
            margin: 0 15px;
        }

        .btn-switch {
            cursor: pointer;
        }

        /* Add styles for active tabs */
        .nav-tabs .nav-item {
            margin-bottom: 0;
        }
        .nav-tabs .nav-link{
            color: #000;
            font-weight: bold;
        }

        .nav-tabs .nav-link.active {
            background-color: #000;
            color: #fff;
            border: 1px solid #000;
            border-radius: 2rem 2rem 0 0;
        }
    </style>
</head>

<body>


    <div class="container">
        <div class="row">
            <div class="col-md-6 mb-5 d-flex justify-content-center align-items-center">
                <!-- Registration Form -->
                <div id="registrationForm" class="card p-5">
                    <h3 class="text-center font-weight-bold text-uppercase mb-3">SIGN UP</h3>
                    <form id="userRegistrationForm" method="post" action="process.php">
                        <div class="form-group">
                            <label>Enter Name</label>
                            <input type="text" class="form-control" name="name" required>
                        </div>
                        <div class="form-group">
                            <label>Enter Email</label>
                            <input type="email" class="form-control" name="email" required>
                        </div>
                        <div class="form-group">
                            <label>Enter Father's Name</label>
                            <input type="text" class="form-control" name="father_name" required>
                        </div>
                        <div class="form-group">
                            <label>Class</label>
                            <div class="input-group">
                                <select class="form-select" name="class">
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>
                                    <option value="6">6</option>
                                    <option value="7">7</option>
                                    <option value="8">8</option>
                                    <option value="9">9</option>
                                    <option value="10">10</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Enter Password</label>
                            <input type="password" class="form-control" name="password" required>
                        </div>
                        <div class="form-group">
                            <label>Confirm Password</label>
                            <input type="password" class="form-control" name="confirm_password" required>
                        </div>
                        <button type="submit" class="btn btn-warning rounded-pill btn-register">Register</button>
                    </form>
                </div>
            </div>
            <!-- Add the vertical line here -->
            <div class="col-md-1 d-flex align-items-center">
                <div class="vertical-line"></div>
            </div>
            <div class="col-md-5 mb-5 d-flex justify-content-center align-items-center">
                <!-- Login Form -->
                <div id="loginForm" class="card p-5">
                    <h3 class="text-center font-weight-bold text-uppercase mb-3">Login Here</h3>
                    <!-- Tabs for switching forms -->
                    <ul class="nav nav-tabs">
                        <li class="nav-item">
                            <a class="nav-link active" id="studentTab" onclick="showStudentLogin()">Student Login</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="adminTab" onclick="showAdminLogin()">Admin Login</a>
                        </li>
                    </ul>
                    <form id="studentLoginForm" method="post" action="process.php">
                        <div class="form-group">
                            <label>Enter Student Email</label>
                            <input type="text" class="form-control" name="student_email">
                        </div>
                        <div class="form-group">
                            <label>Enter Student Password</label>
                            <input type="password" class="form-control" name="student_password">
                        </div>
                        <button type="submit" class="btn btn-info rounded-pill btn-login">Login</button>
                    </form>

                    <form id="adminLoginForm" class="d-none" method="post" action="process.php">
                        <div class="form-group">
                            <label>Enter Admin Email</label>
                            <input type="text" class="form-control" name="admin_email">
                        </div>
                        <div class="form-group">
                            <label>Enter Admin Password</label>
                            <input type="password" class="form-control" name="admin_password">
                        </div>
                        <button type="submit" class="btn btn-success rounded-pill btn-login">Login</button>
                    </form>
                </div>

                <script>
                    function showStudentLogin() {
                        document.getElementById("adminLoginForm").classList.add("d-none");
                        document.getElementById("studentLoginForm").classList.remove("d-none");

                        // Update active tab
                        document.getElementById("studentTab").classList.add("active");
                        document.getElementById("adminTab").classList.remove("active");
                    }

                    function showAdminLogin() {
                        document.getElementById("studentLoginForm").classList.add("d-none");
                        document.getElementById("adminLoginForm").classList.remove("d-none");

                        // Update active tab
                        document.getElementById("adminTab").classList.add("active");
                        document.getElementById("studentTab").classList.remove("active");
                    }
                </script>
            </div>

        </div>
    </div>
</body>

</html>