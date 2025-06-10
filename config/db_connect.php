<?php
// Oracle DB 접속 정보
$db_user = ""; // TODO: your username
$db_pass = ""; // TODO: your password
$db_conn = "localhost/XE"; 

$conn = oci_connect($db_user, $db_pass, $db_conn, 'AL32UTF8');

if (!$conn) {
    $e = oci_error();
    echo "<h3>❌ Oracle 연결 실패</h3>";
    echo htmlentities($e['message']);
    exit;
} else {
    // 테스트 출력 (실제 운영에서는 생략 가능)
    // echo "<h3>✅ Oracle 연결 성공</h3>";
}
?>