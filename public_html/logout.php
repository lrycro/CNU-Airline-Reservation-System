<?php
session_start();
session_unset(); // 모든 세션 변수 제거
session_destroy(); // 세션 자체 제거

header("Location: index.php"); // 메인으로 리디렉션
exit;
?>