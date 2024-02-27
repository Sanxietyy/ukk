<?php
include "../database/db.php";

$data = []; // Initialize an empty array
$aksi_id = ''; // Initialize $aksi_id

try {
    if (isset($_GET['act'])) {
        $aksi = $_GET['act'];
        $aksi_id = $_GET['id'];
        if ($aksi == 'edit') {
            $result = $db->query("SELECT nama_kategori FROM kategori WHERE id_kategori = '$aksi_id'");
            $data = $result->fetch_assoc();
        } else {
            header("location: list_kategori.php?act=delete&id=$aksi_id");
        }
    }
} catch (mysqli_sql_exception $e) {
    echo '<dialog> Terjadi Kesalahan! </dialog>';
}

if (isset($_POST['EDIT'])) { // Use 'EDIT' as the form submission button name
    $newname = $_POST['nama_kategori'];
    $db->query("UPDATE kategori SET nama_kategori = '$newname' WHERE id_kategori='$aksi_id'");
    header('location: list_kategori.php');
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
    <title>Category | EDIT</title>
</head>
<body>

    <header>
        <?php include "../layout/header.php" ?>
    </header>

    <h1>edit Category</h1>

    <form action="edit_kategori.php?act=edit&id=<?php echo $aksi_id; ?>" method="post">
        <label for="nama_kategori">nama_kategori:</label>
        <input type="text" name="nama_kategori" id="nama_kategori" value="<?php echo isset($data['nama_kategori']) ? htmlspecialchars($data['nama_kategori']) : ''; ?>" required>
        <br>
        <input type="submit" value="EDIT" name="EDIT" class="btn btn-success">
        <a href="list_kategori.php" class="btn btn-secondary">Cancel</a>
    </form>

    <!-- Bootstrap JS and Popper.js scripts (optional) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
