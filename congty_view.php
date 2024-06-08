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
    <div id="wrapper">

        <?php include 'sidebar.php'; ?>

        <div class="container-fluid">
            <div class="card mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary text-center">Danh Sách Các Công Ty</h6>
                </div>
                <a class='ml-4 mt-4 col-2 btn btn-primary btn-sm' href='congty_create.php'>Thêm Công Ty</a>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th class='text-center'>ID</th>
                                    <th class='text-center'>Tên</th>
                                    <th class='text-center'>Chỉ tiêu</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                include "database_connection.php";

                                $sql = "SELECT * FROM congty";
                                $result = $connection->query($sql);
                                if (!$result) {
                                    die("Invalid query: " . $connection->error);
                                }

                                while ($row = $result->fetch_assoc()) {
                                    echo "
                                    <tr>
                                        <td class='text-center'>$row[id]</td>
                                        <td class='text-center'>$row[ten]</td>
                                        <td class='text-center'>$row[chiTieu]</td>
                                        <td class='text-center'>
                                            <a class='btn btn-primary btn-sm' href='congty_edit.php?id=$row[id]'>Sửa</a>
                                            
                                        </td>
                                        <td class='text-center'>
                                            
                                            <a class='btn btn-danger btn-sm' href='congty_delete.php?id=$row[id]'>Xóa</a>
                                        </td>
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
    <script src="js/sb-admin-2.min.js"></script>
</body>

</html>