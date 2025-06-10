<!-- sidebar.php -->
<?php
$currentPage = basename($_SERVER['PHP_SELF']);
?>

<aside class="admin-sidebar h-full w-56 bg-white border-r border-gray-200 min-h-screen flex-shrink-0 shadow-sm">
  <div class="p-6">
    <h2 class="text-xl font-bold text-gray-800 mb-6">📊 관리자 메뉴</h2>
    <ul class="space-y-2">
      <li>
        <a href="stats_airline.php"
           class="flex items-center gap-2 px-4 py-2 rounded-lg text-sm font-medium
                  <?= $currentPage === 'stats_airline.php' ? 'bg-blue-100 text-blue-700 font-semibold' : 'text-gray-700 hover:bg-gray-100 hover:text-blue-600' ?>">
          📈 항공사별 예약 통계
        </a>
      </li>
      <li>
        <a href="stats_customer.php"
           class="flex items-center gap-2 px-4 py-2 rounded-lg text-sm font-medium
                  <?= $currentPage === 'stats_customer.php' ? 'bg-blue-100 text-blue-700 font-semibold' : 'text-gray-700 hover:bg-gray-100 hover:text-blue-600' ?>">
          👑 고객별 결제 순위
        </a>
      </li>
    </ul>
  </div>
</aside>