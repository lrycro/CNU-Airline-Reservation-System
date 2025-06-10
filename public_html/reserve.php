<?php
session_start();
include('../config/db_connect.php');

if (!isset($_SESSION['cno'])) {
    echo "<script>alert('로그인이 필요합니다'); location.href='login.php';</script>";
    exit;
}

$cno = $_SESSION['cno'];

$required = ['flightNo', 'departureDateTime', 'seatClass', 'payment'];
foreach ($required as $key) {
    if (!isset($_POST[$key])) {
        die("❌ 필수 정보 누락: $key");
    }
}

$airline = $_POST['airline'];
$flightNo = $_POST['flightNo'];
$departureAirport = $_POST['departureAirport'];
$departureDateTime = $_POST['departureDateTime'];
$arrivalAirport = $_POST['arrivalAirport'];
$arrivalDateTime = $_POST['arrivalDateTime'];
$seatClass = $_POST['seatClass'];
$payment = $_POST['payment'];

// 중복 예약 확인
$dup_sql = "SELECT COUNT(*) cnt FROM RESERVE 
            WHERE flightNo = :f 
              AND departureDateTime = TO_DATE(:d, 'YYYY-MM-DD HH24:MI:SS') 
              AND seatClass = :s 
              AND cno = :c";
$dup_stmt = oci_parse($conn, $dup_sql);
oci_bind_by_name($dup_stmt, ":f", $flightNo);
oci_bind_by_name($dup_stmt, ":d", $departureDateTime);
oci_bind_by_name($dup_stmt, ":s", $seatClass);
oci_bind_by_name($dup_stmt, ":c", $cno);
oci_execute($dup_stmt);
$row = oci_fetch_assoc($dup_stmt);
if ($row['CNT'] > 0) {
    echo "<script>alert('이미 예약된 항공편입니다.'); history.back();</script>";
    exit;
}

// 좌석 감소
$update_sql = "UPDATE SEATS SET no_of_seats = no_of_seats - 1 
               WHERE flightNo = :f AND departureDateTime = TO_DATE(:d, 'YYYY-MM-DD HH24:MI:SS') AND seatClass = :s";
$update_stmt = oci_parse($conn, $update_sql);
oci_bind_by_name($update_stmt, ":f", $flightNo);
oci_bind_by_name($update_stmt, ":d", $departureDateTime);
oci_bind_by_name($update_stmt, ":s", $seatClass);
oci_execute($update_stmt);

// 예약 삽입
$insert_sql = "INSERT INTO RESERVE (flightNo, departureDateTime, seatClass, payment, reserveDateTime, cno)
               VALUES (:f, TO_DATE(:d, 'YYYY-MM-DD HH24:MI:SS'), :s, :p, SYSTIMESTAMP AT TIME ZONE 'Asia/Seoul', :c)";
$insert_stmt = oci_parse($conn, $insert_sql);
oci_bind_by_name($insert_stmt, ":f", $flightNo);
oci_bind_by_name($insert_stmt, ":d", $departureDateTime);
oci_bind_by_name($insert_stmt, ":s", $seatClass);
oci_bind_by_name($insert_stmt, ":p", $payment);
oci_bind_by_name($insert_stmt, ":c", $cno);
oci_execute($insert_stmt);

$_SESSION['last_reserve'] = [
    'airline' => $airline,
    'flightNo' => $flightNo,
    'departureAirport' => $departureAirport,
    'departureDateTime' => $departureDateTime,
    'arrivalAirport' => $arrivalAirport,
    'arrivalDateTime' => $arrivalDateTime,
    'seatClass' => $seatClass,
    'payment' => $payment
];

// 이메일 전송 페이지로 이동
$query = http_build_query([
    'flightNo' => $flightNo,
    'departureDateTime' => $departureDateTime,
    'seatClass' => $seatClass
]);
header("Location: email.php?$query");
exit;