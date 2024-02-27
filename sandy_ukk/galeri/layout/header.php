<!-- header.php -->
<style>
    /* Navbar styles for dark theme */
.navbar {
    background-color: #333; /* Dark background color */
}

.navbar-brand {
    color: #fff; /* Text color for brand */
}


/* Styles for navbar links */
.navbar-nav .nav-item {
    margin-right: 10px; /* Adjust spacing between nav items */
}

.navbar-nav .nav-link {
    color: #fff; /* Text color for nav links */
}

/* Hover effect for navbar links */
.navbar-nav .nav-link:hover {
    color: #ddd; /* Text color on hover */
}

</style>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="../website/index.php">Photo Gallery</a>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a href="../website/gallery.php" class="nav-link">Pictures</a>
                </li>
                <!-- <li class="nav-item">
                    <a class="nav-link" href="../website/list_tag.php">Tag</a>
                </li> -->
                <li class="nav-item">
                    <a class="nav-link" href="../website/list_kategori.php">Category</a>
                </li>
            </ul>
        </div>
    </div>
</nav>