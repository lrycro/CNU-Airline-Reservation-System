<?php
session_start();
include('../config/db_connect.php');

// 로그인 처리 로직
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $cno = trim($_POST['cno']);
  $passwd = trim($_POST['passwd']);

  $sql = "SELECT * FROM CUSTOMER WHERE cno = :cno AND passwd = :passwd";
  $stmt = oci_parse($conn, $sql);
  oci_bind_by_name($stmt, ":cno", $cno);
  oci_bind_by_name($stmt, ":passwd", $passwd);
  oci_execute($stmt);

  $row = oci_fetch_assoc($stmt);

  if ($row) {
    $_SESSION['cno'] = $row['CNO'];
    $_SESSION['name'] = $row['NAME'];  // 선택
    header("Location: index.php");
    exit;
  } else {
    $error = "로그인 정보가 올바르지 않습니다.";
  }

  oci_free_statement($stmt);
  oci_close($conn);
}
?>

<!DOCTYPE html>
<html lang="ko">
<?php include('./components/head.php'); ?>
<body class="h-full flex flex-col bg-gray-50" style="font-family: 'Noto Sans KR', sans-serif;">
  <?php include('./components/header.php'); ?>

  <div class="max-w-md mx-auto mt-16 p-6 border rounded shadow bg-white">
    <h2 class="text-xl font-semibold mb-4">🔐 로그인</h2>

    <?php if (isset($error)): ?>
      <div class="text-red-600 mb-4 text-sm"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form method="POST" action="login.php" class="space-y-4">
      <div>
        <label class="block mb-1 text-sm">회원번호</label>
        <input type="text" name="cno" class="w-full border px-3 py-2 rounded" required>
      </div>
      <div>
        <label class="block mb-1 text-sm">비밀번호</label>
        <input type="password" name="passwd" class="w-full border px-3 py-2 rounded" required>
      </div>
      <button type="submit" class="w-full bg-blue-500 hover:bg-blue-600 text-white py-2 rounded">로그인</button>
    </form>
  </div>

  <?php include('./components/footer.php'); ?>
</body>
</html>