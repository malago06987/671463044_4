<?php
$data1 = $_GET["data"] ?? "";
include(".//conn/connectDB.php");
$sqlcheck = "SELECT t.*, l.lecturer_name
                FROM topic t
                LEFT JOIN lecturer l ON t.lecturer_id = l.lecturer_id
                WHERE t.topic_header LIKE '%$data1%'OR l.lecturer_name LIKE '%$data1%'
                ORDER BY t.topic_id ASC";
$result = $conn->query($sqlcheck);
$no = 0;
$str="";
if($result->num_rows>0){
    while ($row = $result->fetch_array()) {
    $no++;
        $str.= "<tr>
                <td>$no</td>
                <td>" . $row['topic_header'] . "</td>
                <td>" . $row['lecturer_name'] . "</td>
                <td>
                    <button type='button' class='btn btn-primary'
                        data-bs-toggle='modal'
                        data-bs-target='#edit'
                        data-id='" . $row['topic_id'] . "'
                        data-header='" . $row['topic_header'] . "'
                        data-detail='" . $row['topic_detail'] . "'
                        data-lecturer='" . $row['lecturer_id'] . "'>
                        แก้ไข
                    </button>
                </td>
            </tr>";
}
}else{
    $str.="<h6 class='text-danger'>ไม่พบข้อมูล</h6>";
}
echo $str;
?>