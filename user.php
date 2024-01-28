<?php
session_start();

include('includes/config.php');

// Check if the user is logged in, otherwise redirect to the login page
if (!isset($_SESSION["user_id"])) {
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    <link rel="stylesheet" href="/css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <style>
        /* Global Styles */

        body {
            margin: 20px;
            padding-bottom: 50px;
            background-color: #f8f9fa;
            border: 1px solid #000;
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

        .btn-logout {
            width: 150px;
            margin-top: 20px;
        }

        h3 {
            background-color: #5ce786;
            color: #000;
            border-radius: 2rem;
        }

        /* Responsive Styles for Small Screens (up to 576px) */

        @media (max-width: 576px) {
            .container {
                padding-top: 20px;
            }

            .card {
                margin-top: 20px;
            }

            .btn-logout {
                width: 100%;
            }

            h3 {
                max-width: 100%;
                font-size: 17px;
            }
        }
    </style>
</head>

<body>

    <div class="container">
        <div class="row justify-content-center align-items-center">
            <div class="col-md-6 mb-5">
                <!-- User Dashboard -->
                <div id="userDashboard" class="card p-5">
                    <h3 class="text-center font-weight-bold text-uppercase mb-3">Student Dashboard</h3>

                    <!-- Display User Details in a Card -->
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Welcome, <?php echo $_SESSION["user_name"]; ?></h5>
                            <p class="card-text">Email: <?php echo $_SESSION["user_email"]; ?></p>
                            <p class="card-text">Father's Name: <?php echo $_SESSION["user_father_name"]; ?></p>
                            <p class="card-text">Class: <?php echo $_SESSION["user_class"]; ?></p>
                        </div>
                    </div>

                    <!-- Logout Button -->
                    <form method="post" action="logout.php" class="mt-3">
                        <button type="submit" class="btn btn-danger rounded-pill btn-logout">Logout</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

</body>

</html>