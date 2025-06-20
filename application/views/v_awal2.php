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
            background: linear-gradient(135deg, #74ebd5 0%, #ACB6E5 100%);
            margin: 0;
            font-family: 'Arial', sans-serif;
        }

        .container {
            display: flex;
            flex-direction: column;
            align-items: center;
            background: rgba(255, 255, 255, 0.9);
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
        }

        .title {
            font-size: 1.8rem;
            margin-bottom: 20px;
            text-align: center;
            color: #333;
            font-weight: bold;
        }

        .button-container {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
            width: 100%;
        }

        .btn {
            font-size: 1.3rem;
            padding: 20px;
            background-color: rgba(255, 255, 255, 0.8);
            border: none;
            border-radius: 10px;
            position: relative;
            overflow: hidden;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            text-align: center;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .btn:hover {
            transform: translateY(-5px);
            box-shadow: 0px 10px 20px rgba(0, 0, 0, 0.2);
        }

        .btn i {
            margin-right: 10px;
            font-size: 2rem;
        }

        .btn::before {
            content: "";
            position: absolute;
            top: 100%;
            left: 50%;
            width: 300%;
            height: 300%;
            background: rgba(255, 255, 255, 0.5);
            transition: all 0.5s;
            transform: translateX(-50%) rotate(45deg);
        }

        .btn:hover::before {
            top: -50%;
            transition: all 0.5s;
        }

        img {
            max-width: 100px; /* Sesuaikan ukuran logo */
            margin-bottom: 20px;
        }
    </style>
</head>
<body>

<div class="container">
    <img src="<?php echo base_url() ?>assets/images/ptun.jpg" alt="Logo PTUN">
    <div class="title">
        Menu Antrian Pengadilan Tata Usaha Banjarmasin
    </div>
    <form action="<?= base_url('auth/set_session') ?>" method="POST">
        <div class="button-container">
            <button type="submit" name="button_name" value="Dashboard" class="btn">
                <i class="bi bi-speedometer2"></i> Dashboard
            </button>
            <button type="submit" name="button_name" value="Loket 1" class="btn">
                <i class="bi bi-person-circle"></i> Loket 1
            </button>
            <button type="submit" name="button_name" value="Loket 2" class="btn">
                <i class="bi bi-person-circle"></i> Loket 2
            </button>
            <button type="submit" name="button_name" value="Loket 3" class="btn">
                <i class="bi bi-person-circle"></i> Loket 3
            </button>
            <button type="submit" name="button_name" value="Loket 4" class="btn">
                <i class="bi bi-person-circle"></i> Loket 4
            </button>
            <button type="submit" name="button_name" value="Loket 5" class="btn">
                <i class="bi bi-person-circle"></i> Loket 5
            </button>
        </div>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
