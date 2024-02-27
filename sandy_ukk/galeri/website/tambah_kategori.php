<?php
include "../database/db.php";

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate and sanitize the input
    $nama_kategori = $_POST["nama_kategori"];

    // Insert data into the database
    $query = "INSERT INTO `kategori` (`nama_kategori`) VALUES (?)";

    $stmt = $db->prepare($query);
    $stmt->bind_param("s", $nama_kategori);
    $stmt->execute();
    $stmt->close();

    // Redirect to the category list page or show a success message
    header("Location: list_kategori.php");
    exit();
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
    <link rel="stylesheet" href="../assets/css/create_category.css">
    <title>Create Category</title>
</head>
<body>

    <header>
        <?php include "../layout/header.php" ?>
    </header>

    <h1>Create Category</h1>

    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <label for="nama_kategori">nama_kategori:</label>
        <input type="text" name="nama_kategori" id="nama_kategori" required>
        <br>
        <input type="submit" value="Create Category">
        <a href="list_kategori.php" class="btn btn-secondary">Cancel</a>
    </form>
    <!-- Bootstrap JS and Popper.js scripts (optional) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
