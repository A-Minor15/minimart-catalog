<?php
    session_start();
    include "connection.php";
    $user_details = getUser($_SESSION["user_id"]);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>Minimart Catalog | Profile</title>
</head>
<body class="bg-light" style="min-height:100vh;">
    <?php include "navbar.php"; ?>
    <div class="container py-5">
        <?php
            if(isset($_POST["btn_upload"])) {
                //INPUT
                $filename = $_FILES["photo"]["name"];
                $tmp_name = $_FILES["photo"]["tmp_name"];

                //PROCESS
                uploadPhoto($user_details["id"], $filename, $tmp_name);
            }
        ?>
        <div class="card w-25 mx-auto">
            <?php
                if($user_details["photo"] != NULL) {
                    echo "<img src='assets/images/".$user_details['photo']."' class='card-img-top'>";
                }
                else {
                    echo "<img src='assets/images/default.jpeg' class='card-img-top'>";
                }
            ?>

            <div class="card-body">
                <h1 class="card-title display-5"><?= $user_details["first_name"]." ".$user_details["last_name"] ?></h1>
                <h2 class="h6 text-muted text-subtitle mb-5">@<?= $user_details["username"] ?></h2>
                    <form action="" method="post" enctype="multipart/form-data">
                        <input type="file" name="photo" id="photo" class="form-control mb-3">
                        <input type="submit" value="Upload" class="btn btn-success w-100" name="btn_upload">
                    </form>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
</body>
</html>

<?php
    function getUser($user_id) {
        $conn = dbConnect();
        $sql = "SELECT * FROM users WHERE id = '$user_id'";

        return $conn->query($sql)->fetch_assoc();
    }

    function uploadPhoto($user_id, $filename, $tmp_name) {
        $conn = dbConnect();
        $sql = "UPDATE users SET photo ='$filename' WHERE id = $user_id";

        if($conn->query($sql)) {
            $destination = "assets/images/".$filename;
            move_uploaded_file($tmp_name, $destination);
            header("refresh:0"); //reload page
        }
        else {
            echo "<div class='alert alert-danger w-50 mx-auto mb-3 text-center'>Failed to upload the photo. Kindly try again.<br><small>".$conn->error."</small></div>";
        }
    }
?>