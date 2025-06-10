<?php
session_start();
include('../config/db_connect.php');

if (!isset($_SESSION['cno'])) {
    echo "<script>alert('로그인이 필요합니다.'); location.href='login.php';</script>";
    exit;
}

$cno = $_SESSION['cno'];
$flightNo = $_POST['flightNo'] ?? '';
$departureDateTime = $_POST['departureDateTime'] ?? '';
$seatClass = $_POST['seatClass'] ?? '';

if (!$flightNo || !$departureDateTime || !$seatClass) {
    echo "<script>alert('취소할 항공편 정보가 부족합니다.'); history.back();</script>";
    exit;
}

// 예약 정보 확인
$sql = "SELECT payment FROM RESERVE 
        WHERE flightNo = :f 
          AND departureDateTime = TO_DATE(:d, 'YYYY-MM-DD HH24:MI:SS') 
          AND seatClass = :s 
          AND cno = :c";
$stmt = oci_parse($conn, $sql);
oci_bind_by_name($stmt, ":f", $flightNo);
oci_bind_by_name($stmt, ":d", $departureDateTime);
oci_bind_by_name($stmt, ":s", $seatClass);
oci_bind_by_name($stmt, ":c", $cno);
oci_execute($stmt);
$row = oci_fetch_assoc($stmt);

if (!$row) {
    echo "<script>alert('해당 예약 내역이 존재하지 않습니다.'); history.back();</script>";
    exit;
}

$payment = (int)$row['PAYMENT'];

// 위약금 계산
$today = new DateTime();
$departure = DateTime::createFromFormat('Y-m-d H:i:s', $departureDateTime);
$interval = $today->diff($departure);
$daysBefore = (int)$interval->format('%r%a'); // 음수 가능성도 있음

if ($daysBefore >= 15) {
    $penalty = 150000;
} elseif ($daysBefore >= 4) {
    $penalty = 180000;
} elseif ($daysBefore >= 1) {
    $penalty = 250000;
} else {
    $penalty = $payment; // 당일 취소 시 전액
}

$refund = max($payment - $penalty, 0);

// 1. CANCEL 테이블에 INSERT
$cancelSql = "INSERT INTO CANCEL 
              (flightNo, departureDateTime, seatClass, refund, cancelDateTime, cno)
              VALUES (:f, TO_DATE(:d, 'YYYY-MM-DD HH24:MI:SS'), :s, :r, SYSTIMESTAMP, :c)";
$cancelStmt = oci_parse($conn, $cancelSql);
oci_bind_by_name($cancelStmt, ":f", $flightNo);
oci_bind_by_name($cancelStmt, ":d", $departureDateTime);
oci_bind_by_name($cancelStmt, ":s", $seatClass);
oci_bind_by_name($cancelStmt, ":r", $refund);
oci_bind_by_name($cancelStmt, ":c", $cno);
oci_execute($cancelStmt);

// 2. RESERVE 테이블에서 삭제
$deleteSql = "DELETE FROM RESERVE 
              WHERE flightNo = :f AND departureDateTime = TO_DATE(:d, 'YYYY-MM-DD HH24:MI:SS') 
                AND seatClass = :s AND cno = :c";
$deleteStmt = oci_parse($conn, $deleteSql);
oci_bind_by_name($deleteStmt, ":f", $flightNo);
oci_bind_by_name($deleteStmt, ":d", $departureDateTime);
oci_bind_by_name($deleteStmt, ":s", $seatClass);
oci_bind_by_name($deleteStmt, ":c", $cno);
oci_execute($deleteStmt);

// 3. 좌석 수 복구
$updateSql = "UPDATE SEATS 
              SET no_of_seats = no_of_seats + 1 
              WHERE flightNo = :f AND departureDateTime = TO_DATE(:d, 'YYYY-MM-DD HH24:MI:SS') 
                AND seatClass = :s";
$updateStmt = oci_parse($conn, $updateSql);
oci_bind_by_name($updateStmt, ":f", $flightNo);
oci_bind_by_name($updateStmt, ":d", $departureDateTime);
oci_bind_by_name($updateStmt, ":s", $seatClass);
oci_execute($updateStmt);

oci_free_statement($stmt);
oci_free_statement($cancelStmt);
oci_free_statement($deleteStmt);
oci_free_statement($updateStmt);
oci_close($conn);

echo "<script>alert('항공권이 성공적으로 취소되었고, 환불 금액은 " . number_format($refund) . "원입니다.'); location.href='mypage.php';</script>";
exit;
?>