<?php
    include "session_check.php";

    include "database_connection.php";
    $submitted = "no";

    $ten = "";
    $chiTieu = "";

    // Check ID sinh viên
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $ten = $_POST["ten"];
        $chiTieu = $_POST["chiTieu"];

        do {
            if (empty($ten) || empty($chiTieu)) {
                $errorMessage = "Tất cả các trường là bắt buộc";
                break;
            }

            if (!ctype_digit($chiTieu)) {
                $errorMessage = "Chỉ tiêu chỉ bao gồm chữ số";
                break;
            } 

            $sql = "INSERT INTO congty (ten, chiTieu) " .
                "VALUES ('$ten', $chiTieu)";
            $result = $connection->query($sql);
            if (!$result) {
                $errorMessage = "Invalid query: " . $connection->error;
                break;
            }
            $ten = "";
            $chiTieu = "";
            $successMessage = "Công ty đã được thêm thành công";
            header("location: congty_view.php");
            exit;

        } while (false);
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
    <div id="wrapper">
        <?php include 'sidebar.php'; ?>

        <div class="container-fluid">
            <?php
                if (!empty($errorMessage)) {
                    echo "
                    <div class='alert alert-warning alert-dismissable fade show' role='alert'>
                        <strong>$errorMessage</strong>
                        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                    </div>
                    ";
                }

                if (!empty($successMessage)) {
                    echo "
                    <div class='alert alert-success alert-dismissable fade show' role='alert'>
                        <strong>$successMessage</strong>
                        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                    </div>
                    ";
                }
                
            ?>
            <div class="card mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary text-center">Thêm Công Ty Mới</h6>
                </div>
                <div class="card-body d-flex flex-column justify-content-center align-items-center">
                    <form method="post">
                        <div class="col-md-12 col-lg-12 col-xl-12">
                            <div class="row my-3">
                                <div class="form-group w-100 mt-3">
                                    <label for="ten" class="fw-bold">Tên Công Ty<sup>*</sup></label>
                                    <input type="text" class="form-control" id="ten" aria-describedby="tenHelp" placeholder="Nhập tên công ty" name="ten">
                                    <small id="tenHelp" class="form-text text-muted">Tên công ty chỉ bao gồm chữ cái và chữ số.</small>
                                </div>

                                <div class="form-group w-100 mt-3">
                                    <label for="chiTieu" class="fw-bold">Chỉ Tiêu<sup>*</sup></label>
                                    <input type="text" class="form-control" id="chiTieu" aria-describedby="chiTieuHelp" placeholder="Nhập chỉ tiêu" name="chiTieu">
                                    <small id="chiTieuHelp" class="form-text text-muted">Chỉ tiêu chỉ bao gồm kí tự số.</small>
                                </div>
                            </div>
                            
                            
                            <div class="row g-4 text-center align-items-center justify-content-center pt-4">
                                <button type="submit" class="btn border-secondary py-3 px-4 text-uppercase w-100 text-primary">Tạo</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="js/sb-admin-2.min.js"></script>

</body>

</html>