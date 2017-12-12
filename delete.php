<?php
session_start();
if($_SESSION['login'] != 'on') {
    echo "<script>alert('잘못된 접근입니다.')</script>";
    echo "<script>location.href='login.html'</script>";
}
$userid = $_SESSION['userid'];
$roomnum    = isset($_GET['roomnum']) ? $_GET['roomnum'] : false;

//나가기를 했을 때 쓰는 클래스입니다.
class delete {
    function getconnect()
    {
        $connect = new mysqli('localhost', 'root',
            'autoset', 'chatting');
        return $connect;
    }
    //나가기를 했을 때 모든 것을 업데이트 하는 함수입니다.
    function out($con,$userid,$roomnum){
        $query  =   "delete from userinchat where roomnum = $roomnum and roomuser = '$userid'";
        if(!$con->query($query)) echo "오류1";
        $queryk =   "update chat set roompeople = (select count(*) from userinchat where roomnum = $roomnum) 
        where roomnum = $roomnum";
        if(!$con->query($queryk)) echo "오류2";
        $queryp =   "select roompeople from chat where roomnum = $roomnum";
        $result = $con->query($queryp);
        if(!$result) echo "오류3";
        $info   = $result -> fetch_array();
        if($info[0] <= 0) {
            $queryd =   "delete from chat where roomnum = $roomnum";
            if(!$con->query($queryd)) echo "오류4";
            $queryde =   "delete from dialogue where roomint = $roomnum";
            if(!$con->query($queryde)) echo "오류6";
        }
        else {
            $queryde =   "delete from dialogue where userid = $userid";
            if(!$con->query($queryde)) echo "오류6";

            $querypu =   "update chat set roomking = (SELECT *  from (select roomuser  from userinchat
                  where seletking = (select min(seletking) from userinchat where roomnum = $roomnum)) as a) 
                  where roomnum = $roomnum";
            if(!$con->query($querypu)) echo "오류5";
        }
        mysqli_close($con);
        echo "<script>location.href='listview.php'</script>";
    }
}
$del = new delete();
$connect = $del ->getconnect();
$del->out($connect,$userid,$roomnum);


?>

