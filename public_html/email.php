<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../vendor/autoload.php';
session_start();

if (!isset($_SESSION['cno']) || !isset($_SESSION['last_reserve'])) {
    exit('예약 정보가 없습니다.');
}

include('../config/db_connect.php');

$cno = $_SESSION['cno'];
$reserve = $_SESSION['last_reserve'];

$sql = "SELECT email, name FROM CUSTOMER WHERE cno = :cno";
$stmt = oci_parse($conn, $sql);
oci_bind_by_name($stmt, ":cno", $cno);
oci_execute($stmt);
$row = oci_fetch_assoc($stmt);

$email = $row['EMAIL'];
$name = $row['NAME'];

$flight_sql = "
SELECT A.airline, A.departureAirport, A.arrivalAirport,
       TO_CHAR(A.departureDateTime, 'YYYY-MM-DD HH24:MI:SS') AS departureTime,
       TO_CHAR(A.arrivalDateTime, 'YYYY-MM-DD HH24:MI:SS') AS arrivalTime
FROM AIRPLANE A
WHERE A.flightNo = :f AND A.departureDateTime = TO_DATE(:d, 'YYYY-MM-DD HH24:MI:SS')
";
$flight_stmt = oci_parse($conn, $flight_sql);
oci_bind_by_name($flight_stmt, ":f", $reserve['flightNo']);
oci_bind_by_name($flight_stmt, ":d", $reserve['departureDateTime']);
oci_execute($flight_stmt);
$flight_info = oci_fetch_assoc($flight_stmt);

$mail = new PHPMailer(true);
$mail->CharSet = 'UTF-8';
$mail->Encoding = 'base64';
try {
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com'; // 예시: smtp.naver.com, smtp.gmail.com
    $mail->SMTPAuth = true;
    $mail->Username = 'username@gmail.com'; // TODO : 발신자 이메일 주소 입력
    $mail->Password = ''; // TODO: Google 앱 비밀번호 16자리 발급 후 입력
    $mail->SMTPSecure = 'tls';
    $mail->Port = 587;

    $mail->setFrom('username@gmail.com', 'CNU Airline'); // TODO : 발신자 이메일 주소 입력
    $mail->addAddress($email, $name);

    $mail->isHTML(true);
    $mail->Subject = '✈️ CNU Airline 탑승권 안내';
    $mail->Body = "
        <div style='font-family: \"Noto Sans KR\", sans-serif; max-width: 600px; margin: 0 auto; padding: 20px; border: 1px solid #ddd; border-radius: 10px;'>
        <h2 style='color: #1d4ed8;'>✈️ CNU Airline 탑승권</h2>
        <p><strong>{$name}</strong>님, 예약이 성공적으로 완료되었습니다.</p>
        <hr style='margin: 20px 0;'>
        
        <table style='width: 100%; border-collapse: collapse; font-size: 14px;'>
            <tr>
            <td style='padding: 8px; font-weight: bold; width: 30%; background-color: #f9fafb;'>항공사</td>
            <td style='padding: 8px;'>{$flight_info['AIRLINE']}</td>
            </tr>
            <tr>
            <td style='padding: 8px; font-weight: bold; background-color: #f9fafb;'>항공편명</td>
            <td style='padding: 8px;'>{$reserve['flightNo']}</td>
            </tr>
            <tr>
            <td style='padding: 8px; font-weight: bold; background-color: #f9fafb;'>출발 공항</td>
            <td style='padding: 8px;'>{$flight_info['DEPARTUREAIRPORT']}</td>
            </tr>
            <tr>
            <td style='padding: 8px; font-weight: bold; background-color: #f9fafb;'>출발 일시</td>
            <td style='padding: 8px;'>{$flight_info['DEPARTURETIME']}</td>
            </tr>
            <tr>
            <td style='padding: 8px; font-weight: bold; background-color: #f9fafb;'>도착 공항</td>
            <td style='padding: 8px;'>{$flight_info['ARRIVALAIRPORT']}</td>
            </tr>
            <tr>
            <td style='padding: 8px; font-weight: bold; background-color: #f9fafb;'>도착 일시</td>
            <td style='padding: 8px;'>{$flight_info['ARRIVALTIME']}</td>
            </tr>
            <tr>
            <td style='padding: 8px; font-weight: bold; background-color: #f9fafb;'>좌석 등급</td>
            <td style='padding: 8px;'>{$reserve['seatClass']}</td>
            </tr>
            <tr>
            <td style='padding: 8px; font-weight: bold; background-color: #f9fafb;'>결제 금액</td>
            <td style='padding: 8px;'>" . number_format($reserve['payment']) . "원</td>
            </tr>
        </table>

        <hr style='margin: 20px 0;'>
        <p style='font-size: 14px; color: #555;'>즐거운 여행 되시길 바랍니다! <br>감사합니다. 😊</p>
        <p style='font-size: 12px; color: #999;'>본 이메일은 자동으로 발송되었습니다.</p>
        </div>
    ";

    $mail->send();
    unset($_SESSION['last_reserve']);

    // ✅ JavaScript로 안내 후 마이페이지로 이동
    echo "<script>
        alert('✅ 탑승권 예약 및 이메일 전송이 완료되었습니다.');
        location.href = 'mypage.php';
    </script>";
} catch (Exception $e) {
    echo "❌ 이메일 전송 실패: {$mail->ErrorInfo}";
}
?>