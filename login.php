<?php
session_start();

if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
    header("Location: report.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if ($username === 'manager' || $username === 'manager@gmail.com' && $password === 'password123') {

        $_SESSION['logged_in'] = true;
        header("Location: report.php");
        exit;
    } else {
        $error = "Invalid username or password!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="favicon.png" type="image/x-icon">
    <title>Manager Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(45deg, #6a11cb, #2575fc);
            font-family: 'Roboto', sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .login-container {
            width: 100%;
            max-width: 400px;
            padding: 40px;
            background-color: white;
            border-radius: 12px;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1);
            animation: fadeIn 1s ease-in-out;
        }

        .login-container h2 {
            text-align: center;
            color: #333;
            font-size: 2rem;
            margin-bottom: 30px;
            letter-spacing: 0.5px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group input {
            border-radius: 12px;
            padding: 12px 20px;
            font-size: 1.1rem;
            border: 2px solid #ddd;
            transition: all 0.3s ease-in-out;
        }

        .form-group input:focus {
            border-color: #2575fc;
            box-shadow: 0 0 10px rgba(37, 117, 252, 0.5);
        }

        .btn-primary {
            background-color: #2575fc;
            border-color: #2575fc;
            padding: 12px;
            border-radius: 12px;
            font-size: 1.1rem;
            width: 100%;
            transition: all 0.3s ease-in-out;
        }

        .btn-primary:hover {
            background-color: #6a11cb;
            border-color: #6a11cb;
        }

        .btn-danger {

            border-color: #ddd;
            padding: 12px;
            border-radius: 12px;
            font-size: 1.1rem;
            width: 100%;
            margin-top: 15px;
            transition: all 0.3s ease-in-out;
        }

        .btn-secondary:hover {
            background-color: #aaa;
            border-color: #aaa;
        }

        .error-message {
            color: #ff4d4d;
            font-size: 14px;
            text-align: center;
            margin-bottom: 20px;
        }

        @keyframes fadeIn {
            0% {
                opacity: 0;
                transform: translateY(-50px);
            }

            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @media (max-width: 768px) {
            .login-container {
                padding: 30px;
            }

            .login-container h2 {
                font-size: 1.8rem;
            }

            .form-group input {
                font-size: 1rem;
                padding: 10px;
            }

            .btn-primary,
            .btn-secondary {
                font-size: 1rem;
                padding: 10px;
            }
        }
    </style>
</head>

<body>

    <div class="login-container">
        <h2>Manager Login</h2>
        <?php if (isset($error)): ?>
            <div class="error-message"><?php echo $error; ?></div>
        <?php endif; ?>
        <form action="login.php" method="POST">
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" class="form-control" id="username" name="username" required placeholder="Enter your username">
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" class="form-control" id="password" name="password" required placeholder="Enter your password">
            </div>
            <div class="form-group text-center">
                <button type="submit" class="btn btn-primary btn-block">Login</button>
            </div>
        </form>

        <div class="form-group text-center">
            <button type="button" class="btn btn-danger" onclick="window.location.href='index.php'">Back to Home</button>
        </div>
    </div>

</body>

</html>