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
    $sql = "SELECT * FROM data_meminjam WHERE id_book = $id_book";
    $query = mysqli_query($conn, $sql);
    $data = mysqli_fetch_array($query);
?>

<?php
    if(isset($_POST['duration']) AND $_POST['duration'] != NULL){
        $getDuration = $_POST['duration'];
        $getIdType = $data['id_type'];
        #Update durasi, tanggal selesai dan jumlah pembayaran
        #Ambil harga
        $sql = "SELECT $getDuration * price as price FROM room_type WHERE id_type = $getIdType";
        $query_price = mysqli_query($conn, $sql);
        $data_price = mysqli_fetch_array($query_price);
        $getPrice = $data_price['price'];
        #Ekseuksi
        $sql = "UPDATE meminjam SET duration = duration + $getDuration, end_date = date_add(end_date, INTERVAL $getDuration DAY), pay = pay + $getPrice WHERE id_book = $id_book";
        $query = mysqli_query($conn, $sql) or die(mysqli_error($conn));
        echo 
        "<script>
            alert('Berhasil mengedit data peminjaman!');
            window.location.href = 'booking_information.php';
        </script>";
    }
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style/main.css">
    <link rel="stylesheet" href="style/form.css">
    <link rel="stylesheet" href="style/button.css">
    <link rel="stylesheet" href="style/sidebar.css">
    <link rel="stylesheet" href="style/content.css">
    <title>Azure Hotel - Informasi Pemesanan</title>
</head>
<body>
    <main>
        <?php include('include/sidebar.php'); ?>
        <div class="content">
            <div class="content-child">
                <form method="POST" action="" enctype="multipart/form-data" class="content-super-child" style="text-align: center;">
                    <h1>Edit Informasi Pemesanan</h1>
                    <div class="input-in-content-half">
                        <div class="input-in-content-column">
                            <h3>NIK</h3>
                            <h3><?php echo $data['id_card'] ?></h3>
                        </div>
                    </div>
                    <div class="input-in-content-half">
                        <div class="input-in-content-column">
                            <h3>Nama Pemesan:</h3>
                            <h3><?php echo $data['fname'].' '.$data['lname'] ?></h3>
                        </div>
                        <div class="input-in-content-column">
                            <h3>Nomor HP:</h3>
                            <h3><?php echo $data['phone_number'] ?></h3>
                        </div>
                    </div>
                    <div class="input-in-content-row">
                        <div class="input-in-content-column">
                            <h3>Kamar:</h3>
                            <h3><?php echo $data['room_name'] ?></h3>
                        </div>
                    </div>
                    <div class="input-in-content-half">
                        <div class="input-in-content-column">
                            <h3>Tanggal Mulai:</h3>
                            <h3><?php echo $data['start_date'] ?></h3>
                        </div>
                        <div class="input-in-content-column">
                            <h3>Tanggal Selesai:</h3>
                            <h3><?php echo $data['end_date'] ?></h3>
                        </div>
                    </div>
                    <div class="input-in-content-row">
                        <div class="input-in-content-column">
                            <h3>Tambah:</h3>
                            <input type="number" name="duration" class="input-form" class="input_form" min="1" style="width: 50%;">
                        </div>
                    </div>
                    <div class="input-in-content-half" style="justify-content: space-around;">
                        <div class="input-in-content-column">
                            <button type="button" onclick="finishBook(<?php echo $id_book ?>, <?php echo $data['pay'] ?>)" class="blue-button" style="width: 50%; font-size: 18px;" value="Selesai">Selesai</button>
                        </div>
                        <div class="input-in-content-column">
                            <button type="submit" class="green-button" style="width: 50%; font-size: 18px;">Edit</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </main>
    <script>
        function finishBook(id_book, pay){
            let tagihan = 'Apakah Anda yakin ingin menyelesaikan pesanan? (Tagian: Rp. ' + pay + ')';
            if(confirm(tagihan)){
                window.location.href="booking_finish.php?id_book=" + id_book + '';
            }
        }
    </script>
</body>
</html>