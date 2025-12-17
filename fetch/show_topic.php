<?php
include("../conn/connectDB.php");
$data1 = $_GET["data1"] ?? "";

$sql = "SELECT t.*, l.lecturer_name
        FROM topic t
        LEFT JOIN lecturer l ON t.lecturer_id = l.lecturer_id
        WHERE t.topic_header LIKE '%$data1%'
        OR l.lecturer_name LIKE '%$data1%'
        ORDER BY t.topic_id ASC";

$result = $conn->query($sql);

if ($result->num_rows == 0) {
    echo "<div class='col-12 mt-3 text-center text-danger'>ไม่พบข้อมูล</div>";
    exit;
}

while ($row = $result->fetch_assoc()) {
    $short_detail = mb_substr($row['topic_detail'], 0, 100, 'UTF-8') . '...';
?>
    <div class="col-md-5 col-sm-10 mb-3 mt-3">
        <div class="card h-100 shadow-sm">
            <div class="card-body d-flex flex-column">

                <h5 class="card-title text-primary fw-bold">
                    <?=($row['topic_header']) ?>
                </h5>

                <p class="card-text text-muted small">
                    <?=($short_detail) ?>
                </p>

                <ul class="list-group list-group-flush small mb-3">
                    <li class="list-group-item px-0">
                        <strong>วันที่:</strong> <?= $row['start'] ?> ถึง <?= $row['end'] ?>
                    </li>
                    <li class="list-group-item px-0">
                        <strong>สถานที่:</strong> <?=($row['place']) ?>
                    </li>
                    <li class="list-group-item px-0">
                        <strong>วิทยากร:</strong> <?=($row['lecturer_name']) ?>
                    </li>
                </ul>

                <a href="training_detail.php?id=<?= $row['topic_id'] ?>"
                   class="btn btn-success btn-sm w-100 mt-auto">
                    ดูรายละเอียดเพิ่มเติม
                </a>

            </div>
        </div>
    </div>
<?php
}
?>
