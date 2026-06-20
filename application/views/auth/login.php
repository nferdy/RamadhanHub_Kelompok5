<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Ramadhan Companion</title>

    <link rel="stylesheet" href="<?= base_url('assets/css/ramadhan.css'); ?>">

    <style>
        body{
            min-height:100vh;
            display:flex;
            justify-content:center;
            align-items:center;
            padding:20px;
        }

        .login-card{
            width:100%;
            max-width:420px;
            background:rgba(255,255,255,.08);
            backdrop-filter:blur(15px);
            border:1px solid rgba(255,255,255,.1);
            border-radius:24px;
            padding:35px;
            box-shadow:0 10px 40px rgba(0,0,0,.25);
        }

        .login-logo{
            text-align:center;
            margin-bottom:25px;
        }

        .login-logo h1{
            margin:0;
            color:#fff;
            font-size:28px;
        }

        .login-logo p{
            margin-top:8px;
            color:rgba(255,255,255,.7);
        }

        .form-group{
            margin-bottom:18px;
        }

        .form-group label{
            display:block;
            color:#fff;
            margin-bottom:8px;
        }

        .form-control{
            width:100%;
            padding:12px 14px;
            border:none;
            border-radius:12px;
            background:rgba(255,255,255,.08);
            color:#fff;
            outline:none;
        }

        .form-control::placeholder{
            color:rgba(255,255,255,.5);
        }

        .btn-login{
            width:100%;
            padding:13px;
            border:none;
            border-radius:12px;
            background:#22c55e;
            color:white;
            font-weight:600;
            cursor:pointer;
            transition:.3s;
        }

        .btn-login:hover{
            transform:translateY(-2px);
        }

        .alert{
            padding:12px;
            margin-bottom:15px;
            border-radius:10px;
            background:rgba(255,0,0,.15);
            color:#ffb4b4;
        }
    </style>
</head>
<body>

<div class="login-card">

    <div class="login-logo">
        <h1>🌙 Ramadhan Companion</h1>
        <p>Silakan masuk ke akun Anda</p>
    </div>

    <?php if(isset($error)): ?>
        <div class="alert">
            <?= $error ?>
        </div>
    <?php endif; ?>

    <form method="post">

        <div class="form-group">
            <label>Username</label>
            <input
                type="text"
                name="username"
                class="form-control"
                placeholder="Masukkan username"
                required>
        </div>

        <div class="form-group">
            <label>Password</label>
            <input
                type="password"
                name="password"
                class="form-control"
                placeholder="Masukkan password"
                required>
        </div>

        <button type="submit" class="btn-login">
            Login
        </button>

    </form>

</div>

</body>
</html>
