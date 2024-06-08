<?php
    include "database_connection.php";

    $errorMessage = "";
    // Lấy danh sách sinh viên đã sắp xếp theo GPA giảm dần
    $sinhVienSql = "SELECT * FROM sinhvien ORDER BY GPA DESC";
    $sinhVienResult = $connection->query($sinhVienSql);

    if ($sinhVienResult->num_rows > 0) {
        // Duyệt qua danh sách sinh viên
        while ($sinhVienRow = $sinhVienResult->fetch_assoc()) {
            $studentId = $sinhVienRow["id"];
            $studentName = $sinhVienRow["ten"];
            $studentGpa = $sinhVienRow["gpa"];
            $accepted = false; // Flag to check if student has been accepted
            
            // echo "Sinh viên: $studentName (ID: $studentId, GPA: $studentGpa)<br>";
    
            // Lấy danh sách nguyện vọng của sinh viên
            $nguyenVongSql = "SELECT * FROM nguyenvong WHERE idSinhVien = $studentId ORDER BY thuTu";
            $nguyenVongResult = $connection->query($nguyenVongSql);
    
            // Duyệt qua danh sách nguyện vọng của sinh viên
            while ($nguyenVongRow = $nguyenVongResult->fetch_assoc()) {
                $thuTu = $nguyenVongRow["thuTu"];
                $congTyId = $nguyenVongRow["idCongTy"];
    
                // Kiểm tra xem công ty còn slot trống không
                $congTySql = "SELECT chiTieu FROM congty WHERE id = $congTyId";
                $congTyResult = $connection->query($congTySql);
                $congTyRow = $congTyResult->fetch_assoc();
                $chiTieu = $congTyRow["chiTieu"];
    
                // echo " - Nguyện vọng thứ tự: $thuTu, ID công ty: $congTyId, Chỉ tiêu: $chiTieu<br>";
                
                if ($chiTieu > 0 && !$accepted) {
                    // Cập nhật trạng thái của nguyện vọng thành đã được thực tập
                    $updateSql = "UPDATE NguyenVong SET trangThai = 1 WHERE idSinhVien = $studentId AND idCongTy = $congTyId AND thuTu = $thuTu";
                    $connection->query($updateSql);
    
                    // Giảm số lượng slot của công ty
                    $chiTieu--;
                    $updateSlotSql = "UPDATE CongTy SET chiTieu = $chiTieu WHERE id = $congTyId";
                    $connection->query($updateSlotSql);
    
                    // Hiển thị thông báo
                    // echo " - Đã được thực tập tại công ty có ID: $congTyId (Thứ tự: $thuTu)<br>";
    
                    // Đã tìm được slot trống và sinh viên đã được chấp nhận
                    $accepted = true;
                }
                
            }
    
            // Kiểm tra xem sinh viên đã được thực tập chưa
            $thucTapSql = "SELECT COUNT(*) AS total FROM nguyenvong WHERE idSinhVien = $studentId AND trangThai = 1";
            $thucTapResult = $connection->query($thucTapSql);
            $thucTapRow = $thucTapResult->fetch_assoc();
            $totalThucTap = $thucTapRow["total"];
    
            if ($totalThucTap == 0) {
                // Nếu không được thực tập ở bất kỳ công ty nào, hiển thị thông báo
                // $errorMessage = $errorMessage . "Sinh viên $studentName (ID: $studentId) không được thực tập tại bất kỳ công ty nào.<br>";
            }
        }
    } else {
        echo "Không có sinh viên nào trong cơ sở dữ liệu.";
    }

    // Đóng kết nối
    $connection->close();
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
            ?> 
            <div class="card mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary text-center">Xét Nguyện Vọng Thực Tập</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th class='text-center'>Tên Sinh Viên</th>
                                    <th class='text-center'>Tên Công Ty</th>
                                    <th class='text-center'>Thứ Tự Nguyện Vọng</th>
                                    <th class='text-center'>Trạng Thái</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $servername = "localhost";
                                    $username = "root";
                                    $password = "1234";
                                    $database = "student_database";

                                    $connection = new mysqli($servername, $username, $password, $database);

                                    if($connection->connect_error){
                                        die("Connection failed: " . $connection->connect_error);
                                    }

                                    // Adjusting the column names using aliases to avoid conflicts
                                    $sql = "SELECT 
                                                nguyenvong.id, 
                                                sinhvien.id AS idSinhVien,
                                                sinhvien.ten AS tenSinhVien, 
                                                congty.ten AS tenCongTy, 
                                                nguyenvong.thuTu,
                                                nguyenvong.trangThai 
                                            FROM nguyenvong
                                            JOIN sinhvien ON nguyenvong.idSinhVien = sinhvien.id
                                            JOIN congty ON nguyenvong.idCongTy = congty.id
                                            ORDER BY LPAD(CONCAT(nguyenvong.idSinhVien, nguyenvong.thuTu), 5, '0') ASC";

                                    $result = $connection->query($sql);

                                    if(!$result){
                                        die("Query failed: " . $connection->error);
                                    }

                                    

                                    while($row = $result->fetch_assoc()){
                                        // Kiểm tra xem sinh viên đã được thực tập chưa
                                        $studentId = $row['idSinhVien'];
                                        $thucTapSql = "SELECT COUNT(*) AS total FROM nguyenvong WHERE idSinhVien = $studentId AND trangThai = 1";
                                        $thucTapResult = $connection->query($thucTapSql);
                                        $thucTapRow = $thucTapResult->fetch_assoc();
                                        $totalThucTap = $thucTapRow["total"];
                                
                                
                                        echo "<tr>"; 
                                        echo "<td class='col-3'>" . $row['tenSinhVien'] . "</td>";
                                        echo "<td class='text-center col-2'>" . $row['tenCongTy'] . "</td>";
                                        echo "<td class='text-center col-1'>" . $row['thuTu'] . "</td>";
                                        if ($row['trangThai'] != 0) {
                                            echo "<td class='text-center text-success col-2'><strong>Trúng Tuyển</strong></td>"; // Màu xanh
                                        } else {
                                            echo "<td class='text-center col-2'>Không Trúng Tuyển</td>"; // Màu đỏ
                                        }

                                        // Nếu thuTu là 3 và sinh viên không trúng tuyển bất kỳ nguyện vọng nào
                                        if ($row['thuTu'] == 3 && $totalThucTap == 0) {
                                            echo "<td class='text-center text-danger'><strong>Không trúng tuyển công ty nào</strong></td>"; // Màu đỏ, chữ đậm
                                        } else {
                                            echo "<td class='text-center'></td>";
                                        }
                                        
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

    <script src="js/sb-admin-2.min.js"></script>
    <script src="js/demo/datatables-demo.js"></script>

</body>

</html>