<?php
    include "database_connection.php";
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

    <!-- Custom styles for this template -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <?php include 'sidebar.php'; ?>

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">


                <!-- Begin Page Content -->
                <div class="container-fluid">
                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary text-center">Danh Sách Môn Học</h6>
                        </div>
                        
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th scope="col">Mã môn học</th>
                                            <th scope="col">Tên môn học</th>
                                            <th scope="col">Số tín chỉ</th>
                                            <th scope="col">Hệ số điểm chuyên cần</th>
                                            <th scope="col">Hệ số điểm kiểm tra</th>
                                            <th scope="col">Hệ số điểm cuối kì</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            include "database_connection.php";

                                            // Đọc tất cả hàng trong bảng SinhVien
                                            $sql = "SELECT * FROM monhoc";
                                            $result = $connection->query($sql);
                                            if (!$result) {
                                                die("Invalid query: " . $connection->error);
                                            }

                                            while ($row = $result->fetch_assoc()) {
                                                echo "
                                                <tr>
                                                    <td>$row[id]</td>
                                                    <td>$row[ten]</td>
                                                    <td>$row[tinChi]</td>
                                                    <td>$row[heSoDiemChuyenCan]</td>
                                                    <td>$row[heSoDiemKiemTra]</td>
                                                    <td>$row[heSoDiemCuoiKi]</td>
                                                
                                                </tr>
                                                ";
                                            }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>