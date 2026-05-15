<?php
    include 'config.php';

 
    function uploadImage($file, $oldImage = null)
    {
    $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
    $maxSize      = 2 * 1024 * 1024; // 2MB

    if ($file['error'] === UPLOAD_ERR_NO_FILE) {
        return $oldImage;
    }

    if ($file['error'] !== UPLOAD_ERR_OK) {
        return false;
    }

    if (! in_array($file['type'], $allowedTypes)) {
        return false;
    }

    if ($file['size'] > $maxSize) {
        return false;
    }

    $ext         = pathinfo($file['name'], PATHINFO_EXTENSION);
    $filename    = uniqid() . '.' . $ext;
    $destination = "images/" . $filename;

    if (move_uploaded_file($file['tmp_name'], $destination)) {

        if ($oldImage && file_exists("images/" . $oldImage)) {
            unlink("images/" . $oldImage);
        }

        return $filename;
    }

    return false;
    }

    $id = $_GET['id'];

    $stmt = $conn->prepare("SELECT * FROM sections WHERE id = ?");
    $stmt->execute([$id]);

    $slide = $stmt->fetch(PDO::FETCH_ASSOC);

    if (! $slide) {
    die("Slide not found.");
    }

    if (isset($_POST['update'])) {

    $tag      = $_POST['tag'];
    $title    = $_POST['title'];
    $category = $_POST['category'];

    $image = uploadImage($_FILES['image'], $slide['image']);

    if ($image === false) {
        echo "<script>alert('Image upload failed. Ensure it is JPG, PNG, or GIF and under 2MB.')</script>";
        exit();
    }

    try {

        $stmt = $conn->prepare("UPDATE sections SET tag=?, title=?, image=?, category=? WHERE id=?");

        $stmt->execute([
            $tag,
            $title,
            $image,
            $category,
            $id,
        ]);

        header("Location: index.php");
        exit;

    } catch (PDOException $e) {

        die("Error updating slide: " . $e->getMessage());
    }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Slide</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>

        body{
            background: #f4f7fc;
            font-family: 'Segoe UI', sans-serif;
        }

        .edit-card{
            border: none;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0,0,0,0.08);
        }

        .form-control,
        .form-select{
            border-radius: 12px;
            padding: 10px;
            border: 1px solid #dce1ea;
        }

        .form-control:focus,
        .form-select:focus{
            box-shadow: none;
            border-color: #4f46e5;
        }
        .preview-image{
            width: 100%;
            max-width: 300px;
            border-radius: 15px;
            object-fit: cover;
            border: 4px solid #fff;
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
        }

        .image-wrapper{
            text-align: center;
        }

        @media(max-width: 768px){
            .preview-image{
                max-width: 250px;
            }
        }

    </style>
</head>

<body>

<div class="container py-5">

    <div class="row justify-content-center">

        <div class="col-lg-8 col-md-10">

            <div class="card edit-card">

                <div class="card-header-custom bg-dark text-white p-3">
                    <center><h4>Edit Slide</h4></center>
                </div>

                <div class="card-body p-4 p-md-4">

                    <form method="post" enctype="multipart/form-data">

                        <div class="mb-4">
                            <label class="form-label fw-semibold">
                                Tag
                            </label>

                            <input
                                type="text" name="tag" value="<?php echo htmlspecialchars($slide['tag']) ?>" class="form-control"placeholder="Enter tag" required>
                        </div>

                        <div class="mb-4">

                            <label class="form-label fw-semibold">
                                Title
                            </label>

                            <input type="text" name="title" value="<?php echo htmlspecialchars($slide['title']) ?>" class="form-control" placeholder="Enter title" required>

                        </div>

                        <div class="mb-4">

                            <label class="form-label fw-semibold">
                                Category
                            </label>

                            <select name="category" class="form-select">
                                <option value="" selected>Select</option>

                                <option value="Learning" <?php echo $slide['category']=='Learning'?'selected':'' ?>>
                                    Learning
                                </option>

                                <option value="Technology" <?php echo $slide['category']=='Technology'?'selected':'' ?>>
                                    Technology
                                </option>

                                <option value="Communication" <?php echo $slide['category']=='Communication'?'selected':'' ?>>
                                    Communication
                                </option>

                            </select>

                        </div>

                        <div class="mb-4">

                            <label class="form-label fw-semibold">
                                Upload New Image
                            </label>

                            <input type="file" name="image" class="form-control" accept="image/*">

                        </div>

                        <div class="mb-4 image-wrapper">

                            <p class="fw-semibold mb-3">
                                *Current Image
                            </p>

                            <img
                                src="images/<?php echo $slide['image'] ?>" class="preview-image" alt="Slide Image">

                        </div>

                        <div class="d-grid">
                            <center>
                            <button type="submit" name="update" class="btn btn-update text-white bg-dark text-white w-50">
                                Update Slide
                            </button>
                            </center>

                        </div>

                    </form>

                </div>

            </div>

        </div>

    </div>

</div>

</body>
</html>