<?php
    session_start();
    include('include/connect.php');
?>


<?php
    if(!isset($_SESSION['id_management'])){
        header('location:login.php');
    }else{
        if($_SESSION['level'] != 'receptionist'){
            header('location:verification.php');
        }
    }
?>

<?php
    if(!isset($_GET['id_card'])){
        header('location:room_book.php');
    }else{
        $id_card = $_GET['id_card'];
    }
?>

<?php
    $check_array = array('id_type', 'sum', 'duration');
    if (!array_diff($check_array, array_keys($_POST))){
        $getIdType = $_POST['id_type'];
        $getSum = $_POST['sum'];
        $getDuration = $_POST['duration'];
        #Cek Jumlah Ruangan
        $sql = "SELECT id_room FROM room WHERE id_type = $getIdType AND status = 'free' LIMIT $getSum";
        $query_room = mysqli_query($conn, $sql);
        if(mysqli_num_rows($query_room) >= $getSum){
            #Ambil data yang diperlukan
            $id_management = $_SESSION['id_management'];
            $sql = "SELECT id_customer FROM customer WHERE id_card = $id_card";
            $query_customer = mysqli_query($conn, $sql);
            $data = mysqli_fetch_array($query_customer);
            $id_customer = $data['id_customer'];
            #Ambil harga
            $sql = "SELECT $getDuration * price as price FROM room_type WHERE id_type = $getIdType";
            $query_price = mysqli_query($conn, $sql);
            $data = mysqli_fetch_array($query_price);
            $getPrice = $data['price'];
            $i = 1;
            while($i <= $getSum AND $room = mysqli_fetch_array($query_room)){
                $sql = "INSERT INTO meminjam (id_customer, id_management, id_room, start_date, duration, end_date, pay, status)
                VALUES
                ($id_customer, $id_management, $room[id_room], curdate(), $getDuration, date_add(curdate(), INTERVAL $getDuration DAY), $getPrice, 'active')  
                ";
                $query_meminjam = mysqli_query($conn, $sql) or die(mysqli_error($conn));
                $sql = "UPDATE room SET status = 'booked' WHERE id_room = $room[id_room]";
                $query_room_status= mysqli_query($conn, $sql) or die(mysqli_error($conn));
            }
            echo "<script>
                alert('Berhasil menambahkan data peminjaman!');
                window.location.href = 'room_book.php';
            </script>";
        }else{
            echo "<script>
                alert('Jumlah kamar tidak mencukupi!');
                window.location.href = 'room_book.php';
            </script>";
        }
    }
?>
<?php
    #Data customer
    $sql = "SELECT * FROM customer WHERE id_card = $id_card";
    $query_customer = mysqli_query($conn, $sql);
    if(mysqli_num_rows($query_customer) <= 0){
        echo "<script>
            alert('Data NIK tidak terdaftar!');
            window.location.href = 'add_customer.php';
        </script>"; 
    }
    #Cek ruangan
    $sql = "SELECT id_room FROM room WHERE status = 'free'";
    $query = mysqli_query($conn, $sql);
    if(mysqli_num_rows($query) <= 0){
        echo "<script>
            alert('Seluruh kamar telah terpesan atau belum ada data kamar ditambahkan!');
            window.location.href = 'room_book.php';
        </script>"; 
    }
    $data = mysqli_fetch_array($query_customer);
    #Data tipe ruangan
    $sql = "SELECT id_type, name FROM room_type";
    $query_type = mysqli_query($conn, $sql);
    // while($item = mysqli_fetch_array($query_type)){
    //     echo $item['id_type'];
    // }
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
    <title>Azure Hotel - Pesan Kamar</title>
</head>
<body>
    <main>
        <?php include('include/sidebar.php'); ?>
        <div class="content">
            <div class="content-child">
                <form method="POST" action="" class="content-super-child" style="text-align: center;">
                    <h1>Pesan Kamar</h1>
                    <div class="input-in-content-half">
                        <div class="input-in-content-column">
                            <h3>NIK</h3>
                            <h3><?php echo $data['id_card'] ?>
                        </div>
                    </div>
                    <div class="input-in-content-half">
                        <div class="input-in-content-column">
                            <h3>Nama Pemesan:</h3>
                            <h3><?php echo $data['fname']. ' '.$data['lname'] ?>
                        </div>
                    </div>
                    <div class="input-in-content-row">
                        <div class="input-in-content-column">
                            <h3>Alamat:</h3>
                            <h3><?php echo $data['address'] ?>
                        </div>
                    </div>
                    <div class="input-in-content-row">
                        <div class="input-in-content-column" style="margin: 10px 0;">
                            <h3>Tipe ruangan:</h3>
                            <select name="id_type" class="input-form" style="width: 25%;" required>
                                <?php while($type = mysqli_fetch_array($query_type)): ?>
                                    <?php
                                        $sql = "SELECT id_room FROM room WHERE id_type = $type[id_type] AND status = 'free'";
                                        $query_room = mysqli_query($conn, $sql) or die("Gagal");
                                    ?>
                                    <?php if(mysqli_num_rows($query_room) >= 1): ?>
                                        <option value="<?php echo $type['id_type'] ?>"><?php echo $type['name'] ?></option>
                                    <?php endif ?>
                                <?php endwhile ?>
                            </select>
                        </div>
                    </div>
                    <div class="input-in-content-row">
                        <div class="input-in-content-column" style="margin: 10px 0;">
                            <h3>Jumlah:</h3>
                            <input type="number" name="sum" class="input-form" style="width: 25%;" min="1" required>
                        </div>
                    </div>
                    <div class="input-in-content-row">
                        <div class="input-in-content-column" style="margin: 10px 0;">
                            <h3>Durasi (hari):</h3>
                            <input type="number" name="duration" class="input-form" style="width: 25%;" min="1" required>
                        </div>
                    </div>
                    <button type="submit" class="blue-button" style="width: 20%; font-size: 24px;">Pesan</button>
                </form>
            </div>
        </div>
    </main>
</body>
</html>