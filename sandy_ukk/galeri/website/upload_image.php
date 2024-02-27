<?php
include "../database/db.php";

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate and sanitize the input
    $id_kategori = $_POST["id_kategori"];
    $nama_foto = $_POST["nama_foto"];
    $deskripsi_foto = $_POST["deskripsi_foto"];

    // Handle file upload
    $targetDirectory = "../assets/img/";
    $targetFile = $targetDirectory . basename($_FILES["gambar_foto"]["name"]);

    // Check if image file is an actual image or fake image
    $check = getimagesize($_FILES["gambar_foto"]["tmp_name"]);
    if ($check !== false) {
        // Move the uploaded file to the destination
        if (move_uploaded_file($_FILES["gambar_foto"]["tmp_name"], $targetFile)) {
            // Insert data into the database using regular SQL query
            $query = "INSERT INTO `foto` (`id_kategori`, `id_user`, `nama_foto`, `deskripsi_foto`, `gambar_foto`, `created_at`, `updated_at`) 
                      VALUES ('$id_kategori', '1', '$nama_foto', '$deskripsi_foto', '{$_FILES["gambar_foto"]["name"]}', NOW(), NOW())";

            // Execute the query
            $result = $db->query($query);

            if ($result) {
                // Redirect to the gallery page or show a success message
                header("Location: gallery.php?added=success");
                exit();
            } else {
                echo '<p style="color: red;">Error executing query: ' . $db->error . '</p>';
            }
        } else {
            echo '<p style="color: red;">Sorry, there was an error uploading your file.</p>';
        }
    } else {
        echo '<p style="color: red;">File is not an image.</p>';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap CSS link -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        
    <!-- Custom CSS link -->
    <link rel="stylesheet" href="../assets/css/uploadform.css">
    <title>Upload Image</title>
</head>
<body>

    <header>
        <?php include "../layout/header.php" ?>
    </header>

    <h1>Upload Image</h1>

    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
        <label for="id_kategori">Category:</label>
        <select name="id_kategori" id="id_kategori" required>
            <?php
            // Fetch categories from the database
            $query = "SELECT `id_kategori`, `nama_kategori` FROM `kategori`";
            $result = $db->query($query);

            // Check for errors in the query
            if (!$result) {
                die("Error fetching categories: " . $db->error);
            }

            // Fetch the categories into an array of associative arrays
            $categories = $result->fetch_all(MYSQLI_ASSOC);

            // Loop through categories and display them in the dropdown
            foreach ($categories as $category) {
                echo "<option value='{$category['id_kategori']}'>{$category['nama_kategori']}</option>";
            }
            ?>
        </select>
        <br>
        <label for="nama_foto">Image Name:</label>
        <input type="text" name="nama_foto" id="nama_foto" required>
        <br>
        <label for="deskripsi_foto">Description:</label>
        <textarea name="deskripsi_foto" id="deskripsi_foto" required></textarea>
        <br>
        <label for="gambar_foto">Choose Image:</label>
        <input type="file" name="gambar_foto" id="gambar_foto" accept="image/*" style="margin-bottom: 4px;" required>
        <br>
        <input type="submit" value="Upload Image">
        <a href="gallery.php" class="btn btn-secondary">Cancel</a>

    </form>
    <!-- Bootstrap JS and Popper.js scripts (optional) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
