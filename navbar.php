<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a href="#" class="navbar-brand">Minimart Catalog</a>
        <button type="button" class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#menu">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="menu">
            <ul class="navbar-nav">
                <li class="nav-item"><a href="products.php" class="nav-link">Products</a></li>
                <li class="nav-item"><a href="sections.php" class="nav-link">Sections</a></li>
            </ul>
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a href="profile.php" class="nav-link"><?= $_SESSION["username"] ?></a></li>
                <li class="nav-item"><a href="logout.php" class="nav-link text-danger">Logout</a></li>
            </ul>
        </div>
    </div>
</nav>