<?php
    session_start();
    
    // Hủy tất cả các biến session
    $_SESSION = array();
    
    // Hủy session
    session_destroy();
    
    // Chuyển hướng về trang đăng nhập hoặc trang chủ
    header("Location: Dangnhap_Index.php");
    exit;
?>