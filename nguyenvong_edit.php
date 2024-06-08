<?php
    include "session_check.php";
    include "database_connection.php";
   
    $submitted = "no";

    $id = $idSVErr = $idCTErr = $thuTuErr = "";
    $idSV = $idCT = $thuTu = "";

    if($_SERVER["REQUEST_METHOD"] == "GET"){
        if(isset($_GET["id"])){
            $id = $_GET["id"];
            $sql = "SELECT * FROM nguyenvong WHERE id = '$id'";
            $result = $connection->query($sql);
            
            if ($result) {
                $row = $result->fetch_assoc();
                $idSV = $row["idSinhVien"];
                $idCT = $row["idCongTy"];
                $thuTu = $row["thuTu"];
            } else {
                die("Query failed: " . $connection->error);
            }
        }
        else{
            header("Location: nguyenvong_view.php");
            exit();
        }
    }
    
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (empty($_POST["id"])) {
            $submitted = "false";
        } else {
            $id = $_POST["id"];
        }

        if (empty($_POST["idSV"])) {
            $idSVErr = "* ID sinh viên là bắt buộc";
            $submitted = "false";
        } else {
            $idSV = $_POST["idSV"];
            if (!ctype_digit($idSV)) {
                $idSVErr = "* ID sinh viên chỉ bao gồm chữ số";
                $submitted = "false";
            } else {
                $sql = "SELECT id FROM sinhvien WHERE id = '$idSV'";
                $result = $connection->query($sql);
                if ($result->num_rows <= 0) {
                    $idSVErr = "* ID sinh viên không tồn tại";
                    $submitted = "false";
                }
                $result->free(); 
            }
        }

        if (empty($_POST["idCT"])) {
            $idCTErr = "* ID công ty là bắt buộc";
            $submitted = "false";
        } else {
            $idCT = $_POST["idCT"];
            if (!ctype_digit($idCT)) {
                $idCTErr = "* ID công ty chỉ bao gồm chữ số";
                $submitted = "false";
            } else {
                $sql = "SELECT id FROM congty WHERE id = '$idCT'";
                $result = $connection->query($sql);
                if ($result->num_rows <= 0) {
                    $idCTErr = "* ID công ty không tồn tại";
                    $submitted = "false";
                }
                $result->free();  
            }
        }

        if (empty($_POST["thuTu"])) {
            $submitted = "false";
        } else {
            $thuTu = $_POST["thuTu"];
        }

        if ($submitted === "no") {
            $submitted = "true";
    
            $sql = "UPDATE nguyenvong SET idSinhVien = '$idSV', idCongTy = '$idCT', thuTu = '$thuTu' WHERE id = '$id'";
            $result = $connection->query($sql);
            if ($result) {
                header("Location: nguyenvong_view.php");
                exit();
            } else {
                die("Query failed: " . $conn->error);
            }

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
    <div id="wrapper">
        <?php include 'sidebar.php'; ?>
        <div class="container-fluid">
            <div class="card mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary text-center">Chỉnh Sửa Nguyện Vọng</h6>
                </div>
                <div class="card-body d-flex flex-column justify-content-center align-items-center">
                    <form method="post">
                        <input type="hidden" value="<?php echo $id; ?>" name="id">
                        <div class="col-md-12 col-lg-12 col-xl-12">
                            <div class="row my-3">
                                <div class="col-md-12 col-lg-6">
                                    <div class="form-group w-100">
                                        <label for="idSV" class="fw-bold">ID Sinh Viên<sup>*</sup></label>
                                        <input type="text" class="form-control" id="idSV" aria-describedby="idSVHelp" placeholder="Nhập ID sinh viên của bạn" name="idSV" value = "<?php echo $idSV; ?>" readonly>
                                        <small id="idSVHelp" class="form-text text-muted">ID sinh viên chỉ bao gồm kí tự số.</small>
                                        <span class="error"><?php echo $idSVErr;?></span>
                                    </div>
                                </div>
                                <div class="col-md-12 col-lg-6">
                                    <div class="form-group w-100">
                                        <label for="idCT" class="fw-bold">ID Công Ty<sup>*</sup></label>
                                        <input type="text" class="form-control" id="idCT" aria-describedby="idCTHelp" placeholder="Nhập ID công ty của bạn" name="idCT" value = "<?php echo $idCT; ?>">
                                        <small id="idCTHelp" class="form-text text-muted">ID công ty chỉ bao gồm kí tự số.</small>
                                        <span class="error"><?php echo $idCTErr;?></span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group w-100 mt-3">
                                <label for="thuTu" class="fw-bold">Thứ Tự Nguyện Vọng<sup>*</sup></label>
                                <input type="text" class="form-control" id="thuTu" placeholder="Nhập thứ tự nguyện vọng của bạn" name="thuTu" value = "<?php echo $thuTu; ?>" readonly>
                                <small id="idCTHelp" class="form-text text-muted">Thứ tự nguyện vọng từ từ 1 đến 3</small>
                            </div>
                            
                            <div class="row g-4 text-center align-items-center justify-content-center pt-4">
                                <button type="submit" class="btn border-secondary py-3 px-4 text-uppercase w-100 text-primary">Cập Nhật</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

</html>