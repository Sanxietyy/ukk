<?php
include "../database/db.php";

// Check if a category was just created (received the 'created' parameter)
$createdSuccess = isset($_GET['created']) && $_GET['created'] === 'success';

// Fetch categories from the database
$query = "SELECT `id_kategori`, `nama_kategori` FROM `kategori`";
$result = $db->query($query);

// Check for errors in the query
if (!$result) {
    die("Error fetching categories: " . $db->error);
}

// Fetch the categories into an array of associative arrays
$categories = $result->fetch_all(MYSQLI_ASSOC);


try {
    if (isset($_GET['act'])) {
        $aksi = $_GET['act'];
        $aksi_id = $_GET['id'];
        if ($aksi == 'delete') {
            $db->query("DELETE FROM kategori WHERE id_kategori = '$aksi_id'");
            header('location: list_kategori.php');
        } else {
            header("location: edit_kategori.php?act=edit&id=$aksi_id");
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
    <title>Category List</title>

    <!-- Bootstrap CSS link -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        
    <!-- Custom CSS link -->
    <link rel="stylesheet" href="../assets/css/category.css">
</head>
<body>

    <header>
        <?php include "../layout/header.php" ?>
    </header>

    <div class="container mt-5">
        <h1 class="mb-4">Category List</h1>
        <a href="tambah_kategori.php" class="category category-link">Create a new category</a>
        <?php
        // Display success message if a category was just created
        if ($createdSuccess) {
            echo '<p style="color: green;">Category created successfully!</p>';
        }
        ?>

        <table class="table bg-dark">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Category Name</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Loop through categories and display them in a table
                foreach ($categories as $category) {
                    echo "<tr>";
                    echo "<th scope='row'>" . $category['id_kategori'] . "</th>";
                    echo "<td>{$category['nama_kategori']}</td>";
                    echo "<td><div id='wraper'>
                    <a href='list_kategori.php?act=edit&id={$category['id_kategori']}' class='btn btn-warning'>EDIT</a>
                    <a href='list_kategori.php?act=delete&id={$category['id_kategori']}' class='btn btn-danger'>DELETE</a>
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
