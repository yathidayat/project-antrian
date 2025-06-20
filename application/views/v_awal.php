<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background: url('<?php echo base_url() ?>assets/images/latarptun.jpg') no-repeat center center fixed;
            background-size: cover;
            margin: 0;
            font-family: 'Arial', sans-serif;
        }

        /* Efek blur pada latar belakang */
        body::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: inherit;
            backdrop-filter: blur(10px);
            z-index: -1;
        }

        .container {
            display: flex;
            flex-direction: column;
            align-items: center;
            background: rgba(255, 255, 255, 0.9);
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
            position: relative;
            z-index: 1;
        }

        .title {
            font-size: 1.8rem;
            margin-bottom: 20px;
            text-align: center;
            color: #333;
            font-weight: bold;
        }

        .footer {
            background-color: #343a40;
            color: #000;
            padding: 10px 0;
            position: fixed;
            bottom: 0;
            width: 100%;
            text-align: center;
            font-size: 0.9rem;
            font-weight: bold;
        }

        .footer p {
            margin: 0;
        }


        .form-container {
            width: 100%;
            max-width: 400px;
        }

        .form-control {
            font-size: 1.1rem;
            padding: 10px;
            margin-bottom: 20px;
            border-radius: 10px;
            box-shadow: 0px 5px 10px rgba(0, 0, 0, 0.1);
        }

        .btn {
            font-size: 1.2rem;
            padding: 10px;
            width: 100%;
            background-color: #74ebd5;
            border: none;
            border-radius: 10px;
            transition: background-color 0.3s ease, transform 0.3s ease;
        }

        .btn:hover {
            background-color: #ACB6E5;
            transform: translateY(-3px);
            box-shadow: 0px 5px 15px rgba(0, 0, 0, 0.2);
        }

        .image-container {
            display: flex;
            justify-content: space-between;
            gap: 20px;
            margin-bottom: 20px;
        }

        .image-container img {
            max-width: 100px;
        }

        @media (max-width: 576px) {
            .image-container {
                flex-direction: column;
                align-items: center;
            }
        }
    </style>
</head>

<body>

    <div class="container">
        <div class="image-container">
            <img src="<?php echo base_url() ?>assets/images/ptun.jpg" alt="Logo PTUN">
            <img src="<?php echo base_url() ?>assets/images/stmik.jpg" alt="Logo STMIK BANJARBARU">
        </div>
        <div class="title">
            Login Aplikasi Antrian Pengadilan Tata Usaha Negara Banjarmasin
        </div>
        <form action="<?php echo site_url('auth/login'); ?>" method="POST" class="form-container">
            <input type="text" name="username" class="form-control" placeholder="Username" required>
            <input type="password" name="password" class="form-control" placeholder="Password" required>
            <button type="submit" class="btn">Login</button>
        </form>

        <?php if ($this->session->flashdata('error')): ?>
            <div class="alert alert-danger">
                <?php echo $this->session->flashdata('error'); ?>
            </div>
        <?php endif; ?>
    </div>

    <!-- Footer -->
    <footer class="footer text-center">
        <div class="container">
            <p>Hak Cipta © 2024 Muhammad Hidayat-310123023780 STMIK BANJARBARU. All rights reserved.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>