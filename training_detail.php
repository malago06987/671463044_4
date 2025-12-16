<?php
include "./conn/connectDB.php";

if (isset($_GET['id'])) {

    $id = $conn->real_escape_string($_GET['id']);

    $sql = "SELECT t.*, l.lecturer_name 
            FROM topic t 
            LEFT JOIN lecturer l ON t.lecturer_id = l.lecturer_id
            WHERE t.topic_id = '$id'";

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
    } else {
        echo "<script>alert('ไม่พบข้อมูลหัวข้อนี้'); window.location='index.php';</script>";
        exit();
    }
} else {
    header("Location: index.php");
    exit();
}



if (isset($_POST['add_lecturer'])) {
    $name = trim($_POST['lecturer_name']);
    $imgPath = "";
    // ตรวจสอบว่ามีการอัปโหลดไฟล์หรือไม่
    if (!empty($_FILES['img_lecturer']['name'])) {
        $targetDir = "../images/lecturer/";
        if (!file_exists($targetDir)) mkdir($targetDir, 0777, true);
        $imgPath = $targetDir . basename($_FILES['img_lecturer']['name']);
        move_uploaded_file($_FILES['img_lecturer']['tmp_name'], $imgPath);
    }
    // ตรวจสอบชื่อซ้ำ
    $check_sql = "SELECT * FROM lecturer WHERE lecturer_name = '$name'";
    $check_result = $conn->query($check_sql);
    if ($check_result->num_rows > 0) {
        echo "<script>alert('ชื่อวิทยากรซ้ำกับข้อมูลที่มีอยู่ในตาราง');</script>";
    } else {
        $insert_sql = "INSERT INTO lecturer (lecturer_name, img_lecturer)
                       VALUES ('$name', '$imgPath')";
        if ($conn->query($insert_sql)) {
            echo "<script>window.location='lecturer.php';</script>";
        } else {
            echo "<script>alert('เกิดข้อผิดพลาดในการบันทึกข้อมูล');</script>";
        }
    }
}
?>

<!doctype html>
<html lang="en">

<head>
    <title>Title</title>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta
        name="viewport"
        content="width=device-width, initial-scale=1, shrink-to-fit=no" />

    <!-- Bootstrap CSS v5.2.1 -->
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
        rel="stylesheet" />
</head>

<body>
    <header>
        <!-- place navbar here -->
    </header>
    <main>
        <div class="container-fluid">

            <?php
            $folder_name = "images/topic/";
            $images = glob($folder_name . "*.{jpg,png,jpeg,gif}", GLOB_BRACE);
            if (count($images) > 0) {
            ?>
                <div id="folderCarousel"
                    class="carousel slide"
                    data-bs-ride="carousel"
                    data-bs-interval="3000">
                    <div class="carousel-inner">
                        <?php
                        $isFirst = true;
                        foreach ($images as $image_file) {
                            $active_class = ($isFirst) ? 'active' : '';
                            $isFirst = false;
                        ?>
                            <div class="carousel-item <?php echo $active_class; ?>">
                                <img src="<?php echo $image_file; ?>" class="d-block w-100" style="height: 400px; object-fit: contain; background-color: #f0f0f0;" alt="Slide Image">
                            </div>
                        <?php
                        }
                        ?>
                    </div>
                </div>
            <?php
            } else {
                echo "<div class='alert alert-warning'>ไม่พบไฟล์รูปภาพในโฟลเดอร์ $folder_name</div>";
            }
            ?>



            <div class="container mt-5 mb-5">
                <div class="card shadow-lg border-0">
                    <div class="card-header bg-success text-white">
                        <h4 class="m-0"><i class="bi bi-journal-text"></i> รายละเอียดการอบรม</h4>
                    </div>

                    <div class="card-body">
                        <div class="row">

                            <div class="col-md-12">
                                <h2 class="text-primary fw-bold"><?php echo $row['topic_header']; ?></h2>
                                <hr>

                                <div class="mb-3">
                                    <label class="fw-bold text-secondary">รายละเอียด:</label>
                                    <p class="card-text"><?php echo nl2br($row['topic_detail']); ?></p>
                                </div>

                                <ul class="list-group list-group-flush mb-4">
                                    <li class="list-group-item bg-transparent">
                                        <strong><i class="bi bi-person-video3"></i> วิทยากร:</strong>
                                        <span class="text-dark"><?php echo $row['lecturer_name']; ?></span>
                                    </li>
                                    <li class="list-group-item bg-transparent">
                                        <strong><i class="bi bi-calendar-event"></i> วันที่จัดอบรม:</strong>
                                        <span class="text-success"><?php echo $row['start']; ?></span> ถึง <span class="text-danger"><?php echo $row['end']; ?></span>
                                    </li>
                                    <li class="list-group-item bg-transparent">
                                        <strong><i class="bi bi-geo-alt-fill"></i> สถานที่:</strong>
                                        <?php echo $row['place']; ?>
                                    </li>
                                </ul>


                                <div class="modal fade" id="addModal" tabindex="-1">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <form method="POST" enctype="multipart/form-data">
                                                <div class="modal-header bg-success text-white">
                                                    <h5 class="modal-title">เพิ่มข้อมูลผู้เข้าร่วมอบรม</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <label>ชื่อผู้เข้าร่วมอบรม:</label>
                                                    <input type="text" name="personal_name" class="form-control mb-3" required>
                                                    <label>หน่วยงาน:</label>
                                                    <input type="text" name="faculty_id" class="form-control mb-3" required>
                                                    <label>เบอร์โทร:</label>
                                                    <input type="text" name="tel" class="form-control mb-3" required>
                                                    <label>อีเมล:</label>
                                                    <input type="text" name="email" class="form-control mb-3" required>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="submit" name="add_lecturer" class="btn btn-success">บันทึก</button>
                                                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">ยกเลิก</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>


                                <div class="modal fade" id="showlist" tabindex="-1">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header bg-success">
                                                <h5 class="modal-title text-white">รายชื่อผู้เข้าร่วมอบรม</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                               
                                            </div>

                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">ปืด</button>
                                            </div>
                                        </div>
                                    </div>

                                </div>


                                <div class="d-flex justify-content-end gap-2 mb-3">
                                    <div class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addModal">
                                        ลงทะเบียนเข้าร่วม
                                    </div>
                                    <div class="btn btn-info" data-bs-toggle="modal" data-bs-target="#showlist">
                                        รายชื่อผู้เข้าร่วม
                                    </div>
                                    <a href="index.php" class="btn btn-danger">
                                        หน้าหลัก
                                    </a>
                                </div>


                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </main>
    <footer>
        <!-- place footer here -->
    </footer>
    <!-- Bootstrap JavaScript Libraries -->
    <script
        src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
        crossorigin="anonymous"></script>

    <script
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
        integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+"
        crossorigin="anonymous"></script>
</body>

</html>