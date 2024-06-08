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

    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">

</head>

<body id="page-top">
    <div id="wrapper">

        <?php include 'sidebar.php'; ?>
        <div class="container-fluid">
            <div class="card mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary text-center">Danh Sách Các Nguyện Vọng</h6>
                </div>
                <a class='ml-4 mt-4 col-2 btn btn-primary btn-sm' href='nguyenvong_create.php'>Thêm Nguyện Vọng</a>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th class='text-center'>ID</th>
                                    <th class='text-center'>Tên Sinh Viên</th>
                                    <th class='text-center'>ID Công Ty</th>
                                    <th class='text-center'>Tên Công Ty</th>
                                    <th class='text-center'>Thứ Tự Nguyện Vọng</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    // Adjusting the column names using aliases to avoid conflicts
                                    $sql = "SELECT 
                                                nguyenvong.id, 
                                                sinhvien.ten AS tenSinhVien, 
                                                congty.id AS idCongTy,
                                                congty.ten AS tenCongTy, 
                                                nguyenvong.thuTu 
                                            FROM nguyenvong
                                            JOIN sinhvien ON nguyenvong.idSinhVien = sinhvien.id
                                            JOIN congty ON nguyenvong.idCongTy = congty.id
                                            ORDER BY nguyenvong.id ASC";

                                    $result = $connection->query($sql);

                                    if(!$result){
                                        die("Query failed: " . $connection->error);
                                    }

                                    while($row = $result->fetch_assoc()){
                                        echo "<tr>";
                                        echo "<td class='text-center'>" . $row['id'] . "</td>";
                                        echo "<td >" . $row['tenSinhVien'] . "</td>";
                                        echo "<td class='text-center'>" . $row['idCongTy'] . "</td>";
                                        echo "<td class='text-center'>" . $row['tenCongTy'] . "</td>";
                                        echo "<td class='text-center'>" . $row['thuTu'] . "</td>";
                                        echo "<td class='text-center'><a class='btn btn-primary' href='nguyenvong_edit.php?id=" . $row['id'] . "'>Sửa</a></td>"; // Gửi ID khi nhấp vào nút "Sửa"
                                        echo "<td class='text-center'><a class='btn btn-danger' href='nguyenvong_delete.php?id=" . $row['id'] . "'>Xóa</a></td>"; // Gửi ID khi nhấp vào nút "Xóa"
                                        echo "</tr>";
                                    }

                                    $connection->close();
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>