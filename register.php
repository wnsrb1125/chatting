<?php
// 회원가입할 때 쓰는 페이지입니다.
session_start();
$_SESSION['bigyo'] = 0;
$userid = isset($_POST['userid']) ? $_POST['userid'] : false;
$userpw = isset($_POST['password']) ? $_POST['password'] : false;
if(!$userid) {
    echo "<script>alert('잘못된 접근입니다.')</script>";
    echo "<script>location.href='login.html'</script>";
}
class register {
    function getconnect()
    {
        $connect = new mysqli('localhost', 'root',
            'autoset', 'chatting');
        return $connect;
    }
    function reg($con,$userid,$userpw) {
        $login = $con->query("select userid from user WHERE userid = '$userid'");
        $result = $login -> fetch_array();
        $info   = $result[0];
        if($info == null) {
            $queryr = "insert into user values ('$userid','$userpw')";
            $con -> query($queryr);
            echo "<script>alert('회원가입완료')</script>";
            $_SESSION['login'] = 'on';
            $_SESSION['userid'] = $userid;
            echo "<script>location.href='listview.php'</script>";
        }
        else {
            echo "<script>alert('이미 존재하는 아이디입니다.')</script>";
            echo "<script>location.href='register.html'</script>";
        }
    }
}
$obj = new register();
$con = $obj ->getconnect();
$obj ->prevent($userid,$userpw);
$obj -> reg($con,$userid,$userpw);
mysqli_close($con);
?>