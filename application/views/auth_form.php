<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login & Register</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap');
        
        body {
            font-family: 'Roboto', sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background: linear-gradient(135deg, #73a5ff, #5477f5);
        }

        .container {
            display: flex;
            width: 80%;
            max-width: 1200px;
            background: white;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.2);
            border-radius: 15px;
            overflow: hidden;
            transition: transform 0.3s;
        }

        .container:hover {
            transform: scale(1.02);
        }

        .info {
            flex: 1;
            padding: 30px;
            background: #3a8fd7;
            color: white;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
        }

        .info h1 {
            margin: 0;
            font-size: 2.5em;
        }

        .info p {
            font-size: 1.2em;
            margin-top: 10px;
        }

        .forms {
            flex: 1;
            padding: 30px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .form-container {
            position: relative;
        }

        .form-switch {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
        }

        .switch-btn {
            background: #3a8fd7;
            color: white;
            border: none;
            padding: 10px 20px;
            font-size: 1em;
            cursor: pointer;
            border-radius: 4px;
            transition: background 0.3s, transform 0.3s;
        }

        .switch-btn:hover {
            background: #2a6fb4;
            transform: scale(1.1);
        }

        .form-content {
            position: relative;
        }

        .form {
            display: none;
            transition: opacity 0.3s;
        }

        .form.active {
            display: block;
            animation: fadeIn 0.3s;
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        h2 {
            margin-top: 0;
        }

        form {
            display: flex;
            flex-direction: column;
        }

        label {
            margin-bottom: 5px;
        }

        input[type="text"],
        input[type="password"],
        select {
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
            transition: border 0.3s;
        }

        input[type="text"]:focus,
        input[type="password"]:focus,
        select:focus {
            border-color: #3a8fd7;
        }

        input[type="submit"] {
            background: #3a8fd7;
            color: white;
            border: none;
            padding: 10px;
            font-size: 1em;
            cursor: pointer;
            border-radius: 4px;
            transition: background 0.3s, transform 0.3s;
        }

        input[type="submit"]:hover {
            background: #2a6fb4;
            transform: scale(1.1);
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="info">
            <h1>Sistem Informasi Antrian</h1>
            <p>Selamat datang di sistem antrian kami. Silakan login atau daftar untuk melanjutkan.</p>
        </div>
        <div class="forms">
            <div class="form-container">
                <div class="form-switch">
                    <button class="switch-btn" onclick="showLogin()">Login</button>
                    <button class="switch-btn" onclick="showRegister()">Register</button>
                </div>
                <div class="form-content">
                    <div id="login-form" class="form active">
                        <h2>Login</h2>
                        <form action="<?php echo site_url('auth/login'); ?>" method="post">
                            <label for="login-username">Username:</label>
                            <input type="text" id="login-username" name="username" required>
                            <br>
                            <label for="login-password">Password:</label>
                            <input type="password" id="login-password" name="password" required>
                            <br>
                            <input type="submit" value="Login">
                        </form>
                    </div>
                    <div id="register-form" class="form">
                        <h2>Register</h2>
                        <form action="<?php echo site_url('auth/register'); ?>" method="post">
                            <label for="register-username">Username:</label>
                            <input type="text" id="register-username" name="username" required>
                            <br>
                            <label for="register-password">Password:</label>
                            <input type="password" id="register-password" name="password" required>
                            <br>
                            <label for="register-status">Status:</label>
                            <select id="register-status" name="status" required>
                                <option value="#">---Silahkan Pilih---</option>
                                <option value="loket1">Loket 1 - Kasir</option>
                                <option value="loket2">Loket 2 - Perkara</option>
                                <option value="loket3">Loket 3 - Hukum</option>
                                <option value="loket4">Loket 4 - Umum</option>
                                <option value="loket5">Loket 5 - E-Court</option>
                                <option value="admin">Admin</option>
                                <option value="dashboard">Dashboard</option>
                            </select>
                            <br>
                            <input type="submit" value="Register">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
    <script>
        function showLogin() {
            document.getElementById('login-form').classList.add('active');
            document.getElementById('register-form').classList.remove('active');
        }

        function showRegister() {
            document.getElementById('login-form').classList.remove('active');
            document.getElementById('register-form').classList.add('active');
        }

        
        document.addEventListener('DOMContentLoaded', function() {
            <?php if ($this->session->flashdata('message')): ?>
                <?php if ($this->session->flashdata('status') == 'success'): ?>
                    Swal.fire({
                        icon: 'success',
                        title: '<?php echo $this->session->flashdata('message'); ?>',
                        timer: 2000,
                        showConfirmButton: false
                    }).then(() => {
                        window.location.href = '<?php echo $this->session->flashdata('redirect_url'); ?>';
                    });
                <?php else: ?>
                    Swal.fire({
                        icon: 'info',
                        title: '<?php echo $this->session->flashdata('message'); ?>',
                        confirmButtonText: 'Ok'
                    });
                <?php endif; ?>
            <?php endif; ?>
        });
    </script>
</body>
</html>
