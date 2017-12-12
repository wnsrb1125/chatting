<?php
//리스트를 보여주는 페이지입니다.
session_start();
if($_SESSION['login'] != 'on') {
    echo "<script>alert('잘못된 접근입니다.')</script>";
    echo "<script>location.href='login.html'</script>";
}
$Cpage   = isset($_GET['Cpage']) ? $_GET['Cpage'] : 0;
if($Cpage == 0)
    $left = 1;
else
    $left   =   $Cpage - 1;
$right  =   $Cpage + 1;
$userid = $_SESSION['userid'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
    <script src="http://code.jquery.com/jquery-latest.min.js"></script>

    <meta charset="UTF-8">
    <title>Title</title>
</head>
<input type="button" onclick="logout()" value="로그아웃" style="position: absolute; margin-left: 800px" />
<body onload="ajax()">
<div class="container">
<table class="table-striped table-bordered table-hover">
    <thead>
      <tr class="">
          <td>번호</td>
          <td>채팅방 이름</td>
          <td>방장</td>
          <td>인원</td>
          <td>개설일자</td>
      </tr>
    </thead>
    <tbody id="table">

    </tbody>
</table>
</div>
</body>

<br>
<input type="button" onclick="button()" value="방개설">

<script>

    function logout() {
        location.href="logout.php";
    }
    function button() {
        location.href="newroommake.php?userid=<?echo $userid?>";
    }

    //페이지네이션 함수입니다.
    function ajax() {
        var xhr = new XMLHttpRequest();
        var url = "listup.php?page=<? echo $Cpage?>&userid=<?echo $userid ?>";
        xhr.open('GET', url, true);
        xhr.onreadystatechange = function () {
            if (xhr.readyState == 4 && xhr.status == 200) {
                document.getElementById('table').innerHTML = xhr.responseText;
            }
        };
        xhr.send();
    }
</script>
</html>