<?php
session_start();
include "../conn/connectDB.php";
if ((isset($_REQUEST['user_name'])) && isset($_REQUEST['password'])) {


  // ---------------- รับค่าจากฟอร์ม ----------------
  $user_name = trim($_REQUEST['user_name']); // email หรือ user_name
  $password = $_REQUEST['password'];

  // ---------------- ตรวจสอบข้อมูลว่าง ----------------
  if ($user_name == "" || $password == "") {
    echo "<script>
    alert('กรุณากรอกชื่อผู้ใช้และรหัสผ่าน');
    history.back();
  </script>";
    exit;
  }

  // ---------------- ตรวจสอบผู้ใช้ในฐานข้อมูล ----------------
  $sql = "
  SELECT * 
  FROM users 
  WHERE email = '$user_name' 
   OR user_name = '$user_name'
  LIMIT 1
";

  $result = $conn->query($sql);

  if ($result->num_rows == 1) {

    $user = $result->fetch_assoc();

    // ---------------- ตรวจสอบรหัสผ่าน ----------------
    if (password_verify($password, $user['password'])) {

      // ---------- สร้าง session ----------
      $_SESSION['user_id']  = $user['user_id'];
      $_SESSION['user_name'] = $user['user_name'];
      $_SESSION['email']   = $user['email'];

      echo "<script>
      alert('เข้าสู่ระบบสำเร็จ');
      window.location='../index.php';
    </script>";
    } else {
      echo "<script>
      alert('รหัสผ่านไม่ถูกต้อง');
      history.back();
    </script>";
    }
  } else {
    echo "<script>
    alert('ไม่พบผู้ใช้นี้ในระบบ');
    history.back();
  </script>";
  }
}
?>


<!doctype html>
<html lang="en">

<head>
  <title>ระบบลงทะเบียน</title>
  <!-- Required meta tags -->
  <meta charset="utf-8" />
  <meta
    name="viewport"
    content="width=device-width, initial-scale=1, shrink-to-fit=no" />

  <!-- Bootstrap CSS v5.2.1 -->
  <link
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
    rel="stylesheet" />
  <link rel="stylesheet" href="login.css">
</head>

<body>
  <header>
    <!-- place navbar here -->
  </header>
  <main>

    <section class="body">
      <div class="container">
        <div class="login-box">
          <div class="row">
            <div class="col-sm-6">
              <div class="logo">
                <span class="logo-font">Go</span>Snippets
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-sm-6">
              <div id="loginForm">


                <br>
                <h3 class="header-title">ล็อคอิน</h3>
                <form class="login-form" method="post" action="">
                  <div class="form-group">
                    <label for="user_name">ชื่อ</label>
                    <input type="text" name="user_name" id="user_name" class="form-control" placeholder="Email or UserName" required>
                  </div>
                  <div class="form-group">
                    <label for="password">รหัสผ่าน</label>
                    <input type="password" name="password" id="password" class="form-control" placeholder="Password" required>
                  </div>
                  <div class="form-group">
                    <button type="submit" name="login" class="btn btn-primary w-100">ล็อคอิน</button>
                  </div>
                  <div class="form-group">
                    <div class="text-center">New Member?
                      <a href="#!" onclick="showSignup()">สร้างบัญชีใหม่</a>
                    </div>
                  </div>
                </form>
              </div>
              <div class="signupForm">
                <form class="login-form" id="signupForm" action="register.php" style="display:none;">
                  <h3 class="header-title">Sign UP</h3>
                  <div class="form-group">
                    <input type="text" class="form-control"
                      name="user_name" placeholder="User Name">
                  </div>
                  <div class="form-group">
                    <input type="text" class="form-control"
                      name="fullname" placeholder="Full Name">
                  </div>

                  <div class="form-group">
                    <input type="text" class="form-control"
                      name="faculty_id" placeholder="Faculty ID">
                  </div>

                  <div class="form-group">
                    <input type="text" class="form-control"
                      name="tel" placeholder="Phone Number">
                  </div>

                  <div class="form-group">
                    <input type="email" class="form-control"
                      name="email" placeholder="Email">
                  </div>

                  <div class="form-group">
                    <input type="password" class="form-control"
                      name="password" placeholder="Password">
                  </div>

                  <div class="form-group">
                    <input type="password" class="form-control"
                      name="confirm_password" placeholder="Confirm Password">
                  </div>

                  <div class="form-group">
                    <button class="btn btn-primary btn-block">SIGN UP</button>
                  </div>

                  <div class="form-group">
                    <div class="text-center">
                      มีเเอ็คเคาอยู่เเล้วใช่ไหม
                      <a href="#!" onclick="showLogin()">ล็อคอิน</a>
                    </div>
                  </div>

                </form>

              </div>
            </div>
            <div class="col-sm-6 hide-on-mobile">
              <div id="demo" class="carousel slide" data-ride="carousel">
                <!-- Indicators -->
                <ul class="carousel-indicators">
                  <li data-target="#demo" data-slide-to="0" class="active"></li>
                  <li data-target="#demo" data-slide-to="1"></li>
                </ul>
                <!-- The slideshow -->
                <div class="carousel-inner">
                  <div class="carousel-item active">
                    <div class="slider-feature-card">
                      <img src="https://i.imgur.com/YMn8Xo1.png" alt="">
                      <h3 class="slider-title">Title Here</h3>
                      <p class="slider-description">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Iure, odio!</p>
                    </div>
                  </div>
                  <div class="carousel-item">
                    <div class="slider-feature-card">
                      <img src="https://i.imgur.com/Yi5KXKM.png" alt="">
                      <h3 class="slider-title">Title Here</h3>
                      <p class="slider-description">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ratione, debitis?</p>
                    </div>
                  </div>
                </div>
                <!-- Left and right controls -->
                <a class="carousel-control-prev" href="#demo" data-slide="prev">
                  <span class="carousel-control-prev-icon"></span>
                </a>
                <a class="carousel-control-next" href="#demo" data-slide="next">
                  <span class="carousel-control-next-icon"></span>
                </a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

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

  <script>
    function showSignup() {
      document.getElementById("loginForm").style.display = "none";
      document.getElementById("signupForm").style.display = "block";
    }

    function showLogin() {
      document.getElementById("signupForm").style.display = "none";
      document.getElementById("loginForm").style.display = "block";
    }
  </script>
</body>

</html>