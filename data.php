<?php
    include "database_connection.php";
    // Truy vấn SQL để lấy dữ liệu sinh viên và GPA
    $sql = "SELECT ten, gpa FROM SinhVien";
    $result = $connection->query($sql);

    // Khởi tạo các biến đếm cho từng khoảng GPA
    $excellentCount = 0;
    $goodCount = 0;
    $averageCount = 0;
    $fairCount = 0;
    $weakCount = 0;
    $poorCount = 0;

    // Duyệt qua kết quả của truy vấn và tính số lượng sinh viên trong từng khoảng GPA
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $gpa = $row["gpa"];
            if ($gpa >= 3.6 && $gpa <= 4.0) {
                $excellentCount++;
            } elseif ($gpa >= 3.2 && $gpa < 3.6) {
                $goodCount++;
            } elseif ($gpa >= 2.5 && $gpa < 3.2) {
                $averageCount++;
            } elseif ($gpa >= 2.0 && $gpa < 2.5) {
                $fairCount++;
            } elseif ($gpa >= 1.0 && $gpa < 2.0) {
                $weakCount++;
            } elseif ($gpa < 1.0) {
                $poorCount++;
            }
        }
    }

    // Dữ liệu cho biểu đồ cột
    $barChartData = [
        "Xuất sắc (>= 3.6)" => $excellentCount,
        "Giỏi (>= 3.2 & < 3.6)" => $goodCount,
        "Khá (>= 2.5 & < 3.2)" => $averageCount,
        "Trung bình (>= 2.0 & < 2.5)" => $fairCount,
        "Yếu (>= 1.0 & < 2.0)" => $weakCount,
        "Kém (< 1.0)" => $poorCount
    ];

    // Đảo ngược thứ tự của mảng
    $reversedChartData = array_reverse($barChartData, true);

    // Trả về dữ liệu dưới dạng JSON
    header('Content-Type: application/json');
    echo json_encode($reversedChartData);

    // Đóng kết nối
    $connection->close();
?>
