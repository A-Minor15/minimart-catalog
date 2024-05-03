<?php
    include "connection.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <title>Minimart Catalog | Login</title>
</head>
<body class="bg-light" style="min-height:100vh;">
    <div class="container py-5">
        <?php
            if(isset($_POST["btn_submit"])) {
                //INPUT
                $username = $_POST["username"];
                $password = $_POST["password"];

                //PROCESS
                login($username, $password);
            }
        ?>

        <div class="card w-25 mx-auto">
            <div class="card-header">
                <h1 class="display-5 text-center card-title">Login</h1>
            </div>
            <div class="card-body">
                <form action="" method="post">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" name="username" id="username" required class="form-control mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" name="password" id="password" class="form-control mb-3" required>
                    <input type="submit" value="Login" name="btn_submit" class="btn btn-primary w-100">
                </form>
                <p class="my-3 text-center text-muted">Doesn't have an account? <a href="sign-up.php">Sign up here</a></p>
            </div>
        </div>
    </div>
</body>
</html>

<?php
    function login($username, $password) {
        $conn = dbConnect();
        $sql = "SELECT * FROM users WHERE username = '$username'";
        $result = $conn->query($sql);

        //check if the sql statement runs successfully and if it has returned at most 1 result
        if($result && $result->num_rows == 1) {
            $user_details = $result->fetch_assoc();
            // $result->fetch_assoc() returns 1 record from the result set and it returns it as an associative array
            $password_compare = password_verify($password, $user_details["password"]);
            // password_verify() check if the encrypted password and the password from the user input match

            //check if the passwords match
            if($password_compare) {
                session_start();
                $_SESSION["user_id"] = $user_details["id"];
                $_SESSION["username"] = $user_details["username"];
                header("location: products.php");
            }
            else {
                //display an error message
                echo "<div class='alert alert-danger w-50 mx-auto text-center mb-3'>Incorrect password, Kindly try again.</div>";
            }
        }
        else {
            //display an error message
            echo "<div class='alert alert-danger w-50 mx-auto text-center mb-3'>Incorrect username, Kindly try again.<br><small>".$conn->error."</small></div>";
        }
    }
?>