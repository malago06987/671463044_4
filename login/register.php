<?php
include "../conn/connectDB.php";

// ---------------- รับค่าจากฟอร์ม ----------------
$user_name = trim($_REQUEST['user_name']);
$fullname = trim($_REQUEST['fullname']);
$faculty_id = trim($_REQUEST['faculty_id']);
$tel    = trim($_REQUEST['tel']);
$email   = trim($_REQUEST['email']);
$password  = $_REQUEST['password'];
$confirm  = $_REQUEST['confirm_password'];

if($user_name != "" &&
    $fullname != "" &&
    $faculty_id != "" &&
    $tel != "" &&
    $email != "" &&
    $password != "" &&
    $confirm != ""){



// ---------------- ตรวจสอบข้อมูล ----------------
if ($password != $confirm) {
  echo "<script>
    alert('รหัสผ่านไม่ตรงกัน');
    history.back();
  </script>";
  exit;
}

// ---------------- ตรวจสอบอีเมลซ้ำ ----------------
$check_sql = "SELECT user_id FROM users WHERE email = '$email'";
$result = $conn->query($check_sql);

if ($result->num_rows > 0) {
  echo "<script>
    alert('อีเมลนี้ถูกใช้งานแล้ว');
    history.back();
  </script>";
  exit;
}

// ---------------- ตรวจสอบuser_nameซ้ำ ----------------
$check_sql = "SELECT user_name FROM users WHERE user_name = '$user_name'";
$result = $conn->query($check_sql);

if ($result->num_rows > 0) {
  echo "<script>
    alert('user_name นี้ถูกใช้งานแล้ว');
    history.back();
  </script>";
  exit;
}
// ---------------- เข้ารหัสรหัสผ่าน ----------------
$hash_password = password_hash($password, PASSWORD_DEFAULT);

// ---------------- Insert ข้อมูล ----------------
$insert_sql = "
  INSERT INTO users (user_name, fullname,faculty_id, tel, email, password)
  VALUES ('$user_name', '$fullname', '$faculty_id', '$tel', '$email', '$hash_password')
";

if ($conn->query($insert_sql) === TRUE) {
  echo "<script>
    alert('สมัครสมาชิกเรียบร้อยแล้ว');
    window.location='login.php';
  </script>";
} else {
  echo "<script>
    alert('เกิดข้อผิดพลาด: {$conn->error}');
    history.back();
  </script>";
}
} else {
  echo "<script>
    alert('กรุณากรอกข้อมูลให้ครบทุกช่อง');
    history.back();
  </script>";
}
?>

