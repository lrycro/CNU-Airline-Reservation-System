<?php
session_start();
?>
<!DOCTYPE html>
<html lang="ko" class="h-full">
<?php include('./components/head.php'); ?>

<body class="h-full flex flex-col" style="font-family: 'Noto Sans KR', sans-serif;">
  <?php include('./components/header.php'); ?>

  <?php if (isset($_SESSION['cno']) && isset($_SESSION['name'])): ?>
    <div class="max-w-4xl mx-auto mt-10 text-center text-lg font-semibold text-gray-800">
      <?= htmlspecialchars($_SESSION['name']) ?>님, 안녕하세요. CNU Airline과 함께 즐거운 여행을 떠나실 준비가 되셨나요? ✈️
    </div>
  <?php else: ?>
    <div class="max-w-4xl mx-auto mt-10 text-center text-lg font-semibold text-gray-800">
      로그인하고 CNU Airline과 함께 즐거운 여행을 떠날 준비를 해볼까요? ✈️
    </div>
  <?php endif; ?>

<div class="bg-white py-10">
  <div class="max-w-4xl mx-auto bg-white rounded-xl shadow px-6 py-5 flex flex-wrap items-center gap-4 justify-between relative z-10">
    
    <!-- 출발지 -->
    <div class="text-center" onclick="openAirportModal('departure')">
        <div id="departureCode" class="text-2xl font-semibold cursor-pointer">출발</div>
        <div id="departureCity" class="text-sm text-gray-700 mt-1">선택 <i class="fas fa-caret-down ml-1"></i></div>
    </div>

    <!-- 아이콘 -->
    <div class="text-blue-500 text-xl">
      <i class="fas fa-plane"></i>
    </div>

    <!-- 도착지 -->
    <div class="text-center" onclick="openAirportModal('arrival')">
        <div id="arrivalCode" class="text-2xl font-semibold cursor-pointer">도착</div>
        <div id="arrivalCity" class="text-sm text-gray-700 mt-1">선택 <i class="fas fa-caret-down ml-1"></i></div>
    </div>

<!-- 가는 날 -->
<div class="relative w-48">
  <button
    onclick="document.getElementById('departureDateInput').showPicker();"
    type="button"
    class="flex items-center px-3 py-2 bg-gray-100 text-sm rounded w-full"
  >
    <i class="far fa-calendar-alt mr-2"></i>
    <span id="dateText">가는 날</span>
  </button>
  <input
    type="date"
    id="departureDateInput"
    class="absolute top-0 left-0 w-full h-full opacity-0 pointer-events-none"
    onchange="setSelectedDate()"
  />
</div>

    <!-- 좌석 등급 -->
    <div class="relative">
      <div class="flex items-center px-3 py-2 bg-gray-100 text-sm rounded cursor-pointer" onclick="toggleSeatDropdown()">
        <i class="fas fa-chair mr-2"></i> 좌석 등급 <i class="fas fa-caret-down ml-1"></i>
      </div>
      <div id="seatDropdown" class="absolute hidden bg-white shadow rounded mt-2 w-40">
        <div class="px-4 py-2 hover:bg-gray-100 cursor-pointer" onclick="selectSeat('economy')">economy</div>
        <div class="px-4 py-2 hover:bg-gray-100 cursor-pointer" onclick="selectSeat('business')">business</div>
      </div>
    </div>
    
    <!-- 정렬 기준 -->
    <div class="relative">
      <div class="flex items-center px-3 py-2 bg-gray-100 text-sm rounded cursor-pointer" onclick="toggleSortDropdown()">
        <i class="fas fa-sort mr-2"></i> 정렬 기준 <i class="fas fa-caret-down ml-1"></i>
      </div>
      <div id="sortDropdown" class="absolute hidden bg-white shadow rounded mt-2 w-40">
        <div class="px-4 py-2 hover:bg-gray-100 cursor-pointer" onclick="selectSort('price')">요금 순</div>
        <div class="px-4 py-2 hover:bg-gray-100 cursor-pointer" onclick="selectSort('departureDateTime')">출발시간 순</div>
      </div>
    </div>

    <!-- 검색 버튼 -->
    <button class="bg-blue-500 hover:bg-blue-600 text-white text-sm px-4 py-2 rounded" onclick="validateSearchForm()">
      항공권 검색
    </button>
  </div>


  <!-- 출/도착지 모달 -->
  <div id="airportModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-20 flex items-center justify-center">
    <div class="bg-white w-full max-w-xl max-h-[80vh] overflow-y-auto rounded-xl p-6 relative">
      <h2 class="text-xl font-bold mb-4">도시 선택</h2>
      <input type="text" placeholder="국가, 도시명 검색" class="w-full border px-3 py-2 mb-4 rounded" id="airportSearchInput" oninput="filterAirports()" />

      <div>
        <h3 class="font-semibold mb-2">국내</h3>
        <div class="flex flex-wrap gap-2 mb-4">
            <span class="airport-option bg-gray-100 px-3 py-1 rounded cursor-pointer" data-code="SEL" data-city="서울" data-country="대한민국" onclick="selectAirport(selectedAirportType, 'SEL', '서울')">서울</span>
            <span class="airport-option bg-gray-100 px-3 py-1 rounded cursor-pointer" data-code="ICN" data-city="인천" data-country="대한민국" onclick="selectAirport(selectedAirportType, 'ICN', '인천')">인천</span>
            <span class="airport-option bg-gray-100 px-3 py-1 rounded cursor-pointer" data-code="CJU" data-city="제주" data-country="대한민국" onclick="selectAirport(selectedAirportType, 'CJU', '제주')">제주</span>
        </div>

        <h3 class="font-semibold mb-2">일본</h3>
        <div class="flex flex-wrap gap-2 mb-4">
            <span class="airport-option bg-gray-100 px-3 py-1 rounded cursor-pointer" data-code="NRT" data-city="도쿄" data-country="일본" onclick="selectAirport(selectedAirportType, 'NRT', '도쿄')">도쿄</span>
            <span class="airport-option bg-gray-100 px-3 py-1 rounded cursor-pointer" data-code="KIX" data-city="오사카" data-country="일본" onclick="selectAirport(selectedAirportType, 'KIX', '오사카')">오사카</span>
            <span class="airport-option bg-gray-100 px-3 py-1 rounded cursor-pointer" data-code="FUK" data-city="후쿠오카" data-country="일본" onclick="selectAirport(selectedAirportType, 'FUK', '후쿠오카')">후쿠오카</span>
        </div>

        <h3 class="font-semibold mb-2">유럽</h3>
        <div class="flex flex-wrap gap-2">
            <span class="airport-option bg-gray-100 px-3 py-1 rounded cursor-pointer" data-code="CDG" data-city="파리" data-country="프랑스" onclick="selectAirport(selectedAirportType, 'CDG', '파리')">파리</span>
            <span class="airport-option bg-gray-100 px-3 py-1 rounded cursor-pointer" data-code="LHR" data-city="런던" data-country="영국" onclick="selectAirport(selectedAirportType, 'LHR', '런던')">런던</span>
            <span class="airport-option bg-gray-100 px-3 py-1 rounded cursor-pointer" data-code="FCO" data-city="로마" data-country="이탈리아" onclick="selectAirport(selectedAirportType, 'FCO', '로마')">로마</span>
        </div>
      </div>

      <button onclick="closeAirportModal()" class="absolute top-2 right-4 text-gray-500 text-xl">&times;</button>
    </div>
  </div>
</div>

<!-- 검색 결과 출력 영역 -->
<div id="searchResults" class="mt-8"></div>

<!-- Toast 메시지 -->
<div id="toast" class="fixed bottom-5 left-1/2 transform -translate-x-1/2 bg-gray-800 text-white px-4 py-2 rounded shadow hidden z-50 text-sm"></div>

<script>
  function toggleSeatDropdown() {
    document.getElementById('seatDropdown').classList.toggle('hidden');
  }

  let selectedSeat = '';

  function selectSeat(type) {
    selectedSeat = type; // economy 또는 business
    document.querySelector('.fa-chair').nextSibling.textContent = ' ' + type;
    toggleSeatDropdown();
  }

  let selectedAirportType = ''; // 'departure' or 'arrival'

  function openAirportModal(type) {
    selectedAirportType = type;
    document.getElementById('airportModal').classList.remove('hidden');
  }

  function closeAirportModal() {
    document.getElementById('airportModal').classList.add('hidden');
  }

  function selectAirport(type, code, city) {
    if (type === 'departure') {
      document.getElementById('departureCode').textContent = code;
      document.getElementById('departureCity').innerHTML = city + ' <i class="fas fa-caret-down ml-1"></i>';
    } else if (type === 'arrival') {
      document.getElementById('arrivalCode').textContent = code;
      document.getElementById('arrivalCity').innerHTML = city + ' <i class="fas fa-caret-down ml-1"></i>';
    }
    closeAirportModal();
  }

  function toggleDatePicker() {
    document.getElementById('calendar').classList.toggle('hidden');
  }

  function setSelectedDate() {
    const dateInput = document.getElementById('departureDateInput').value;
    const dateText = document.getElementById('dateText');

    if (dateInput) {
      const dateObj = new Date(dateInput);
      const options = { year: 'numeric', month: '2-digit', day: '2-digit', weekday: 'short' };
      const formatted = dateObj.toLocaleDateString('ko-KR', options); // e.g. 2025.06.08. (일)

      dateText.textContent = formatted;
      toggleDatePicker(); // 선택 후 자동으로 닫기
    }
  }

  function filterAirports() {
    const keyword = document.getElementById('airportSearchInput').value.trim().toLowerCase();
    const airports = document.querySelectorAll('.airport-option');

    airports.forEach(span => {
        const code = span.dataset.code.toLowerCase();
        const city = span.dataset.city.toLowerCase();
        const country = span.dataset.country.toLowerCase();

        const match =
            code.includes(keyword) ||
            city.includes(keyword) ||
            country.includes(keyword);

        span.style.display = match ? 'inline-block' : 'none';
    });
  }

  let selectedSort = 'price'; // 기본 정렬: 가격순

  function toggleSortDropdown() {
    document.getElementById('sortDropdown').classList.toggle('hidden');
  }

  function selectSort(type) {
    selectedSort = type;
    document.querySelector('.fa-sort').nextSibling.textContent = ' ' + (type === 'price' ? '요금 순' : '출발시간 순');
    toggleSortDropdown();
  }

  function showToast(message) {
    const toast = document.getElementById('toast');
    toast.textContent = message;
    toast.classList.remove('hidden');

    setTimeout(() => {
      toast.classList.add('hidden');
    }, 3000); // 3초 후 자동 숨김
  }
  function validateSearchForm() {
    const departureCode = document.getElementById('departureCode').textContent.trim();
    const arrivalCode = document.getElementById('arrivalCode').textContent.trim();
    const date = document.getElementById('departureDateInput').value;

    if (departureCode === '출발' || arrivalCode === '도착') {
      showToast('출발지와 도착지를 모두 입력해 주세요.');
      return;
    }

    if (!date) {
      showToast('여행 일정을 입력하세요.');
      return;
    }

    if (departureCode === arrivalCode) {
      showToast('출발지과 도착지는 다른 지역을 선택해 주세요.');
      return;
    }

    // 오늘 날짜보다 이전인지 확인
    const selectedDate = new Date(date);
    selectedDate.setHours(0, 0, 0, 0);
    const today = new Date();
    today.setHours(0, 0, 0, 0); // 시간 0시로 초기화

    if (selectedDate <= today) {
        showToast('여행 일자는 오늘 이후여야 합니다.');
        return;
    }

    if (!selectedSeat) {
      showToast('좌석 등급을 선택해 주세요.');
      return;
    }

    // ✅ 모든 값이 유효한 경우 → AJAX 요청 전송
    fetch('search_flight.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: new URLSearchParams({
            departureAirport: departureCode,
            arrivalAirport: arrivalCode,
            departureDate: date,
            seatClass: selectedSeat,
            sort: selectedSort
        }),
    })
        .then(response => response.text())
        .then(data => {
            document.getElementById('searchResults').innerHTML = data;
        })
        .catch(error => {
            console.error('검색 중 오류 발생:', error);
            showToast('검색 결과를 불러오는 중 오류가 발생했습니다.');
        });
 }

  document.addEventListener('click', function (e) {
    if (e.target && e.target.classList.contains('reserve-btn')) {
      const row = e.target.closest('tr');
      const flightNo = row.children[1].textContent.trim();
      const departureDateTime = row.children[3].textContent.trim();
      const seatClass = row.children[6].textContent.trim();
      const payment = row.children[7].textContent.replace(/[^\d]/g, '');

      const form = document.createElement('form');
      form.method = 'POST';
      form.action = 'reserve.php'; // reserve_flight.php → reserve.php로 리네이밍 추천

      const fields = { flightNo, departureDateTime, seatClass, payment };
      for (const key in fields) {
        const input = document.createElement('input');
        input.type = 'hidden';
        input.name = key;
        input.value = fields[key];
        form.appendChild(input);
      }

      document.body.appendChild(form);
      form.submit();
    }
  });
</script>

<?php include('./components/footer.php'); ?>
</body>
</html>