<?php
session_start();
include('../config/db_connect.php');
?>
<!DOCTYPE html>
<html lang="ko" class="h-full">
<?php include('./components/head.php'); ?>
<body class="h-full flex flex-col bg-gray-50" style="font-family: 'Noto Sans KR', sans-serif;">
<?php include('./components/header.php'); ?>
<div class="flex flex-1 h-full min-h-0">
  <?php include('./components/sidebar.php'); ?>

  <main class="flex-1 p-10 overflow-auto">
    <h1 class="text-2xl font-bold mb-6">👑 고객별 결제 순위</h1>
    <div class="bg-white shadow rounded-xl p-6">
      <table class="w-full text-sm text-center border-collapse">
        <thead>
          <tr class="bg-gray-100 text-gray-700">
            <th class="border px-4 py-2">순위</th>
            <th class="border px-4 py-2">고객 번호</th>
            <th class="border px-4 py-2">이름</th>
            <th class="border px-4 py-2">총 결제 금액</th>
          </tr>
        </thead>
        <tbody>
        <?php
        $sql = "
          SELECT
              c.cno,
              c.name,
              SUM(r.payment) AS total_payment,
              RANK() OVER (ORDER BY SUM(r.payment) DESC) AS payment_rank
          FROM RESERVE r
          JOIN CUSTOMER c ON r.cno = c.cno
          GROUP BY c.cno, c.name
          ORDER BY payment_rank";

        $stmt = oci_parse($conn, $sql);
        oci_execute($stmt);

        while ($row = oci_fetch_assoc($stmt)) {
            echo "<tr class='hover:bg-gray-50 transition'>";
            echo "<td class='border px-4 py-2'>" . htmlspecialchars($row['PAYMENT_RANK']) . "</td>";
            echo "<td class='border px-4 py-2'>" . htmlspecialchars($row['CNO']) . "</td>";
            echo "<td class='border px-4 py-2'>" . htmlspecialchars($row['NAME']) . "</td>";
            echo "<td class='border px-4 py-2'>" . number_format($row['TOTAL_PAYMENT']) . "원</td>";
            echo "</tr>";
        }

        oci_free_statement($stmt);
        ?>
        </tbody>
      </table>
    </div>
  </main>
</div>
<?php include('./components/footer.php'); ?>
</body>
</html>