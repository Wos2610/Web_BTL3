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
            <div class="d-sm-flex align-items-center justify-content-between mb-4 mt-4">
                <h1 class="h4 mb-0 text-gray-800">Top 3 Sinh Viên GPA Cao Nhất</h1>
            </div>

            <div class="row">

                <?php            
                    $sql = "SELECT * FROM SinhVien ORDER BY gpa DESC LIMIT 3";

                    $result = $connection->query($sql);

                    if(!$result){
                        die("Query failed: " . $connection->error);
                    }

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<div class='col-xl-4 col-md-4 mb-4'>";
                            echo "<div class='card border-secondary h-100 py-2'>";
                            echo "<div class='card-body'>";
                            echo "<div class='row no-gutters align-items-center'>";
                            echo "<div class='col-auto'>";
                            echo "<img src='" . $row['photo'] . "' alt='Student Photo' class='img-fluid student-photo' style='width: 80px; height: 80px;'>";
                            echo "</div>";
                            echo "<div class='col mx-3'>";
                            echo "<div class='text-xs font-weight-bold text-primary text-uppercase mb-1'>Tên Sinh Viên</div>";
                            echo "<div class='h6 mb-0 font-weight-bold text-gray-800'>" . $row['ten'] . "</div>";
                            echo "<div class='text-xs font-weight-bold text-primary text-uppercase mb-1 mt-1'>GPA</div>";
                            echo "<div class='h6 mb-0 font-weight-bold text-gray-800'>" . $row['gpa'] . "</div>";
                            echo "</div>";
                            echo "</div>";
                            echo "</div>";
                            echo "</div>";
                            echo "</div>";
                        }
                    } else {
                        echo "Không có sinh viên nào.";
                    }
                    
                ?>
            </div>

            <div class="d-sm-flex align-items-center justify-content-between mb-4 mt-4">
                <h1 class="h4 mb-0 text-gray-800">Top 3 Sinh Viên Điểm Rèn Luyện Cao Nhất</h1>
            </div>

            <div class="row">

                <?php            
                    $sql = "SELECT * FROM SinhVien ORDER BY diemRenLuyen DESC LIMIT 3";

                    $result = $connection->query($sql);

                    if(!$result){
                        die("Query failed: " . $connection->error);
                    }

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<div class='col-xl-4 col-md-4 mb-4'>";
                            echo "<div class='card border-secondary h-100'>";
                            echo "<div class='card-body'>";
                            echo "<div class='row no-gutters align-items-center'>";
                            echo "<div class='col-auto'>";
                            echo "<img src='" . $row['photo'] . "' alt='Student Photo' class='img-fluid student-photo' style='width: 80px; height: 80px;'>";
                            echo "</div>";
                            echo "<div class='col mx-3'>";
                            echo "<div class='text-xs font-weight-bold text-primary text-uppercase mb-1'>Tên Sinh Viên</div>";
                            echo "<div class='h6 mb-0 font-weight-bold text-gray-800'>" . $row['ten'] . "</div>";
                            echo "<div class='text-xs font-weight-bold text-primary text-uppercase mb-1 mt-1'>GPA</div>";
                            echo "<div class='h6 mb-0 font-weight-bold text-gray-800'>" . $row['diemRenLuyen'] . "</div>";
                            echo "</div>";
                            echo "</div>";
                            echo "</div>";
                            echo "</div>";
                            echo "</div>";
                        }
                    } else {
                        echo "Không có sinh viên nào.";
                    }
                    $connection->close();
                ?>
            </div>
        </div>
    </div>
    <script src="js/sb-admin-2.min.js"></script>
</body>

</html>