<?php
include('../config/db_connect.php');

// ORDER BY 항목 화이트리스트 지정
$allowedSorts = ['price'=> 'S.PRICE', 'departureDateTime' => 'A.departureDateTime'];
$sortKey = $_POST['sort'] ?? 'price';
$sort = $allowedSorts[$sortKey] ?? 'S.PRICE';

$departure = "'" . str_replace("'", "''", trim($_POST['departureAirport'] ?? '')) . "'";
$arrival = "'" . str_replace("'", "''", trim($_POST['arrivalAirport'] ?? '')) . "'";
$date = "'" . str_replace("'", "''", trim($_POST['departureDate'] ?? '')) . "'";
$seatClass = "'" . str_replace("'", "''", trim($_POST['seatClass'] ?? '')) . "'";

$sql = "
SELECT A.airline, A.flightNo, A.departureAirport,
       TO_CHAR(A.departureDateTime, 'YYYY-MM-DD HH24:MI:SS') AS departureTime,
       A.arrivalAirport,
       TO_CHAR(A.arrivalDateTime, 'YYYY-MM-DD HH24:MI:SS') AS arrivalTime,
       S.SEATCLASS, S.PRICE, S.NO_OF_SEATS
FROM AIRPLANE A
JOIN SEATS S ON A.flightNo = S.flightNo AND A.departureDateTime = S.departureDateTime
WHERE A.departureAirport = $departure
  AND A.arrivalAirport = $arrival
  AND TO_CHAR(A.departureDateTime, 'YYYY-MM-DD') = $date
  AND S.SEATCLASS = $seatClass
ORDER BY $sort";

$stmt = oci_parse($conn, $sql);

oci_execute($stmt);

$hasResult = false;
echo '<div class="max-w-6xl mx-auto mt-6 bg-white rounded-xl shadow px-6 py-5">';
echo '<table class="w-full border-collapse text-sm">';
echo '<thead>
<tr class="bg-gray-100 text-gray-700 text-center">
  <th class="px-3 py-2 border-b">항공사</th>
  <th class="px-3 py-2 border-b">운항편명</th>
  <th class="px-3 py-2 border-b">출발공항</th>
  <th class="px-3 py-2 border-b">출발시간</th>
  <th class="px-3 py-2 border-b">도착공항</th>
  <th class="px-3 py-2 border-b">도착시간</th>
  <th class="px-3 py-2 border-b">좌석등급</th>
  <th class="px-3 py-2 border-b">가격</th>
  <th class="px-3 py-2 border-b">남은좌석</th>
  <th class="px-3 py-2 border-b">예약하기</th>
</tr></thead><tbody>';

if (!oci_execute($stmt)) {
  $e = oci_error($stmt);
  echo "SQL 오류: " . $e['message'];
  exit;
}

while ($row = oci_fetch_assoc($stmt)) {
  $hasResult = true;
  $disabled = $row['NO_OF_SEATS'] <= 0 ? 'disabled class="bg-gray-300 text-white px-2 py-1 rounded text-xs cursor-not-allowed"' : 'class="bg-blue-500 hover:bg-blue-600 text-white px-2 py-1 rounded text-xs"';
  if ($row['NO_OF_SEATS'] <= 0) {
    $button = '<button class="bg-gray-300 text-white px-2 py-1 rounded text-xs cursor-not-allowed" disabled data-seats="0">예약불가</button>';
  } else {
    $button = '<button class="reserve-btn bg-blue-500 hover:bg-blue-600 text-white px-2 py-1 rounded text-xs" data-seats="' . $row['NO_OF_SEATS'] . '">예약</button>';
  }

  echo '<tr class="text-center hover:bg-gray-50 transition">';
  echo '<td class="px-3 py-2 border-b">' . htmlspecialchars($row['AIRLINE']) . '</td>';
  echo '<td class="px-3 py-2 border-b">' . htmlspecialchars($row['FLIGHTNO']) . '</td>';
  echo '<td class="px-3 py-2 border-b">' . htmlspecialchars($row['DEPARTUREAIRPORT']) . '</td>';
  echo '<td class="px-3 py-2 border-b">' . htmlspecialchars($row['DEPARTURETIME']) . '</td>';
  echo '<td class="px-3 py-2 border-b">' . htmlspecialchars($row['ARRIVALAIRPORT']) . '</td>';
  echo '<td class="px-3 py-2 border-b">' . htmlspecialchars($row['ARRIVALTIME']) . '</td>';
  echo '<td class="px-3 py-2 border-b">' . htmlspecialchars($row['SEATCLASS']) . '</td>';
  echo '<td class="px-3 py-2 border-b">' . number_format($row['PRICE']) . '원</td>';
  echo '<td class="px-3 py-2 border-b">' . htmlspecialchars($row['NO_OF_SEATS']) . '</td>';
  echo '<td class="px-3 py-2 border-b">' . $button . '</td>';
  echo '</tr>';

}

if (!$hasResult) {
  echo '<tr><td colspan="10" class="text-center text-gray-500 py-4">검색 결과가 없습니다.</td></tr>';
}

echo '</tbody></table>';
echo '</div>'; 
oci_free_statement($stmt);
oci_close($conn);
?>