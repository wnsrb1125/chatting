<?php
session_start();
if($_SESSION['login'] != 'on') {
    echo "<script>alert('잘못된 접근입니다.')</script>";
    echo "<script>location.href='login.html'</script>";
}
$userid = $_SESSION['userid'];
$page       = isset($_GET['page']) ? $_GET['page'] : 0;
$pagemul = $page * 5;

//리스트업 시키는 클래스입니다.
class listup {
    function listupt($pagemul) {
        if($_SESSION['login'] == 'on') {
                $connect = new mysqli('localhost', 'root',
                'autoset', 'chatting');
                $result = $connect->query("select * from chat ORDER BY roomnum desc limit $pagemul,5");
                for ($i = 0; $i <= 5; $i++) {
                    $tableinfo = $result->fetch_array();
                    echo "<tr>";
                    echo "   <td>$tableinfo[0]</td>
                             <td><a href='chatroom.php?roomnum=$tableinfo[0]'>$tableinfo[1]</a></td>
                             <td>$tableinfo[2]</td>
                             <td>$tableinfo[3]</td>
                             <td>$tableinfo[4]</td>";
                    echo "</tr>";
                }
                $query  = "select * from chat";
                $result = $connect -> query($query);
                $rows   = $result -> num_rows;
                $page   = ceil($rows/5.0);

                for ($i = 1 ; $i < $page; $i++)
                    echo "<a href='listview.php?Cpage=$i'>$i</a>";

        }
        else
            echo "<script>alert('잘못된 접근입니다.')</script>";
    }
}
$obj = new listup();
$obj->listupt($pagemul,$userid);

?>

