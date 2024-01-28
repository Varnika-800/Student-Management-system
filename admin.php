<?php
session_start();
include('includes/config.php');

// Check if the admin is logged in, otherwise redirect to the login page
if (!isset($_SESSION["admin_id"])) {
    header("Location: index.php");
    exit();
}
$currentYear = date('Y');
// Function to promote students to the next class
function promoteStudents($conn)
{
    $year = $_POST['year'];
    $class = $_POST['class'];
    $studentId = $_POST['student_id'];

    // SQL to promote a specific student (update the class and registration year)
    $sql = "UPDATE students SET class = ?, registration_year = ? ,status = 'Promoted' WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iii", $class, $year, $studentId);

    if ($stmt->execute()) {
        echo "<div class='success-message mx-3'>Student promoted successfully.</div>";
    } else {
        echo "<div class='error-message'>Error promoting student: " . $stmt->error . "</div>";
    }

    $stmt->close();
}

// Perform promotion when the "Promote" button is clicked
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["promoteStudent"])) {
    promoteStudents($conn);
}

// Function to delete a student from the database
function deleteStudent($conn)
{
    $studentId = $_POST['student_id'];

    // SQL to delete a specific student
    $sql = "DELETE FROM students WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $studentId);

    if ($stmt->execute()) {
        echo "<div class='success-message mx-3'>Student deleted successfully.</div>";
    } else {
        echo "<div class='error-message'>Error deleting student: " . $stmt->error . "</div>";
    }

    $stmt->close();
}

// Perform promotion or deletion based on the button clicked
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["promoteStudent"])) {
        promoteStudents($conn);
    } elseif (isset($_POST["deleteStudent"])) {
        deleteStudent($conn);
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="/css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-eMa2l2wqkHxiy2lEh6HmNnGgxDw9zRFe6dDvKsNs1t+I8F2FpQJ4b2aT9FiKqbl" crossorigin="anonymous"></script>


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

        .btn-logout,
        .btn-promote {
            color: #fff;
        }

        h3 {
            background-color: #5ce786;
            color: #000;
            border-radius: 2rem;
        }

        .btn-logout,
        .btn-promote {
            width: 150px;
            margin-top: 20px;
        }

        table {
            margin-top: 20px;
        }

        .success-message {
            color: #155724;
            background-color: #d4edda;
            border-color: #c3e6cb;
            padding: 10px;
            margin-top: 10px;
            border-radius: 5px;
        }

        .error-message {
            color: #721c24;
            background-color: #f8d7da;
            border-color: #f5c6cb;
            padding: 10px;
            margin-top: 10px;
            border-radius: 5px;
        }

        table,
        th,
        td {
            border: 1px solid #000;
            border-collapse: collapse;
            padding: 10px;
        }
    </style>
</head>

<body>

    <div class="container">
        <div class="row">
            <div class="col-md-12 mb-5 d-flex justify-content-center align-items-center">
                <!-- Admin Dashboard -->
                <div id="adminDashboard" class="card p-5">
                    <h3 class="text-center font-weight-bold text-uppercase mb-3">Admin Dashboard</h3>

                    <!-- Display Admin Details in a Card -->
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Welcome, <?php echo $_SESSION["admin_name"]; ?></h5>
                            <p class="card-text">Email: <?php echo $_SESSION["admin_email"]; ?></p>
                        </div>
                    </div>

                    <!-- Display Student Details in a Table -->
                    <table>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Father's Name</th>
                            <th>Class</th>
                            <th>Registration Year</th>
                            <th>Status</th>
                            <th>Action</th>
                            <th>Action</th>
                        </tr>
                        <?php
                        // Fetch and display student details
                        $result = $conn->query("SELECT * FROM students");
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $row['id'] . "</td>";
                            echo "<td>" . $row['name'] . "</td>";
                            echo "<td>" . $row['email'] . "</td>";
                            echo "<td>" . $row['father_name'] . "</td>";
                            echo "<td>" . $row['class'] . "</td>";
                            echo "<td>" . $row['registration_year'] . "</td>";
                            echo "<td>" . $row['status'] . "</td>";
                            echo "<td>
                                    <!-- Button trigger modal -->
                                    <button type='button' class='btn btn-primary' data-toggle='modal' data-target='#promoteModal" . $row['id'] . "'>Promote</button>
                                    
                                    <!-- Modal -->
                                    <div class='modal fade' id='promoteModal" . $row['id'] . "' tabindex='-1' role='dialog' aria-labelledby='promoteModalLabel' aria-hidden='true'>
                                        <div class='modal-dialog' role='document'>
                                            <div class='modal-content'>
                                                <div class='modal-header'>
                                                    <h5 class='modal-title' id='promoteModalLabel'>Promote Student</h5>
                                                    <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                                                        <span aria-hidden='true'>&times;</span>
                                                    </button>
                                                </div>
                                                <div class='modal-body'>
                                                    <form method='post' action=''>
                                                        <div class='form-group'>
                                                            <label for='classDropdown'>Select Class To Promote:</label>
                                                            <select class='form-control' id='classDropdown' name='class'>
                                                                <option value='1'>1</option>
                                                                <option value='2'>2</option>
                                                                <option value='3'>3</option>
                                                                <option value='4'>4</option>
                                                                <option value='5'>5</option>
                                                                <option value='6'>6</option>
                                                                <option value='7'>7</option>
                                                                <option value='8'>8</option>
                                                                <option value='9'>9</option>
                                                                <option value='10'>10</option>
                                                            </select>
                                                        </div>
                                                        <div class='form-group'>
                                                            <label for='yearDropdown'>Select Year:</label>
                                                            <select class='form-control' id='yearDropdown' name='year'>
                                                                <option value=2024'>2024</option>
                                                                <option value='2025'>2025</option>
                                                                <option value='2026'>2026</option>
                                                                <option value='2027'>2027</option>   
                                                                <option value='2028'>2028</option>   
                                                                <option value='2029'>2029</option>                                                  
                                                            </select>
                                                        </div>
                                                        <div class='d-flex justify-content-between'>
                                                            <button type='submit' class='btn btn-primary' name='promoteStudent'>Promote</button>
                                                            <button type='button' class='btn btn-secondary' data-dismiss='modal'>Cancel</button>
                                                        </div>
                                                        <input type='hidden' name='student_id' value='" . $row['id'] . "'>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>";
                            echo "<td>
                                        <!-- Delete Button with Confirm Dialog -->
                                        <button type='button' class='btn btn-danger' data-toggle='modal' data-target='#deleteModal" . $row['id'] . "'>Delete</button>
                                        <!-- Modal for Delete Confirmation -->
                                        <div class='modal fade' id='deleteModal" . $row['id'] . "' tabindex='-1' role='dialog' aria-labelledby='deleteModalLabel' aria-hidden='true'>
                                            <div class='modal-dialog' role='document'>
                                                <div class='modal-content'>
                                                    <div class='modal-header'>
                                                        <h5 class='modal-title' id='deleteModalLabel'>Delete Student</h5>
                                                        <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                                                            <span aria-hidden='true'>&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class='modal-body'>
                                                        Are you sure you want to delete this student's data?
                                                    </div>
                                                    <div class='modal-footer'>
                                                        <button type='button' class='btn btn-secondary' data-dismiss='modal'>Cancel</button>
                                                        <form method='post' class='d-inline'>
                                                            <button type='submit' class='btn btn-danger' name='deleteStudent'>Delete</button>
                                                            <input type='hidden' name='student_id' value='" . $row['id'] . "'>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>";
                            echo "</tr>";
                        }
                        ?>
                    </table>

                    <!-- Logout Button -->
                    <form method="post" action="logout.php">
                        <button type="submit" class="btn btn-danger rounded-pill btn-logout">Logout</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        // Hide success and error messages after 3 seconds
        setTimeout(function() {
            document.querySelector('.success-message').style.display = 'none';
            document.querySelector('.error-message').style.display = 'none';
        }, 3000);
    </script>
</body>

</html>