<?php
    session_start(); //always add session_start() first to access/use $_SESSION
    include "connection.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <title>Minimart Catalog | Sections</title>
</head>
<body class="bg-light" style="min-height:100vh;">
    <?php include "navbar.php"; ?>
    <div class="container py-5">
        <form action="" method="post">
            <div class="row mx-auto w-75">
                <div class="col text-end">
                    <label for="section" class="form-label">Add Section</label>
                </div>
                <div class="col">
                    <input type="text" class="form-control" id="section" name="section" required>
                </div>
                <div class="col text-start">
                    <input type="submit" value="Add" class="btn btn-success" name="btn_add">
                    <?php
                        if(isset($_POST["btn_add"])) {
                            //INPUT
                            $title = $_POST["section"];

                            createSections($title);
                        }
                    ?>
                </div>
            </div>
        </form>

        <div class="mt-5 w-50 mx-auto">
            <table class="table table-bordered table-striped">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Section</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- display your  sections here -->
                    <?php
                        $sections = getSections();

                        if($sections && $sections->num_rows > 0) {
                            while($row = $sections->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td>".$row["id"]."</td>";
                                echo "<td>".$row["title"]."</td>";
                                echo "</tr>";
                            }
                        }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
</body>
</html>

<?php
    function getSections() {
        $conn = dbConnect();
        $sql = "SELECT * FROM sections ORDER BY id";

        return $conn->query($sql);
    }
?>

<?php
    function createSections($title) {
        $conn = dbConnect();
        $sql = "INSERT INTO sections(title) VALUES ('$title')";
        $result = $conn->query($sql); //run the sql statement

        //check if the sql statement runs successfully
        if($result) {
            header("Location: sections.php"); //redirect to login page
        }
        else {
            //display an error message
            echo "<div class='alert alert-danger w-50 mx-auto mb-3 text-center'>Failed to insert data. Kindly try again. <br><small>".$conn->error."</small></div>";
        }
    }
?>