<?php
//채팅 하는 방입니다
session_start();
$roomnum = $_GET['roomnum'];
$userid  = $_SESSION['userid'];
// 변수를 받습니다.

//로그인 안 했을 경우 접근 시 차단합니다.
if($_SESSION['login'] != 'on') {
    echo "<script>alert('잘못된 접근입니다.')</script>";
    echo "<script>location.href='login.html'</script>";
}

//챗팅 룸의 클래스입니다.
class chatroom {

    // 값이 유효한지 확인합니다.
    function valid($con,$roomnum) {
        $query = "select roomnum from chat where roomnum = $roomnum";
        $result = $con->query($query);
        $vali   = $result -> fetch_array();
        if($vali == null) {
            echo "<script>alert('잘못된 접근입니다.')</script>";
            echo "<script>location.href='listview.php'</script>";
        }
    }

    //db에 연결하는 함수입니다.
    function getconnect()
    {
        $connect = new mysqli('localhost', 'root',
            'autoset', 'chatting');
        return $connect;
    }

    //채팅방에 들어올때 업데이트하는 함수입니다.
    function update($connect,$roomnum,$userid) {
        $query2  = "insert into userinchat values($roomnum,'$userid','')";
        $connect->query($query2);
        $query  = "update chat set roompeople = (select count(*) from userinchat where roomnum = $roomnum) 
        where roomnum = $roomnum";
        $connect->query($query);
        $queryd  = "delete from dialogue where roomint = $roomnum";
        $connect->query($queryd);
        mysqli_close($connect);
    }
}
$obj = new chatroom();
$con = $obj -> getconnect();
$obj -> valid($con,$roomnum);
$obj -> update($con,$roomnum,$userid);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
</head>
<body onload="a()">
<textarea style="width: 500px; height:600px" id="textarea" readonly="readonly">
</textarea>
<br>

    <input type="text" id="text" onkeyup="enterkey()">
    <input type="button" onclick="button()" value="보내기">
<form action='delete.php' method='get' id="frm">
    <input type='text' hidden='hidden' name='roomnum' value='<? echo $roomnum?>'>
    <input type='submit' value='나가기'>
</form>
<script>

    //로그아웃 시에 쓰이는 함수입니다.
    function logout() {
        location.href="logout.php";
    }

    //뒤로가기를 막는 함수입니다.
    history.pushState(null, null, location.href);
    window.onpopstate = function(event) {
        history.go(1);
    };
    function enterkey() {
        if(window.event.keyCode == 13) {
            button();
        }
    }

    //버튼을 눌렀을 때 코멘트를 보내는 함수입니다.
    function button() {
        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'insert.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        var result = 'insert='+document.getElementById('text').value+'&roomnum='+'<? echo $roomnum?>'
            +'&userid='+'<? echo $userid?>';
        xhr.send(result);
        document.getElementById('text').value = '';
    }

    //계속해서 업데이트하는 함수입니다.
    var a = setInterval(function () {
        var xhr = new XMLHttpRequest();
        var url = "chatup.php?roomnum=+<? echo $roomnum?>";
        xhr.open('GET', url, true);
        xhr.onreadystatechange = function () {
            if (xhr.readyState == 4 && xhr.status == 200) {
                if(xhr.response)
                    document.getElementById('textarea').value += '\n'+xhr.response;
            }
        };
        xhr.send();
    },100)


</script>
</body>
</html>