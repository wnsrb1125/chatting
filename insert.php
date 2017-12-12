<?php
session_start();

if($_SESSION['login'] != 'on') {
    echo "<script>alert('잘못된 접근입니다.')</script>";
    echo "<script>location.href='login.html'</script>";
}
$roomnum    = isset($_POST['roomnum']) ? $_POST['roomnum'] : false;
$userid = $_SESSION['userid'];
$insert     = isset($_POST['insert']) ? $_POST['insert'] : false;

//코멘트를 보내는 클래스입니다.
class insert {
    //코멘트를 보내는 함수입니다.
    function insertt($connect,$comment,$roomnum,$userid) {
        $queryin    = "insert into dialogue VALUES ($roomnum,'$userid','$comment','')";
        if(!$connect->query($queryin))
            mysqli_close($connect);
    }
    function getconnect()
    {
        $connect = new mysqli('localhost', 'root',
            'autoset', 'chatting');
        return $connect;
    }
}
$obj = new insert();
$con = $obj -> getconnect();
$obj->insertt($con,$insert,$roomnum,$userid);

/**
 * Created by PhpStorm.
 * User: jungyu
 * Date: 2017-12-11
 * Time: 오전 11:59
 */
?>

