<?php
//로그인 할 때 쿼리문을 보내는 php 입니다.
session_start();
$_SESSION['bigyo'] = 0;
$userid = isset($_POST['userid']) ? $_POST['userid'] : false;
$userpw = isset($_POST['userpw']) ? $_POST['userpw'] : false;
if(!$userid || !$userpw) {
    echo "<script>alert('잘못된 접근입니다.')</script>";
    echo "<script>location.href='login.html'</script>";
}
class login
{
    function getconnect()
    {
        $connect = new mysqli('localhost', 'root',
            'autoset', 'chatting');
        return $connect;
    }

    function quer($connect,$userid,$userpw)
    {
        $login = $connect->query("select userpw from user WHERE userid = '$userid'");
        if (!$login) {
            echo "문법오류 발생";
            exit();
        } else {
            $logininfo = $login->fetch_array();
            if ($login == null)
                echo "<script>alert('옳지 않은 값이 들어왔습니다')</script>";
            else {
                if ($logininfo[0] == $userpw) {
                    echo "<script>alert('로그인 완료')</script>";
                    $_SESSION['login'] = 'on';
                    $_SESSION['userid'] = $userid;
                    echo "<script>location.href='listview.php'</script>";
                } else {
                    echo "<script>alert('로그인 실패')</script>";
                    echo "<script>location.href='login.html'</script>";
                }
            }
        }
        mysqli_close($connect);
    }
}
$obj = new login();
$con = $obj->getconnect();
$obj->quer($con,$userid,$userpw);
?>