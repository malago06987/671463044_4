<?php
include "./conn/connectDB.php";

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
    <style>
        /* เพิ่ม CSS เพื่อกำหนดขนาดรูปภาพให้สวยงาม */
        .carousel-item img {
            height: 400px;
            /* ปรับความสูงตามต้องการ */
            object-fit: cover;
            /* ให้รูปเต็มพื้นที่โดยไม่เสียสัดส่วน */
            width: 100%;
        }
    </style>
</head>

<body style="background-color: #d7e7f7ff;">
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

 <div class="row justify-content-center">
            <?php
            $sql = "SELECT t.*, l.lecturer_name 
            FROM topic t 
            LEFT JOIN lecturer l ON t.lecturer_id = l.lecturer_id
            ORDER BY t.topic_id ASC";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
            ?>

                    <div class="col-md-5 col-sm-10 mb-3 mt-3">
                        <div class="card h-100 shadow-sm">
                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title text-primary fw-bold"><?php echo $row['topic_header']; ?></h5>

                                <p class="card-text text-muted small">
                                    <?php echo mb_substr($row['topic_detail'], 0, 100, 'UTF-8') . '...'; ?>
                                </p>

                                <ul class="list-group list-group-flush small mb-3">
                                    <li class="list-group-item px-0">
                                        <strong>วันที่:</strong> <?php echo $row['start']; ?> ถึง <?php echo $row['end']; ?>
                                    </li>
                                    <li class="list-group-item px-0">
                                        <strong>สถานที่:</strong> <?php echo $row['place']; ?>
                                    </li>
                                    <li class="list-group-item px-0">
                                        <strong>วิทยากร:</strong> <?php echo $row['lecturer_name']; ?>
                                    </li>
                                </ul>

                                <div class="d-flex justify-content-between mt-auto">
                                    <a href="topic_detail.php?id=<?php echo $row['topic_id']; ?>"
                                        class="btn btn-success btn-sm w-100 text-white">

                                        <i class="bi bi-eye"></i> ดูรายละเอียดเพิ่มเติม
                                    </a>
                                </div>

                            </div>
                        </div>
                    </div>
                  
            <?php
                }
            } else {
                // กรณีไม่มีข้อมูล
                echo "<div class='col-12'><div class='alert alert-secondary text-center'>ไม่พบข้อมูลการอบรม</div></div>";
            }
            ?>


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