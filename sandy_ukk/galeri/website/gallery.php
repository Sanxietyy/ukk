<?php
include "../database/db.php";

// Check if an image was just added (received the 'added' parameter)
$addedSuccess = isset($_GET['added']) && $_GET['added'] === 'success';

// Fetch images from the database
$query = "SELECT * FROM `foto` INNER JOIN kategori ON foto.id_kategori = kategori.id_kategori";
$result = $db->query($query);

// Check for errors in the query
if (!$result) {
    die("Error fetching images: " . $db->error);
}

// Fetch the images into an array of associative arrays
$images = $result->fetch_all(MYSQLI_ASSOC);

try {
    if (isset($_GET['act'])) {
        $aksi = $_GET['act'];
        $aksi_id = $_GET['id'];
        if ($aksi == 'delete') {
            $db->query("DELETE FROM foto WHERE id_foto = '$aksi_id'");
            header('location: gallery.php');
        } else {
            header("location: edit_foto.php?act=edit&id=$aksi_id");
        }
    }
} catch (mysqli_sql_exception $e) {
    echo '<dialog> Terjadi Kesalahan! </dialog>';
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Image Gallery</title>

    <!-- Bootstrap CSS link -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        
    <!-- Custom CSS link -->
    <link rel="stylesheet" href="../assets/css/gallery.css"> <!-- Create gallery.css for custom styles -->
</head>
<body>

    <header>
        <?php include "../layout/header.php" ?>
    </header>

    <div class="container mt-5">
        <h1 class="mb-4">Image Gallery</h1>
        <a href="upload_image.php" class="category category-link">Upload a new image</a>
        <?php
        // Display success message if an image was just added
        if ($addedSuccess) {
            echo '<p style="color: green;">Image added successfully!</p>';
        }
        ?>

        <table class="table bg-dark">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Image Name</th>
                    <th scope="col">Description</th>
                    <th scope="col">Category</th>
                    <th scope="col">Image</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Loop through images and display them in a table
                foreach ($images as $image) {
                    echo "<tr>";
                    echo "<th scope='row'>" . $image['id_foto'] . "</th>";
                    echo "<td>{$image['nama_foto']}</td>";
                    echo "<td>{$image['deskripsi_foto']}</td>";
                    echo "<td>{$image['nama_kategori']}</td>";
                    echo "<td><img src='../assets/img/{$image['gambar_foto']}' alt='{$image['nama_foto']}' class='img-thumbnail'></td>";
                    echo "<td><div id='wrapper'>
                    <a href='edit_image.php?act=edit&id={$image['id_foto']}' class='btn btn-warning'>EDIT</a>
                    <a href='gallery.php?act=delete&id={$image['id_foto']}' class='btn btn-danger'>DELETE</a>
                    </div></td>";
                    echo "</tr>";
                }                
                ?>
            </tbody>
        </table>
    </div>
    <!-- Bootstrap JS and Popper.js scripts (optional) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
