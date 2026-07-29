<?php
session_start();

if(isset($_SESSION['user'])){
    header("Location: dashboard.php");
    exit();
}

include "config/database.php";

$error = "";

if(isset($_POST['login'])){
    $username = mysqli_real_escape_string($conn,$_POST['username']);
    $password = md5($_POST['password']);

    $sql = "SELECT * FROM users WHERE username='$username' AND password='$password'";
    $query = mysqli_query($conn,$sql);

    if(mysqli_num_rows($query) > 0){
        $row = mysqli_fetch_assoc($query);
        $_SESSION['user'] = $row['username'];
        $_SESSION['role'] = $row['role'];
        $_SESSION['name'] = $row['fullname'];
        header("Location: dashboard.php");
        exit();
    } else {
        $error = "ชื่อผู้ใช้หรือรหัสผ่านไม่ถูกต้อง";
    }
}
?>
<!DOCTYPE html>
<html lang="th">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Stock Management</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
body{background:#f3f6fb;}
.login-card{margin-top:120px;border-radius:20px;box-shadow:0 10px 30px rgba(0,0,0,.1);}
</style>
</head>
<body>
<div class="container">
<div class="row justify-content-center">
<div class="col-md-4">
<div class="card login-card">
<div class="card-body p-4">
<h2 class="text-center mb-4">📦 Stock Management</h2>
<?php if($error!=""){ echo "<div class='alert alert-danger'>$error</div>"; } ?>
<form method="post">
<div class="mb-3">
<label>Username</label>
<input type="text" name="username" class="form-control" required>
</div>
<div class="mb-3">
<label>Password</label>
<input type="password" name="password" class="form-control" required>
</div>
<button class="btn btn-primary w-100" name="login">เข้าสู่ระบบ</button>
</form>
</div></div></div></div></div>
</body>
</html>