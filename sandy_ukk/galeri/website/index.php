<?php
include "../database/db.php";

if ($_SERVER["REQUEST_METHOD"] === "GET" && isset($_GET['act']) && isset($_GET['id'])) {
    $aksi = $_GET['act'];
    $aksi_id = $_GET['id'];

    if ($aksi === 'delete') {
        // Fetch image details
        $imageQuery = $db->query("SELECT `gambar_foto` FROM `foto` WHERE `id_foto` = $aksi_id");
        $imageDetails = $imageQuery->fetch_assoc();

        if ($imageDetails) {
            // Delete the image record from the database
            $db->query("DELETE FROM `foto` WHERE `id_foto` = $aksi_id");

            // Remove the image file
            $imagePath = "../assets/img/" . $imageDetails['gambar_foto'];
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }

            // Redirect back to the dashboard
            header("Location: dashboard.php");
            exit();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Photo Gallery Dashboard</title>

    <!-- Bootstrap CSS link -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS link -->
    <link rel="stylesheet" href="../assets/css/dashboard.css">
</head>
<body>
    <header>
        <?php include "../layout/header.php" ?>
    </header>
    <div class="container-fluid">
        <h1 class="bg-dark text-white p-3">Photo Gallery Dashboard</h1>

        <div class="d-flex flex-wrap justify-content-around p-3">
            <?php
            $result = $db->query("SELECT `id_foto`, `nama_foto`, `deskripsi_foto`, `gambar_foto` FROM `foto`");
            $photos = $result->fetch_all(MYSQLI_ASSOC);

            foreach ($photos as $photo):
                $photoId = $photo['id_foto'];
                $tagResult = $db->query("SELECT `id_tag` FROM `foto_tag` WHERE `id_foto` = $photoId");
                $tags = $tagResult->fetch_all(MYSQLI_ASSOC);
            ?>
                <div class="card m-3">
                    <img src="../assets/img/<?php echo $photo['gambar_foto']; ?>" alt="<?php echo $photo['nama_foto']; ?>" class="card-img-top">
                    <div class="card-body">
                        <h3 class="card-title"><?php echo $photo['nama_foto']; ?></h3>
                        <hr>
                        <p class="card-text"><?php echo $photo['deskripsi_foto']; ?></p>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- Bootstrap JS and Popper.js scripts (optional) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
