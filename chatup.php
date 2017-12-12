<?php
session_start();
if($_SESSION['login'] != 'on') {
    echo "<script>alert('잘못된 접근입니다.')</script>";
    echo "<script>location.href='login.html'</script>";
}
$roomnum = isset($_GET['roomnum']) ? $_GET['roomnum'] : false;
class chat
{
    function getconnect()
    {
        $connect = new mysqli('localhost', 'root',
            'autoset', 'chatting');
        return $connect;
    }
    //채팅을 업데이트하는 함수입니다.
    function chatup($connectt,$roomnum)
    {

            $querychatup =  "select * from dialogue where roomint = $roomnum ORDER by commentnum DESC limit 1 ";
            $result = $connectt->query($querychatup);
            $info = $result->fetch_array();
            if($info[0] != null && $_SESSION['bigyo'] != $info[3] ) {
                $_SESSION['bigyo'] = $info[3];
                echo $info[1] . ':' . $info[2];
            }
            else
                echo false;
            mysqli_close($connectt);
    }
}

$newchat = new chat();
$con = $newchat->getconnect();
$newchat->chatup($con, $roomnum);

?>