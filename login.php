<?php
// 데이터베이스 연결 정보
$host = "localhost"; // 데이터베이스 호스트 주소
$username = "username"; // 데이터베이스 사용자 이름
$password = "password"; // 데이터베이스 비밀번호
$dbname = "logindb"; // 데이터베이스 이름

// 데이터베이스 연결
$conn = new mysqli($host, $username, $password, $dbname);

// 연결 확인
if ($conn->connect_error) {
    die("데이터베이스 연결 실패: " . $conn->connect_error);
}

// 로그인 기능 구현
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $userId = $_POST["user_id"];
    $userPw = $_POST["user_pw"];

    // 데이터베이스에서 입력된 ID와 일치하는 레코드 조회
    $sql = "SELECT * FROM user WHERE username = '$userId'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $storedPw = $row["password"];

        // 입력된 비밀번호와 데이터베이스에 저장된 비밀번호 일치 여부 확인
        if ($userPw == $storedPw) {
            // 로그인 성공
            session_start();
            $_SESSION["username"] = $row["username"]; // 세션에 사용자 이름 저장
            // 추가적인 로직 처리 가능

            // 메인 화면으로 이동
            header("Location: main.html");
            exit();
        } else {
            // 비밀번호 불일치
            echo "비밀번호가 일치하지 않습니다.";
        }
    } else {
        // 일치하는 ID가 없음
        echo "일치하는 계정이 없습니다.";
    }
}

// 데이터베이스 연결 종료
$conn->close();
?>
