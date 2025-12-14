<?php
session_start();
require 'db.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST'){
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $mysqli->prepare("SELECT id, password FROM users WHERE username = ?");
    $stmt->bind_param('s', $username);
    $stmt->execute();
    $res = $stmt->get_result();

    if ($res->num_rows === 1){
        $row = $res->fetch_assoc();
        if ($password === $row['password']){
            $_SESSION['user_id'] = $row['id'];
            header("Location: dashboard.php");
            exit;
        } else {
            $error = '❌ Password salah';
        }
    } else {
        $error = '❌ Username tidak ditemukan';
    }
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Login | Toko Barokah</title>
<style>
    body {
        font-family: 'Poppins', sans-serif;
        background: linear-gradient(135deg, #1e90ff, #2ecc71);
        height: 100vh;
        margin: 0;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .login-box {
        background: white;
        width: 360px;
        padding: 35px;
        border-radius: 20px;
        box-shadow: 0 12px 30px rgba(0,0,0,0.25);
        text-align: center;
        animation: fadeIn 0.8s ease;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(25px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .logo {
        font-size: 42px;
        margin-bottom: 10px;
    }

    h2 {
        margin: 10px 0 25px;
        color: #1e90ff;
    }

    .input-group {
        text-align: left;
        margin-bottom: 18px;
    }

    .input-group label {
        font-size: 14px;
        color: #555;
        font-weight: bold;
    }

    .input-group input {
        width: 100%;
        padding: 12px;
        margin-top: 6px;
        border-radius: 12px;
        border: 1px solid #ccc;
        font-size: 15px;
        transition: 0.2s;
    }

    .input-group input:focus {
        border-color: #2ecc71;
        outline: none;
        box-shadow: 0 0 0 3px rgba(46,204,113,0.2);
    }

    button {
        width: 100%;
        padding: 12px;
        background: linear-gradient(135deg, #1e90ff, #2ecc71);
        border: none;
        border-radius: 14px;
        color: white;
        font-size: 16px;
        font-weight: bold;
        cursor: pointer;
        margin-top: 10px;
        transition: 0.3s;
        box-shadow: 0 5px 12px rgba(0,0,0,0.25);
    }

    button:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 16px rgba(0,0,0,0.3);
        opacity: 0.95;
    }

    .error {
        margin-top: 15px;
        color: #e74c3c;
        font-weight: bold;
        font-size: 14px;
    }

    .footer {
        margin-top: 20px;
        font-size: 13px;
        color: #999;
    }
</style>
</head>
<body>

<div class="login-box">
    <div class="logo">🔐</div>
    <h2>Login Toko Barokah</h2>

    <form method="post">
        <div class="input-group">
            <label>Username</label>
            <input type="text" name="username" placeholder="Masukkan username" required>
        </div>

        <div class="input-group">
            <label>Password</label>
            <input type="password" name="password" placeholder="Masukkan password" required>
        </div>

        <button type="submit">Masuk</button>
    </form>

    <?php if ($error): ?>
        <div class="error"><?= $error ?></div>
    <?php endif; ?>

    <div class="footer">
        © <?= date('Y') ?> Toko Barokah
    </div>
</div>

</body>
</html>
