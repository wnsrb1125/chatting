<?php
session_start();
if($_SESSION['login'] != 'on')
    echo "<script>alert('잘못된 접근입니다.')</script>";
session_destroy();
echo "<script>location.href='login.html'</script>";
?>