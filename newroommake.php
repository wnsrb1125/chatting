<?php
//새로운 방을 만들 때 필요한 정보를 보내는 페이지입니다.
session_start();
if($_SESSION['login'] != 'on') {
    echo "<script>alert('잘못된 접근입니다.')</script>";
    echo "<script>location.href='login.html'</script>";
}
$userid = $_SESSION['userid'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
</head>
<input type="button" onclick="logout()" value="로그아웃" style="position: absolute; margin-left: 800px" />
    <script> function logout() {
        location.href="logout.php";
    }</script>
<body>
<form method="post" action="newroom.php" id="frm">
    방이름<br><input type="text" name="roomname"><br>
    <input type="text" hidden="hidden">
    <input type="submit" value="방개설">
</form>
</body>
<script>
</script>
</html>
