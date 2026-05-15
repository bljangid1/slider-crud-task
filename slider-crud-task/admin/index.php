    <?php
    include 'config.php';

   //handle file securely
    function uploadImage($file) {
        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
        $maxSize = 2 * 1024 * 1024;

        if ($file['error'] !== UPLOAD_ERR_OK) return false;
        if (!in_array($file['type'], $allowedTypes)) return false;
        if ($file['size'] > $maxSize) return false;

        $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
        $filename = uniqid() . '.' . $ext;
        $destination = "images/" . $filename;

        return move_uploaded_file($file['tmp_name'], $destination) ? $filename : false;
    }

   //form submit
    if(isset($_POST['add'])) {
        $tag = $_POST['tag'];
        $title = $_POST['title'];
        $category = $_POST['category'];

        $image = uploadImage($_FILES['image']);
        if (!$image) {
            echo "<script>alert('Image upload failed. Ensure it is JPG, PNG, or GIF and under 2MB.')</script>";
            die();
        }

        try {
            $stmt = $conn->prepare("INSERT INTO sections (tag, title, image, category, created_at) VALUES (?, ?, ?, ?, NOW())");
            $stmt->execute([$tag, $title, $image, $category]);
            echo "<script>alert('Added Successfully!!')</script>";
            header("Location: index.php#slidesTable");
            exit;
        } catch (PDOException $e) {
            die("Error inserting slide: " . $e->getMessage());
        }
    }

    // Delete data
    if(isset($_GET['delete'])) {
        $id = $_GET['delete'];
        $stmt = $conn->prepare("DELETE FROM sections WHERE id = ?");
        $stmt->execute([$id]);
        header("Location: index.php#slidesTable");
    }

    // Fetch data
    $slides = $conn->query("SELECT * FROM sections ORDER BY created_at DESC")->fetchAll(PDO::FETCH_ASSOC);
    ?>

    <!DOCTYPE html>
    <html lang="en">
    <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Panel - Slides CRUD</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.dataTables.min.css">

    <style>
    body {
        background: #f4f6f9;
    }

    .page-title {
        font-weight: 700;
        letter-spacing: .5px;
    }

    .card {
        border: none;
        border-radius: 14px;
    }

    .card-header {
        font-weight: 600;
        border-radius: 14px 14px 0 0 !important;
    }

    .table img {
        border-radius: 8px;
        object-fit: cover;
    }

    .form-label {
        font-weight: 500;
    }

    .btn {
        border-radius: 8px;
    }

    @media (max-width: 768px) {
        .page-title {
            font-size: 20px;
            text-align: center;
        }
    }
    </style>
    </head>

    <body>

    <div class="container py-4" style="max-width: 1100px;">

        <h2 class="page-title text-center mb-4">Admin Panel - Slides Management</h2>

        <div class="d-flex flex-column gap-4">
            <div>
                <div class="card shadow-sm">
                    <div class="card-header bg-dark text-center text-white">
                        <h5>Add New Slide</h5>
                    </div>

                    <div class="card-body">
                        <form method="post" enctype="multipart/form-data">

                            <div class="mb-3">
                                <label class="form-label">Tag</label>
                                <input type="text" name="tag" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Title</label>
                                <input type="text" name="title" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Category</label>
                                <select name="category" class="form-select" required>
                                    <option value="">Select</option>
                                    <option value="Learning">Learning</option>
                                    <option value="Technology">Technology</option>
                                    <option value="Communication">Communication</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Image</label>
                                <input type="file" name="image" class="form-control" required>
                            </div>
                            <center>
                            <button type="submit" name="add" class="btn btn-success">
                                Add Slide
                            </button>
                            </center>
                        </form>
                    </div>
                </div>
            </div>

            <div>
                <div class="card shadow-sm">
                                <div class="card-header bg-dark text-center text-white">
                        <h5>Slides</h5>
                    </div>

                    <div class="card-body table-responsive">
                        <table id="slidesTable" class="table table-hover align-middle table-bordered table-light">
                            <thead class="table-light">
                                <tr>
                                    <th>ID</th>
                                    <th>Tag</th>
                                    <th>Title</th>
                                    <th>Category</th>
                                    <th>Image</th>
                                    <th>Action</th>
                                </tr>
                            </thead>

                            <tbody>
                            <?php $Sr=1; foreach($slides as $slide):  ?>
                                <tr>
                                    <td><?= $Sr++ ?></td>
                                    <td><?= htmlspecialchars($slide['tag']) ?></td>
                                    <td><?= htmlspecialchars($slide['title']) ?></td>
                                    <td>
                                    
                                            <?= htmlspecialchars($slide['category']) ?>
                                    
                                    </td>
                                    <td>
                                        <img src="images/<?= $slide['image'] ?>" width="70" height="50">
                                    </td>
                                    <td>
                                        <a href="edit.php?id=<?= $slide['id'] ?>" class="btn btn-warning btn-sm mb-1">
                                            Edit
                                        </a>
                                        <a href="?delete=<?= $slide['id'] ?>"
                                        class="btn btn-danger btn-sm"
                                        onclick="return confirm('Delete this slide?')">
                                            Delete
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>

                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
    $(document).ready(function () {
        $('#slidesTable').DataTable({
            responsive: true,
            pageLength: 10,
            lengthMenu: [5, 10, 25, 50],
        });
    });
    </script>

    </body>
    </html>