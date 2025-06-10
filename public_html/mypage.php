<?php
session_start();
include('../config/db_connect.php');

if (!isset($_SESSION['cno'])) {
    echo "<script>alert('로그인이 필요합니다.'); location.href='login.php';</script>";
    exit;
}

$cno = $_SESSION['cno'];
$type = $_GET['type'] ?? 'all';
$start = $_GET['start'] ?? '';
$end = $_GET['end'] ?? '';

function build_reserve_query($start, $end) {
  $whereClauses = ["cno = :cno"];
  if ($start) $whereClauses[] = "TO_DATE(:start_reserve, 'YYYY-MM-DD') <= R.reserveDateTime";
  if ($end) $whereClauses[] = "TO_DATE(:end_reserve_plus1, 'YYYY-MM-DD') >= R.reserveDateTime";

  return "SELECT '예약' AS action, A.airline, R.flightNo, A.departureAirport, A.arrivalAirport,
          TO_CHAR(A.departureDateTime, 'YYYY-MM-DD HH24:MI:SS') AS departureDateTime,
          TO_CHAR(A.arrivalDateTime, 'YYYY-MM-DD HH24:MI:SS') AS arrivalDateTime,
          R.seatClass, R.payment AS amount,
          TO_CHAR(R.reserveDateTime, 'YYYY-MM-DD HH24:MI:SS') AS actionDate
          FROM RESERVE R
          JOIN AIRPLANE A ON R.flightNo = A.flightNo AND R.departureDateTime = A.departureDateTime
          WHERE " . implode(" AND ", $whereClauses);
}

function build_cancel_query($start, $end) {
  $whereClauses = ["cno = :cno"];
  if ($start) $whereClauses[] = "TO_DATE(:start_cancel, 'YYYY-MM-DD') <= C.cancelDateTime";
  if ($end) $whereClauses[] = "TO_DATE(:end_cancel_plus1, 'YYYY-MM-DD') >= C.cancelDateTime";

  return "SELECT '취소' AS action, A.airline, C.flightNo, A.departureAirport, A.arrivalAirport,
          TO_CHAR(A.departureDateTime, 'YYYY-MM-DD HH24:MI:SS') AS departureDateTime,
          TO_CHAR(A.arrivalDateTime, 'YYYY-MM-DD HH24:MI:SS') AS arrivalDateTime,
          C.seatClass, C.refund AS amount,
          TO_CHAR(C.cancelDateTime, 'YYYY-MM-DD HH24:MI:SS') AS actionDate
          FROM CANCEL C
          JOIN AIRPLANE A ON C.flightNo = A.flightNo AND C.departureDateTime = A.departureDateTime
          WHERE " . implode(" AND ", $whereClauses);
}

if ($type === 'reserve') {
  $sql = build_reserve_query($start, $end);
  $stmt = oci_parse($conn, $sql);
  oci_bind_by_name($stmt, ":cno", $cno);
  if ($start) oci_bind_by_name($stmt, ":start_reserve", $start);
  if ($end) {
    $end_plus1 = date('Y-m-d', strtotime($end . ' +1 day'));
    oci_bind_by_name($stmt, ":end_reserve_plus1", $end_plus1);
  }
} elseif ($type === 'cancel') {
  $sql = build_cancel_query($start, $end);
  $stmt = oci_parse($conn, $sql);
  oci_bind_by_name($stmt, ":cno", $cno);
  if ($start) oci_bind_by_name($stmt, ":start_cancel", $start);
  if ($end) {
    $end_plus1 = date('Y-m-d', strtotime($end . ' +1 day'));
    oci_bind_by_name($stmt, ":end_cancel_plus1", $end_plus1);
  }

} else {
  $sql = build_reserve_query($start, $end) . " UNION ALL " . build_cancel_query($start, $end);
  $stmt = oci_parse($conn, $sql);
  oci_bind_by_name($stmt, ":cno", $cno);
  // reserve 바인딩
  if ($start) oci_bind_by_name($stmt, ":start_reserve", $start);
  if ($end) {
    $end_plus1 = date('Y-m-d', strtotime($end . ' +1 day'));
    oci_bind_by_name($stmt, ":end_reserve_plus1", $end_plus1);
  }
  // cancel 바인딩
  if ($start) oci_bind_by_name($stmt, ":start_cancel", $start);
  if ($end) {
    $end_plus1 = date('Y-m-d', strtotime($end . ' +1 day'));
    oci_bind_by_name($stmt, ":end_cancel_plus1", $end_plus1);
  }
}
oci_execute($stmt);
?>

<!DOCTYPE html>
<html lang="ko">
<?php include('components/head.php'); ?>
<body class="h-full flex flex-col" style="font-family: 'Noto Sans KR', sans-serif;">
<?php include('components/header.php'); ?>
<div class="max-w-6xl mx-auto px-6 py-8 flex-1 w-full">
  <h1 class="text-2xl font-bold mb-8 text-center text-gray-800">📄 마이페이지</h1>
    <form method="GET" class="mb-8 mx-auto w-full max-w-4xl bg-white border border-gray-200 rounded-xl shadow-md px-6 py-5 flex flex-wrap gap-6 justify-between items-end">
        <!-- 시작일 -->
        <div class="flex flex-col w-[30%] min-w-[120px] text-sm">
            <label for="start" class="text-gray-600 font-medium mb-1">시작일</label>
            <input type="date" name="start" id="start" value="<?= htmlspecialchars($start) ?>"
                class="border px-3 py-2 rounded-md text-sm shadow-sm focus:ring-blue-500 focus:border-blue-500" />
        </div>

        <!-- 종료일 -->
        <div class="flex flex-col w-[30%] min-w-[120px] text-sm">
            <label for="end" class="text-gray-600 font-medium mb-1">종료일</label>
            <input type="date" name="end" id="end" value="<?= htmlspecialchars($end) ?>"
                class="border px-3 py-2 rounded-md text-sm shadow-sm focus:ring-blue-500 focus:border-blue-500" />
        </div>

        <!-- 구분 -->
        <div class="flex flex-col w-[30%] min-w-[120px] text-sm">
            <label for="type" class="text-gray-600 font-medium mb-1">구분</label>
            <select name="type" id="type"
                    class="border px-3 py-2 rounded-md text-sm shadow-sm focus:ring-blue-500 focus:border-blue-500">
            <option value="all" <?= $type === 'all' ? 'selected' : '' ?>>전체</option>
            <option value="reserve" <?= $type === 'reserve' ? 'selected' : '' ?>>예약</option>
            <option value="cancel" <?= $type === 'cancel' ? 'selected' : '' ?>>취소</option>
            </select>
        </div>

        <!-- 조회 버튼 -->
        <div class="w-full flex justify-end">
            <button type="submit"
                    class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-2 rounded-lg shadow font-semibold text-sm mt-2">
            🔍 조회하기
            </button>
        </div>
        </form>


  <table class="w-full border-collapse text-sm">
    <thead>
      <tr class="bg-gray-100 text-gray-700 text-center">
        <th class="px-3 py-2 border-b">구분</th>
        <th class="px-3 py-2 border-b">항공사</th>
        <th class="px-3 py-2 border-b">항공편명</th>
        <th class="px-3 py-2 border-b">출발지</th>
        <th class="px-3 py-2 border-b">도착지</th>
        <th class="px-3 py-2 border-b">출발일시</th>
        <th class="px-3 py-2 border-b">도착일시</th>
        <th class="px-3 py-2 border-b">금액</th>
        <th class="px-3 py-2 border-b">처리일시</th>
        <?php if ($type !== 'cancel') echo '<th class="px-3 py-2 border-b">취소</th>'; ?>
      </tr>
    </thead>
    <tbody>
      <?php while ($row = oci_fetch_assoc($stmt)): ?>
      <?php
          $isReservable = $row['ACTION'] === '예약';
          $departureTime = strtotime($row['DEPARTUREDATETIME']);
          $now = time();
      ?>
      <tr class="text-center hover:bg-gray-50 transition">
        <td class="px-3 py-2 border-b"><?= $row['ACTION'] ?></td>
        <td class="px-3 py-2 border-b"><?= htmlspecialchars($row['AIRLINE']) ?></td>
        <td class="px-3 py-2 border-b"><?= htmlspecialchars($row['FLIGHTNO']) ?></td>
        <td class="px-3 py-2 border-b"><?= htmlspecialchars($row['DEPARTUREAIRPORT']) ?></td>
        <td class="px-3 py-2 border-b"><?= htmlspecialchars($row['ARRIVALAIRPORT']) ?></td>
        <td class="px-3 py-2 border-b"><?= htmlspecialchars($row['DEPARTUREDATETIME']) ?></td>
        <td class="px-3 py-2 border-b"><?= htmlspecialchars($row['ARRIVALDATETIME']) ?></td>
        <td class="px-3 py-2 border-b"><?= number_format($row['AMOUNT']) ?>원</td>
        <td class="px-3 py-2 border-b"><?= htmlspecialchars($row['ACTIONDATE']) ?></td>
        <?php if ($isReservable && $departureTime > $now): ?>
        <td class="px-3 py-2 border-b">
          <form method="POST" action="cancel.php" onsubmit="return confirm('정말 취소하시겠습니까?');">
            <input type="hidden" name="flightNo" value="<?= $row['FLIGHTNO'] ?>">
            <input type="hidden" name="departureDateTime" value="<?= $row['DEPARTUREDATETIME'] ?>">
            <input type="hidden" name="seatClass" value="<?= $row['SEATCLASS'] ?>">
            <button class="text-red-600 underline text-sm">취소하기</button>
          </form>
        </td>
        <?php elseif ($isReservable): ?>
        <td class="px-3 py-2 border-b text-gray-400">취소 불가</td>
        <?php endif; ?>
      </tr>
      <?php endwhile; ?>
    </tbody>
  </table>
</div>
<?php
if (!oci_execute($stmt)) {
    $e = oci_error($stmt);
    echo "SQL 오류: " . htmlentities($e['message']);
    exit;
}
?>
<?php include('components/footer.php'); ?>
</body>
</html>