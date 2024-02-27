<?php
include "../database/db.php";

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate and sanitize the input
    $id_kategori = $_POST["id_kategori"];
    $nama_foto = $_POST["nama_foto"];
    $deskripsi_foto = $_POST["deskripsi_foto"];

    // Get the photo ID from the URL parameter
    $aksi_id = $_GET['id'];

    // Update data in the database using regular SQL query
    $query = "UPDATE `foto` 
              SET `id_kategori`='$id_kategori', 
                  `nama_foto`='$nama_foto', 
                  `deskripsi_foto`='$deskripsi_foto', 
                  `updated_at`=NOW() 
              WHERE `id_foto` = $aksi_id";

    // Execute the query
    $result = $db->query($query);

    if ($result) {
        // Redirect to the gallery page or show a success message
        header("Location: gallery.php?updated=success");
        exit();
    } else {
        echo '<p style="color: red;">Error executing query: ' . $db->error . '</p>';
    }
}

// Fetch existing data to pre-fill the form fields
$aksi_id = $_GET['id'];
$result = $db->query("SELECT * FROM `foto` WHERE `id_foto` = $aksi_id");
$photo = $result->fetch_assoc();

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
    <title>Edit Image</title>
</head>
<body>

    <header>
        <?php include "../layout/header.php" ?>
    </header>

    <h1>Edit Image</h1>

    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . '?id=' . $aksi_id; ?>" method="post">
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
                $selected = ($category['id_kategori'] == $photo['id_kategori']) ? 'selected' : '';
                echo "<option value='{$category['id_kategori']}' $selected>{$category['nama_kategori']}</option>";
            }
            ?>
        </select>
        <br>
        <label for="nama_foto">Image Name:</label>
        <input type="text" name="nama_foto" id="nama_foto" value="<?php echo $photo['nama_foto']; ?>" required>
        <br>
        <label for="deskripsi_foto">Description:</label>
        <textarea name="deskripsi_foto" id="deskripsi_foto" required><?php echo $photo['deskripsi_foto']; ?></textarea>
        <br>
        <input type="submit" value="Update Image">
        <a href="gallery.php" class="btn btn-secondary">Cancel</a>
    </form>
    <!-- Bootstrap JS and Popper.js scripts (optional) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
