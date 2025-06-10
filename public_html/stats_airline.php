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
    <h1 class="text-2xl font-bold mb-6">📈 항공사별 예약 통계</h1>
    <div class="bg-white shadow rounded-xl p-6">
      <table class="w-full text-sm text-center border-collapse">
        <thead>
          <tr class="bg-gray-100 text-gray-700">
            <th class="border px-4 py-2">항공사</th>
            <th class="border px-4 py-2">좌석 등급</th>
            <th class="border px-4 py-2">예약 매출</th>
            <th class="border px-4 py-2">예약 건수</th>
          </tr>
        </thead>
        <tbody>
        <?php
        $sql = "
          SELECT 
              NVL(a.airline, '총계') AS airline,
              NVL(s.seatClass, CASE WHEN a.airline IS NULL THEN NULL ELSE '소계' END) AS seatClass,
              SUM(r.payment) AS total_payment,
              COUNT(*) AS total_reservations
          FROM RESERVE r
          JOIN SEATS s 
              ON r.flightNo = s.flightNo 
              AND r.departureDateTime = s.departureDateTime 
              AND r.seatClass = s.seatClass
          JOIN AIRPLANE a 
              ON r.flightNo = a.flightNo 
              AND r.departureDateTime = a.departureDateTime
          GROUP BY ROLLUP(a.airline, s.seatClass)
          ORDER BY 
              GROUPING(a.airline), a.airline, 
              GROUPING(s.seatClass), s.seatClass";

        $stmt = oci_parse($conn, $sql);
        oci_execute($stmt);

        while ($row = oci_fetch_assoc($stmt)) {
          $airline = $row['AIRLINE'];
          $seatClass = $row['SEATCLASS'];
          
          // '소계' 또는 '총계'인 경우 스타일 지정
          if ($airline === '총계') {
            $rowClass = 'bg-blue-50 font-bold'; // 총계
          } elseif ($seatClass === '소계') {
            $rowClass = 'bg-blue-50 font-semibold'; // 소계
          } else {
            $rowClass = 'hover:bg-gray-50'; // 일반 행
          }
          echo "<tr class='hover:bg-gray-50 $rowClass transition'>";
          echo "<td class='border px-4 py-2'>" . htmlspecialchars($row['AIRLINE']) . "</td>";
          echo "<td class='border px-4 py-2'>" . htmlspecialchars($row['SEATCLASS']) . "</td>";
          echo "<td class='border px-4 py-2'>" . number_format($row['TOTAL_PAYMENT']) . "원</td>";
          echo "<td class='border px-4 py-2'>" . htmlspecialchars($row['TOTAL_RESERVATIONS']) . "건</td>";
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