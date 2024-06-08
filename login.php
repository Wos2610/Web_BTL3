<?php
    session_start();

    // Mảng giả lập dữ liệu người dùng
    $users = [
        'admin' => 'admin',
    ];

    $errorMessage = "";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $user = $_POST['username'];
        $pass = $_POST['password'];

        if (isset($users[$user]) && $users[$user] === $pass) {
            $_SESSION['loggedin'] = true;
            $_SESSION['username'] = $user;

            header("Location: index.php");
            exit;
        } else {
            $errorMessage = "Tên đăng nhập hoặc mật khẩu không đúng";
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
    <head>

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <meta name="author" content="">

        <title>Quản Lý Sinh Viên</title>

        <link
            href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
            rel="stylesheet">

        <link href="css/bootstrap.min.css" rel="stylesheet">
        <link href="css/style.css" rel="stylesheet">

    </head>

    <body id="page-top">

        <?php
            if (!empty($errorMessage)) {
                echo "
                <div class='alert alert-warning alert-dismissable fade show' role='alert'>
                    <strong>$errorMessage</strong>
                    <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                </div>
                ";
            }
        ?>

        <div class="container d-flex align-items-center justify-content-center min-vh-100">
            <div class="card w-100" style="max-width: 600px;">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary text-center">Đăng Nhập</h6>
                </div>
                <div class="card-body">
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
                        <div class="form-group mb-3">
                            <label for="username" class="fw-bold">Tên Đăng Nhập<sup>*</sup></label>
                            <input type="text" class="form-control" id="username" name="username" required>
                        </div>

                        <div class="form-group mb-3">
                            <label for="password" class="fw-bold">Mật Khẩu<sup>*</sup></label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>

                        <div class="text-center">
                            <button type="submit" class="btn btn-primary w-100">Đăng Nhập</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <script src="js/bootstrap.bundle.min.js"></script>
    </body>
</html>
