# ✈️ CNU Airline Reservation System

CNU Airline은 2025 Spring Database 과목의 Term Project를 위한 모의 항공권 예약 시스템입니다.  
**회원가입부터 항공권 예약, 취소, 통계까지** 전 기능을 웹 기반으로 구현하였으며, Oracle DB와 PHP를 활용해 개발되었습니다.

---

## 📌 주요 기능

- **항공편 검색**  
  출발지, 도착지, 날짜, 좌석 등급 및 정렬 기준으로 항공편을 실시간 조회할 수 있습니다.

- **항공권 예약**  
  남은 좌석 수를 고려하여 예약이 가능하며, 예약 완료 시 이메일로 탑승권이 자동 발송됩니다.

- **예약/취소 내역 조회**  
  기간 필터 및 유형 필터(예약/취소)를 통한 마이페이지 조회 기능 제공

- **항공권 취소**  
  출발 이전인 예약 항공권만 취소 가능하며, 자동 환불 처리됩니다.

- **관리자 통계 기능**  
  - 항공사별/좌석등급별 예약 매출과 예약 건수를 ROLLUP으로 집계  
  - 고객별 누적 결제 금액 기준 결제 순위 통계 제공

---

## 🛠️ 기술 스택

| 분류        | 사용 기술                          |
|-------------|-----------------------------------|
| 백엔드      | PHP (Oracle 연동)                  |
| 데이터베이스 | Oracle 19c                        |
| 프론트엔드  | HTML, CSS (Tailwind 기반), JavaScript |
| 기타        | PHPMailer (SMTP 이메일 전송)       |

---

## 📁 폴더 구조
```
📁DB-TP/
├── config/
│ └── db_connect.php # Oracle DB 연결 파일
│
├── db/
│ └── init.sql # 테이블 생성 및 초기 데이터 삽입 스크립트
│
├── public_html/
│ ├── assets/
│ │ └── img/ # 로고 이미지
│ │ ├── CNU Airline header logo blue.png
│ │ ├── CNU Airline header logo white.png
│ │ └── CNU Airline logo.png
│ │
│ ├── components/ # UI 구성 요소 (공통 Header/Footer 등)
│ │ ├── footer.php
│ │ ├── head.php
│ │ ├── header.php
│ │ └── sidebar.php
│ │
│ ├── cancel.php # 항공권 취소 처리
│ ├── db_connect_test.php # DB 연결 테스트 (개발용)
│ ├── email.php # 예약 확인 이메일 전송
│ ├── index.php # 항공권 검색 및 예약 메인 화면
│ ├── login.php # 로그인
│ ├── logout.php # 로그아웃
│ ├── mypage.php # 예약 및 취소 내역 조회
│ ├── reserve.php # 항공권 예약 처리
│ ├── search_flight.php # AJAX 기반 항공편 검색 처리
│ ├── stats_airline.php # [관리자] 항공사별 예약 통계
│ └── stats_customer.php # [관리자] 고객별 결제 순위 통계
│
├── vendor/ # Composer, phpmailer
├── composer.json
├── composer.lock
└── README.md
```
---

## 📬 설치 및 실행

1. Oracle DB 및 계정 생성 후 `init.sql` 실행으로 테이블과 데이터 구축
2. 'db_connect.php'에 Oracle DB 계정 정보 입력
3. Apache + PHP 환경에서 `/public_html` 경로 실행  
4. `composer install`로 PHPMailer 설치  
5. `email.php` 내 관리자 이메일 주소 및 SMTP 설정 수정

---

## 👨‍💻 소개

- **프로젝트명**: CNU Airline
- **개발자**: lrycro
- **개발 기간**: 2025년 5월 ~ 6월