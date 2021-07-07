<?php
    session_start();
    include('include/connect.php');
?>

<?php
    if(!isset($_SESSION['id_management'])){
        header('location:login.php');
    }else{
        if($_SESSION['level'] == 'receptionist'){
            header('location:room_book.php');
        }else if($_SESSION['level'] == 'admin'){
            header('location:user_management.php');
        }else{
            header('location:income_information.php');
        }
    }
?>