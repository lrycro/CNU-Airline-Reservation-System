<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$isLoggedIn = isset($_SESSION['cno']);
$isAdmin = ($isLoggedIn && $_SESSION['cno'] === 'c0');

// 현재 페이지 파일명 구하기
$currentPage = basename($_SERVER['PHP_SELF']);
?>

<header class="bg-blue-500 text-white shadow-md">
  <div class="max-w-7xl mx-auto px-4 py-3 flex items-center justify-between flex-wrap">
    
    <!-- 로고 -->
    <a href="/DB-TP/public_html/index.php" class="flex items-center gap-3">
      <img src="assets/img/CNU Airline header logo white.png" alt="CNU Airline Logo" class="h-12" />
    </a>

    <!-- 메뉴 -->
    <nav class="flex items-center gap-3 text-sm font-medium">
      <?php if (!$isLoggedIn): ?>
        <a href="/DB-TP/public_html/login.php"
           class="px-3 py-1 rounded-lg border border-white/50 hover:bg-white hover:text-blue-500 transition
                  <?= $currentPage === 'login.php' ? 'bg-white text-blue-500 font-semibold border-white' : '' ?>">
          <i class="fas fa-sign-in-alt mr-1"></i> 로그인
        </a>
      <?php else: ?>
        <?php if ($isAdmin): ?>
          <a href="/DB-TP/public_html/stats_airline.php"
             class="px-3 py-1 rounded-lg border border-white/50 hover:bg-white hover:text-blue-500 transition
                    <?= $currentPage === 'stats_airline.php' || $currentPage === 'stats_customer.php' ? 'bg-white text-blue-500 font-semibold border-white' : '' ?>">
            <i class="fas fa-chart-line mr-1"></i> 통계
          </a>
        <?php else: ?>
          <a href="/DB-TP/public_html/mypage.php"
             class="px-3 py-1 rounded-lg border border-white/50 hover:bg-white hover:text-blue-500 transition
                    <?= $currentPage === 'mypage.php' ? 'bg-white text-blue-500 font-semibold border-white' : '' ?>">
            <i class="fas fa-user-circle mr-1"></i> 마이페이지
          </a>
        <?php endif; ?>
        <a href="/DB-TP/public_html/logout.php"
           class="px-3 py-1 rounded-lg border border-white/50 hover:bg-white hover:text-blue-500 transition
                  <?= $currentPage === 'logout.php' ? 'bg-white text-blue-500 font-semibold border-white' : '' ?>">
          <i class="fas fa-sign-out-alt mr-1"></i> 로그아웃
        </a>
      <?php endif; ?>
    </nav>
  </div>
</header>