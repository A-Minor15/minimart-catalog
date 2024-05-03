<?php
    include "connection.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <title>Minimart Catalog | Sign Up</title>
</head>
<body class="bg-light" style="min-height: 100vh;">
    <div class="container py-5">
        <?php
            if( isset($_POST["btn_submit"])) {
                //INPUT
                $first_name = $_POST["first_name"];
                $last_name = $_POST["last_name"];
                $username = $_POST["username"];
                $password = $_POST["password"];
                $confirm_password = $_POST["confirm_password"];

                //PROCESS
                //conpare passwords
                if($password == $confirm_password) {
                    //insert the data to the database
                    createUser($first_name, $last_name, $username, $password);
                }
                else {
                    //display an error message
                    echo "<div class='alert alert-danger w-50 mx-auto mb-3 text-center'>Passwords do not much. Kindly try again.</div>";
                }
            }
        ?>

        <div class="card w-25 mx-auto">
            <div class="card-header">
                <h1 class="display-5 text-center card-title">Sign Up</h1>
            </div>
            <div class="card-body">
                <form action="" method="post">
                    <label for="first-name" class="form-label">First Name</label>
                    <input type="text" name="first_name" id="first-name" class="form-control mb-3" required>
                    <label for="last-name" class="form-label">Last Name</label>
                    <input type="text" name="last_name" id="last-name" class="form-control mb-3" required>
                    <label for="username" class='form-label'>Username</label>
                    <input type="text" name="username" id="username" class="form-control mb-3" required>
                    <label for="password" class="form-label">Password</label>
                    <input type="password" name="password" id="password" required class="form-control mb-3">
                    <label for="password" class="form-label">Confirm Password</label>
                    <input type="password" name="confirm_password" id="password" required class="form-control mb-3">
                    <input type="submit" value="Submit" name="btn_submit" class="btn btn-success w-100">
                    <p class="my-3 text-center text-muted">Do you have an account? <a href="login.php">Login here</a></p>
                </form>
            </div>
        </div>
    </div>
</body>
</html>

<?php
    function createUser($first_name, $last_name, $username, $password) {
        $conn = dbConnect();
        $encrypted_password = password_hash($password, PASSWORD_DEFAULT); //encrypt the password
        $sql = "INSERT INTO users(first_name, last_name, username, password) VALUES ('$first_name', '$last_name', '$username', '$encrypted_password')";
        $result = $conn->query($sql); //run the sql statement

        //check if the sql statement runs successfully
        if($result) {
            header("Location: login.php"); //redirect to login page
        }
        else {
            //display an error message
            echo "<div class='alert alert-danger w-50 mx-auto mb-3 text-center'>Failed to insert data. Kindly try again. <br><small>".$conn->error."</small></div>";
        }
    }
?>