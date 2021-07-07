<?php
    session_start();
    include('include/connect.php');
?>

<?php
    if(!isset($_SESSION['id_management'])){
        header('location:login.php');
    }else if($_SESSION['level'] != 'receptionist'){
        header('location:verification.php');
    }
?>

<?php
    if(!isset($_GET['id_book'])){
        header('location:booking_information.php');
    }else{
        $id_book = $_GET['id_book'];
    }
?>

<?php
    #Set status meminjam
    $sql = "UPDATE meminjam SET status = 'finished' WHERE id_book = $id_book";
    $query = mysqli_query($conn, $sql);
    #Set status ruangan
    $sql = "SELECT id_room FROM data_meminjam WHERE id_book = $id_book";
    $query = mysqli_query($conn, $sql);
    $data = mysqli_fetch_array($query);
    $id_room = $data['id_room'];

    $sql = "UPDATE room SET status='free' WHERE id_room = $id_room";
    $query = mysqli_query($conn, $sql);

    echo "
        <script>
            window.location.href = 'booking_information.php';
        </script>
    ";
?>