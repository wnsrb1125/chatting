<?php
// 새로운 방을 만드는 페이지입니다.
session_start();

if($_SESSION['login'] != 'on') {
    echo "<script>alert('잘못된 접근입니다.')</script>";
    echo "<script>location.href='login.html'</script>";
}
$roomking = $_SESSION['userid'];
$roomname = $_POST['roomname'];
class roomM
{
    function getconnect()
    {
        $connect = new mysqli('localhost', 'root',
            'autoset', 'chatting');
        return $connect;
    }

    function make($connectt,$roomname,$roomking)
    {
            $date = date('Y-m-d H:i:s');
            $querychatup = "insert into chat VALUES('','$roomname','$roomking',0,'$date')";
            if(!$connectt->query($querychatup)) echo "오류1";
            $queryselect = "select roomnum from chat ORDER by roomnum desc limit 1";
            $result = $connectt->query($queryselect);
            if(!$result) echo "오류2";
            $roomn  = $result->fetch_array();
            mysqli_close($connectt);
            echo "<script>location.href='chatroom.php?roomnum=$roomn[0]&userid=$roomking'</script>";
    }
}
$obj = new roomM();
$con = $obj->getconnect();
$obj->make($con,$roomname,$roomking);
mysqli_close($con);

?>
<input type="button" onclick="logout()" value="로그아웃" style="position: absolute; margin-left: 800px" />
<script> function logout() {
        location.href="logout.php";
    }</script>
